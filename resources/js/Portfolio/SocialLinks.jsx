import { FaGithub, FaLinkedinIn, FaYoutube, FaXTwitter, FaFacebookF, FaEnvelope } from "react-icons/fa6";

const LINKS = [
    ["social_github", FaGithub, "GitHub"],
    ["social_linkedin", FaLinkedinIn, "LinkedIn"],
    ["social_youtube", FaYoutube, "YouTube"],
    ["social_twitter", FaXTwitter, "X"],
    ["social_facebook", FaFacebookF, "Facebook"],
];

export default function SocialLinks({ settings = {}, small = false }) {
    return (
        <div className={`pf-social ${small ? "small" : ""}`}>
            {LINKS.filter(([k]) => settings[k]).map(([k, Icon, label]) => (
                <a key={k} href={settings[k]} target="_blank" rel="noopener noreferrer" aria-label={label}>
                    <Icon />
                </a>
            ))}
            {settings.contact_email && (
                <a href={`mailto:${settings.contact_email}`} aria-label="Email">
                    <FaEnvelope />
                </a>
            )}
        </div>
    );
}
