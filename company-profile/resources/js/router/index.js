import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Home.vue'
import About from '../pages/About.vue'
import NotFound from '../pages/NotFound.vue'

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/about',
        name: 'about',
        component: About
    },
    {
        path: '/:catchAll(.*)',
        component: NotFound
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
  })
  
export default router