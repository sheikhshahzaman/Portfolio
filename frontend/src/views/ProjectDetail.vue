<template>
  <div class="min-h-screen py-20 px-4 pt-24">
    <div class="max-w-4xl mx-auto">
      <div v-if="loading" class="text-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
      </div>

      <div v-else-if="project" class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-lg">
        <div class="aspect-video bg-gradient-to-br from-blue-500 to-purple-600"></div>

        <div class="p-8">
          <div class="flex items-center justify-between mb-4">
            <h1 class="text-4xl font-bold">{{ project.title }}</h1>
            <span v-if="project.is_featured" class="px-3 py-1 bg-yellow-400 text-yellow-900 rounded-full text-sm">
              Featured
            </span>
          </div>

          <p class="text-xl text-blue-600 dark:text-blue-400 mb-6">{{ project.category }}</p>

          <div class="prose dark:prose-invert max-w-none mb-8">
            <p class="text-lg text-gray-700 dark:text-gray-300">{{ project.description }}</p>
          </div>

          <div class="mb-8">
            <h3 class="text-xl font-bold mb-3">Technologies Used</h3>
            <div class="flex flex-wrap gap-2">
              <span
                v-for="tech in project.technologies"
                :key="tech"
                class="px-4 py-2 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-full"
              >
                {{ tech }}
              </span>
            </div>
          </div>

          <div class="flex gap-4">
            <a
              v-if="project.demo_url"
              :href="project.demo_url"
              target="_blank"
              class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            >
              View Live Demo →
            </a>
            <a
              v-if="project.github_url"
              :href="project.github_url"
              target="_blank"
              class="px-6 py-3 border-2 border-blue-600 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-600 hover:text-white transition-colors"
            >
              View on GitHub →
            </a>
            <router-link
              to="/projects"
              class="px-6 py-3 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors"
            >
              ← Back to Projects
            </router-link>
          </div>
        </div>
      </div>

      <div v-else class="text-center py-20">
        <h2 class="text-2xl font-bold mb-4">Project Not Found</h2>
        <router-link to="/projects" class="text-blue-600 hover:text-blue-700">
          ← Back to Projects
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { portfolioAPI } from '../services/api'

const route = useRoute()
const project = ref(null)
const loading = ref(true)

onMounted(async () => {
  try {
    const response = await portfolioAPI.getProject(route.params.slug)
    project.value = response.data
  } catch (error) {
    console.error('Error loading project:', error)
  } finally {
    loading.value = false
  }
})
</script>
