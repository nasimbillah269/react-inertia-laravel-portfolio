import { useEffect, useRef } from "react";

const CHARS = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()<>/{}[]=+-;:アイウエオカキクケコサシスセソ";

/**
 * Matrix-style falling code rain on a fixed, full-screen canvas.
 * It sits over the page with pointer-events: none, so it never blocks clicks.
 *
 * Props:
 *  color    – head/trail colour (default theme violet; "#00ff41" = classic green)
 *  fontSize – glyph size in px
 *  speed    – frames per second
 *  opacity  – overall layer opacity
 */
export default function MatrixRain({ color = "#a855f7", fontSize = 16, speed = 22, opacity = 0.32 }) {
    const ref = useRef(null);

    useEffect(() => {
        // respect users who prefer reduced motion
        if (window.matchMedia?.("(prefers-reduced-motion: reduce)").matches) return;

        const canvas = ref.current;
        const ctx = canvas.getContext("2d");
        let w = 0;
        let h = 0;
        let drops = [];
        let raf = 0;
        let last = 0;
        const interval = 1000 / speed;

        const resize = () => {
            const dpr = Math.min(window.devicePixelRatio || 1, 2);
            w = window.innerWidth;
            h = window.innerHeight;
            canvas.width = w * dpr;
            canvas.height = h * dpr;
            canvas.style.width = `${w}px`;
            canvas.style.height = `${h}px`;
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
            const cols = Math.ceil(w / fontSize);
            // keep existing columns, start new ones at a random height on screen (rain is visible immediately)
            drops = Array.from({ length: cols }, (_, i) => drops[i] ?? Math.floor((Math.random() * h) / fontSize));
        };

        const draw = (t) => {
            raf = requestAnimationFrame(draw);
            if (t - last < interval) return;
            last = t;

            // translucent black wipe leaves the fading trail
            ctx.fillStyle = "rgba(0, 0, 0, 0.08)";
            ctx.globalCompositeOperation = "destination-out";
            ctx.fillRect(0, 0, w, h);
            ctx.globalCompositeOperation = "source-over";

            ctx.font = `${fontSize}px monospace`;
            for (let i = 0; i < drops.length; i++) {
                const y = drops[i] * fontSize;
                if (y > 0) {
                    const ch = CHARS[(Math.random() * CHARS.length) | 0];
                    // bright head, coloured body
                    ctx.fillStyle = Math.random() > 0.96 ? "#ffffff" : color;
                    ctx.fillText(ch, i * fontSize, y);
                }
                if (y > h && Math.random() > 0.975) drops[i] = 0;
                drops[i]++;
            }
        };

        resize();
        raf = requestAnimationFrame(draw);
        window.addEventListener("resize", resize);
        return () => {
            cancelAnimationFrame(raf);
            window.removeEventListener("resize", resize);
        };
    }, [color, fontSize, speed]);

    return <canvas ref={ref} className="pf-matrix" style={{ opacity }} aria-hidden />;
}
