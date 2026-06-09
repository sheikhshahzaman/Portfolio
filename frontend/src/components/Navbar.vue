<script setup>
import { ref, computed, onMounted, onBeforeUnmount, watch } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useTranslations } from '../composables/useTranslations'
import { usePortfolio } from '../composables/usePortfolio'
import { scrollToEl, scrollToTop } from '../composables/useMotion'
import LanguageSwitcher from './LanguageSwitcher.vue'

defineProps({
  languages: { type: Array, default: () => [] },
  currentLanguage: { type: String, default: 'en' },
})
const emit = defineEmits(['languageChanged'])

const { t } = useTranslations()
const { data } = usePortfolio()
const router = useRouter()
const route = useRoute()

const brand = computed(() => data.value?.profile?.name || 'Shahzaman')
const resumeUrl = computed(() => data.value?.profile?.resume_url || '/resume.pdf')

const hidden = ref(false)
const menuOpen = ref(false)
let last = 0

const onScroll = () => {
  const y = window.scrollY || document.documentElement.scrollTop
  hidden.value = y > last && y > 240 && !menuOpen.value
  last = y
}

const goHome = () => {
  closeMenu()
  if (route.path === '/') scrollToTop(false)
  else router.push('/')
}
const goAnchor = (hash) => {
  closeMenu()
  if (route.path === '/') scrollToEl(hash)
  else router.push({ path: '/', hash })
}
const go = (path) => {
  closeMenu()
  if (route.path !== path) router.push(path)
}

const closeMenu = () => (menuOpen.value = false)

watch(menuOpen, (v) => {
  document.body.style.overflow = v ? 'hidden' : ''
})

onMounted(() => window.addEventListener('scroll', onScroll, { passive: true }))
onBeforeUnmount(() => {
  window.removeEventListener('scroll', onScroll)
  document.body.style.overflow = ''
})
</script>

<template>
  <nav class="nav" :class="{ hide: hidden }">
    <a class="nav__brand mag" data-mag="0.2" href="/" @click.prevent="goHome">
      <span class="blip"></span><span class="brandtext">{{ brand }}</span>
    </a>

    <div class="nav__links">
      <a @click="go('/projects')" :class="{ on: route.path.startsWith('/projects') }">{{ t('nav.projects', 'Projects') }}</a>
      <a @click="go('/about')" :class="{ on: route.path === '/about' }">{{ t('nav.about', 'About') }}</a>
      <a @click="goAnchor('#experience')">{{ t('nav.experience', 'Experience') }}</a>
      <a @click="goAnchor('#skills')">{{ t('nav.skills', 'Skills') }}</a>
      <a @click="go('/services')" :class="{ on: route.path === '/services' }">{{ t('nav.services', 'Services') }}</a>
      <a @click="go('/blog')" :class="{ on: route.path.startsWith('/blog') }">{{ t('nav.blog', 'Blog') }}</a>
      <a v-if="resumeUrl" class="ghost" :href="resumeUrl" target="_blank" rel="noopener" download>{{ t('nav.resume', 'Resume') }}</a>
      <a class="cta mag" data-mag="0.25" @click="go('/contact')">{{ t('nav.lets_talk', "Let's talk") }}</a>
      <LanguageSwitcher
        :languages="languages"
        :currentLanguage="currentLanguage"
        @languageChanged="emit('languageChanged', $event)"
      />
    </div>

    <button class="nav__toggle" :class="{ open: menuOpen }" @click="menuOpen = !menuOpen" aria-label="Menu">
      <span></span>
    </button>
  </nav>

  <div class="nav__scrim" :class="{ open: menuOpen }" @click="closeMenu"></div>
  <aside class="nav__drawer" :class="{ open: menuOpen }">
    <a @click="goHome">{{ t('nav.home', 'Home') }}</a>
    <a @click="go('/projects')">{{ t('nav.projects', 'Projects') }}</a>
    <a @click="go('/about')">{{ t('nav.about', 'About') }}</a>
    <a @click="goAnchor('#experience')">{{ t('nav.experience', 'Experience') }}</a>
    <a @click="goAnchor('#skills')">{{ t('nav.skills', 'Skills') }}</a>
    <a @click="go('/services')">{{ t('nav.services', 'Services') }}</a>
    <a @click="go('/blog')">{{ t('nav.blog', 'Blog') }}</a>
    <a v-if="resumeUrl" :href="resumeUrl" target="_blank" rel="noopener" download>{{ t('nav.resume', 'Resume') }}</a>
    <a class="cta" @click="go('/contact')">{{ t('nav.lets_talk', "Let's talk") }} →</a>
    <div style="margin-top: 22px">
      <LanguageSwitcher
        :languages="languages"
        :currentLanguage="currentLanguage"
        @languageChanged="emit('languageChanged', $event)"
      />
    </div>
  </aside>
</template>
