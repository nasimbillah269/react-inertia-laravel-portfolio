import React from "react";

import {
  FacebookShareButton,
  TwitterShareButton,
  WhatsappShareButton,
  LinkedinShareButton,
  FacebookIcon,
  TwitterIcon,
  WhatsappIcon,
  LinkedinIcon,
} from "react-share";
import { FaXTwitter, FaInstagram, FaTiktok } from "react-icons/fa6";

const ProductSocialSear = ({ product }) => {
  const currentUrl =  window.location.href; // Current page URL

  const productTitle = product.name || "Check out this product!";

  const productImage = product?.image_url || "/default-image.jpg";

   // Construct the Facebook share URL
   const facebookShareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentUrl)}&quote=${encodeURIComponent(productTitle)}`;

  // X (Twitter) Share URL
  const xShareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(
    currentUrl
  )}&text=${encodeURIComponent(productTitle)}`;



  return (
    <>

    <div className="quickview__social d-flex align-items-center mb-15 mt-5">
      <label className="quickview__social--title">Social Media Product Share: </label>
      <ul className="quickview__social--wrapper mt-0 d-flex">
        <li className="quickview__social--list">
     
          <FacebookShareButton url={currentUrl} quote={productTitle}>
            <FacebookIcon size={32} round />
          </FacebookShareButton>
        </li>
        {/* <li className="quickview__social--list">
          <TwitterShareButton url={currentUrl} title={productTitle}>
            <TwitterIcon size={32} round />
          </TwitterShareButton>
        </li> */}
         {/* X (Twitter) */}
        <li className="quickview__social--list">
          <a
            href={xShareUrl}
            target="_blank"
            rel="noopener noreferrer"
            className="social-circle x"
          >
            <FaXTwitter size={18} />
          </a>
        </li>
        <li className="quickview__social--list">
          <WhatsappShareButton url={currentUrl} title={productTitle}>
            <WhatsappIcon size={32} round />
          </WhatsappShareButton>
        </li>
        <li className="quickview__social--list">
          <LinkedinShareButton url={currentUrl} title={productTitle}>
            <LinkedinIcon size={32} round />
          </LinkedinShareButton>
        </li>
      </ul>
    </div>
    </>
  );
};

export default ProductSocialSear;
