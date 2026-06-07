<script setup>
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { useTranslations } from '../composables/useTranslations'
import { usePortfolio } from '../composables/usePortfolio'
import { scrollToTop } from '../composables/useMotion'

const { t } = useTranslations()
const { data } = usePortfolio()
const router = useRouter()

const profile = computed(() => data.value?.profile || {})
const year = new Date().getFullYear()

const SOCIAL_LABELS = {
  github: 'GH', linkedin: 'IN', twitter: 'X', x: 'X',
  devto: 'DEV', 'dev.to': 'DEV', instagram: 'IG', facebook: 'FB',
  youtube: 'YT', dribbble: 'DR', behance: 'BE', gitlab: 'GL',
}

const socials = computed(() => {
  const links = profile.value.social_links || {}
  return Object.entries(links)
    .filter(([, url]) => url)
    .map(([key, url]) => ({ key, url, label: SOCIAL_LABELS[key.toLowerCase()] || key.slice(0, 2).toUpperCase() }))
})

const go = (path) => router.push(path)
const goHome = () => (router.currentRoute.value.path === '/' ? scrollToTop(false) : router.push('/'))
</script>

<template>
  <footer class="site-footer">
    <div class="site-footer__grid">
      <div>
        <h4><span class="blip"></span>{{ profile.name || 'Shahzaman' }}</h4>
        <p class="desc">
          {{ t('footer.description', profile.bio ||
            'Software engineer building scalable backend systems. PHP, Laravel, Rust, Kafka and Vue.js. AI integration, system design and team leadership.') }}
        </p>
        <p class="contactline" v-if="profile.email || profile.phone">
          <a v-if="profile.email" :href="`mailto:${profile.email}`">{{ profile.email }}</a>
          <template v-if="profile.email && profile.phone"> · </template>
          <span v-if="profile.phone">{{ profile.phone }}</span>
        </p>
      </div>

      <div class="col">
        <h5>{{ t('footer.quick_links', 'Quick Links') }}</h5>
        <a @click="goHome">{{ t('nav.home', 'Home') }}</a>
        <a @click="go('/projects')">{{ t('nav.projects', 'Projects') }}</a>
        <a @click="go('/about')">{{ t('nav.about', 'About') }}</a>
        <a @click="go('/services')">{{ t('nav.services', 'Services') }}</a>
        <a @click="go('/blog')">{{ t('nav.blog', 'Blog') }}</a>
        <a @click="go('/contact')">{{ t('nav.contact', 'Contact') }}</a>
      </div>

      <div class="col">
        <h5>{{ t('footer.legal', 'Legal') }}</h5>
        <a @click="go('/privacy')">{{ t('footer.privacy', 'Privacy Policy') }}</a>
        <a @click="go('/terms')">{{ t('footer.terms', 'Terms & Conditions') }}</a>
        <div class="social-row" v-if="socials.length">
          <a
            v-for="s in socials"
            :key="s.key"
            :href="s.url"
            target="_blank"
            rel="noopener"
            :title="s.key"
          >{{ s.label }}</a>
        </div>
      </div>
    </div>

    <div class="site-footer__bottom">
      <span>© {{ year }} {{ profile.name || 'Shahzaman' }}. {{ t('footer.rights', 'All rights reserved.') }}</span>
      <span>{{ t('footer.tagline', 'Built around one system · shahzaman.dev') }}</span>
    </div>
  </footer>
</template>
