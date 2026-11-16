import { useEffect, useRef, useState } from "react";

/**
 * Counts the first number inside `value` up from 0 when it scrolls into view.
 * Keeps any prefix/suffix and the decimal places: "50+", "3K+", "5.0", "24/7", "100%".
 */
export default function CountUp({ value, duration = 1800 }) {
    const str = String(value ?? "");
    const m = str.match(/^(\D*)(\d+(?:\.\d+)?)(.*)$/s);
    const ref = useRef(null);
    const [n, setN] = useState(m ? 0 : null);

    useEffect(() => {
        if (!m) return;
        const target = parseFloat(m[2]);
        if (window.matchMedia?.("(prefers-reduced-motion: reduce)").matches) {
            setN(target);
            return;
        }
        let raf = 0;
        const obs = new IntersectionObserver(
            ([e]) => {
                if (!e.isIntersecting) return;
                obs.disconnect();
                const start = performance.now();
                const step = (t) => {
                    const p = Math.min(1, (t - start) / duration);
                    const eased = 1 - Math.pow(1 - p, 3); // easeOutCubic
                    setN(target * eased);
                    if (p < 1) raf = requestAnimationFrame(step);
                };
                raf = requestAnimationFrame(step);
            },
            { threshold: 0.4 }
        );
        if (ref.current) obs.observe(ref.current);
        return () => {
            obs.disconnect();
            cancelAnimationFrame(raf);
        };
    }, [str, duration]);

    if (!m) return <>{str}</>;
    const decimals = (m[2].split(".")[1] || "").length;
    return (
        <span ref={ref} aria-label={str}>
            {m[1]}
            {n.toFixed(decimals)}
            {m[3]}
        </span>
    );
}
