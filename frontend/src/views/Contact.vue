<template>
  <div class="min-h-screen py-20 px-4 pt-24">
    <div class="max-w-2xl mx-auto">
      <h1 class="text-5xl font-bold text-center mb-4 gradient-text">
        Get In Touch
      </h1>
      <p class="text-center text-gray-600 dark:text-gray-400 mb-12">
        Have a project in mind? Let's work together!
      </p>

      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
        <form @submit.prevent="submitForm" class="space-y-6">
          <div>
            <label for="name" class="block text-sm font-medium mb-2">Name *</label>
            <input
              v-model="form.name"
              type="text"
              id="name"
              required
              class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-600 outline-none transition-all"
              placeholder="Your name"
            />
          </div>

          <div>
            <label for="email" class="block text-sm font-medium mb-2">Email *</label>
            <input
              v-model="form.email"
              type="email"
              id="email"
              required
              class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-600 outline-none transition-all"
              placeholder="your.email@example.com"
            />
          </div>

          <div>
            <label for="subject" class="block text-sm font-medium mb-2">Subject</label>
            <input
              v-model="form.subject"
              type="text"
              id="subject"
              class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-600 outline-none transition-all"
              placeholder="What's this about?"
            />
          </div>

          <div>
            <label for="message" class="block text-sm font-medium mb-2">Message *</label>
            <textarea
              v-model="form.message"
              id="message"
              required
              rows="6"
              class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-600 outline-none transition-all resize-none"
              placeholder="Tell me about your project..."
            ></textarea>
          </div>

          <button
            type="submit"
            :disabled="loading"
            class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed font-medium text-lg"
          >
            {{ loading ? 'Sending...' : 'Send Message' }}
          </button>

          <p v-if="message" :class="success ? 'text-green-600' : 'text-red-600'" class="text-center font-medium">
            {{ message }}
          </p>
        </form>
      </div>

      <div class="mt-12 text-center">
        <p class="text-gray-600 dark:text-gray-400 mb-4">
          Or reach out directly:
        </p>
        <div class="flex justify-center gap-6">
          <a href="mailto:sheikhshahzaman001@gmail.com" class="text-blue-600 hover:text-blue-700 dark:text-blue-400">
            sheikhshahzaman001@gmail.com
          </a>
          <span class="text-gray-400">•</span>
          <a href="tel:+923215505100" class="text-blue-600 hover:text-blue-700 dark:text-blue-400">
            +92-321-550-5100
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useHead } from '@unhead/vue'
import { portfolioAPI } from '../services/api'

const form = ref({
  name: '',
  email: '',
  subject: '',
  message: ''
})

const loading = ref(false)
const message = ref('')
const success = ref(false)

// Set meta tags for Contact page
useHead({
  title: 'Contact - Portfolio',
  meta: [
    { name: 'description', content: 'Get in touch for project collaborations, freelance work, or just to say hello. Contact me via email or phone.' },
    { name: 'keywords', content: 'contact, get in touch, hire developer, freelance, collaboration' },
    { name: 'robots', content: 'index, follow' },

    // Open Graph
    { property: 'og:type', content: 'website' },
    { property: 'og:title', content: 'Contact - Portfolio' },
    { property: 'og:description', content: 'Get in touch for project collaborations, freelance work, or just to say hello.' },
    { property: 'og:url', content: window.location.href },

    // Twitter Card
    { name: 'twitter:card', content: 'summary' },
    { name: 'twitter:title', content: 'Contact - Portfolio' },
    { name: 'twitter:description', content: 'Get in touch for project collaborations, freelance work, or just to say hello.' },
  ],
  link: [
    { rel: 'canonical', href: window.location.href },
  ],
})

const submitForm = async () => {
  loading.value = true
  message.value = ''

  try {
    const response = await portfolioAPI.sendContactMessage(form.value)
    success.value = true
    message.value = response.data.message
    form.value = { name: '', email: '', subject: '', message: '' }
  } catch (error) {
    success.value = false
    message.value = error.response?.data?.message || 'Failed to send message. Please try again.'
  } finally {
    loading.value = false
  }
}
</script>
