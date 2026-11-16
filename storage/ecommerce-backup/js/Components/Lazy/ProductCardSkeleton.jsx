const ProductCardSkeleton = () => {
    return (
        <div className="product-skeleton-card">
            <div className="skeleton skeleton-image" />

            <div className="product-skeleton-content">
                <div className="skeleton skeleton-category" />
                <div className="skeleton skeleton-title" />
                <div className="skeleton skeleton-title skeleton-title-short" />

                <div className="d-flex align-items-center gap-2 mt-3">
                    <div className="skeleton skeleton-price" />
                    <div className="skeleton skeleton-old-price" />
                </div>

                <div className="skeleton skeleton-button mt-3" />
            </div>
        </div>
    );
};

export default ProductCardSkeleton;