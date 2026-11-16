import { Link } from "@inertiajs/react";
import { FaArrowLeft, FaArrowUpRightFromSquare, FaGithub, FaCode } from "react-icons/fa6";
import PortfolioLayout from "@/Layouts/PortfolioLayout";
import { SectionTitle, ProjectCard } from "@/Portfolio/Parts";

export default function ProjectDetail({ meta, project, related }) {
    return (
        <PortfolioLayout meta={meta}>
            <section className="pf-page-head">
                <div className="pf-container">
                    <Link href="/projects" className="pf-back">
                        <FaArrowLeft /> All Projects
                    </Link>
                    {project.category && <span className="pf-badge">{project.category}</span>}
                    <h1 className="pf-detail-title">{project.title}</h1>
                    {project.short_description && <p className="pf-muted pf-lead">{project.short_description}</p>}
                </div>
            </section>

            <section className="pf-section pt-0">
                <div className="pf-container pf-detail-grid">
                    <div>
                        <div className="pf-card pf-detail-img">
                            {project.image ? <img src={project.image} alt={project.title} /> : <div className="pf-project-ph big"><FaCode /></div>}
                        </div>
                        {project.description && <div className="pf-content" dangerouslySetInnerHTML={{ __html: project.description }} />}
                    </div>
                    <aside className="pf-card pf-detail-side">
                        <h3>Project Info</h3>
                        {project.client && (
                            <p>
                                <span>Client</span>
                                {project.client}
                            </p>
                        )}
                        {project.category && (
                            <p>
                                <span>Category</span>
                                {project.category}
                            </p>
                        )}
                        {project.date && (
                            <p>
                                <span>Date</span>
                                {project.date}
                            </p>
                        )}
                        {project.tags.length > 0 && (
                            <div className="pf-tags">
                                {project.tags.map((t) => (
                                    <span key={t}>{t}</span>
                                ))}
                            </div>
                        )}
                        <div className="pf-detail-btns">
                            {project.live_url && (
                                <a href={project.live_url} target="_blank" rel="noopener noreferrer" className="pf-btn pf-btn-primary pf-btn-sm">
                                    Live Preview <FaArrowUpRightFromSquare />
                                </a>
                            )}
                            {project.github_url && (
                                <a href={project.github_url} target="_blank" rel="noopener noreferrer" className="pf-btn pf-btn-outline pf-btn-sm">
                                    Source <FaGithub />
                                </a>
                            )}
                        </div>
                    </aside>
                </div>
            </section>

            {related.length > 0 && (
                <section className="pf-section pt-0">
                    <div className="pf-container">
                        <SectionTitle title="More" highlight="Projects" />
                        <div className="pf-project-grid three">
                            {related.map((p) => (
                                <ProjectCard key={p.id} project={p} />
                            ))}
                        </div>
                    </div>
                </section>
            )}
        </PortfolioLayout>
    );
}
