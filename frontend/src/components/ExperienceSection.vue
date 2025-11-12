<template>
  <section id="experience" class="py-20 px-4 bg-white dark:bg-gray-900">
    <div class="max-w-4xl mx-auto">
      <h2 class="scroll-animate text-4xl font-bold text-center mb-4 gradient-text">
        {{ t('experience.title', 'Work Experience') }}
      </h2>
      <p class="scroll-animate text-center text-gray-600 dark:text-gray-400 mb-12 text-lg max-w-2xl mx-auto" style="animation-delay: 0.1s">
        {{ t('experience.subtitle', 'My professional journey and accomplishments') }}
      </p>

      <div class="space-y-8">
        <div
          v-for="(exp, index) in experiences"
          :key="exp.id"
          class="scroll-animate group border-l-4 border-blue-600 hover:border-purple-600 pl-6 pb-8 relative transition-all duration-300"
          :style="{ animationDelay: (index * 0.15 + 0.2) + 's' }"
        >
          <div class="absolute -left-2 top-0 w-4 h-4 bg-blue-600 rounded-full group-hover:scale-150 group-hover:bg-purple-600 transition-all duration-300 shadow-lg"></div>
          <div class="absolute -left-1 top-1 w-2 h-2 bg-white dark:bg-gray-900 rounded-full animate-ping"></div>

          <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-4 gap-2">
            <div class="flex-1">
              <h3 class="text-2xl font-bold group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ exp.position }}</h3>
              <p class="text-xl text-blue-600 dark:text-blue-400 font-semibold flex items-center gap-2 mt-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                {{ exp.company }}
              </p>
            </div>
            <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-full text-sm font-medium">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              {{ formatDate(exp.start_date) }} - {{ exp.is_current ? t('experience.present', 'Present') : formatDate(exp.end_date) }}
            </span>
          </div>

          <div class="text-gray-600 dark:text-gray-400 mb-4 leading-relaxed bg-gray-50 dark:bg-gray-800 p-4 rounded-lg whitespace-pre-line">
            {{ exp.description }}
          </div>

          <ul v-if="exp.achievements" class="space-y-2">
            <li v-for="(achievement, index) in exp.achievements" :key="index" class="flex items-start gap-2 text-gray-600 dark:text-gray-400">
              <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
              </svg>
              <span>{{ achievement }}</span>
            </li>
          </ul>
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
  experiences: {
    type: Array,
    default: () => []
  }
})

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', { year: 'numeric', month: 'short' })
}
</script>
