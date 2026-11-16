import { Link, router } from "@inertiajs/react";
import { useState } from "react";
import { FaMagnifyingGlass } from "react-icons/fa6";
import PortfolioLayout from "@/Layouts/PortfolioLayout";
import { SectionTitle } from "@/Portfolio/Parts";

export default function Blogs({ meta, blogs, search }) {
    const [q, setQ] = useState(search || "");
    const submit = (e) => {
        e.preventDefault();
        router.get("/blog", q ? { search: q } : {}, { preserveState: true });
    };

    return (
        <PortfolioLayout meta={meta}>
            <section className="pf-page-head">
                <div className="pf-container">
                    <SectionTitle center badge="Blog" title="Latest" highlight="Articles" subtitle="Thoughts, tutorials and insights." as="h1" />
                    <form className="pf-search" onSubmit={submit}>
                        <input value={q} onChange={(e) => setQ(e.target.value)} placeholder="Search articles..." aria-label="Search articles" />
                        <button aria-label="Search">
                            <FaMagnifyingGlass />
                        </button>
                    </form>
                </div>
            </section>
            <section className="pf-section pt-0">
                <div className="pf-container">
                    {blogs.data.length ? (
                        <div className="pf-blog-grid">
                            {blogs.data.map((b) => (
                                <Link key={b.id} href={`/blog/${b.slug}`} className="pf-card pf-blog">
                                    <img src={b.image} alt={b.title} loading="lazy" />
                                    <div>
                                        <span className="pf-small pf-muted">{b.date}</span>
                                        <h3>{b.title}</h3>
                                        <p>{b.excerpt}</p>
                                    </div>
                                </Link>
                            ))}
                        </div>
                    ) : (
                        <p className="pf-muted" style={{ textAlign: "center" }}>
                            No articles found.
                        </p>
                    )}
                    {blogs.last_page > 1 && (
                        <div className="pf-pagination">
                            {blogs.links.map((l, i) =>
                                l.url ? (
                                    <Link key={i} href={l.url} className={l.active ? "on" : ""} dangerouslySetInnerHTML={{ __html: l.label }} preserveScroll />
                                ) : (
                                    <span key={i} className="disabled" dangerouslySetInnerHTML={{ __html: l.label }} />
                                )
                            )}
                        </div>
                    )}
                </div>
            </section>
        </PortfolioLayout>
    );
}
