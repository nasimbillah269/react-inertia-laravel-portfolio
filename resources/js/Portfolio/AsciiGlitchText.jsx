import { useEffect, useRef } from "react";

// deterministic 0..1 noise per cell (changes only when `seed` changes → "stable" noise)
const hash = (x, y, seed) => {
    const v = Math.sin(x * 12.9898 + y * 78.233 + seed * 37.719) * 43758.5453;
    return v - Math.floor(v);
};

/**
 * Renders text as a glowing pixel/ASCII grid with a "glitch" effect:
 * stable noise punches holes into the fill and, every few seconds, rows
 * jump sideways with a cyan split. Size follows the parent's font-size.
 *
 * parts: [{ text, color } | { text, gradient: [from, to] }]
 */
export default function AsciiGlitchText({ parts, weight = 700, family = "Poppins", glitchEvery = 3200 }) {
    const wrap = useRef(null);
    const canvas = useRef(null);

    useEffect(() => {
        const el = wrap.current;
        const cv = canvas.current;
        const ctx = cv.getContext("2d");
        const reduced = window.matchMedia?.("(prefers-reduced-motion: reduce)").matches;
        let cells = [];
        let cell = 5;
        let W = 0;
        let H = 0;
        let raf = 0;
        let last = 0;
        let alive = true;

        const build = () => {
            const fontSize = parseFloat(getComputedStyle(el).fontSize) || 74;
            const font = `${weight} ${fontSize}px ${family}`;
            const off = document.createElement("canvas").getContext("2d", { willReadFrequently: true });
            off.font = font;
            const widths = parts.map((p) => off.measureText(p.text).width);
            W = Math.ceil(widths.reduce((a, b) => a + b, 0)) + 4;
            H = Math.ceil(fontSize * 1.2);
            off.canvas.width = W;
            off.canvas.height = H;
            off.font = font;
            off.textBaseline = "alphabetic";
            let x = 0;
            parts.forEach((p, i) => {
                if (p.gradient) {
                    const g = off.createLinearGradient(x, 0, x + widths[i], 0);
                    g.addColorStop(0, p.gradient[0]);
                    g.addColorStop(1, p.gradient[1]);
                    off.fillStyle = g;
                } else off.fillStyle = p.color || "#fff";
                off.fillText(p.text, x, fontSize * 0.93);
                x += widths[i];
            });

            // sample the rendered text into a grid of cells
            cell = Math.max(3, Math.round(fontSize / 17));
            const data = off.getImageData(0, 0, W, H).data;
            cells = [];
            for (let cy = 0; cy < H; cy += cell) {
                for (let cx = 0; cx < W; cx += cell) {
                    const px = Math.min(W - 1, cx + (cell >> 1));
                    const py = Math.min(H - 1, cy + (cell >> 1));
                    const k = (py * W + px) * 4;
                    if (data[k + 3] > 70) cells.push({ x: cx, y: cy, c: `rgb(${data[k]},${data[k + 1]},${data[k + 2]})` });
                }
            }

            const dpr = Math.min(window.devicePixelRatio || 1, 2);
            cv.width = W * dpr;
            cv.height = H * dpr;
            cv.style.width = `${W}px`;
            cv.style.height = `${H}px`;
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        };

        const draw = (now) => {
            const seed = Math.floor(now / 650); // slow-changing "stable" noise
            const burst = !reduced && now % glitchEvery < 240; // short glitch burst
            const shift = {};
            if (burst) {
                const s2 = Math.floor(now / 60);
                for (let y = 0; y < H; y += cell) if (hash(y, 1, s2) > 0.72) shift[y] = (hash(y, 2, s2) - 0.5) * cell * 8;
            }
            ctx.clearRect(0, 0, W, H);
            const size = cell - 0.35;

            if (burst) {
                // cyan split ghost
                ctx.globalAlpha = 0.45;
                ctx.fillStyle = "#22d3ee";
                for (const p of cells) ctx.fillRect(p.x + (shift[p.y] || 0) + cell, p.y, size, size);
                ctx.globalAlpha = 1;
            }
            for (const p of cells) {
                const n = hash(p.x, p.y, seed);
                const x = p.x + (shift[p.y] || 0);
                ctx.fillStyle = p.c;
                if (n > 0.95) continue; // hole
                if (n > 0.86) {
                    // dithered cell
                    const d = Math.max(1, cell / 3);
                    ctx.fillRect(x, p.y, d, d);
                    ctx.fillRect(x + d * 1.6, p.y + d * 1.6, d, d);
                    continue;
                }
                ctx.fillRect(x, p.y, size, size);
            }
        };

        const loop = (t) => {
            raf = requestAnimationFrame(loop);
            if (t - last < 70) return;
            last = t;
            draw(t);
        };

        const start = () => {
            if (!alive) return;
            build();
            if (reduced) draw(0);
            else raf = requestAnimationFrame(loop);
        };

        // wait for the web font, otherwise the grid is built from a fallback font
        const fontReady = document.fonts?.load ? document.fonts.load(`${weight} 40px ${family}`) : Promise.resolve();
        fontReady.then(start, start);

        const onResize = () => {
            build();
            if (reduced) draw(0);
        };
        window.addEventListener("resize", onResize);
        return () => {
            alive = false;
            cancelAnimationFrame(raf);
            window.removeEventListener("resize", onResize);
        };
    }, [JSON.stringify(parts), weight, family, glitchEvery]);

    return (
        <span ref={wrap} className="agt" aria-hidden>
            <canvas ref={canvas} />
        </span>
    );
}
