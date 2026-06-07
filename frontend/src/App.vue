<script setup>
import { ref, onMounted } from 'vue'
import SkyOrbs from './components/SkyOrbs.vue'
import Navbar from './components/Navbar.vue'
import Footer from './components/Footer.vue'
import { useTranslations } from './composables/useTranslations'
import { useTheme } from './composables/useTheme'
import { usePortfolio } from './composables/usePortfolio'
import { initEngine } from './composables/useMotion'
import { portfolioAPI } from './services/api'

const languages = ref([])
const currentLanguage = ref(localStorage.getItem('selectedLanguage') || 'en')
const { loadTranslations } = useTranslations()
const { load: loadTheme } = useTheme()
const { load: loadPortfolio, reload: reloadPortfolio } = usePortfolio()

onMounted(async () => {
  initEngine()
  loadTheme()

  // load the full portfolio payload (shared across sections + footer + navbar)
  loadPortfolio(currentLanguage.value).catch(() => {})

  try {
    const response = await portfolioAPI.getLanguages()
    languages.value = response.data || []
  } catch (e) {
    /* languages are optional */
  }

  await loadTranslations(currentLanguage.value)
})

const handleLanguageChange = async (langCode) => {
  currentLanguage.value = langCode
  localStorage.setItem('selectedLanguage', langCode)
  await Promise.all([loadTranslations(langCode), reloadPortfolio(langCode)])
  window.dispatchEvent(new CustomEvent('languageChanged', { detail: { language: langCode } }))
}
</script>

<template>
  <SkyOrbs />
  <Navbar
    :languages="languages"
    :currentLanguage="currentLanguage"
    @languageChanged="handleLanguageChange"
  />

  <router-view v-slot="{ Component }">
    <transition name="fade" mode="out-in">
      <component :is="Component" />
    </transition>
  </router-view>

  <Footer />
</template>
