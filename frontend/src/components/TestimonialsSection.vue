<template>
  <section class="py-20 px-4 bg-gradient-to-br from-purple-50 via-pink-50 to-red-50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-900">
    <div class="max-w-6xl mx-auto">
      <h2 class="scroll-animate text-4xl font-bold text-center mb-4 gradient-text">
        {{ t('testimonials.title', 'Testimonials') }}
      </h2>
      <p class="scroll-animate text-center text-gray-600 dark:text-gray-400 mb-12 text-lg max-w-2xl mx-auto" style="animation-delay: 0.1s">
        {{ t('testimonials.subtitle', 'What clients say about my work') }}
      </p>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="(testimonial, index) in testimonials"
          :key="testimonial.id"
          class="scroll-animate group bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-transparent hover:border-purple-500 relative overflow-hidden"
          :style="{ animationDelay: (index * 0.15 + 0.2) + 's' }"
        >
          <!-- Quote Icon Background -->
          <div class="absolute top-0 right-0 text-blue-100 dark:text-gray-700 opacity-50 group-hover:opacity-70 transition-opacity">
            <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 32 32">
              <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
            </svg>
          </div>

          <div class="flex items-center mb-4 relative z-10">
            <div class="flex-shrink-0">
              <img
                v-if="testimonial.image_url"
                :src="testimonial.image_url"
                :alt="testimonial.client_name"
                class="w-16 h-16 rounded-full object-cover border-4 border-blue-500 group-hover:border-purple-500 transition-colors shadow-lg"
              />
              <div v-else class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg group-hover:scale-110 transition-transform">
                {{ testimonial.client_name ? testimonial.client_name.charAt(0).toUpperCase() : '?' }}
              </div>
            </div>
            <div class="ml-4">
              <h4 class="font-bold text-lg text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ testimonial.client_name }}</h4>
              <p class="text-sm text-gray-600 dark:text-gray-400">
                <span v-if="testimonial.client_position" class="font-medium">{{ testimonial.client_position }}</span>
                <span v-if="testimonial.client_position && testimonial.client_company">{{ t('testimonials.at_separator', ' at ') }}</span>
                <span v-if="testimonial.client_company" class="text-blue-600 dark:text-blue-400">{{ testimonial.client_company }}</span>
              </p>
            </div>
          </div>

          <div class="flex mb-4">
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

          <p class="text-gray-700 dark:text-gray-300 italic leading-relaxed relative z-10">
            "{{ testimonial.content }}"
          </p>

          <!-- Animated Gradient Border on Hover -->
          <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
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
  testimonials: {
    type: Array,
    default: () => []
  }
})
</script>
