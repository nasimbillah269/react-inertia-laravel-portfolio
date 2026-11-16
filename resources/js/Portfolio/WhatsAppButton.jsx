import { useEffect, useState } from "react";
import { FaWhatsapp, FaXmark, FaPaperPlane } from "react-icons/fa6";

const read = (k) => {
    try {
        return sessionStorage.getItem(k);
    } catch {
        return null;
    }
};
const write = (k, v) => {
    try {
        sessionStorage.setItem(k, v);
    } catch {
        /* storage unavailable */
    }
};

/**
 * Floating WhatsApp chat widget.
 * Always visible. With a WhatsApp number (Admin → Hero, About & Settings) "Start Chat"
 * opens WhatsApp; without one it falls back to the contact form.
 */
export default function WhatsAppButton({ number, message, name, avatar }) {
    const digits = String(number || "").replace(/\D/g, "");
    const [open, setOpen] = useState(false);
    const [teaser, setTeaser] = useState(false);
    const [typing, setTyping] = useState(true);

    // small "Need help?" bubble after a few seconds (once per browser session)
    useEffect(() => {
        if (read("pf-wa-teaser")) return;
        const t = setTimeout(() => setTeaser(true), 6000);
        return () => clearTimeout(t);
    }, []);

    // fake "typing…" before the greeting appears each time the card opens
    useEffect(() => {
        if (!open) return;
        setTyping(true);
        const t = setTimeout(() => setTyping(false), 1300);
        return () => clearTimeout(t);
    }, [open]);

    const text = message || "Hi! I visited your portfolio and would like to discuss a project.";
    const link = digits ? `https://wa.me/${digits}?text=${encodeURIComponent(text)}` : "#contact";
    const first = (name || "").split(" ")[0] || "there";

    const closeTeaser = () => {
        setTeaser(false);
        write("pf-wa-teaser", "1");
    };
    const toggle = () => {
        setOpen((o) => !o);
        closeTeaser();
    };

    return (
        <div className={`wa ${open ? "is-open" : ""}`}>
            {/* chat card */}
            <div className="wa-card" role="dialog" aria-label="WhatsApp chat" aria-hidden={!open}>
                <div className="wa-head">
                    <span className="wa-avatar">
                        {avatar ? <img src={avatar} alt={name} /> : <b>{(name || "?")[0]}</b>}
                        <i className="wa-online" />
                    </span>
                    <div>
                        <strong>{name}</strong>
                        <span>Online · replies in a few minutes</span>
                    </div>
                    <button className="wa-x" onClick={() => setOpen(false)} aria-label="Close chat">
                        <FaXmark />
                    </button>
                </div>
                <div className="wa-body">
                    {typing ? (
                        <div className="wa-bubble wa-typing" aria-label="typing">
                            <i />
                            <i />
                            <i />
                        </div>
                    ) : (
                        <div className="wa-bubble">
                            Hi there 👋
                            <br />
                            I'm {first}. How can I help you with your project?
                            <time>{new Date().toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" })}</time>
                        </div>
                    )}
                </div>
                {digits ? (
                    <a className="wa-start" href={link} target="_blank" rel="noopener noreferrer">
                        <FaWhatsapp /> Start Chat <FaPaperPlane className="wa-send" />
                    </a>
                ) : (
                    // no number configured yet → send visitors to the contact form
                    <a className="wa-start" href={link} onClick={() => setOpen(false)}>
                        <FaPaperPlane /> Send a Message
                    </a>
                )}
            </div>

            {/* teaser bubble */}
            {teaser && !open && (
                <div className="wa-teaser">
                    <button onClick={closeTeaser} aria-label="Dismiss">
                        <FaXmark />
                    </button>
                    <span onClick={toggle}>
                        👋 Need help? <b>Chat with me</b>
                    </span>
                </div>
            )}

            {/* floating button */}
            <button className="wa-fab" onClick={toggle} aria-label={open ? "Close WhatsApp chat" : "Chat on WhatsApp"} aria-expanded={open}>
                <span className="wa-ring" />
                <span className="wa-ring wa-ring2" />
                <span className="wa-label">Chat with me</span>
                <span className="wa-icon">{open ? <FaXmark /> : <FaWhatsapp />}</span>
            </button>
        </div>
    );
}
