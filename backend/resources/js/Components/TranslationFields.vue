<template>
  <div v-if="languages.length > 1" class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Translations</h3>

    <!-- Language Tabs -->
    <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
      <nav class="-mb-px flex space-x-4">
        <button
          v-for="lang in nonDefaultLanguages"
          :key="lang.code"
          @click="activeTab = lang.code"
          type="button"
          :class="[
            activeTab === lang.code
              ? 'border-blue-500 text-blue-600 dark:text-blue-400'
              : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600',
            'whitespace-nowrap py-2 px-4 border-b-2 font-medium text-sm'
          ]"
        >
          {{ lang.native_name }}
        </button>
      </nav>
    </div>

    <!-- Translation Fields for Each Language -->
    <div v-for="lang in nonDefaultLanguages" :key="lang.code">
      <div v-show="activeTab === lang.code" class="space-y-4">
        <slot :languageCode="lang.code" :translations="modelValue[lang.code] || {}"></slot>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  languages: {
    type: Array,
    required: true
  },
  modelValue: {
    type: Object,
    default: () => ({})
  }
})

defineEmits(['update:modelValue'])

const activeTab = ref(null)

const nonDefaultLanguages = computed(() => {
  const langs = props.languages.filter(lang => !lang.is_default)
  if (langs.length > 0 && !activeTab.value) {
    activeTab.value = langs[0].code
  }
  return langs
})
</script>
