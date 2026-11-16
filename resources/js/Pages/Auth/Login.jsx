import { useForm, usePage } from "@inertiajs/react";
import { FaArrowRight } from "react-icons/fa6";
import PortfolioLayout from "@/Layouts/PortfolioLayout";

export default function Login() {
    const { flash = {} } = usePage().props;
    const { data, setData, post, processing, errors } = useForm({ email: "", password: "", remember: false });

    const submit = (e) => {
        e.preventDefault();
        post("/login");
    };

    return (
        <PortfolioLayout meta={{ title: "Admin Login" }}>
            <section className="pf-page-head">
                <div className="pf-container pf-login-wrap">
                    <form className="pf-card pf-form pf-login" onSubmit={submit}>
                        <h1>
                            Admin <span className="pf-grad">Login</span>
                        </h1>
                        {flash.error && <div className="pf-alert">{flash.error}</div>}
                        <label>
                            <input
                                type="text"
                                placeholder="Email or username"
                                value={data.email}
                                onChange={(e) => setData("email", e.target.value)}
                                autoComplete="username"
                                aria-label="Email or username"
                            />
                            {errors.email && <small className="pf-err">{errors.email}</small>}
                        </label>
                        <label>
                            <input
                                type="password"
                                placeholder="Password"
                                value={data.password}
                                onChange={(e) => setData("password", e.target.value)}
                                autoComplete="current-password"
                                aria-label="Password"
                            />
                            {errors.password && <small className="pf-err">{errors.password}</small>}
                        </label>
                        <label className="pf-check">
                            <input type="checkbox" checked={data.remember} onChange={(e) => setData("remember", e.target.checked)} /> Remember me
                        </label>
                        <button className="pf-btn pf-btn-primary" disabled={processing}>
                            {processing ? "Signing in..." : "Sign In"} <FaArrowRight />
                        </button>
                    </form>
                </div>
            </section>
        </PortfolioLayout>
    );
}
