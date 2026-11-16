import { Link, usePage } from "@inertiajs/react";
import { useEffect, useState } from "react";
import { FaArrowRight, FaDownload, FaCircleCheck, FaChevronLeft, FaChevronRight, FaChevronDown } from "react-icons/fa6";
import PortfolioLayout from "@/Layouts/PortfolioLayout";
import Icon from "@/Portfolio/icons";
import SocialLinks from "@/Portfolio/SocialLinks";
import AnimatedCodeBlock from "@/Portfolio/AnimatedCodeBlock";
import TypingWords from "@/Portfolio/TypingWords";
import Marquee from "@/Portfolio/Marquee";
import CountUp from "@/Portfolio/CountUp";
import AsciiGlitchText from "@/Portfolio/AsciiGlitchText";
import { SectionTitle, ProjectCard, ContactForm, PaperPlaneArt, Waves } from "@/Portfolio/Parts";

// label shown under each floating hero badge (null = logo only, like the php badge in the design)
const LABELS = { laravel: "Laravel", nextjs: "Next.js", react: "React", php: null, mysql: "MySQL", javascript: "JavaScript", typescript: "TypeScript", tailwind: "Tailwind", nodejs: "Node.js", vue: "Vue" };

function Hero({ s, badgeImages = {} }) {
    const floating = (s.hero_floating_skills || "").split(",").map((x) => x.trim()).filter(Boolean).slice(0, 6);
    const [first, ...rest] = (s.hero_name || "Your Name").split(" ");
    // titles cycled by the typing animation (admin: "Typing titles"); defaults to the hero title
    const typing = (s.hero_typing_words || "").split(",").map((w) => w.trim()).filter(Boolean);
    const titles = typing.length ? typing : [s.hero_title].filter(Boolean);
    const initials = (s.hero_name || "Y N").split(" ").map((w) => w[0]).slice(0, 2).join("");

    return (
        <section
            id="home"
            className={`pf-hero ${s.hero_bg ? "has-bg" : ""}`}
            style={s.hero_bg ? { backgroundImage: `url(${s.hero_bg})` } : undefined}
        >
            {!s.hero_bg && <Waves />}
            <div className="pf-container pf-hero-grid">
                <div className="pf-hero-text">
                    {s.hero_greeting && <span className="pf-pill">👋 {s.hero_greeting}</span>}
                    <h1 aria-label={s.hero_name}>
                        {/* real text for SEO / screen readers; the canvas draws the ASCII glitch version */}
                        <span className="pf-sr">{s.hero_name}</span>
                        <AsciiGlitchText
                            parts={[
                                { text: `${first} `, color: "#ffffff" },
                                { text: rest.join(" "), gradient: ["#b05cf8", "#6271ff"] },
                            ]}
                        />
                    </h1>
                    {titles.length > 0 && (
                        <h2 className="pf-hero-title">
                            <TypingWords words={titles} from="#ffffff" to="#ffffff" />
                        </h2>
                    )}
                    {s.hero_description && <p className="pf-lead">{s.hero_description}</p>}
                    <div className="pf-actions">
                        <a href="#projects" className="pf-btn pf-btn-primary">
                            View My Projects <FaArrowRight />
                        </a>
                        <a
                            href={s.cv_file || "#contact"}
                            className="pf-btn pf-btn-outline"
                            {...(s.cv_file ? { target: "_blank", rel: "noopener noreferrer", download: true } : {})}
                        >
                            Download CV <FaDownload />
                        </a>
                    </div>
                    <SocialLinks settings={s} />
                </div>

                <div className="pf-hero-visual">
                    {/* glowing ring drawn in CSS so it always sits behind the photo, at any screen width */}
                    <div className="pf-hero-ring" aria-hidden />
                    {s.hero_image ? (
                        <img src={s.hero_image} alt={s.hero_name} className="pf-hero-photo" />
                    ) : (
                        <div className="pf-hero-avatar">{initials}</div>
                    )}
                    {floating.map((key, i) => (
                        <div key={key} className={`pf-float f${i + 1}`}>
                            <Icon name={key} image={badgeImages[key]} size={LABELS[key] === null ? 66 : 46} alt={LABELS[key] || key} />
                            {LABELS[key] !== null && <span>{LABELS[key] || key}</span>}
                        </div>
                    ))}
                    {s.hero_tagline && (
                        <div className="pf-tagline">
                            <TaglineText text={s.hero_tagline} />
                        </div>
                    )}
                </div>
            </div>
            <a href="#about" className="pf-scroll" aria-label="Scroll down">
                <span className="pf-mouse">
                    <span />
                </span>
                <FaChevronDown />
            </a>
        </section>
    );
}

/** Last word of the tagline is cyan, as in the design ("Code • Innovate • Inspire"). */
function TaglineText({ text }) {
    const parts = text.split(" ");
    const last = parts.pop();
    return (
        <>
            {parts.join(" ")} <span className="pf-tagline-accent">{last}</span>
        </>
    );
}

/** Snippet typed in the About code block, built from the admin data. */
function aboutCode(s, skills) {
    const q = (v) => JSON.stringify(v || "");
    const names = skills.slice(0, 4).map((k) => q(k.name)).join(", ");
    return [
        "interface Developer {",
        "  name: string;",
        "  role: string;",
        "  skills: string[];",
        "}",
        "",
        "const me: Developer = {",
        `  name: ${q(s.hero_name)},`,
        `  role: ${q(s.hero_title)},`,
        `  skills: [${names}],`,
        "};",
        "",
        "export function buildIdea(idea: string) {",
        "  return me.skills.reduce(",
        "    (product, skill) => craft(product, skill),",
        "    idea",
        "  ); // => clean, scalable, fast",
        "}",
    ].join("\n");
}

function About({ s, stats, skills }) {
    const points = (s.about_points || "").split("\n").map((p) => p.trim()).filter(Boolean);
    return (
        <section id="about" className="pf-about">
            <div className="pf-container pf-about-grid">
                <div className="pf-about-media pf-about-code">
                    <AnimatedCodeBlock code={aboutCode(s, skills)} filename="developer.ts" lang="TS" />
                </div>
                <div className="pf-about-text">
                    <SectionTitle badge="About Me" title={s.about_title} highlight={s.about_highlight} />
                    {s.about_text && <p className="pf-about-desc">{s.about_text}</p>}
                    {points.length > 0 && (
                        <ul className="pf-checks">
                            {points.map((p) => (
                                <li key={p}>
                                    <FaCircleCheck /> {p}
                                </li>
                            ))}
                        </ul>
                    )}
                </div>
                {stats.length > 0 && (
                    <div className="pf-about-stats">
                        {stats.map((st) => (
                            <div key={st.id} className="pf-stat-row">
                                <span className="pf-stat-icon">
                                    <Icon name={st.icon} image={st.image} size={38} alt={st.title} />
                                </span>
                                <div>
                                    <strong>
                                        <CountUp value={st.value} />
                                    </strong>
                                    <span>{st.title}</span>
                                </div>
                            </div>
                        ))}
                        {s.signature_image ? (
                            <img src={s.signature_image} alt={s.signature || "Signature"} className="pf-signature-img" />
                        ) : (
                            s.signature && <div className="pf-signature">{s.signature}</div>
                        )}
                    </div>
                )}
            </div>
        </section>
    );
}

function Skills({ s, skills }) {
    if (!skills.length) return null;
    return (
        <section id="skills" className="pf-skills">
            <div className="pf-container">
                <SectionTitle center badge="My Skills" title="Technologies I" highlight="Work With" subtitle={s.skills_subtitle} />
                {/* infinite marquee: hover to pause, drag to scroll */}
                <Marquee
                    className="pf-skill-marquee"
                    items={skills}
                    renderItem={(sk) => (
                        <div key={sk.id} className="pf-skill" title={sk.name}>
                            <Icon name={sk.icon} image={sk.image} color={sk.color} size={40} alt={sk.name} />
                            <span>{sk.name}</span>
                        </div>
                    )}
                />
            </div>
        </section>
    );
}

function Services({ s, services }) {
    if (!services.length) return null;
    return (
        <section id="services" className="pf-services">
            <div className="pf-container pf-services-grid">
                <div className="pf-services-intro">
                    <SectionTitle badge="My Services" title="What I Do" subtitle={s.services_text} />
                    <a href="#contact" className="pf-btn pf-btn-primary pf-btn-sm">
                        Explore All Services <FaArrowRight />
                    </a>
                </div>
                <div className="pf-service-list">
                    {services.map((sv) => (
                        <div key={sv.id} className="pf-service">
                            <div className="pf-service-icon">
                                <Icon name={sv.icon} image={sv.image} size={36} alt={sv.title} />
                            </div>
                            <div>
                                <h3>{sv.title}</h3>
                                <p>{sv.short_description}</p>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}

function Projects({ s, projects }) {
    return (
        <section id="projects" className="pf-projects">
            <div className="pf-container">
                <div className="pf-row-between">
                    <SectionTitle badge="My Portfolio" title="Featured Projects" subtitle={s.projects_subtitle} />
                    <Link href="/projects" className="pf-btn pf-btn-outline pf-btn-xs">
                        View All Projects <FaArrowRight />
                    </Link>
                </div>
                {projects.length ? (
                    <div className="pf-project-grid">
                        {projects.slice(0, 4).map((p) => (
                            <ProjectCard key={p.id} project={p} />
                        ))}
                    </div>
                ) : (
                    <p className="pf-muted">Projects coming soon.</p>
                )}
            </div>
        </section>
    );
}

function Testimonials({ items }) {
    const [i, setI] = useState(0);
    const n = items.length;
    useEffect(() => {
        if (n < 2) return;
        const t = setInterval(() => setI((x) => (x + 1) % n), 6000);
        return () => clearInterval(t);
    }, [n]);
    if (!n) return null;
    const t = items[i];

    return (
        <div className="pf-testimonials">
            <SectionTitle badge="Testimonials" title="What Clients Say" subtitle="Honest feedback from happy clients." as="h3" />
            <div className="pf-testimonial">
                <button className="pf-arrow left" onClick={() => setI((i - 1 + n) % n)} aria-label="Previous" disabled={n < 2}>
                    <FaChevronLeft />
                </button>
                <div className="pf-testimonial-body" key={t.id}>
                    <p>{t.message}</p>
                    <div className="pf-person">
                        {t.image ? <img src={t.image} alt={t.name} /> : <span className="pf-person-ph">{t.name[0]}</span>}
                        <div>
                            <strong>{t.name}</strong>
                            <span>{t.designation}</span>
                        </div>
                    </div>
                </div>
                <button className="pf-arrow right" onClick={() => setI((i + 1) % n)} aria-label="Next" disabled={n < 2}>
                    <FaChevronRight />
                </button>
            </div>
            <div className="pf-dots">
                {items.map((x, k) => (
                    <button key={x.id} className={k === i ? "on" : ""} onClick={() => setI(k)} aria-label={`Testimonial ${k + 1}`} />
                ))}
            </div>
        </div>
    );
}

function FactsAndTestimonials({ s, facts, testimonials }) {
    if (!facts.length && !testimonials.length) return null;
    return (
        <section id="experience" className="pf-facts">
            <div className="pf-container pf-facts-grid">
                <div>
                    <SectionTitle badge="My Achievement" title="Some Facts &" highlight="Numbers" subtitle={s.facts_subtitle} as="h3" />
                    <div className="pf-fact-grid">
                        {facts.map((f) => (
                            <div key={f.id} className="pf-fact">
                                <Icon name={f.icon} image={f.image} size={26} alt={f.title} />
                                <strong>
                                    <CountUp value={f.value} />
                                </strong>
                                <span>{f.title}</span>
                            </div>
                        ))}
                    </div>
                </div>
                <Testimonials items={testimonials} />
            </div>
        </section>
    );
}

export function ContactSection({ s }) {
    return (
        <section id="contact" className="pf-contact">
            <div className="pf-container pf-contact-grid">
                <div className="pf-contact-text">
                    <SectionTitle badge="Get In Touch" title={s.contact_title || "Let's Work Together"} subtitle={s.contact_text} />
                    <a href={s.contact_email ? `mailto:${s.contact_email}` : "#contact"} className="pf-btn pf-btn-primary pf-btn-sm">
                        Contact Me <FaArrowRight />
                    </a>
                    <PaperPlaneArt />
                </div>
                <ContactForm />
            </div>
            <div className="pf-contact-glow" aria-hidden />
        </section>
    );
}

export default function Home({ meta, badgeImages, skills, services, projects, testimonials, aboutStats, facts }) {
    const { settings: s = {} } = usePage().props;
    return (
        <PortfolioLayout meta={meta} isHome>
            <Hero s={s} badgeImages={badgeImages} />
            <About s={s} stats={aboutStats} skills={skills} />
            <Skills s={s} skills={skills} />
            <Services s={s} services={services} />
            <Projects s={s} projects={projects} />
            <FactsAndTestimonials s={s} facts={facts} testimonials={testimonials} />
            <ContactSection s={s} />
        </PortfolioLayout>
    );
}
