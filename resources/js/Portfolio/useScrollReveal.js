import { useEffect } from "react";

// Elements that fade/slide in when they scroll into view.
const SELECTORS = [
    ".pf-hero-text > *",
    ".pf-hero-visual",
    ".pf-section-title",
    ".pf-about-media",
    ".pf-about-text > p, .pf-about-text li",
    ".pf-stat-row",
    ".pf-skill-marquee",
    ".pf-services-intro .pf-btn",
    ".pf-service",
    ".pf-row-between > .pf-btn",
    ".pf-project",
    ".pf-fact",
    ".pf-testimonial, .pf-dots",
    ".pf-contact-text .pf-btn",
    ".pf-plane",
    ".pf-form",
    ".pf-blog, .pf-filters, .pf-search, .pf-detail-img, .pf-detail-side, .pf-content, .pf-recent",
].join(",");

/**
 * Scroll-reveal: adds `.rv` to matching elements, then `.in` as each one enters
 * the viewport. Siblings get a small stagger. Once the transition finishes the
 * classes are removed again, so hover effects (translateY etc.) keep working.
 */
export default function useScrollReveal() {
    useEffect(() => {
        if (window.matchMedia?.("(prefers-reduced-motion: reduce)").matches) return;

        const els = Array.from(document.querySelectorAll(SELECTORS)).filter((el) => !el.closest(".rv"));
        els.forEach((el) => {
            // stagger by position among revealed siblings (cards in a grid, list items…)
            const sibs = Array.from(el.parentElement?.children || []).filter((c) => c.matches(SELECTORS));
            const i = Math.max(0, sibs.indexOf(el));
            el.style.setProperty("--rv-delay", `${Math.min(i, 9) * 70}ms`);
            el.classList.add("rv");
        });

        const done = (el) => {
            el.classList.remove("rv", "in");
            el.style.removeProperty("--rv-delay");
        };

        const obs = new IntersectionObserver(
            (entries) => {
                entries.forEach((e) => {
                    if (!e.isIntersecting) return;
                    const el = e.target;
                    el.classList.add("in");
                    obs.unobserve(el);
                    const delay = parseInt(el.style.getPropertyValue("--rv-delay")) || 0;
                    setTimeout(() => done(el), delay + 900);
                });
            },
            { rootMargin: "0px 0px -6% 0px", threshold: 0.05 }
        );
        els.forEach((el) => obs.observe(el));

        return () => {
            obs.disconnect();
            els.forEach(done);
        };
    }, []);
}
