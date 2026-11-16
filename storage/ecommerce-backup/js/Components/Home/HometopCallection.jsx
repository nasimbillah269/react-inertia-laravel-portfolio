import { Link } from '@inertiajs/react'

import Slider from "react-slick";
export default function HometopCallection({homeProductCtg}) {

  const length = homeProductCtg.length;

  const sliderCount = length < 2 ? 1 : 2




    var settings = {
        dots: false,
        infinite: true,
        autoplay: true,
        speed: 1000,
        slidesToShow: sliderCount,
        slidesToScroll: 1,
        initialSlide: 0,
        arrows: false,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              infinite: true,
              dots: true
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              initialSlide: 1
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

    <div className="homeTomCallectionMain">
        <div class="container">
            <div className="homeTomCallectionRow">
                    <div className="slider-container ">
                  <Slider {...settings}>
                        {homeProductCtg.map((homeProductCtgC)=>(
                        <div className="banner__items">
                            <a href={homeProductCtgC.image_link} className="banner__items--thumbnail position__relative" >
                                <img className="banner__items--thumbnail__img" src={homeProductCtgC.image_url} alt="" />
                                {/* <div className="banner__items--content">
                                    <h2 className="banner__items--content__title h3">{homeProductCtgC.name}</h2>
                                    <span className="banner__items--content__subtitle" dangerouslySetInnerHTML={{ __html: homeProductCtgC.content }}>
                                      
                                      </span>

                                    {homeProductCtgC.image_link &&
                                    <Link href={homeProductCtgC.image_link}>
                                       <span className="banner__items--content__link view">
                                        View Callection
                                    </span>
                                    </Link>
                                    }
                                    
                                   
                                </div> */}
                            </a>
                        </div>
                        ))}
                    </Slider>
                    </div>
            </div>
            
        </div>
    </div>


  )
}
