<template>
  <nav class="navbar shadow-lg bg-secondary-content justify-center text-neutral-content fixed top-0 left-0 right-0 z-50 py-4 font-sans">
    <div class="px-6 mx-6 navbar-start hidden sm:flex items-start">
        <img src="/images/logo.png" alt="logo" width="150px">
    </div> 
    <div class="dropdown dropdown-right md:hidden">
        <div class="cursor-pointer md:hidden" tabindex="0">
            <svg class="w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </div> 
        <ul tabindex="0" class="p-2 shadow menu dropdown-content bg-base-200 rounded-box w-52 text-red-500 my-4">
            <li>
                <a>Home</a> 
            </li> 
            <li>
                <a>Our Service</a> 
            </li> 
            <li>
                <a>Portfolio</a> 
            </li> 
            <li>
                <a>Our Team</a> 
            </li> 
            <li>
                <a>Ouch!</a> 
            </li> 
            <li>
                <a>Contact Us</a> 
            </li> 
            <li>
                <a>About Us</a> 
            </li>
        </ul>
    </div>
    <div class="hidden px-2 mx-2 navbar-center md:flex text-red-500">
        <div class="flex items-stretch">
            <a class="btn btn-ghost btn-sm rounded-btn">
                Home
            </a>
            <div class="dropdown dropdown-hover">
            <div tabindex="0" class="btn btn-ghost btn-sm rounded-btn">
                <a>
                    Our Service
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-auto inline" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div> 
            <ul tabindex="0" class="p-2 shadow menu dropdown-content bg-base-100 rounded-box w-52 py-5">
                <li>
                    <a>Campaigns</a>
                </li> 
                <li>
                    <a>Platform</a>
                </li> 
                <li>
                    <a>Techno-Device</a>
                </li>
            </ul>
            </div>
            <a class="btn btn-ghost btn-sm rounded-btn">
                Portfolio
            </a> 
            <a class="btn btn-ghost btn-sm rounded-btn">
                Our Team
            </a> 
            <div class="dropdown dropdown-hover">
            <div tabindex="1" class="btn btn-ghost btn-sm rounded-btn">
                <a>
                    Ouch!
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-auto inline" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div> 
            <ul tabindex="1" class="p-2 shadow menu dropdown-content bg-base-100 rounded-box w-52 py-5">
                <li>
                    <a>News</a>
                </li> 
                <li>
                    <a>Article</a>
                </li> 
                <li>
                    <a>Career</a>
                </li>
            </ul>
            </div>
            <a class="btn btn-ghost btn-sm rounded-btn">
                Contact Us
            </a>
            <router-link to="/about" class="btn btn-ghost btn-sm rounded-btn">
                About Us
            </router-link>
        </div>
    </div> 
    <div class="hidden navbar-end px-3 mx-3 lg:flex">
        <button class="btn btn-square btn-ghost text-red-500">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current">             
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>             
        </svg>
        </button> 
    </div>
</nav>  
</template>

<script>
export default {
    name: "Navbar",
}
</script>

<style scoped>
.btn {
    text-transform: capitalize !important;
    font-size: 1rem !important;
}
</style>