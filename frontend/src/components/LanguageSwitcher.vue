<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'

const props = defineProps({
  languages: { type: Array, default: () => [] },
  currentLanguage: { type: String, default: 'en' },
})
const emit = defineEmits(['languageChanged'])

const open = ref(false)
const root = ref(null)

const current = () =>
  props.languages.find((l) => l.code === props.currentLanguage) || { code: props.currentLanguage }

const choose = (code) => {
  open.value = false
  if (code !== props.currentLanguage) emit('languageChanged', code)
}

const onDocClick = (e) => {
  if (root.value && !root.value.contains(e.target)) open.value = false
}
onMounted(() => document.addEventListener('click', onDocClick))
onBeforeUnmount(() => document.removeEventListener('click', onDocClick))
</script>

<template>
  <div class="langsw" ref="root" v-if="languages.length > 1">
    <button class="langsw__btn" @click="open = !open" :aria-expanded="open">
      <svg width="14" height="14" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
        <circle cx="10" cy="10" r="8" />
        <path d="M2 10h16M10 2c2.5 2.2 2.5 13.8 0 16M10 2c-2.5 2.2-2.5 13.8 0 16" />
      </svg>
      {{ (current().code || 'en').toUpperCase() }}
    </button>
    <div class="langsw__menu" v-show="open">
      <button
        v-for="lang in languages"
        :key="lang.code"
        :class="{ on: lang.code === currentLanguage }"
        @click="choose(lang.code)"
      >
        <span>{{ lang.native_name || lang.name }}</span>
        <span>{{ (lang.code || '').toUpperCase() }}</span>
      </button>
    </div>
  </div>
</template>
