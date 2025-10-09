<template>
  <section id="experience" class="py-20 px-4">
    <div class="max-w-4xl mx-auto">
      <h2 class="text-4xl font-bold text-center mb-12 gradient-text">
        {{ t('experience.title', 'Work Experience') }}
      </h2>

      <div class="space-y-8">
        <div
          v-for="exp in experiences"
          :key="exp.id"
          class="border-l-4 border-blue-600 pl-6 pb-8 relative"
        >
          <div class="absolute -left-2 top-0 w-4 h-4 bg-blue-600 rounded-full"></div>

          <div class="flex justify-between items-start mb-2">
            <div>
              <h3 class="text-2xl font-bold">{{ exp.position }}</h3>
              <p class="text-xl text-blue-600 dark:text-blue-400">{{ exp.company }}</p>
            </div>
            <span class="text-gray-500 dark:text-gray-400">
              {{ formatDate(exp.start_date) }} - {{ exp.is_current ? t('experience.present', 'Present') : formatDate(exp.end_date) }}
            </span>
          </div>

          <p class="text-gray-600 dark:text-gray-400 mb-4">
            {{ exp.description }}
          </p>

          <ul v-if="exp.achievements" class="list-disc list-inside space-y-1 text-gray-600 dark:text-gray-400">
            <li v-for="(achievement, index) in exp.achievements" :key="index">
              {{ achievement }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { useTranslations } from '../composables/useTranslations'

const { t } = useTranslations()

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
