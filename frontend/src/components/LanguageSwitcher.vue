<template>
  <div class="language-switcher">
    <button
      @click="toggleDropdown"
      class="flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors"
    >
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
      </svg>
      <span class="text-sm font-medium">{{ currentLanguageName }}</span>
      <svg class="w-4 h-4" :class="{ 'rotate-180': isOpen }" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
      </svg>
    </button>

    <div
      v-if="isOpen"
      class="absolute right-0 mt-2 w-48 rounded-lg shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-50"
    >
      <div class="py-1">
        <button
          v-for="lang in languages"
          :key="lang.code"
          @click="selectLanguage(lang.code)"
          class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
          :class="{ 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400': lang.code === currentLanguage }"
        >
          <span class="font-medium">{{ lang.native_name }}</span>
          <span v-if="lang.code === currentLanguage" class="ml-2 text-xs">(Current)</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  languages: {
    type: Array,
    default: () => []
  },
  currentLanguage: {
    type: String,
    default: 'en'
  }
})

const emit = defineEmits(['languageChanged'])

const isOpen = ref(false)

const currentLanguageName = computed(() => {
  const lang = props.languages.find(l => l.code === props.currentLanguage)
  return lang ? lang.native_name : 'English'
})

const toggleDropdown = () => {
  isOpen.value = !isOpen.value
}

const selectLanguage = (code) => {
  if (code !== props.currentLanguage) {
    localStorage.setItem('selectedLanguage', code)
    emit('languageChanged', code)
  }
  isOpen.value = false
}

const closeDropdown = (e) => {
  if (!e.target.closest('.language-switcher')) {
    isOpen.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', closeDropdown)
})

onUnmounted(() => {
  document.removeEventListener('click', closeDropdown)
})
</script>

<style scoped>
.language-switcher {
  position: relative;
  display: inline-block;
}

.rotate-180 {
  transform: rotate(180deg);
}
</style>
