<template>
  <section id="contact" class="py-20 px-4 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-2xl mx-auto">
      <h2 class="text-4xl font-bold text-center mb-12 gradient-text">
        Get In Touch
      </h2>

      <form @submit.prevent="submitForm" class="space-y-6">
        <div>
          <label for="name" class="block text-sm font-medium mb-2">Name</label>
          <input
            v-model="form.name"
            type="text"
            id="name"
            required
            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-600 outline-none"
          />
        </div>

        <div>
          <label for="email" class="block text-sm font-medium mb-2">Email</label>
          <input
            v-model="form.email"
            type="email"
            id="email"
            required
            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-600 outline-none"
          />
        </div>

        <div>
          <label for="subject" class="block text-sm font-medium mb-2">Subject</label>
          <input
            v-model="form.subject"
            type="text"
            id="subject"
            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-600 outline-none"
          />
        </div>

        <div>
          <label for="message" class="block text-sm font-medium mb-2">Message</label>
          <textarea
            v-model="form.message"
            id="message"
            required
            rows="6"
            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-600 outline-none"
          ></textarea>
        </div>

        <button
          type="submit"
          :disabled="loading"
          class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50"
        >
          {{ loading ? 'Sending...' : 'Send Message' }}
        </button>

        <p v-if="message" :class="success ? 'text-green-600' : 'text-red-600'" class="text-center">
          {{ message }}
        </p>
      </form>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
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
