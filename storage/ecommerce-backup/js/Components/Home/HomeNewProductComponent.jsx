import { IoCartOutline } from "react-icons/io5";
import { CiHeart } from "react-icons/ci";
import { IoEyeOutline } from "react-icons/io5";
import { useState } from "react";
import { MdOutlineStarPurple500 } from "react-icons/md";
import { FaFacebook, FaInstagram, FaTwitter, FaYoutube } from "react-icons/fa";
import Slider from "react-slick";
import QuickViewModal from "../QuickViewModal";
import ProductGallery from "../products/ProductGallery";
import ProductGrid from "../products/ProductGrid";
import NewProductGallery from "../NewProductGallery";
import LazyProductSection from "../Lazy/LazyProductSection";


export default function HomeNewProductComponent({topProducts,trandingProducts,latestProducts, homeProductDatas}) {
    // State to track the active tab
    const [activeTab, setActiveTab] = useState("newarrival");
    const [isModalOpen, setModalOpen] = useState(false);


    const [productQuantity, setProductQuantity] = useState(1);

    const [selectedSize, setSelectedSize] = useState("S"); // Default selected size
    const [selectedColor, setSelectedColor] = useState("Red"); // Default selected color

    const handleSizeChange = (event) => {
        setSelectedSize(event.target.value); // Update the selected size state
        console.log("Selected Size:", event.target.value);
      };

    const handleColorChange = (event) => {
      setSelectedColor(event.target.value); // Update the selected color state
      console.log("Selected Color:", event.target.value);
    };

    const handleIncrement = () =>{
        setProductQuantity((prevQuantity) => prevQuantity + 1);
        console.log('button click pluse', productQuantity)
    }

    const handleDecrement = () => {
        if (productQuantity > 1) {
          setProductQuantity((prevQuantity) => prevQuantity - 1);
        }
      };

    const handleOpenModal = () => {
      setModalOpen(true);
    };
  
    const handleCloseModal = () => {
      setModalOpen(false);
    };


    // Function to handle tab click
    const handleTabClick = (tab) => {
        setActiveTab(tab);
    };



    const sliderSettings = {
        dots: false,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 4000,
        speed: 600,
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: false,

        // React Slick lazy loading
        lazyLoad: "ondemand",

        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    dots: true,
                },
            },
        ],
    };


      const firstSixTopProducts = topProducts.slice(0, 5);
      const lastSixTopProducts = topProducts.slice(6, 11);

      const firstSixTrandProducts = trandingProducts.slice(0, 5);
      const lastSixTrandProducts = trandingProducts.slice(6, 11);


      const fisrtSixLetestProducts = latestProducts.slice(0, 5);
      const lastSixLetestProducts = latestProducts.slice(6, 11);


      console.log(homeProductDatas);



    return (
       <>
            {Array.isArray(homeProductDatas) &&
                homeProductDatas.map((homeProductData, index) => (
                    <LazyProductSection
                        key={
                            homeProductData?.id ??
                            `home-product-section-${index}`
                        }
                        section={homeProductData}
                        settings={sliderSettings}
                    />
                ))}

            <QuickViewModal
                isOpen={isModalOpen}
                onClose={handleCloseModal}
                content={
                    <section className="product__details--section section--padding modalView">
                        <div className="container">
                            <div className="row row-cols-lg-2 row-cols-md-2">
                                <div className="col">
                                    <NewProductGallery />
                                </div>

                                <div className="col">
                                    <div className="product__details--info">
                                        <form>
                                            <h2 className="product__details--info__title mb-15">
                                                Oversize Cotton Dress
                                            </h2>

                                            <div className="product__details--info__price mb-10">
                                                <span className="current__price">
                                                    $110
                                                </span>

                                                <span className="price__divided" />

                                                <span className="old__price">
                                                    $178
                                                </span>
                                            </div>

                                            <div className="product__details--info__rating d-flex align-items-center mb-15">
                                                <ul className="rating d-flex justify-content-center">
                                                    {Array.from({
                                                        length: 5,
                                                    }).map((_, index) => (
                                                        <li
                                                            key={index}
                                                            className="rating__list"
                                                        >
                                                            <span className="rating__list--icon">
                                                                <MdOutlineStarPurple500 />
                                                            </span>
                                                        </li>
                                                    ))}
                                                </ul>

                                                <span className="product__items--rating__count--number">
                                                    (24)
                                                </span>
                                            </div>

                                            <p className="product__details--info__desc mb-15">
                                                Lorem ipsum dolor sit amet
                                                consectetur adipisicing elit.
                                                Aut numquam ullam recusandae
                                                laborum explicabo.
                                            </p>

                                            <div className="product__variant">
                                                <div className="product__variant--list mb-10">
                                                    <fieldset className="variant__input--fieldset">
                                                        <legend className="product__variant--title mb-8">
                                                            Color:{" "}
                                                            {selectedColor}
                                                        </legend>

                                                        {[
                                                            {
                                                                value: "Red",
                                                                image: "/images/img/product/product1.png",
                                                            },
                                                            {
                                                                value: "Black",
                                                                image: "/images/img/product/product2.png",
                                                            },
                                                            {
                                                                value: "Pink",
                                                                image: "/images/img/product/product3.png",
                                                            },
                                                            {
                                                                value: "Orange",
                                                                image: "/images/img/product/product4.png",
                                                            },
                                                        ].map(
                                                            (
                                                                color,
                                                                index
                                                            ) => {
                                                                const inputId = `product-color-${index}`;

                                                                return (
                                                                    <span
                                                                        key={
                                                                            color.value
                                                                        }
                                                                    >
                                                                        <input
                                                                            id={
                                                                                inputId
                                                                            }
                                                                            name="color"
                                                                            type="radio"
                                                                            value={
                                                                                color.value
                                                                            }
                                                                            checked={
                                                                                selectedColor ===
                                                                                color.value
                                                                            }
                                                                            onChange={
                                                                                handleColorChange
                                                                            }
                                                                        />

                                                                        <label
                                                                            className="variant__color--value red"
                                                                            htmlFor={
                                                                                inputId
                                                                            }
                                                                            title={
                                                                                color.value
                                                                            }
                                                                        >
                                                                            <img
                                                                                className="variant__color--value__img"
                                                                                src={
                                                                                    color.image
                                                                                }
                                                                                alt={
                                                                                    color.value
                                                                                }
                                                                                loading="lazy"
                                                                            />
                                                                        </label>
                                                                    </span>
                                                                );
                                                            }
                                                        )}
                                                    </fieldset>
                                                </div>

                                                <div className="product__variant--list mb-15">
                                                    <fieldset className="variant__input--fieldset weight">
                                                        <legend className="product__variant--title mb-8">
                                                            Size:{" "}
                                                            {selectedSize}
                                                        </legend>

                                                        {[
                                                            "S",
                                                            "M",
                                                            "L",
                                                            "XL",
                                                        ].map(
                                                            (
                                                                size,
                                                                index
                                                            ) => {
                                                                const inputId = `product-size-${index}`;

                                                                return (
                                                                    <span
                                                                        key={
                                                                            size
                                                                        }
                                                                    >
                                                                        <input
                                                                            id={
                                                                                inputId
                                                                            }
                                                                            name="weight"
                                                                            type="radio"
                                                                            value={
                                                                                size
                                                                            }
                                                                            checked={
                                                                                selectedSize ===
                                                                                size
                                                                            }
                                                                            onChange={
                                                                                handleSizeChange
                                                                            }
                                                                        />

                                                                        <label
                                                                            className="variant__size--value red"
                                                                            htmlFor={
                                                                                inputId
                                                                            }
                                                                        >
                                                                            {
                                                                                size
                                                                            }
                                                                        </label>
                                                                    </span>
                                                                );
                                                            }
                                                        )}
                                                    </fieldset>
                                                </div>

                                                <div className="product__variant--list quantity d-flex align-items-center mb-20">
                                                    <div className="quantity__box">
                                                        <button
                                                            onClick={
                                                                handleDecrement
                                                            }
                                                            type="button"
                                                            className="quantity__value quickview__value--quantity decrease"
                                                            aria-label="Decrease quantity"
                                                        >
                                                            -
                                                        </button>

                                                        <label>
                                                            <input
                                                                type="number"
                                                                className="quantity__number quickview__value--number"
                                                                value={
                                                                    productQuantity
                                                                }
                                                                min="1"
                                                                readOnly
                                                            />
                                                        </label>

                                                        <button
                                                            onClick={
                                                                handleIncrement
                                                            }
                                                            type="button"
                                                            className="quantity__value quickview__value--quantity increase"
                                                            aria-label="Increase quantity"
                                                        >
                                                            +
                                                        </button>
                                                    </div>

                                                    <button
                                                        className="quickview__cart--btn primary__btn"
                                                        type="button"
                                                    >
                                                        Add To Cart
                                                    </button>

                                                    <button
                                                        className="quickview__cart--btn primary__btn wishList"
                                                        type="button"
                                                    >
                                                        Add to Wishlist
                                                    </button>
                                                </div>

                                                <div className="product__variant--list mb-15">
                                                    <button
                                                        className="variant__buy--now__btn primary__btn"
                                                        type="button"
                                                    >
                                                        Buy it now
                                                    </button>
                                                </div>
                                            </div>

                                            <div className="quickview__social d-flex align-items-center mb-15">
                                                <label className="quickview__social--title">
                                                    Social Share:
                                                </label>

                                                <ul className="quickview__social--wrapper mt-0 d-flex">
                                                    <li className="quickview__social--list">
                                                        <a
                                                            className="quickview__social--icon"
                                                            target="_blank"
                                                            rel="noreferrer"
                                                            href="https://www.facebook.com"
                                                        >
                                                            <FaFacebook />
                                                            <span className="visually-hidden">
                                                                Facebook
                                                            </span>
                                                        </a>
                                                    </li>

                                                    <li className="quickview__social--list">
                                                        <a
                                                            className="quickview__social--icon"
                                                            target="_blank"
                                                            rel="noreferrer"
                                                            href="https://twitter.com"
                                                        >
                                                            <FaTwitter />
                                                            <span className="visually-hidden">
                                                                Twitter
                                                            </span>
                                                        </a>
                                                    </li>

                                                    <li className="quickview__social--list">
                                                        <a
                                                            className="quickview__social--icon"
                                                            target="_blank"
                                                            rel="noreferrer"
                                                            href="https://www.instagram.com"
                                                        >
                                                            <FaInstagram />
                                                            <span className="visually-hidden">
                                                                Instagram
                                                            </span>
                                                        </a>
                                                    </li>

                                                    <li className="quickview__social--list">
                                                        <a
                                                            className="quickview__social--icon"
                                                            target="_blank"
                                                            rel="noreferrer"
                                                            href="https://www.youtube.com"
                                                        >
                                                            <FaYoutube />
                                                            <span className="visually-hidden">
                                                                YouTube
                                                            </span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                }
            />
        </>
    );
}
