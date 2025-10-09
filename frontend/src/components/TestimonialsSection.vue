<template>
  <section class="py-20 px-4">
    <div class="max-w-6xl mx-auto">
      <h2 class="text-4xl font-bold text-center mb-12 gradient-text">
        {{ t('testimonials.title', 'Testimonials') }}
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="testimonial in testimonials"
          :key="testimonial.id"
          class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg"
        >
          <div class="flex items-center mb-4">
            <div class="flex-shrink-0">
              <img
                v-if="testimonial.image_url"
                :src="testimonial.image_url"
                :alt="testimonial.client_name"
                class="w-16 h-16 rounded-full object-cover border-2 border-blue-500"
              />
              <div v-else class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-xl font-bold">
                {{ testimonial.client_name ? testimonial.client_name.charAt(0).toUpperCase() : '?' }}
              </div>
            </div>
            <div class="ml-4">
              <h4 class="font-bold text-gray-900 dark:text-white">{{ testimonial.client_name }}</h4>
              <p class="text-sm text-gray-600 dark:text-gray-400">
                <span v-if="testimonial.client_position">{{ testimonial.client_position }}</span>
                <span v-if="testimonial.client_position && testimonial.client_company">{{ t('testimonials.at_separator', ' at ') }}</span>
                <span v-if="testimonial.client_company">{{ testimonial.client_company }}</span>
              </p>
            </div>
          </div>

          <div class="flex mb-3">
            <svg
              v-for="star in (testimonial.rating || 5)"
              :key="star"
              class="w-5 h-5 text-yellow-400"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
          </div>

          <p class="text-gray-600 dark:text-gray-400 italic">
            "{{ testimonial.content }}"
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
  testimonials: {
    type: Array,
    default: () => []
  }
})
</script>
