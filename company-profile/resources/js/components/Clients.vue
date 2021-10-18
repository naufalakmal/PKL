<template>
    <div class="w-full bg-secondary-content">
        <div class="flex justify-center pt-20 pb-16">      
            <h1 class="text-5xl font-bold" data-aos="fade-up">Our Previous Client</h1>
        </div>
        <div class="flex mx-16">
        <swiper
          :slidesPerView="6"
          :autoplay='{
            "delay":
            3500,
            "disableOnInteraction":
            false
          }'
          :loop="true"
          :loopFillGroupWithBlank="true"
          class="mySwiper mb-20"> 
            <swiper-slide>
                <img src="/images/clients/1.png">
            </swiper-slide>
            <swiper-slide class="flex items-center">
                <img src="/images/clients/cli.png">
            </swiper-slide>
            <swiper-slide>
                <img src="/images/clients/itb.png">
            </swiper-slide>
            <swiper-slide>
                <img src="/images/clients/bkkbn.png">
            </swiper-slide>
            <swiper-slide>
                <img src="/images/clients/gdi.png">
            </swiper-slide>
            <swiper-slide>
                <img src="/images/clients/gurat.png">
            </swiper-slide>
            <swiper-slide>
                <img src="/images/clients/ybj.png">
            </swiper-slide>
            <swiper-slide>
                <img src="/images/clients/kkri.png">
            </swiper-slide>
            <swiper-slide>
                <img src="/images/clients/nks.png">
            </swiper-slide>
            <swiper-slide>
                <img src="/images/clients/telkom.png">
            </swiper-slide>
            <swiper-slide>
                <img src="/images/clients/tutwuri.png">
            </swiper-slide>
            <swiper-slide>
                <img src="/images/clients/upi.png">
            </swiper-slide>
        </swiper>
        </div>
    </div>
</template>

<script>
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from 'swiper/vue';

// Import Swiper styles
import 'swiper/css';

import SwiperCore, {
  Autoplay
} from 'swiper';

SwiperCore.use([Autoplay]);

export default {
  components: {
    Swiper,
    SwiperSlide,
  },
}
</script>

<style scoped>
.swiper {
  width: 100%;
  display: flex;
  align-content: center !important;
  height: 100%;
}

.swiper-slide img {
  display: block;
  width: 50%;
  object-fit: cover;
}
</style>