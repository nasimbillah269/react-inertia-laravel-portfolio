import { useEffect, useState } from "react";

// blend two hex colours (keeps the purple → blue gradient across the letters)
const mix = (a, b, t) => {
    const p = (h) => [1, 3, 5].map((i) => parseInt(h.slice(i, i + 2), 16));
    const [x, y] = [p(a), p(b)];
    return `rgb(${x.map((v, i) => Math.round(v + (y[i] - v) * t)).join(",")})`;
};

/**
 * Typing headline: types each word letter-by-letter, holds, then flips the
 * letters out (3D + blur) one by one and moves to the next word.
 */
export default function TypingWords({ words = [], from = "#b05cf8", to = "#6271ff", typeSpeed = 110, outSpeed = 55, hold = 2200 }) {
    const list = words.length ? words : [""];
    const [index, setIndex] = useState(0);
    const [shown, setShown] = useState(0); // letters typed in
    const [out, setOut] = useState(0); // letters flipped out (from the end)
    const [phase, setPhase] = useState("in"); // in | hold | out
    const word = list[index % list.length];
    const reduced = typeof window !== "undefined" && window.matchMedia?.("(prefers-reduced-motion: reduce)").matches;

    useEffect(() => {
        if (reduced) return;
        let t;
        if (phase === "in") {
            t = shown < word.length ? setTimeout(() => setShown(shown + 1), typeSpeed) : setTimeout(() => setPhase("hold"), 0);
        } else if (phase === "hold") {
            t = setTimeout(() => setPhase("out"), hold);
        } else {
            t =
                out < word.length
                    ? setTimeout(() => setOut(out + 1), outSpeed)
                    : setTimeout(() => {
                          setIndex((i) => i + 1);
                          setShown(0);
                          setOut(0);
                          setPhase("in");
                      }, 380); // let the last letter finish flipping
        }
        return () => clearTimeout(t);
    }, [phase, shown, out, word, typeSpeed, outSpeed, hold, reduced]);

    if (reduced) return <span style={{ color: from }}>{list[0]}</span>;

    const letters = word.split("").slice(0, shown);
    return (
        <span className="tw" aria-label={word}>
            {letters.map((ch, i) => (
                <span
                    key={`${index}-${i}`}
                    aria-hidden
                    className={`tw-ch ${i >= word.length - out ? "out" : ""}`}
                    style={{ color: mix(from, to, word.length > 1 ? i / (word.length - 1) : 0) }}
                >
                    {ch === " " ? " " : ch}
                </span>
            ))}
            <span className="tw-caret" aria-hidden />
        </span>
    );
}
