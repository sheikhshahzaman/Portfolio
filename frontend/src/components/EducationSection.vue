<template>
  <section id="education" class="py-20 px-4 bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-900">
    <div class="max-w-4xl mx-auto">
      <h2 class="scroll-animate text-4xl font-bold text-center mb-4 gradient-text">
        {{ t('education.title', 'Education') }}
      </h2>
      <p class="scroll-animate text-center text-gray-600 dark:text-gray-400 mb-12 text-lg max-w-2xl mx-auto" style="animation-delay: 0.1s">
        {{ t('education.subtitle', 'My academic background and certifications') }}
      </p>

      <div class="space-y-8">
        <div
          v-for="(edu, index) in education"
          :key="edu.id"
          class="scroll-animate group border-l-4 border-green-600 hover:border-emerald-600 pl-6 pb-8 relative transition-all duration-300 hover:pl-8"
          :style="{ animationDelay: (index * 0.15 + 0.2) + 's' }"
        >
          <div class="absolute -left-2 top-0 w-4 h-4 bg-green-600 rounded-full group-hover:scale-150 group-hover:bg-emerald-600 transition-all duration-300 shadow-lg"></div>
          <div class="absolute -left-1 top-1 w-2 h-2 bg-white dark:bg-gray-900 rounded-full animate-ping"></div>

          <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-4 gap-2">
            <div class="flex-1">
              <h3 class="text-2xl font-bold group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">{{ edu.degree }}</h3>
              <p class="text-xl text-green-600 dark:text-green-400 font-semibold flex items-center gap-2 mt-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M12 14l9-5-9-5-9 5 9 5z" />
                  <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                </svg>
                {{ edu.institution }}
              </p>
              <p v-if="edu.location" class="text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ edu.location }}
              </p>
            </div>
            <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 rounded-full text-sm font-medium">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              {{ formatDate(edu.start_date) }} - {{ edu.is_current ? t('education.present', 'Present') : formatDate(edu.end_date) }}
            </span>
          </div>

          <p v-if="edu.description" class="text-gray-600 dark:text-gray-400 mt-4 leading-relaxed bg-white dark:bg-gray-800 p-4 rounded-lg">
            {{ edu.description }}
          </p>
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
  education: {
    type: Array,
    default: () => []
  }
})

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', { year: 'numeric', month: 'short' })
}
</script>
