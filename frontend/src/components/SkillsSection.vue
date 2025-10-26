<template>
  <section id="skills" class="py-20 px-4 bg-white dark:bg-gray-900">
    <div class="max-w-6xl mx-auto">
      <h2 class="scroll-animate text-4xl font-bold text-center mb-4 gradient-text">
        {{ t('skills.title', 'Skills & Expertise') }}
      </h2>
      <p class="scroll-animate text-center text-gray-600 dark:text-gray-400 mb-12 text-lg max-w-2xl mx-auto" style="animation-delay: 0.1s">
        {{ t('skills.subtitle', 'Technologies and tools I work with') }}
      </p>

      <div class="space-y-12">
        <div v-for="(categorySkills, category, catIndex) in skills" :key="category"
             class="scroll-animate"
             :style="{ animationDelay: (catIndex * 0.2 + 0.2) + 's' }">
          <h3 class="text-2xl font-bold mb-6 flex items-center gap-2">
            <div class="w-1 h-8 bg-gradient-to-b from-blue-600 to-purple-600 rounded-full"></div>
            {{ category }}
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div v-for="(skill, index) in categorySkills" :key="skill.id"
                 class="group space-y-2 p-4 rounded-lg bg-gray-50 dark:bg-gray-800 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-blue-900/20 dark:hover:to-purple-900/20 transition-all duration-300 hover:scale-105 hover:shadow-lg border-2 border-transparent hover:border-blue-500">
              <div class="flex justify-between items-center">
                <span class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors flex items-center gap-2">
                  <span class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></span>
                  {{ skill.name }}
                </span>
                <span class="text-sm font-bold px-2 py-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-full">{{ skill.proficiency }}%</span>
              </div>
              <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                <div
                  class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 h-3 rounded-full transition-all duration-1000 ease-out relative overflow-hidden"
                  :style="{ width: skill.proficiency + '%' }"
                >
                  <div class="absolute inset-0 bg-white opacity-20 animate-shimmer"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { useTranslations } from '../composables/useTranslations'
import { useScrollAnimation } from '../composables/useScrollAnimation'

const { t } = useTranslations()
useScrollAnimation()

defineProps({
  skills: {
    type: Object,
    default: () => ({})
  }
})
</script>

<style scoped>
@keyframes shimmer {
  0% {
    transform: translateX(-100%);
  }
  100% {
    transform: translateX(100%);
  }
}

.animate-shimmer {
  animation: shimmer 2s infinite;
}
</style>
