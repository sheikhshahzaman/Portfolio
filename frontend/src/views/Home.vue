<template>
  <div>
    <!-- Hero Section -->
    <HeroSection :profile="portfolioData?.profile" />

    <!-- Projects Section -->
    <ProjectsSection :projects="portfolioData?.projects" />

    <!-- Experience Section -->
    <ExperienceSection :experiences="portfolioData?.experiences" />

    <!-- Education Section -->
    <EducationSection :education="portfolioData?.education" />

    <!-- Skills Section -->
    <SkillsSection :skills="portfolioData?.skills" />

    <!-- Testimonials Section -->
    <TestimonialsSection :testimonials="portfolioData?.testimonials" />

    <!-- Contact Section -->
    <ContactSection />
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useHead } from '@unhead/vue'
import { portfolioAPI } from '../services/api'
import { useTranslations } from '../composables/useTranslations'
import HeroSection from '../components/HeroSection.vue'
import ProjectsSection from '../components/ProjectsSection.vue'
import ExperienceSection from '../components/ExperienceSection.vue'
import EducationSection from '../components/EducationSection.vue'
import SkillsSection from '../components/SkillsSection.vue'
import TestimonialsSection from '../components/TestimonialsSection.vue'
import ContactSection from '../components/ContactSection.vue'
import LanguageSwitcher from '../components/LanguageSwitcher.vue'

const portfolioData = ref(null)
const loading = ref(true)
const currentLanguage = ref(localStorage.getItem('selectedLanguage') || 'en')
const { loadTranslations } = useTranslations()

const loadPortfolioData = async (lang = 'en') => {
  try {
    loading.value = true
    const response = await portfolioAPI.getPortfolio(lang)
    portfolioData.value = response.data
    currentLanguage.value = response.data.current_language || lang
  } catch (error) {
    console.error('Error loading portfolio data:', error)
  } finally {
    loading.value = false
  }
}

const changeLanguage = async (lang) => {
  await Promise.all([
    loadPortfolioData(lang),
    loadTranslations(lang)
  ])
}

onMounted(async () => {
  await loadPortfolioData(currentLanguage.value)

  // Listen for language changes
  window.addEventListener('languageChanged', async (event) => {
    const newLanguage = event.detail.language
    currentLanguage.value = newLanguage
    await loadPortfolioData(newLanguage)
  })
})

// Reactive meta tags
const currentUrl = computed(() => window.location.href)

useHead(computed(() => {
  if (!portfolioData.value || !portfolioData.value.seo) return {}

  const seo = portfolioData.value.seo
  const profile = portfolioData.value.profile

  return {
    title: seo.meta_title || `${profile.name} - ${profile.title}`,
    meta: [
      { name: 'description', content: seo.meta_description || profile.bio || '' },
      { name: 'keywords', content: seo.meta_keywords || '' },
      { name: 'robots', content: seo.robots || 'index, follow' },

      // Open Graph
      { property: 'og:type', content: 'website' },
      { property: 'og:title', content: seo.og_title || seo.meta_title || `${profile.name} - ${profile.title}` },
      { property: 'og:description', content: seo.og_description || seo.meta_description || profile.bio || '' },
      { property: 'og:image', content: seo.og_image || profile.avatar || '' },
      { property: 'og:url', content: currentUrl.value },

      // Twitter Card
      { name: 'twitter:card', content: seo.twitter_card || 'summary_large_image' },
      { name: 'twitter:site', content: seo.twitter_handle || '' },
      { name: 'twitter:title', content: seo.og_title || seo.meta_title || `${profile.name} - ${profile.title}` },
      { name: 'twitter:description', content: seo.og_description || seo.meta_description || profile.bio || '' },
      { name: 'twitter:image', content: seo.og_image || profile.avatar || '' },
    ],
    link: [
      { rel: 'canonical', href: seo.canonical_url || currentUrl.value },
    ],
  }
}))
</script>
