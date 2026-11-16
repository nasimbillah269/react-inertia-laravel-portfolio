import { Link, useForm } from "@inertiajs/react";
import { FaArrowRight, FaCode } from "react-icons/fa6";

/** "Technologies I <Work With>" — `highlight` is rendered with the violet gradient. */
export function SectionTitle({ badge, title, highlight, subtitle, center = false, as: Tag = "h2" }) {
    return (
        <div className={`pf-section-title ${center ? "center" : ""}`}>
            {badge && <span className="pf-badge">{badge}</span>}
            <Tag>
                {/* "|" in a title = line break (set from admin, e.g. "Turning Ideas into|Powerful") */}
                {String(title || "")
                    .split("|")
                    .map((part, i) => (
                        <span key={i}>
                            {i > 0 && <br />}
                            {part.trim()}
                        </span>
                    ))}{" "}
                {highlight && <span className="pf-grad">{highlight}</span>}
            </Tag>
            {subtitle && <p>{subtitle}</p>}
        </div>
    );
}

export function ProjectCard({ project }) {
    return (
        <Link href={`/projects/${project.slug}`} className="pf-project">
            <div className="pf-project-img">
                {project.image ? (
                    <img src={project.image} alt={project.title} loading="lazy" />
                ) : (
                    <div className="pf-project-ph">
                        <FaCode />
                    </div>
                )}
            </div>
            <div className="pf-project-body">
                <div>
                    <h3>{project.title}</h3>
                    <div className="pf-tags">
                        {project.tags.slice(0, 3).map((t) => (
                            <span key={t}>{t}</span>
                        ))}
                    </div>
                </div>
                <span className="pf-round-btn" aria-hidden>
                    <FaArrowRight />
                </span>
            </div>
        </Link>
    );
}

/** Input whose placeholder shows a red "*" (a native placeholder can't be two colours). */
function Field({ label, value, onChange, error, type = "text", textarea = false }) {
    const Tag = textarea ? "textarea" : "input";
    return (
        <label className="pf-field">
            <Tag type={textarea ? undefined : type} rows={textarea ? 3 : undefined} value={value} onChange={onChange} aria-label={label} />
            {!value && (
                <span className="pf-ph">
                    {label} <b>*</b>
                </span>
            )}
            {error && <small className="pf-err">{error}</small>}
        </label>
    );
}

export function ContactForm() {
    const { data, setData, post, processing, errors, reset } = useForm({ name: "", email: "", subject: "", message: "" });

    const submit = (e) => {
        e.preventDefault();
        post("/contact", { preserveScroll: true, onSuccess: () => reset() });
    };

    return (
        <form className="pf-form" onSubmit={submit} noValidate>
            <div className="pf-form-row">
                <Field label="Your Name" value={data.name} onChange={(e) => setData("name", e.target.value)} error={errors.name} />
                <Field label="Your Email" type="email" value={data.email} onChange={(e) => setData("email", e.target.value)} error={errors.email} />
            </div>
            <Field label="Your Message" textarea value={data.message} onChange={(e) => setData("message", e.target.value)} error={errors.message} />
            <div>
                <button className="pf-btn pf-btn-primary pf-btn-sm" disabled={processing}>
                    {processing ? "Sending..." : "Send Message"} <FaArrowRight />
                </button>
            </div>
        </form>
    );
}

/** Paper plane with a dashed looping trail (contact section). */
export function PaperPlaneArt() {
    return (
        <svg className="pf-plane" viewBox="0 0 260 150" aria-hidden>
            <defs>
                <linearGradient id="pfPlaneA" x1="0" y1="1" x2="1" y2="0">
                    <stop offset="0" stopColor="#a855f7" />
                    <stop offset="1" stopColor="#60a5fa" />
                </linearGradient>
                <linearGradient id="pfPlaneB" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0" stopColor="#7c3aed" />
                    <stop offset="1" stopColor="#c026d3" />
                </linearGradient>
                <filter id="pfPlaneGlow" x="-50%" y="-50%" width="200%" height="200%">
                    <feGaussianBlur stdDeviation="6" result="b" />
                    <feMerge>
                        <feMergeNode in="b" />
                        <feMergeNode in="SourceGraphic" />
                    </feMerge>
                </filter>
            </defs>
            <path
                d="M2 140 C 60 140, 120 120, 150 95 C 175 75, 165 40, 130 42 C 95 44, 80 85, 105 110 C 125 130, 160 125, 190 92"
                fill="none"
                stroke="#a855f7"
                strokeOpacity=".75"
                strokeWidth="2"
                strokeDasharray="6 6"
                strokeLinecap="round"
            />
            <g filter="url(#pfPlaneGlow)">
                <polygon points="158,38 255,8 205,60" fill="url(#pfPlaneA)" />
                <polygon points="205,60 255,8 228,78" fill="url(#pfPlaneB)" />
                <polygon points="190,50 205,60 200,72" fill="#5b21b6" />
            </g>
        </svg>
    );
}

/** Thin neon wave lines used at the bottom of the hero. */
export function Waves() {
    const lines = Array.from({ length: 14 });
    return (
        <svg className="pf-waves" viewBox="0 0 1440 260" preserveAspectRatio="none" aria-hidden>
            <defs>
                <linearGradient id="pfWave" x1="0" x2="1">
                    <stop offset="0" stopColor="#a855f7" />
                    <stop offset=".45" stopColor="#6d28d9" stopOpacity=".25" />
                    <stop offset=".7" stopColor="#3b82f6" stopOpacity=".3" />
                    <stop offset="1" stopColor="#38bdf8" />
                </linearGradient>
            </defs>
            {lines.map((_, i) => (
                <path
                    key={i}
                    d={`M0 ${150 + i * 6} C 260 ${40 + i * 9}, 520 ${250 - i * 4}, 760 ${190 + i * 2} S 1180 ${80 + i * 8}, 1440 ${120 + i * 7}`}
                    fill="none"
                    stroke="url(#pfWave)"
                    strokeWidth={i % 4 === 0 ? 1.6 : 0.8}
                    strokeOpacity={0.25 + (i % 4) * 0.12}
                />
            ))}
        </svg>
    );
}
