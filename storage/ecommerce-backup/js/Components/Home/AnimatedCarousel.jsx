import React, { useEffect, useMemo, useState } from "react";
import { ChevronLeft, ChevronRight } from "lucide-react";
import { Link } from "@inertiajs/react";

const AnimatedCarousel = ({ sliders = [] }) => {
    const [currentSlide, setCurrentSlide] = useState(0);
    const [loadedImages, setLoadedImages] = useState({});
    const [imageErrors, setImageErrors] = useState({});

    const slides = useMemo(() => {
        if (!Array.isArray(sliders)) {
            return [];
        }

        return sliders.map((slider) => ({
            id: slider?.id,
            bgImage: slider?.image || "",
            title: slider?.title || "",
            subtitle: slider?.subtitle || "",
            description: slider?.description || "",
            buttonText: slider?.button_text || "Shop Now",
            buttonLink: slider?.button_link || "#",
            textColor: slider?.text_color || "#000000",
        }));
    }, [sliders]);

    const nextSlide = () => {
        if (slides.length <= 1) return;

        setCurrentSlide((previousSlide) => {
            return (previousSlide + 1) % slides.length;
        });
    };

    const prevSlide = () => {
        if (slides.length <= 1) return;

        setCurrentSlide((previousSlide) => {
            return (
                (previousSlide - 1 + slides.length) %
                slides.length
            );
        });
    };

    const goToSlide = (index) => {
        setCurrentSlide(index);
    };

    const handleImageLoad = (index) => {
        setLoadedImages((previousImages) => ({
            ...previousImages,
            [index]: true,
        }));
    };

    const handleImageError = (index) => {
        setLoadedImages((previousImages) => ({
            ...previousImages,
            [index]: true,
        }));

        setImageErrors((previousErrors) => ({
            ...previousErrors,
            [index]: true,
        }));
    };

    useEffect(() => {
        if (slides.length <= 1) return undefined;

        const interval = window.setInterval(() => {
            setCurrentSlide((previousSlide) => {
                return (previousSlide + 1) % slides.length;
            });
        }, 4000);

        return () => {
            window.clearInterval(interval);
        };
    }, [slides.length]);

    /*
     * Preload the next slide image.
     */
    useEffect(() => {
        if (!slides.length) return undefined;

        const nextIndex =
            currentSlide === slides.length - 1
                ? 0
                : currentSlide + 1;

        const nextImageUrl = slides[nextIndex]?.bgImage;

        if (
            !nextImageUrl ||
            loadedImages[nextIndex] ||
            imageErrors[nextIndex]
        ) {
            return undefined;
        }

        const preloadImage = new Image();

        preloadImage.src = nextImageUrl;

        preloadImage.onload = () => {
            handleImageLoad(nextIndex);
        };

        preloadImage.onerror = () => {
            handleImageError(nextIndex);
        };

        return () => {
            preloadImage.onload = null;
            preloadImage.onerror = null;
        };
    }, [currentSlide, slides]);

    /*
     * Reset slide index if backend slider data changes.
     */
    useEffect(() => {
        if (currentSlide >= slides.length) {
            setCurrentSlide(0);
        }
    }, [slides.length, currentSlide]);

    if (!slides.length) {
        return (
            <div className="slideMain position-relative w-100 overflow-hidden">
                <div className="slider-skeleton">
                    <div className="slider-skeleton-shimmer" />
                </div>

                <SliderStyles />
            </div>
        );
    }

    const activeSlide = slides[currentSlide];
    const activeImageLoaded =
        Boolean(loadedImages[currentSlide]);
    const activeImageError =
        Boolean(imageErrors[currentSlide]);

    return (
        <div className="slideMain position-relative w-100 overflow-hidden">
            <Link
                href={activeSlide.buttonLink}
                className="slider-background position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                style={{
                    backgroundImage:
                        activeImageLoaded &&
                        !activeImageError &&
                        activeSlide.bgImage
                            ? `url("${activeSlide.bgImage}")`
                            : "none",
                    backgroundSize: "cover",
                    backgroundPosition: "center",
                    backgroundRepeat: "no-repeat",
                    transition: "all 1s ease-in-out",
                }}
            >
                {/* Hidden image used only to detect image loading */}
                {activeSlide.bgImage && (
                    <img
                        key={`${activeSlide.id ?? currentSlide}-${activeSlide.bgImage}`}
                        src={activeSlide.bgImage}
                        alt=""
                        className="slider-image-loader"
                        loading={
                            currentSlide === 0
                                ? "eager"
                                : "lazy"
                        }
                        decoding="async"
                        onLoad={() =>
                            handleImageLoad(currentSlide)
                        }
                        onError={() =>
                            handleImageError(currentSlide)
                        }
                    />
                )}

                {/* Skeleton loader */}
                {!activeImageLoaded && (
                    <div className="slider-skeleton">
                        <div className="slider-skeleton-shimmer" />
                    </div>
                )}

                {/* Error fallback */}
                {activeImageError && (
                    <div className="slider-image-error">
                        Image unavailable
                    </div>
                )}

                {/* Original overlay */}
                <div
                    className="position-absolute top-0 start-0 w-100 h-100 slider-overlay"
                    style={{
                        transition: "all 1s ease-in-out",
                    }}
                />

                {/* Original decorative circles */}
                <div
                    className="position-absolute top-0 start-0 w-100 h-100 decorative-circles"
                    style={{ opacity: 0.1 }}
                >
                    <div
                        className="position-absolute bg-white rounded-circle animate-pulse"
                        style={{
                            top: "2rem",
                            left: "2rem",
                            width: "8rem",
                            height: "8rem",
                        }}
                    />

                    <div
                        className="position-absolute bg-white rounded-circle"
                        style={{
                            top: "8rem",
                            right: "5rem",
                            width: "6rem",
                            height: "6rem",
                            animation:
                                "bounce 2s infinite 1s",
                        }}
                    />

                    <div
                        className="position-absolute bg-white rounded-circle"
                        style={{
                            bottom: "5rem",
                            left: "25%",
                            width: "4rem",
                            height: "4rem",
                            animation:
                                "ping 2s infinite 2s",
                        }}
                    />

                    <div
                        className="position-absolute bg-white rounded-circle"
                        style={{
                            bottom: "8rem",
                            right: "33%",
                            width: "5rem",
                            height: "5rem",
                            animation:
                                "pulse 2s infinite 0.5s",
                        }}
                    />
                </div>
            </Link>

            {/* Navigation arrows */}
            {slides.length > 1 && (
                <>
                    <button
                        type="button"
                        onClick={prevSlide}
                        className="slider-btn btn btn-outline-light position-absolute top-50 start-0 translate-middle-y ms-4 p-3"
                        aria-label="Previous slide"
                    >
                        <ChevronLeft size={24} />
                    </button>

                    <button
                        type="button"
                        onClick={nextSlide}
                        className="slider-btn btn btn-outline-light position-absolute top-50 end-0 translate-middle-y me-4 p-3"
                        aria-label="Next slide"
                    >
                        <ChevronRight size={24} />
                    </button>
                </>
            )}

            {/* Indicators */}
            {slides.length > 1 && (
                <div
                    className="slider-indicators position-absolute bottom-0 start-50 translate-middle-x mb-4 d-flex gap-3"
                    style={{ zIndex: 20 }}
                >
                    {slides.map((slide, index) => (
                        <button
                            key={slide.id ?? index}
                            type="button"
                            onClick={() => goToSlide(index)}
                            className="btn rounded-circle p-0"
                            aria-label={`Go to slide ${index + 1}`}
                            style={{
                                width: "12px",
                                height: "12px",
                                border: "none",
                                background:
                                    index === currentSlide
                                        ? "#ffffff"
                                        : "rgba(255, 255, 255, 0.5)",
                                transform:
                                    index === currentSlide
                                        ? "scale(1.25)"
                                        : "scale(1)",
                                transition:
                                    "all 0.3s ease",
                            }}
                        />
                    ))}
                </div>
            )}

            <SliderStyles />
        </div>
    );
};

const SliderStyles = () => {
    return (
        <style>{`
            .slideMain {
                min-height: 500px;
                background: #e8e8e8;
            }

            .slider-background {
                overflow: hidden;
            }

            .slider-image-loader {
                position: absolute;
                width: 1px;
                height: 1px;
                opacity: 0;
                pointer-events: none;
            }

            .slider-skeleton {
                position: absolute;
                inset: 0;
                z-index: 5;
                overflow: hidden;
                background: #e8e8e8;
            }

            .slider-skeleton-shimmer {
                position: absolute;
                inset: 0;
                transform: translateX(-100%);
                background: linear-gradient(
                    90deg,
                    transparent 0%,
                    rgba(255, 255, 255, 0.75) 50%,
                    transparent 100%
                );
                animation: sliderSkeletonLoading 1.4s infinite;
            }

            .slider-image-error {
                position: absolute;
                inset: 0;
                z-index: 6;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #eeeeee;
                color: #777777;
                font-size: 16px;
            }

            .slider-overlay {
                z-index: 2;
                pointer-events: none;
            }

            .decorative-circles {
                z-index: 3;
                pointer-events: none;
            }

            .slider-btn {
                z-index: 10;
            }

            @keyframes sliderSkeletonLoading {
                100% {
                    transform: translateX(100%);
                }
            }

            @keyframes pulse {
                0%,
                100% {
                    opacity: 1;
                    transform: scale(1);
                }

                50% {
                    opacity: 0.8;
                    transform: scale(1.02);
                }
            }

            @keyframes bounce {
                0%,
                20%,
                53%,
                80%,
                100% {
                    transform: translate3d(0, 0, 0);
                }

                40%,
                43% {
                    transform: translate3d(0, -15px, 0);
                }

                70% {
                    transform: translate3d(0, -7px, 0);
                }

                90% {
                    transform: translate3d(0, -2px, 0);
                }
            }

            @keyframes ping {
                75%,
                100% {
                    transform: scale(2);
                    opacity: 0;
                }
            }

            .animate-pulse {
                animation: pulse 2s infinite;
            }

            @media (max-width: 991.98px) {
                .slideMain {
                    min-height: 450px;
                }
            }

            @media (max-width: 767.98px) {
                .slideMain {
                    min-height: 300px;
                }

                .slider-btn {
                    padding: 8px !important;
                    margin-left: 8px !important;
                    margin-right: 8px !important;
                }

                .slider-btn svg {
                    width: 18px;
                    height: 18px;
                }
            }

            @media (max-width: 575.98px) {
                .slideMain {
                    min-height: 230px;
                }
            }
        `}</style>
    );
};

export default AnimatedCarousel;