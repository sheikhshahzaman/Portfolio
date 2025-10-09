import { ref, computed } from 'vue'
import { portfolioAPI } from '../services/api'

// Global reactive state for translations
const translations = ref({})
const currentLanguage = ref(localStorage.getItem('selectedLanguage') || 'en')
const isLoaded = ref(false)

export function useTranslations() {
  /**
   * Load translations for a specific language
   */
  const loadTranslations = async (lang = 'en') => {
    try {
      const response = await portfolioAPI.getTranslations(lang)
      translations.value = response.data.translations || {}
      currentLanguage.value = response.data.language || lang
      isLoaded.value = true

      // Store selected language in localStorage
      localStorage.setItem('selectedLanguage', currentLanguage.value)
    } catch (error) {
      console.error('Error loading translations:', error)
      // Fallback to empty translations
      translations.value = {}
      isLoaded.value = true
    }
  }

  /**
   * Get translation by key
   * @param {string} key - Translation key in format "group.key" (e.g., "nav.home")
   * @param {string} fallback - Fallback text if key not found
   * @returns {string} Translated text or fallback
   */
  const t = (key, fallback = '') => {
    if (!key) return fallback

    const parts = key.split('.')
    if (parts.length !== 2) {
      console.warn(`Invalid translation key format: ${key}. Expected format: "group.key"`)
      return fallback || key
    }

    const [group, keyName] = parts
    const groupTranslations = translations.value[group]

    if (!groupTranslations) {
      return fallback || key
    }

    return groupTranslations[keyName] || fallback || key
  }

  /**
   * Check if translations are loaded
   */
  const translationsLoaded = computed(() => isLoaded.value)

  /**
   * Get current language code
   */
  const language = computed(() => currentLanguage.value)

  /**
   * Get all translations for a specific group
   * @param {string} group - Group name (e.g., "nav", "hero")
   * @returns {object} All translations for the group
   */
  const getGroup = (group) => {
    return translations.value[group] || {}
  }

  return {
    t,
    loadTranslations,
    translationsLoaded,
    language,
    getGroup,
  }
}
