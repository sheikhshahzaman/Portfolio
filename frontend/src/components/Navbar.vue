<template>
  <nav class="fixed top-0 left-0 right-0 z-40 bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-b border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <!-- Logo -->
        <router-link to="/" class="text-2xl font-bold gradient-text">
          Shahzaman
        </router-link>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center space-x-8">
          <router-link
            to="/"
            class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
            active-class="text-blue-600 dark:text-blue-400"
          >
            {{ t('nav.home', 'Home') }}
          </router-link>
          <router-link
            to="/projects"
            class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
            active-class="text-blue-600 dark:text-blue-400"
          >
            {{ t('nav.projects', 'Projects') }}
          </router-link>
          <a
            @click="scrollToSection('experience')"
            class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors cursor-pointer"
          >
            {{ t('nav.experience', 'Experience') }}
          </a>
          <a
            @click="scrollToSection('skills')"
            class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors cursor-pointer"
          >
            {{ t('nav.skills', 'Skills') }}
          </a>
          <router-link
            to="/services"
            class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
            active-class="text-blue-600 dark:text-blue-400"
          >
            {{ t('nav.services', 'Services') }}
          </router-link>
          <router-link
            to="/blog"
            class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
            active-class="text-blue-600 dark:text-blue-400"
          >
            {{ t('nav.blog', 'Blog') }}
          </router-link>
          <a
            href="/resume.pdf"
            download="Shahzaman_Resume.pdf"
            class="flex items-center gap-1 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            {{ t('nav.resume', 'Resume') }}
          </a>

          <!-- Language Switcher -->
          <LanguageSwitcher
            v-if="languages.length > 0"
            :languages="languages"
            :currentLanguage="currentLanguage"
            @languageChanged="$emit('languageChanged', $event)"
          />

          <router-link
            to="/contact"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            active-class="bg-blue-800"
          >
            {{ t('nav.contact', 'Contact') }}
          </router-link>
        </div>

        <!-- Mobile Menu Button -->
        <button
          @click="mobileMenuOpen = !mobileMenuOpen"
          class="md:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
        >
          <svg
            class="w-6 h-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              v-if="!mobileMenuOpen"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"
            />
            <path
              v-else
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>
      </div>

      <!-- Mobile Menu -->
      <div
        v-if="mobileMenuOpen"
        class="md:hidden py-4 space-y-2 border-t border-gray-200 dark:border-gray-800"
      >
        <router-link
          to="/"
          @click="mobileMenuOpen = false"
          class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
        >
          {{ t('nav.home', 'Home') }}
        </router-link>
        <router-link
          to="/projects"
          @click="mobileMenuOpen = false"
          class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
        >
          {{ t('nav.projects', 'Projects') }}
        </router-link>
        <a
          @click="scrollToSection('experience'); mobileMenuOpen = false"
          class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors cursor-pointer"
        >
          {{ t('nav.experience', 'Experience') }}
        </a>
        <a
          @click="scrollToSection('skills'); mobileMenuOpen = false"
          class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors cursor-pointer"
        >
          {{ t('nav.skills', 'Skills') }}
        </a>
        <router-link
          to="/services"
          @click="mobileMenuOpen = false"
          class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
        >
          {{ t('nav.services', 'Services') }}
        </router-link>
        <router-link
          to="/blog"
          @click="mobileMenuOpen = false"
          class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
        >
          {{ t('nav.blog', 'Blog') }}
        </router-link>
        <a
          href="/resume.pdf"
          download="Shahzaman_Resume.pdf"
          @click="mobileMenuOpen = false"
          class="flex items-center gap-2 px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          {{ t('nav.resume', 'Resume') }}
        </a>
        <router-link
          to="/contact"
          @click="mobileMenuOpen = false"
          class="block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-center"
        >
          {{ t('nav.contact', 'Contact') }}
        </router-link>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useTranslations } from '../composables/useTranslations'
import LanguageSwitcher from './LanguageSwitcher.vue'

const { t } = useTranslations()

defineProps({
  languages: {
    type: Array,
    default: () => []
  },
  currentLanguage: {
    type: String,
    default: 'en'
  }
})

defineEmits(['languageChanged'])

const mobileMenuOpen = ref(false)
const router = useRouter()
const route = useRoute()

const scrollToSection = (sectionId) => {
  // If not on home page, navigate to home first
  if (route.path !== '/') {
    router.push('/').then(() => {
      // Wait for navigation to complete, then scroll
      setTimeout(() => {
        const element = document.getElementById(sectionId)
        if (element) {
          element.scrollIntoView({ behavior: 'smooth', block: 'start' })
        }
      }, 100)
    })
  } else {
    // Already on home page, just scroll
    const element = document.getElementById(sectionId)
    if (element) {
      element.scrollIntoView({ behavior: 'smooth', block: 'start' })
    }
  }
}
</script>
