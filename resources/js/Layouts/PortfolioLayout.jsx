import { Head, Link, usePage } from "@inertiajs/react";
import { useEffect, useRef, useState } from "react";
import { FaBars, FaXmark, FaPaperPlane, FaArrowUp } from "react-icons/fa6";
import SocialLinks from "@/Portfolio/SocialLinks";
import MatrixRain from "@/Portfolio/MatrixRain";
import useScrollReveal from "@/Portfolio/useScrollReveal";
import WhatsAppButton from "@/Portfolio/WhatsAppButton";
import AsciiGlitchText from "@/Portfolio/AsciiGlitchText";

const NAV = [
    ["Home", "home"],
    ["About", "about"],
    ["Skills", "skills"],
    ["Projects", "projects"],
    ["Services", "services"],
    ["Experience", "experience"],
    ["Blog", "/blog"],
    ["Contact", "contact"],
];

export function Logo({ settings }) {
    if (settings.site_logo) {
        return <img src={settings.site_logo} alt={settings.site_logo_text || "Logo"} className="pf-logo-img" />;
    }
    return (
        <span className="pf-logo">
            <span className="pf-logo-mark">&lt;/&gt;</span>
            {settings.site_logo_text || settings.hero_name || "Portfolio"}
        </span>
    );
}

export default function PortfolioLayout({ children, meta, isHome = false }) {
    const { settings = {}, flash = {} } = usePage().props;
    const [open, setOpen] = useState(false);
    const [scrolled, setScrolled] = useState(false);
    const [active, setActive] = useState(isHome ? "home" : "");
    const [toast, setToast] = useState(null);
    const [progress, setProgress] = useState(0);
    const navLock = useRef(0); // after a menu click, keep that item active until the smooth scroll ends

    useScrollReveal();

    // Same-page "#section" links: scroll ourselves. A native hash jump fires `popstate`,
    // which Inertia handles by resetting the scroll to the top — so the page never moved.
    useEffect(() => {
        const onClick = (e) => {
            if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
            const a = e.target.closest?.('a[href^="#"]');
            if (!a) return;
            const id = a.getAttribute("href").slice(1);
            const el = id ? document.getElementById(id) : null;
            if (!el) return;
            e.preventDefault();
            el.scrollIntoView({ behavior: "smooth", block: "start" }); // honours scroll-margin-top (fixed navbar)
            // update the URL but keep Inertia's history state, and don't trigger popstate
            window.history.replaceState(window.history.state, "", `#${id}`);
            navLock.current = Date.now() + 1200;
            setActive(id);
        };
        document.addEventListener("click", onClick);
        return () => document.removeEventListener("click", onClick);
    }, []);

    // liquid-metal click ripple on buttons
    useEffect(() => {
        const onDown = (e) => {
            const btn = e.target.closest?.(".pf-btn, .pf-social a, .pf-arrow");
            if (!btn) return;
            const r = btn.getBoundingClientRect();
            const dot = document.createElement("span");
            dot.className = "pf-ripple";
            dot.style.left = `${e.clientX - r.left}px`;
            dot.style.top = `${e.clientY - r.top}px`;
            btn.appendChild(dot);
            setTimeout(() => dot.remove(), 700);
        };
        document.addEventListener("pointerdown", onDown);
        return () => document.removeEventListener("pointerdown", onDown);
    }, []);

    useEffect(() => {
        const onScroll = () => {
            setScrolled(window.scrollY > 30);
            const max = document.documentElement.scrollHeight - window.innerHeight;
            setProgress(max > 0 ? Math.min(1, window.scrollY / max) : 0);
        };
        onScroll();
        window.addEventListener("scroll", onScroll, { passive: true });
        return () => window.removeEventListener("scroll", onScroll);
    }, []);

    // highlight the nav item of the section in view
    useEffect(() => {
        if (!isHome) return;
        // active = the last section whose top has passed just below the fixed navbar;
        // at the very bottom of the page the last section wins (it can't scroll any higher)
        const ids = NAV.filter(([, t]) => !t.startsWith("/")).map(([, t]) => t);
        let ticking = false;
        const update = () => {
            ticking = false;
            if (Date.now() < navLock.current) return;
            const line = 72 + 40; // navbar height + a little slack
            const atBottom = window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 4;
            const present = ids.map((id) => document.getElementById(id)).filter(Boolean);
            // closest section above the line, by real page position (menu order != page order)
            let current = present[0]?.id || "home";
            let best = -Infinity;
            for (const el of present) {
                const top = el.getBoundingClientRect().top;
                if (top <= line && top > best) {
                    best = top;
                    current = el.id;
                }
            }
            if (atBottom && present.length) {
                // pick the lowest section that is visible on screen
                const visible = present.filter((el) => el.getBoundingClientRect().top < window.innerHeight);
                current = visible.sort((a, b) => a.getBoundingClientRect().top - b.getBoundingClientRect().top).pop()?.id || current;
            }
            setActive(current);
        };
        const onScroll = () => {
            if (!ticking) {
                ticking = true;
                requestAnimationFrame(update);
            }
        };
        update();
        window.addEventListener("scroll", onScroll, { passive: true });
        window.addEventListener("resize", onScroll);
        return () => {
            window.removeEventListener("scroll", onScroll);
            window.removeEventListener("resize", onScroll);
        };
    }, [isHome]);

    useEffect(() => {
        if (flash.success || flash.error) {
            setToast(flash.success ? { type: "ok", text: flash.success } : { type: "err", text: flash.error });
            const t = setTimeout(() => setToast(null), 4500);
            return () => clearTimeout(t);
        }
    }, [flash.success, flash.error]);

    const href = (target) => (target.startsWith("/") ? target : isHome ? `#${target}` : `/#${target}`);
    const isActive = (target) =>
        target.startsWith("/") ? typeof window !== "undefined" && window.location.pathname.startsWith(target) : active === target;

    const NavLink = ({ label, target, className = "" }) =>
        target.startsWith("/") || !isHome ? (
            <Link href={href(target)} className={`${className} ${isActive(target) ? "active" : ""}`} onClick={() => setOpen(false)}>
                {label}
            </Link>
        ) : (
            <a href={href(target)} className={`${className} ${isActive(target) ? "active" : ""}`} onClick={() => setOpen(false)}>
                {label}
            </a>
        );

    return (
        <div className="pf">
            {/* full-site Matrix code rain (use color="#00ff41" for classic green) */}
            <MatrixRain />
            {/* scroll progress bar */}
            <div className="pf-progress" style={{ transform: `scaleX(${progress})` }} aria-hidden />
            {meta && (
                <Head title={meta.title}>
                    {meta.description && <meta name="description" content={meta.description} />}
                    {meta.image && <meta property="og:image" content={meta.image} />}
                </Head>
            )}

            <header className={`pf-nav ${scrolled ? "scrolled" : ""}`}>
                <div className="pf-container pf-nav-inner">
                    <Link href="/" className="pf-brand">
                        <Logo settings={settings} />
                    </Link>
                    <nav className={`pf-menu ${open ? "open" : ""}`}>
                        {NAV.map(([label, target]) => (
                            <NavLink key={target} label={label} target={target} />
                        ))}
                        <a href={href("contact")} className="pf-btn pf-btn-outline pf-menu-cta" onClick={() => setOpen(false)}>
                            Let's Talk <FaPaperPlane />
                        </a>
                    </nav>
                    <a href={href("contact")} className="pf-btn pf-btn-talk pf-nav-cta">
                        Let's Talk <FaPaperPlane />
                    </a>
                    <button className="pf-burger" aria-label="Menu" onClick={() => setOpen(!open)}>
                        {open ? <FaXmark /> : <FaBars />}
                    </button>
                </div>
            </header>

            <main>{children}</main>

            <footer className="pf-footer">
                <div className="pf-container pf-footer-inner">
                    <div>
                        <Link href="/" className="pf-brand">
                            <Logo settings={settings} />
                        </Link>
                        {settings.footer_tagline && <p className="pf-muted pf-small">{settings.footer_tagline}</p>}
                    </div>
                    <nav className="pf-footer-links">
                        {NAV.filter(([l]) => l !== "Experience").map(([label, target]) => (
                            <NavLink key={target} label={label} target={target} />
                        ))}
                    </nav>
                    <SocialLinks settings={settings} small />
                </div>
                <div className="pf-container pf-footer-bottom">
                    <span>{settings.copyright || `© ${new Date().getFullYear()} All rights reserved.`}</span>
                    {settings.hero_name && (
                        <span className="pf-footer-name" aria-label={settings.hero_name}>
                            <AsciiGlitchText
                                parts={[
                                    { text: `${settings.hero_name.split(" ")[0]} `, color: "#ffffff" },
                                    {
                                        text: settings.hero_name.split(" ").slice(1).join(" "),
                                        gradient: ["#b05cf8", "#6271ff"],
                                    },
                                ]}
                            />
                        </span>
                    )}
                    <span>
                        Designed with <span style={{ color: "#f43f5e" }}>♥</span> for Developers
                    </span>
                </div>
            </footer>

            {scrolled && (
                <button className="pf-top" aria-label="Back to top" onClick={() => window.scrollTo({ top: 0, behavior: "smooth" })}>
                    <FaArrowUp />
                </button>
            )}

            <WhatsAppButton
                number={settings.whatsapp_number}
                message={settings.whatsapp_message}
                name={settings.hero_name}
                avatar={settings.hero_image}
            />

            {toast && <div className={`pf-toast ${toast.type}`}>{toast.text}</div>}
        </div>
    );
}
