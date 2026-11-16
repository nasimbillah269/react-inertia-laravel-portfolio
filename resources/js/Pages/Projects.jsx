import { useMemo, useState } from "react";
import PortfolioLayout from "@/Layouts/PortfolioLayout";
import { SectionTitle, ProjectCard } from "@/Portfolio/Parts";

export default function Projects({ meta, projects, categories }) {
    const [cat, setCat] = useState("All");
    const list = useMemo(() => (cat === "All" ? projects : projects.filter((p) => p.category === cat)), [cat, projects]);

    return (
        <PortfolioLayout meta={meta}>
            <section className="pf-page-head">
                <div className="pf-container">
                    <SectionTitle center badge="My Portfolio" title="All" highlight="Projects" subtitle="A collection of things I've built." as="h1" />
                </div>
            </section>
            <section className="pf-section pt-0">
                <div className="pf-container">
                    {categories.length > 1 && (
                        <div className="pf-filters">
                            {["All", ...categories].map((c) => (
                                <button key={c} className={c === cat ? "on" : ""} onClick={() => setCat(c)}>
                                    {c}
                                </button>
                            ))}
                        </div>
                    )}
                    {list.length ? (
                        <div className="pf-project-grid">
                            {list.map((p) => (
                                <ProjectCard key={p.id} project={p} />
                            ))}
                        </div>
                    ) : (
                        <p className="pf-muted" style={{ textAlign: "center" }}>
                            No projects yet.
                        </p>
                    )}
                </div>
            </section>
        </PortfolioLayout>
    );
}
