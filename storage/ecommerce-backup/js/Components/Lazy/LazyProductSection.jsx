import { useEffect, useRef, useState } from "react";
import Slider from "react-slick";
import ProductCardSkeleton from "./ProductCardSkeleton";
import ProductGrid from "../products/ProductGrid";



const LazyProductSection = ({ section, settings }) => {
    const sectionRef = useRef(null);
    const [isVisible, setIsVisible] = useState(false);

    useEffect(() => {
        const currentSection = sectionRef.current;

        if (!currentSection) {
            return;
        }

        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    setIsVisible(true);

                    // Render only once, then stop observing.
                    observer.unobserve(currentSection);
                }
            },
            {
                root: null,
                rootMargin: "250px 0px",
                threshold: 0.01,
            }
        );

        observer.observe(currentSection);

        return () => {
            observer.disconnect();
        };
    }, []);

    const products = Array.isArray(section?.products)
        ? section.products
        : [];

    return (
        <section
            ref={sectionRef}
            className="product__section section--padding pb-0 homeProduct"
        >
            <div className="container">
                <div className="wrapper">
                    <div className="wpb_wrapper">
                        <div className="wpb_text_column wpb_content_element module-title">
                            <div className="wpb_wrapper">
                                {section?.sub_title && (
                                    <p>
                                        <em>{section.sub_title}</em>
                                    </p>
                                )}

                                <h3>
                                    <strong>{section?.name}</strong>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="slider-container">
                    {isVisible ? (
                        products.length > 0 ? (
                            <Slider {...settings}>
                                {products.map((product, index) => (
                                    <div
                                        key={
                                            product?.id ??
                                            `${section?.id ?? "section"}-${index}`
                                        }
                                        className="product-slide-item"
                                    >
                                        <ProductGrid
                                         product={product} />
                                    </div>
                                ))}
                            </Slider>
                        ) : (
                            <div className="text-center py-5">
                                No products found.
                            </div>
                        )
                    ) : (
                        <ProductSkeletonSlider />
                    )}
                </div>
            </div>
        </section>
    );
};

const ProductSkeletonSlider = () => {
    return (
        <div className="row g-3 g-lg-4">
            {Array.from({ length: 4 }).map((_, index) => (
                <div
                    key={index}
                    className="col-12 col-sm-6 col-md-4 col-lg-3"
                >
                    <ProductCardSkeleton />
                </div>
            ))}
        </div>
    );
};

export default LazyProductSection;