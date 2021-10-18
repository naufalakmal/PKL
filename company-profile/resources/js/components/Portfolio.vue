<template>
<div class="w-full py-24 bg-secondary-content">
    <div class="flex justify-around mx-28">
        <div class="grid flex-grow">
            <h1 class="text-4xl font-bold" data-aos="fade-right">Our Works</h1>
        </div> 
        <div class="grid flex-grow place-items-end text-center text-xl">
            <ul>
                <li class="list active" data-filter="all" data-aos="fade-left" data-aos-delay="100">All</li>
                <li class="list" data-filter="campaigns" data-aos="fade-left" data-aos-delay="200">Campaigns</li>
                <li class="list" data-filter="platform" data-aos="fade-left" data-aos-delay="300">Platform</li>
                <li class="list" data-filter="technodevices" data-aos="fade-left" data-aos-delay="400">Techno Devices</li>
            </ul>
        </div>
    </div>
    <div
        class="flex justify-center flex-wrap mt-20 mx-16 gap-5 items-center catalog" data-aos="fade-up">
        <div class="itemBox" data-item="campaigns" data-fancybox="gallery" href="/images/campaigns/campaigns1.webp" @click="onClik()">
            <img alt="nice" src="/images/campaigns/campaigns1.webp">
        </div>
        <div class="itemBox" data-item="platform" data-fancybox="gallery" href="/images/platform/platform.webp">
            <img src="/images/platform/platform.webp">
        </div>
        <div class="itemBox" data-item="technodevices" data-fancybox="gallery" href="/images/technodevices/COMMCENTER1.webp">
            <img src="/images/technodevices/COMMCENTER1.webp">
        </div>
        <div class="itemBox" data-item="platform" data-fancybox="gallery" href="/images/platform/platform.webp">
            <img src="/images/platform/platform2.webp">
        </div>
        <div class="itemBox" data-item="campaigns" data-fancybox="gallery" href="/images/campaigns/campaigns4.webp">
            <img src="/images/campaigns/campaigns4.webp">
        </div>
        <div class="itemBox" data-item="technodevices" data-fancybox="gallery" href="/images/technodevices/COMMCENTER2.webp">
            <img src="/images/technodevices/COMMCENTER2.webp">
        </div>
        <div class="itemBox" data-item="campaigns" data-fancybox="gallery" href="/images/campaigns/campaigns5.webp">
            <img src="/images/campaigns/campaigns5.webp">
        </div>
        <div class="itemBox" data-item="platform" data-fancybox="gallery" href="/images/platform/platform.webp">
            <img src="/images/platform/platform3.webp">
        </div>
        <div class="itemBox" data-item="technodevices" data-fancybox="gallery" href="/images/platform/platform.webp">
            <img src="/images/technodevices/COMMCENTER1.webp">
        </div>
    </div>
    <div class="flex justify-center flex-wrap mt-10">
        <router-link class="btn btn-primary" to="/portfolio">More project</router-link>
    </div>
</div>
</template>

<script>
export default {
    methods: {
        onClik() {
            console.log(this.$route.path);
        }
    },
    mounted() {
        let list = document.querySelectorAll('.list');
        let itemBox = document.querySelectorAll('.itemBox');

        for (let i = 0; i < list.length; i++) {
        list[i].addEventListener('click', function(){
            for (let j = 0; j < list.length; j++) {
                list[j].classList.remove('active');            
            }
            this.classList.add('active');

            let dataFilter = this.getAttribute('data-filter');

            for (let k = 0; k < itemBox.length; k++) {
                itemBox[k].classList.remove('active');
                itemBox[k].classList.add('hide');
                
                if (itemBox[k].getAttribute('data-item') == dataFilter || dataFilter == "all") {
                    itemBox[k].classList.remove('hide');
                    itemBox[k].classList.add('active');
                }
            }
        })
    }
    }    
}

</script>

<style scoped>
ul li {
  width:9em;
  float:left;
  cursor: pointer;
  color: rgb(107, 114, 128);
}
ul li:hover{
    color: rgb(41, 19, 52);
    letter-spacing: 3px;
}
ul li.active,
ul li.active:hover {
    font-weight: 600;
    letter-spacing: 1px;
    color: rgb(41, 19, 52);
}
.catalog .itemBox{
    position: relative;
    display: block;
    width: 450px;
    height: 450px;
    cursor: pointer;
}
.catalog .itemBox img{
    position:absolute;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.catalog .itemBox.hide {
    display: none;
}
</style>