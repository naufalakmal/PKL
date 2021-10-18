<template>
  <div class="w-full bg-secondary-content">
      <div class="flex flex-col text-center py-14">
        <h1 class="text-4xl font-bold">Get in Touch</h1>
      </div>
      <div class="flex mx-16 gap-10 w-full pb-10">
        <div class="message w-7/12 ml-7">
        <!-- <form action="post"></form> -->
          <h1 class="text-2xl font-semibold mb-5">Message</h1>
          <input type="text" class="inp w-47 mr-6 mb-6" placeholder="Name">
          <input type="text" class="inp w-47 mb-6" placeholder="Email">
          <input type="text" class="inp w-full mb-6" placeholder="Subject">
          <textarea class="inp w-full h-40 mb-5" placeholder="Message"></textarea>
          <button class="btn btn-primary text-lg font-semibold">Send Messages</button>
        </div>
        <div class="info w-1/3">
            <h1 class="text-2xl font-semibold mb-4">Contact Info</h1>
            <h1 class="text-lg font-medium text-gray-400">Always available for freelance work if the right <br> project comes along, Feel free to contact us!</h1>

            <div class="flex flex-row mt-3">
                <a href="https://www.instagram.com/jagadcreative.id/" class="mr-10">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 30 30" fill="#3D3D3D" class="w-6">
                    <path d="M9.9980469 3C6.1390469 3 3 6.1419531 3 10.001953L3 20.001953C3 23.860953 6.1419531 27 10.001953 27L20.001953 27C23.860953 27 27 23.858047 27 19.998047L27 9.9980469C27 6.1390469 23.858047 3 19.998047 3L9.9980469 3 z M 22 7C22.552 7 23 7.448 23 8C23 8.552 22.552 9 22 9C21.448 9 21 8.552 21 8C21 7.448 21.448 7 22 7 z M 15 9C18.309 9 21 11.691 21 15C21 18.309 18.309 21 15 21C11.691 21 9 18.309 9 15C9 11.691 11.691 9 15 9 z M 15 11 A 4 4 0 0 0 11 15 A 4 4 0 0 0 15 19 A 4 4 0 0 0 19 15 A 4 4 0 0 0 15 11 z" fill="#3D3D3D" />
                    </svg>
                </a>
                <a href="https://twitter.com/JagadCreativeID" class="mr-10">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 30 30" fill="#3D3D3D" class="w-6">
                    <path d="M28,6.937c-0.957,0.425-1.985,0.711-3.064,0.84c1.102-0.66,1.947-1.705,2.345-2.951c-1.03,0.611-2.172,1.055-3.388,1.295 c-0.973-1.037-2.359-1.685-3.893-1.685c-2.946,0-5.334,2.389-5.334,5.334c0,0.418,0.048,0.826,0.138,1.215 c-4.433-0.222-8.363-2.346-10.995-5.574C3.351,6.199,3.088,7.115,3.088,8.094c0,1.85,0.941,3.483,2.372,4.439 c-0.874-0.028-1.697-0.268-2.416-0.667c0,0.023,0,0.044,0,0.067c0,2.585,1.838,4.741,4.279,5.23 c-0.447,0.122-0.919,0.187-1.406,0.187c-0.343,0-0.678-0.034-1.003-0.095c0.679,2.119,2.649,3.662,4.983,3.705 c-1.825,1.431-4.125,2.284-6.625,2.284c-0.43,0-0.855-0.025-1.273-0.075c2.361,1.513,5.164,2.396,8.177,2.396 c9.812,0,15.176-8.128,15.176-15.177c0-0.231-0.005-0.461-0.015-0.69C26.38,8.945,27.285,8.006,28,6.937z" fill="#3D3D3D" />
                    </svg>
                </a>
                <a href="https://www.youtube.com/channel/UC_p_wnjUnLdWM30LWAUD4yg" class="mr-10">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50" fill="#3D3D3D" class="w-6">
                    <path d="M44.898438 14.5C44.5 12.300781 42.601563 10.699219 40.398438 10.199219C37.101563 9.5 31 9 24.398438 9C17.800781 9 11.601563 9.5 8.300781 10.199219C6.101563 10.699219 4.199219 12.199219 3.800781 14.5C3.398438 17 3 20.5 3 25C3 29.5 3.398438 33 3.898438 35.5C4.300781 37.699219 6.199219 39.300781 8.398438 39.800781C11.898438 40.5 17.898438 41 24.5 41C31.101563 41 37.101563 40.5 40.601563 39.800781C42.800781 39.300781 44.699219 37.800781 45.101563 35.5C45.5 33 46 29.398438 46.101563 25C45.898438 20.5 45.398438 17 44.898438 14.5 Z M 19 32L19 18L31.199219 25Z" fill="#3D3D3D" />
                    </svg>
                </a>
                <a href="mailto:Admin@jagadcreative.id" class="mr-10">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48" fill="#3D3D3D" class="w-6">
                        <path d="M10.5 8C6.9280619 8 4 10.928062 4 14.5L4 33.5C4 37.071938 6.9280619 40 10.5 40L37.5 40C41.071938 40 44 37.071938 44 33.5L44 14.5C44 10.928062 41.071938 8 37.5 8L10.5 8 z M 10.5 11L37.5 11C38.093018 11 38.640276 11.157774 39.126953 11.412109L24 19.589844L8.8730469 11.412109C9.3597237 11.157774 9.9069817 11 10.5 11 z M 10 18.84375L22.572266 25.638672C23.018266 25.879672 23.509 26 24 26C24.491 26 24.981734 25.879672 25.427734 25.638672L38 18.84375L38 36.951172C37.835551 36.974343 37.671413 37 37.5 37L10.5 37C10.328587 37 10.164449 36.974343 10 36.951172L10 18.84375 z" fill="#3D3D3D" />
                    </svg>
                </a>
            </div>

            <div class="flex flex-row flex-wrap mt-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mr-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                </svg>
                <h1 class="text-xl font-bold">Call Us <br> <span class="text-lg font-normal text-gray-400">(+62) 81808383766 || (+62) 81313969337</span> </h1>
            </div>

            <div class="flex flex-row flex-wrap mt-5">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48" fill="#3D4451" class="w-12 mr-5">
                    <path d="M10.5 8C6.9280619 8 4 10.928062 4 14.5L4 33.5C4 37.071938 6.9280619 40 10.5 40L37.5 40C41.071938 40 44 37.071938 44 33.5L44 14.5C44 10.928062 41.071938 8 37.5 8L10.5 8 z M 10.5 11L37.5 11C38.093018 11 38.640276 11.157774 39.126953 11.412109L24 19.589844L8.8730469 11.412109C9.3597237 11.157774 9.9069817 11 10.5 11 z M 10 18.84375L22.572266 25.638672C23.018266 25.879672 23.509 26 24 26C24.491 26 24.981734 25.879672 25.427734 25.638672L38 18.84375L38 36.951172C37.835551 36.974343 37.671413 37 37.5 37L10.5 37C10.328587 37 10.164449 36.974343 10 36.951172L10 18.84375 z" fill="#3D4451" />
                </svg>
                <h1 class="text-xl font-bold">Email <br> <span class="text-lg font-normal text-gray-400"><a href="mailto:Admin@jagadcreative.id">Admin@jagadcreative.id</a></span> </h1>
            </div>

            <div class="flex flex-row flex-wrap mt-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mr-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>
                <h1 class="text-xl font-bold">Location <br> <span class="text-lg font-normal text-gray-400">Jl. Saturnus Tengah no.18, Manjahlega, <br> Kec. Rancasari, Kota Bandung Jawa Barat</span> </h1>
            </div>

        </div>

      </div>
    </div>
</template>

<script>
export default {

}
</script>

<style scoped>
.inp {
    display: inline;
    background-color:#eeeeee;
    font-size: 1.125rem;
    line-height: 1.75rem;
    padding: 8px;
    height: 3.5rem;
    outline: none;
    transition: all .4s;
}
textarea{
    height: 10rem !important;
}
.btn {
    text-transform: capitalize !important;
}
.inp.w-47 {
    width: 48.5%;
}
.inp:focus {
    border: solid 1px rgb(239, 68, 68);
}
</style>