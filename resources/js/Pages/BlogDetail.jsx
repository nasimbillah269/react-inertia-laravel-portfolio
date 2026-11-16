import { Link } from "@inertiajs/react";
import { FaArrowLeft } from "react-icons/fa6";
import PortfolioLayout from "@/Layouts/PortfolioLayout";

export default function BlogDetail({ meta, blog, recent }) {
    return (
        <PortfolioLayout meta={meta}>
            <section className="pf-page-head">
                <div className="pf-container pf-narrow">
                    <Link href="/blog" className="pf-back">
                        <FaArrowLeft /> All Articles
                    </Link>
                    <h1 className="pf-detail-title">{blog.title}</h1>
                    <p className="pf-muted">
                        {blog.date}
                        {blog.author && ` • by ${blog.author}`}
                    </p>
                </div>
            </section>
            <section className="pf-section pt-0">
                <div className="pf-container pf-blog-detail">
                    <article>
                        <img className="pf-blog-cover" src={blog.image} alt={blog.title} />
                        <div className="pf-content" dangerouslySetInnerHTML={{ __html: blog.description || "" }} />
                    </article>
                    {recent.length > 0 && (
                        <aside className="pf-card pf-recent">
                            <h3>Recent Articles</h3>
                            {recent.map((r) => (
                                <Link key={r.id} href={`/blog/${r.slug}`}>
                                    <img src={r.image} alt="" loading="lazy" />
                                    <div>
                                        <strong>{r.title}</strong>
                                        <span>{r.date}</span>
                                    </div>
                                </Link>
                            ))}
                        </aside>
                    )}
                </div>
            </section>
        </PortfolioLayout>
    );
}
