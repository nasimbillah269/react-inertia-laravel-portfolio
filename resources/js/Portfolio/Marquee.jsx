import { useEffect, useLayoutEffect, useRef, useState } from "react";

/**
 * Infinite marquee: auto-scrolls, pauses on hover, can be dragged
 * (mouse / touch), fades out at the edges.
 *
 *  items      – array to render
 *  renderItem – (item, i) => node
 *  speed      – px per second
 *  reverse    – scroll left → right
 *  gap        – px between items (keep in sync with CSS)
 */
export default function Marquee({ items, renderItem, speed = 45, reverse = false, gap = 14, className = "" }) {
    const wrap = useRef(null);
    const track = useRef(null);
    const firstSet = useRef(null);
    const [copies, setCopies] = useState(2);
    const state = useRef({ offset: 0, setW: 1, paused: false, dragging: false, startX: 0, startOffset: 0, moved: 0 });

    // enough copies so the track always covers the visible width (+1 set to wrap into)
    useLayoutEffect(() => {
        const measure = () => {
            const setW = (firstSet.current?.offsetWidth || 1) + gap;
            state.current.setW = setW;
            const need = Math.max(2, Math.ceil((wrap.current?.offsetWidth || 0) / setW) + 1);
            setCopies((c) => (c === need ? c : need));
        };
        measure();
        const ro = new ResizeObserver(measure);
        if (wrap.current) ro.observe(wrap.current);
        if (firstSet.current) ro.observe(firstSet.current);
        return () => ro.disconnect();
    }, [items.length, gap]);

    useEffect(() => {
        const reduced = window.matchMedia?.("(prefers-reduced-motion: reduce)").matches;
        const s = state.current;
        let raf = 0;
        let last = performance.now();
        const apply = () => {
            // keep offset in (-setW, 0] so the loop is seamless
            s.offset = ((s.offset % s.setW) - s.setW) % s.setW;
            if (track.current) track.current.style.transform = `translate3d(${s.offset}px,0,0)`;
        };
        const tick = (t) => {
            const dt = Math.min(0.05, (t - last) / 1000);
            last = t;
            if (!reduced && !s.paused && !s.dragging) s.offset += (reverse ? 1 : -1) * speed * dt;
            apply();
            raf = requestAnimationFrame(tick);
        };
        raf = requestAnimationFrame(tick);
        return () => cancelAnimationFrame(raf);
    }, [speed, reverse]);

    const s = state.current;
    const onDown = (e) => {
        s.dragging = true;
        s.startX = e.clientX;
        s.startOffset = s.offset;
        s.moved = 0;
        e.currentTarget.setPointerCapture?.(e.pointerId);
    };
    const onMove = (e) => {
        if (!s.dragging) return;
        const dx = e.clientX - s.startX;
        s.moved = Math.max(s.moved, Math.abs(dx));
        s.offset = s.startOffset + dx;
    };
    const onUp = () => {
        s.dragging = false;
    };

    return (
        <div
            ref={wrap}
            className={`mq ${className}`}
            onMouseEnter={() => (s.paused = true)}
            onMouseLeave={() => {
                s.paused = false;
                s.dragging = false;
            }}
            onPointerDown={onDown}
            onPointerMove={onMove}
            onPointerUp={onUp}
            onPointerCancel={onUp}
            // swallow the click that ends a drag
            onClickCapture={(e) => s.moved > 5 && e.preventDefault()}
        >
            <div ref={track} className="mq-track" style={{ gap }}>
                {Array.from({ length: copies }).map((_, c) => (
                    <div key={c} ref={c === 0 ? firstSet : undefined} className="mq-set" style={{ gap }} aria-hidden={c > 0 || undefined}>
                        {items.map((it, i) => renderItem(it, i))}
                    </div>
                ))}
            </div>
        </div>
    );
}
