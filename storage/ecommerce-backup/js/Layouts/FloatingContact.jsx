import React, { useState } from "react";
import {
  FaWhatsapp,
  FaFacebookMessenger,
  FaPhone,
  FaEnvelope,
  FaInstagram,
  FaTiktok,
  FaComments,
  FaXmark,
} from "react-icons/fa6";



const FloatingContact = () => {
  const [isOpen, setIsOpen] = useState(false);

  const contactItems = [
    {
      id: 1,
      title: "WhatsApp",
      icon: <FaWhatsapp />,
      link: "https://wa.me/447782273969",
      className: "whatsapp",
    },
    {
      id: 2,
      title: "Messenger",
      icon: <FaFacebookMessenger />,
      link: "https://m.me/yourFacebookUsername",
      className: "messenger",
    },
    {
      id: 3,
      title: "Call Us",
      icon: <FaPhone />,
      link: "tel:+447782273969",
      className: "phone",
    },

  ];

  return (
    <div className={`floating-contact ${isOpen ? "active" : ""}`}>
      <div className="floating-contact__items">
        {contactItems.map((item, index) => (
          <div
            className="floating-contact__item-wrapper"
            key={item.id}
            style={{
              "--item-index": index,
            }}
          >
            <span className="floating-contact__tooltip">{item.title}</span>

            <a
              href={item.link}
              target={
                item.link.startsWith("http") ? "_blank" : undefined
              }
              rel={
                item.link.startsWith("http")
                  ? "noopener noreferrer"
                  : undefined
              }
              className={`floating-contact__item ${item.className}`}
              aria-label={item.title}
              title={item.title}
            >
              {item.icon}
            </a>
          </div>
        ))}
      </div>

      <button
        type="button"
        className="floating-contact__toggle"
        onClick={() => setIsOpen((previousState) => !previousState)}
        aria-label={isOpen ? "Close contact menu" : "Open contact menu"}
        aria-expanded={isOpen}
      >
        <span className="floating-contact__pulse" />

        <span className="floating-contact__toggle-icon">
          {isOpen ? <FaXmark /> : <FaComments />}
        </span>
      </button>
    </div>
  );
};

export default FloatingContact;