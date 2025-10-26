<template>
  <section id="education" class="py-20 px-4 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-4xl mx-auto">
      <h2 class="text-4xl font-bold text-center mb-12 gradient-text">
        {{ t('education.title', 'Education') }}
      </h2>

      <div class="space-y-8">
        <div
          v-for="edu in education"
          :key="edu.id"
          class="border-l-4 border-green-600 pl-6 pb-8 relative"
        >
          <div class="absolute -left-2 top-0 w-4 h-4 bg-green-600 rounded-full"></div>

          <div class="flex justify-between items-start mb-2">
            <div>
              <h3 class="text-2xl font-bold">{{ edu.degree }}</h3>
              <p class="text-xl text-green-600 dark:text-green-400">{{ edu.institution }}</p>
              <p v-if="edu.location" class="text-gray-500 dark:text-gray-400">{{ edu.location }}</p>
            </div>
            <span class="text-gray-500 dark:text-gray-400">
              {{ formatDate(edu.start_date) }} - {{ edu.is_current ? t('education.present', 'Present') : formatDate(edu.end_date) }}
            </span>
          </div>

          <p v-if="edu.description" class="text-gray-600 dark:text-gray-400 mt-4">
            {{ edu.description }}
          </p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { useTranslations } from '../composables/useTranslations'

const { t } = useTranslations()

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
