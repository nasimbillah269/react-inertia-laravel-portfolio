import { Link } from "@inertiajs/react";
import { FaArrowLeft } from "react-icons/fa6";
import PortfolioLayout from "@/Layouts/PortfolioLayout";

export default function Error({ status = 404, message = "Page not found." }) {
    return (
        <PortfolioLayout meta={{ title: `${status} | ${message}` }}>
            <section className="pf-page-head pf-error">
                <div className="pf-container">
                    <h1 className="pf-grad">{status}</h1>
                    <p className="pf-lead pf-muted">{message}</p>
                    <Link href="/" className="pf-btn pf-btn-primary">
                        <FaArrowLeft /> Back to Home
                    </Link>
                </div>
            </section>
        </PortfolioLayout>
    );
}
