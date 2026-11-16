
import DemoImageComponent from "@/Components/DemoImageComponent";
import HomeBestSellerCoponent from "@/Components/Home/HomeBestSellerCoponent";
import HomeCategoryComponent from "@/Components/Home/HomeCategoryComponent";
import HomeCelebretiGalleryComponent from "@/Components/Home/HomeCelebretiGalleryComponent";
import HomeDiscountBannerCoponent from "@/Components/Home/HomeDiscountBannerCoponent";
import HomeNewProductComponent from "@/Components/Home/HomeNewProductComponent";
import HomeNewsAndBlog from "@/Components/Home/HomeNewsAndBlog";
import HomeSliderComponent from "@/Components/Home/HomeSliderComponent";
import NewsletterPopup from "@/Components/NewsletterPopup";
import OurClients from "@/Components/Home/OurClients";
import MainLayout from "@/Layouts/MainLayout";
import { Head } from "@inertiajs/react";
import WowSlider from "@/Components/Home/WowSlider";
import AnimatedCarousel from "@/Components/Home/AnimatedCarousel";
import HometopCallection from "@/Components/Home/HometopCallection";
import HomeEcommerInfo from "@/Components/Home/HomeEcommerInfo";

export default function Welcome({
    general,
    sliders,
    headerMenu,
    categoryMenu,
    footerMenu2,
    footerMenu3,
    footerMenu4,
    topProducts,
    trandingProducts,
    latestProducts,
    clients,
    bannerGroupOne,
    timeOfferBanner,
    galleries,
    promotions,
    auth,
    blogs,
    carts,
    homeProductDatas,
    homeProductCtg,
    homeProductCtg2,
}) { 




    return (
        <>
            <MainLayout
                auth={auth}
                general={general}
                headerMenu={headerMenu}
                categoryMenu={categoryMenu}
                footerMenu4={footerMenu4}
                footerMenu2={footerMenu2}
                footerMenu3={footerMenu3}
                carts={carts}
            >
                <Head>
                    <meta name="title" property="og:title" content={general.meta_title} />
                    <meta name="description" property="og:description" content={general.meta_description} />
                    <meta name="keyword" property="og:keyword" content={general.meta_keyword} />
                    <meta name="image" property="og:image" content={general.logo_url} />
                    <meta name="url" property="og:url" content={route('index')} />
                    <link rel="canonical" href={route('index')} />
                </Head>
                <NewsletterPopup/>
              
                {/* {sliders.length > 0 && 
                <HomeSliderComponent sliders={sliders} />
                } */}

                <AnimatedCarousel sliders={sliders}/>

                <HometopCallection homeProductCtg={homeProductCtg}/>

           
                <HomeNewProductComponent topProducts={topProducts} trandingProducts={trandingProducts} latestProducts={latestProducts} homeProductDatas={homeProductDatas} />

                {homeProductCtg2.length > 0 &&   
                <HomeCategoryComponent homeProductCtg2={homeProductCtg2}/>
                }

             

             

                {blogs.length > 0 && 
                <HomeNewsAndBlog blogs={blogs}/>
                }

                <HomeEcommerInfo/>
          
            </MainLayout>
        </>
    );
}
