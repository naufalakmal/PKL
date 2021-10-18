<template>
  <div>
    <Navbar />
    <Hero />
    <!-- About -->
    <div class="flex flex-row w-full mb-20 bg-secondary-content" id="about">
      <div class="flex-grow w-1/6"></div>
      <div class="grid flex-grow w-1/2 place-items-start content-center pt-20" data-aos="fade-right" data-aos-anchor-placement="top-center">
          <h1 class="text-6xl font-bold py-5">About Us</h1>
          <p class="pb-10"><span class="font-bold">JAGAD CREATIVE</span> adalah perusahaan yang bergerak dalam bidang pelayanan desain kreatif dan teknologi informasi. Kami terdiri dari orang-orang yang memiliki visi serta potensi kreatif untuk menularkan sebuah karya yang kami rancang dan padu padankan dengan berbagai kebutuhan konsumen baik personal maupun perusahaan.
          </p>
      </div>
      <div class="grid flex-grow w-1/2 h-full place-items-center pt-20">
          <img src="/images/gambar2.png" alt="gambar2" class="h-3/4" data-aos="fade-up" data-aos-anchor-placement="top-center">
      </div>
    </div>

    <!-- Services -->
    <div class="flex flex-col w-full bg-base-100 mb-36">
      <div class="grid h-full card place-items-center" data-aos="zoom-in" data-aos-anchor-placement="bottom-bottom">
        <h1 class="text-6xl font-bold py-5">Our Product & Service</h1>
        <p class="pb-12 text-lg font-light">There are many variations of passages of Lorem Ipsum available</p>
      </div>
      <div class="grid grid-cols-3 gap-5 mx-28">
        <div class="card hov shadow-none hover:shadow-2xl duration-300" data-aos="flip-left">
          <div class="card-body text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 text-red-500" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.505 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
            <h2 class="card-title my-5 text-xl">Software & Web Aplication</h2> 
            <p class="text-gray-500">Permudah dan percepat pekerjaan dengan tools digital dan perkenalkan perusahaan dan produkmu lebih luas.</p>
          </div>
        </div>
        <div class="card hov shadow-none hover:shadow-2xl duration-300" data-aos="flip-left" data-aos-delay="200">
          <div class="card-body text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 5l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 5m8 4v10M4 5v10l8 4" />
            </svg>
            <h2 class="card-title my-5 text-xl">Visual Design</h2> 
            <p class="text-gray-500">Sajikan tampilan perusahaan dan produkmu dengan ciri khas, dan memikat audience.</p>
          </div>
        </div>
        <div class="card hov shadow-none hover:shadow-2xl duration-300" data-aos="flip-left" data-aos-delay="400">
          <div class="card-body text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H5a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 5h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            <h2 class="card-title my-5 text-xl">Content Advertising</h2> 
            <p class="text-gray-500">Sampaikan value produk dengan campaign yang mudah dipahami oleh audience.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Portfolio -->
    <Portfolio />

    <!-- Our Team -->
    <div class="w-full bg-base-100">
      <div class="flex justify-center pt-20 pb-16">      
        <h1 class="text-5xl font-bold" data-aos="fade-up">Meet Our Awesome Team</h1>
      </div>
      <div class="flex flex-wrap justify-center gap-5 mx-16 mb-14">

        <div class="team relative text-center" data-aos="flip-left">
          <div class="overlay bg-red-500 absolute flex justify-center items-center rounded-lg">
            <a href="#"><img src="/images/ig.png" alt="ig" class="w-8 h-8"></a>
            <a href="#"><img src="/images/twitter.png" alt="twitter" class="w-8 h-8 mx-5"></a>
            <a href="#"><img src="/images/gmail.png" alt="gmail" class="w-8 h-8"></a>
          </div>
          <img src="/images/team/SANSAN.jpg" alt="team" class="w-64 rounded-lg">
          <h3 class="text-2xl font-bold">Sansan</h3>
          <p class="text-md text-gray-400 font-medium">Campaign</p>
        </div>

        <div class="team relative text-center" data-aos="flip-left" data-aos-delay="100">
          <div class="overlay bg-red-500 absolute flex justify-center items-center rounded-lg">
            <a href="#"><img src="/images/ig.png" alt="ig" class="w-8 h-8"></a>
            <a href="#"><img src="/images/twitter.png" alt="twitter" class="w-8 h-8 mx-5"></a>
            <a href="#"><img src="/images/gmail.png" alt="gmail" class="w-8 h-8"></a>
          </div>
          <img src="/images/team/DIKI.jpg" alt="team" class="w-64 rounded-lg">
          <h3 class="text-2xl font-bold">Diki</h3>
          <p class="text-md text-gray-400 font-medium">Campaign</p>
        </div>

        <div class="team relative text-center" data-aos="flip-left" data-aos-delay="150">
          <div class="overlay bg-red-500 absolute flex justify-center items-center rounded-lg">
            <a href="#"><img src="/images/ig.png" alt="ig" class="w-8 h-8"></a>
            <a href="#"><img src="/images/twitter.png" alt="twitter" class="w-8 h-8 mx-5"></a>
            <a href="#"><img src="/images/gmail.png" alt="gmail" class="w-8 h-8"></a>
          </div>
          <img src="/images/team/UNGKY.jpg" alt="team" class="w-64 rounded-lg">
          <h3 class="text-2xl font-bold">Ungky</h3>
          <p class="text-md text-gray-400 font-medium">Campaign</p>
        </div>

        <div class="team relative text-center" data-aos="flip-left" data-aos-delay="200">
          <div class="overlay bg-red-500 absolute flex justify-center items-center rounded-lg">
            <a href="#"><img src="/images/ig.png" alt="ig" class="w-8 h-8"></a>
            <a href="#"><img src="/images/twitter.png" alt="twitter" class="w-8 h-8 mx-5"></a>
            <a href="#"><img src="/images/gmail.png" alt="gmail" class="w-8 h-8"></a>
          </div>
          <img src="/images/team/SULTAN.jpg" alt="team" class="w-64 rounded-lg">
          <h3 class="text-2xl font-bold">Sultan</h3>
          <p class="text-md text-gray-400 font-medium">Ceo</p>
        </div>

        <div class="team relative text-center" data-aos="flip-left" data-aos-delay="250">
          <div class="overlay bg-red-500 absolute flex justify-center items-center rounded-lg">
            <a href="#"><img src="/images/ig.png" alt="ig" class="w-8 h-8"></a>
            <a href="#"><img src="/images/twitter.png" alt="twitter" class="w-8 h-8 mx-5"></a>
            <a href="#"><img src="/images/gmail.png" alt="gmail" class="w-8 h-8"></a>
          </div>
          <img src="/images/team/INTAN.jpg" alt="team" class="w-64 rounded-lg">
          <h3 class="text-2xl font-bold">Intan</h3>
          <p class="text-md text-gray-400 font-medium">Marketing</p>
        </div>

        <div class="team relative text-center" data-aos="flip-left" data-aos-delay="300">
          <div class="overlay bg-red-500 absolute flex justify-center items-center rounded-lg">
            <a href="#"><img src="/images/ig.png" alt="ig" class="w-8 h-8"></a>
            <a href="#"><img src="/images/twitter.png" alt="twitter" class="w-8 h-8 mx-5"></a>
            <a href="#"><img src="/images/gmail.png" alt="gmail" class="w-8 h-8"></a>
          </div>
          <img src="/images/team/ANDREW.jpg" alt="team" class="w-64 rounded-lg">
          <h3 class="text-2xl font-bold">Andrew</h3>
          <p class="text-md text-gray-400 font-medium">Marketing</p>
        </div>

        <div class="team relative text-center" data-aos="flip-left" data-aos-delay="350">
          <div class="overlay bg-red-500 absolute flex justify-center items-center rounded-lg">
            <a href="#"><img src="/images/ig.png" alt="ig" class="w-8 h-8"></a>
            <a href="#"><img src="/images/twitter.png" alt="twitter" class="w-8 h-8 mx-5"></a>
            <a href="#"><img src="/images/gmail.png" alt="gmail" class="w-8 h-8"></a>
          </div>
          <img src="/images/team/CATUR.jpg" alt="team" class="w-64 rounded-lg">
          <h3 class="text-2xl font-bold">Catur</h3>
          <p class="text-md text-gray-400 font-medium">Platform</p>
        </div>

        <div class="team relative text-center" data-aos="flip-left" data-aos-delay="400">
          <div class="overlay bg-red-500 absolute flex justify-center items-center rounded-lg">
            <a href="#"><img src="/images/ig.png" alt="ig" class="w-8 h-8"></a>
            <a href="#"><img src="/images/twitter.png" alt="twitter" class="w-8 h-8 mx-5"></a>
            <a href="#"><img src="/images/gmail.png" alt="gmail" class="w-8 h-8"></a>
          </div>
          <img src="/images/team/PINANDITA.jpg" alt="team" class="w-64 rounded-lg">
          <h3 class="text-2xl font-bold">Pinandita</h3>
          <p class="text-md text-gray-400 font-medium">Platform</p>
        </div>
      </div>
    </div>

    <!-- Clients -->
    <Clients />

    <!-- YT -->
    <div class="flex w-full bg-base-100 flex-col flex-grow mb-14 mt-10">
      <div class="text-center">
        <!-- <h1 class="text-2xl font-semibold text-red-500">Youtube Video</h1> -->
        <p class="text-4xl font-bold mt-2 mb-1" data-aos="fade-right">Temukan ide menarik disini</p>
        <p class="text-lg font-medium text-gray-400 mb-4" data-aos="fade-left">Podcast, tutorial, review, dan hiburan bisa kamu temukan disini.</p>
      </div>
      <div class="flex justify-center flex-grow">
        <iframe iframe width="60%" height="512" src="https://www.youtube.com/embed/HLARV4DdLIA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
    </div>

    <!-- Contact Us -->
    <Contact />

    <!-- Footer -->
    <Footer />
  </div>
</template>

<script>
import Navbar from '../components/Navbar.vue'
import Hero from '../components/Hero.vue'
import Portfolio from '../components/Portfolio.vue'
import Clients from '../components/Clients.vue'
import Contact from '../components/Contact.vue'
import Footer from '../components/Footer.vue'

export default {
  name: "Home",
  components: {
      Navbar,
      Hero,
      Portfolio,
      Clients,
      Contact,
      Footer
  }
}
</script>

<style scoped>
  .hov:hover {
    background: -webkit-linear-gradient(to right, #ff416c, #ff4b2b);
    background: linear-gradient(to right, #ff416c, #ff4b2b);
    color: white !important;
    transform: translateY(-10px);
    cursor: pointer;
    transition: all .3s;
  }
  .hov:hover > .card-body > .text-gray-500 {
    color: white !important;
  }
  .hov:hover > .card-body > .h-14 {
    color: white !important;
  }
  .overlay {
    opacity: 0;
    width: 0px;
    height:82.6%;
    transition: ease .3s;
  }
  .team:hover > .overlay {
    width: 100%;
    opacity:1;
  }
  .swiper-wrapper {
    align-items: center !important;
  }
</style>