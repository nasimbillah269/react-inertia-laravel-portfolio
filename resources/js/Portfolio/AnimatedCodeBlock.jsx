import { useEffect, useMemo, useRef, useState } from "react";
import { FaPause, FaPlay, FaRotateRight, FaRegCopy, FaCheck, FaCode } from "react-icons/fa6";

// --- tiny JS/TS syntax highlighter (enough for a showcase snippet) ---
const KEYWORDS = new Set([
    "const", "let", "var", "function", "return", "import", "from", "export", "default", "interface",
    "type", "new", "await", "async", "if", "else", "for", "of", "in", "class", "extends", "true", "false", "null",
]);
const TOKEN = /(\/\/.*$)|("(?:[^"\\]|\\.)*"?|'(?:[^'\\]|\\.)*'?|`(?:[^`\\]|\\.)*`?)|(\b\d+(?:\.\d+)?\b)|([A-Za-z_$][\w$]*)|(\s+)|([^\sA-Za-z_$\d"'`]+)/g;

function highlight(line) {
    const out = [];
    let m;
    TOKEN.lastIndex = 0;
    while ((m = TOKEN.exec(line))) {
        const [text, comment, str, num, word, space] = m;
        let cls = "p"; // punctuation
        if (comment) cls = "c";
        else if (str) cls = "s";
        else if (num) cls = "n";
        else if (space) cls = "";
        else if (word) {
            const rest = line.slice(m.index + text.length);
            if (KEYWORDS.has(word)) cls = "k";
            else if (/^\s*\(/.test(rest)) cls = "f"; // function call / declaration
            else if (/^[A-Z]/.test(word)) cls = "t"; // Types / Components
            else if (/^\s*:/.test(rest)) cls = "prop"; // object keys
            else cls = "v";
        }
        out.push(
            <span key={m.index} className={cls ? `cb-${cls}` : undefined}>
                {text}
            </span>
        );
    }
    return out;
}

/**
 * Typewriter code block (About section).
 *  code     – the full snippet to type
 *  filename – shown in the title bar
 *  lang     – badge next to the filename
 *  speed    – ms per character
 */
export default function AnimatedCodeBlock({ code, filename = "developer.ts", lang = "TS", speed = 32, visibleLines = 9 }) {
    const [count, setCount] = useState(0);
    const [paused, setPaused] = useState(false);
    const [copied, setCopied] = useState(false);
    const timer = useRef(null);
    const reduced = useMemo(() => typeof window !== "undefined" && window.matchMedia?.("(prefers-reduced-motion: reduce)").matches, []);

    useEffect(() => {
        if (reduced) {
            setCount(code.length);
            return;
        }
        if (paused) return;
        const done = count >= code.length;
        // type next char; newlines are quicker, pause at the end then loop
        const delay = done ? 3500 : code[count] === "\n" ? speed * 4 : speed + Math.random() * speed;
        timer.current = setTimeout(() => setCount(done ? 0 : count + 1), delay);
        return () => clearTimeout(timer.current);
    }, [count, paused, code, speed, reduced]);

    const typed = code.slice(0, count);
    const lines = typed.split("\n");
    const total = code.split("\n").length;
    const current = lines.length - 1;
    const offset = Math.max(0, current - (visibleLines - 2)); // keep the caret line in view

    const copy = async () => {
        try {
            await navigator.clipboard.writeText(code);
            setCopied(true);
            setTimeout(() => setCopied(false), 1500);
        } catch {
            /* clipboard unavailable */
        }
    };

    return (
        <div className="cb">
            <div className="cb-bar">
                <span className="cb-dots" aria-hidden>
                    <i />
                    <i />
                    <i />
                </span>
                <span className="cb-file">
                    <FaCode /> {filename} <em>{lang}</em>
                </span>
                <span className="cb-actions">
                    <button onClick={() => setPaused(!paused)} aria-label={paused ? "Play" : "Pause"}>
                        {paused ? <FaPlay /> : <FaPause />}
                    </button>
                    <button onClick={() => { setCount(0); setPaused(false); }} aria-label="Replay">
                        <FaRotateRight />
                    </button>
                    <button onClick={copy} aria-label="Copy code">
                        {copied ? <FaCheck /> : <FaRegCopy />}
                    </button>
                </span>
            </div>
            <div className="cb-body" style={{ "--cb-lines": visibleLines }}>
                <div className="cb-scroll" style={{ transform: `translateY(calc(${-offset} * var(--cb-lh)))` }}>
                    {Array.from({ length: total }).map((_, i) => (
                        <div key={i} className={`cb-line ${i === current ? "on" : ""}`}>
                            <span className="cb-num">{i + 1}</span>
                            <code>
                                {i < lines.length && highlight(lines[i])}
                                {i === current && <span className="cb-caret" />}
                            </code>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
}
