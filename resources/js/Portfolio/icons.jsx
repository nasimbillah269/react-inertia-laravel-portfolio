import {
    SiLaravel, SiReact, SiNextdotjs, SiPhp, SiMysql, SiJavascript, SiTypescript, SiTailwindcss,
    SiBootstrap, SiGit, SiNodedotjs, SiVuedotjs, SiHtml5, SiCss3, SiPython, SiDocker, SiFigma,
    SiWordpress, SiMongodb, SiRedux,
} from "react-icons/si";
import {
    FaGlobe, FaMobileScreen, FaGear, FaCartShopping, FaPenNib, FaChartColumn, FaCode, FaServer,
    FaCloud, FaShieldHalved, FaRocket, FaUsers, FaHeart, FaTrophy, FaStar, FaClock, FaBriefcase,
    FaGraduationCap,
} from "react-icons/fa6";

// Keys must match App\Http\Controllers\Admin\PortfolioController::ICONS
export const ICONS = {
    laravel: [SiLaravel, "#ff2d20"],
    react: [SiReact, "#61dafb"],
    nextjs: [SiNextdotjs, "#ffffff"],
    php: [SiPhp, "#8892bf"],
    mysql: [SiMysql, "#4f9ed8"],
    javascript: [SiJavascript, "#f7df1e"],
    typescript: [SiTypescript, "#3178c6"],
    tailwind: [SiTailwindcss, "#38bdf8"],
    bootstrap: [SiBootstrap, "#8b5cf6"],
    git: [SiGit, "#f05032"],
    nodejs: [SiNodedotjs, "#68a063"],
    vue: [SiVuedotjs, "#42b883"],
    html: [SiHtml5, "#e34f26"],
    css: [SiCss3, "#1572b6"],
    python: [SiPython, "#3776ab"],
    docker: [SiDocker, "#2496ed"],
    figma: [SiFigma, "#f24e1e"],
    wordpress: [SiWordpress, "#21759b"],
    mongodb: [SiMongodb, "#47a248"],
    redux: [SiRedux, "#764abc"],
    web: [FaGlobe, "#60a5fa"],
    mobile: [FaMobileScreen, "#60a5fa"],
    api: [FaGear, "#38bdf8"],
    cart: [FaCartShopping, "#22d3ee"],
    design: [FaPenNib, "#c084fc"],
    seo: [FaChartColumn, "#38bdf8"],
    code: [FaCode, "#a78bfa"],
    server: [FaServer, "#60a5fa"],
    cloud: [FaCloud, "#7dd3fc"],
    shield: [FaShieldHalved, "#34d399"],
    rocket: [FaRocket, "#f472b6"],
    users: [FaUsers, "#60a5fa"],
    globe: [FaGlobe, "#38bdf8"],
    heart: [FaHeart, "#f472b6"],
    trophy: [FaTrophy, "#fbbf24"],
    star: [FaStar, "#fbbf24"],
    clock: [FaClock, "#22d3ee"],
    briefcase: [FaBriefcase, "#a78bfa"],
    graduation: [FaGraduationCap, "#a78bfa"],
};

/** Renders an uploaded image if given, else the icon for `name`, else a code icon. */
export default function Icon({ name, image, color, size = 28, alt = "" }) {
    if (image) {
        return <img src={image} alt={alt} style={{ width: size, height: size, objectFit: "contain" }} />;
    }
    const [Comp, defColor] = ICONS[name] || [FaCode, "#a78bfa"];
    return <Comp size={size} color={color || defColor} />;
}
