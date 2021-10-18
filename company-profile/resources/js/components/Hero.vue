<template>
  <div class="hero bg-base-200">
    <swiper
        :spaceBetween="10"
        :centeredSlides="true"
        :autoplay='{
        "delay":
        4500,
        "disableOnInteraction":
        false
        }'
        :pagination='{
        "clickable":
        true
        }'
        class="mySwiper">
        <swiper-slide>
            <div class="hero-overlay bg-opacity-40 absolute z-20"></div> 
            <img src="/images/slider/jagadcreative.jpeg" alt="" class="w-screen h-full">
            <div class="text-center hero-content text-neutral-content absolute z-50">
            <div class="max-w-md">
                <h1 class="mb-5 text-5xl font-bold">
                    Hello there
                </h1> 
                <p class="mb-5">
                    Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi exercitationem quasi. In deleniti eaque aut repudiandae et a id nisi.
                </p>
            <button class="btn btn-primary"><a href="#about">About Us</a></button>
            </div>
            </div>
        </swiper-slide>
        <swiper-slide>
            <div class="hero-overlay bg-opacity-60 absolute z-20"></div> 
            <img src="/images/slider/slide2.jpg" alt="" class="w-screen h-full">
            <div class="flex-col hero-content lg:flex-row-reverse absolute z-50 text-neutral-content">
                <img src="https://picsum.photos/id/1005/600/600" class="max-w-sm rounded-lg shadow-2xl"> 
                <div>
                <h1 class="mb-5 text-5xl font-bold">
                    Hello there
                </h1> 
                <p class="mb-5">
                    Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi exercitationem quasi. In deleniti eaque aut repudiandae et a id nisi.
                </p> 
                <button class="btn btn-primary">Get Started</button>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide>
            <div class="hero-overlay bg-opacity-60 absolute z-20"></div> 
            <img src="/images/slider/slide3.jpg" alt="" class="w-screen h-full">
        </swiper-slide>
        <swiper-slide>
            <div class="hero-overlay bg-opacity-60 absolute z-20"></div> 
            <img src="/images/slider/slide4.jpg" alt="" class="w-screen h-full">
        </swiper-slide>
    </swiper>
    </div>
</template>

<script>
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from 'swiper/vue';

// Import Swiper styles
import 'swiper/css';
import 'swiper/scss';
import 'swiper/scss/pagination';

import SwiperCore, {
  Autoplay,Pagination
} from 'swiper';

SwiperCore.use([Autoplay,Pagination]);

export default {
    name: "Hero",
    components: {
        Swiper,
        SwiperSlide,
    },
}
</script>

<style>
.swiper {
  width: 100%;
  height: 100%;
}
.swiper-slide {
  text-align: center;
  font-size: 18px;
  background: #fff;

  /* Center slide text vertically */
  display: -webkit-box;
  display: -ms-flexbox;
  display: -webkit-flex;
  display: flex;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  -webkit-justify-content: center;
  justify-content: center;
  -webkit-box-align: center;
  -ms-flex-align: center;
  -webkit-align-items: center;
  align-items: center;
}
.swiper-slide img {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover;
  -webkit-user-drag: none;
  -khtml-user-drag: none;
  -moz-user-drag: none;
  -o-user-drag: none;
}
</style>