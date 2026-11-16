
import Slider from "react-slick";
import BlogGrid from "../blogs/BlogGrid";
import { FaArrowLeft, FaArrowRight } from "react-icons/fa";
export default function HomeNewsAndBlog({blogs}) {


const CustomPrevArrow = ({ className, style, onClick }) => (
    <div className={`custom-arrow custom-prev`} onClick={onClick}>
        <FaArrowLeft />
    </div>
);

const CustomNextArrow = ({ className, style, onClick }) => (
    <div className={`custom-arrow custom-next`} onClick={onClick}>
        <FaArrowRight />
    </div>
);




var settings = {
    dots: false,
    infinite: true,
    autoplay: false, // autoplay removed
    speed: 1000,
    slidesToShow: 3,
    slidesToScroll: 1,
    initialSlide: 0,
    arrows: true, // enable next/previous buttons
    prevArrow: <CustomPrevArrow />,
    nextArrow: <CustomNextArrow />,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: true,
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                initialSlide: 2
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
};






  return (
    <>
        <section class="blog__section section--padding pt-0 homeNews">
             <div class="container">
                 
                   <div class="wrapper wrapper2">
                        <div class="wpb_wrapper">
                            <div class="wpb_text_column wpb_content_element module-title">
                                <div class="wpb_wrapper">
                                    <p><em>LATEST NEWS</em></p>
                                    <h3><strong>FROM OUR BLOG</strong></h3>
                                </div>
                            </div>
                        </div>
                    </div>


                <div className="slider-container news-slider">
                        <Slider {...settings}>
                            {blogs.map((blog, index) => (
                                <BlogGrid key={index} blog={blog} />
                            ))}
                        </Slider>
                </div>  

                </div>
         </section> 
    </>
  )
}
