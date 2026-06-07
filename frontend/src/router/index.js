import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import { initEngine, scrollToTop, scrollToEl } from '../composables/useMotion'

const routes = [
  { path: '/', name: 'Home', component: Home },
  { path: '/projects', name: 'Projects', component: () => import('../views/Projects.vue') },
  { path: '/projects/:slug', name: 'ProjectDetail', component: () => import('../views/ProjectDetail.vue') },
  { path: '/about', name: 'About', component: () => import('../views/About.vue') },
  { path: '/services', name: 'Services', component: () => import('../views/Services.vue') },
  { path: '/blog', name: 'Blog', component: () => import('../views/Blog.vue') },
  { path: '/blog/:slug', name: 'BlogPost', component: () => import('../views/BlogPost.vue') },
  { path: '/contact', name: 'Contact', component: () => import('../views/Contact.vue') },
  { path: '/privacy', name: 'Privacy', component: () => import('../views/Privacy.vue') },
  { path: '/terms', name: 'Terms', component: () => import('../views/Terms.vue') },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  // Scrolling is handled manually below so it cooperates with Lenis.
  scrollBehavior() {
    return false
  },
})

// After each navigation, reset/anchor scroll and refresh ScrollTrigger once
// the incoming view has had a chance to render.
router.afterEach((to) => {
  setTimeout(() => {
    const { ScrollTrigger } = initEngine()
    if (to.hash) scrollToEl(to.hash)
    else scrollToTop(true)
    if (ScrollTrigger) ScrollTrigger.refresh()
  }, 80)
})

export default router
