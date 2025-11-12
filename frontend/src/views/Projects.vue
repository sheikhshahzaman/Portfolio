<template>
  <div class="min-h-screen py-20 px-4 pt-24">
    <div class="max-w-7xl mx-auto">
      <h1 class="text-5xl font-bold text-center mb-4 gradient-text">
        All Projects
      </h1>
      <p class="text-center text-gray-600 dark:text-gray-400 mb-12">
        Explore my portfolio of web applications and platforms
      </p>

      <div v-if="loading" class="text-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
      </div>

      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="project in projects"
          :key="project.id"
          class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2 flex flex-col"
        >
          <div class="aspect-video relative overflow-hidden">
            <img
              v-if="project.image_url"
              :src="project.image_url"
              :alt="project.title"
              class="w-full h-full object-cover"
            />
            <div v-else class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600"></div>
          </div>
          <div class="p-6 flex flex-col flex-1">
            <div class="flex items-center justify-between mb-2">
              <h3 class="text-xl font-bold">{{ project.title }}</h3>
              <span v-if="project.is_featured" class="text-xs px-2 py-1 bg-yellow-400 text-yellow-900 rounded-full">
                Featured
              </span>
            </div>
            <p class="text-sm text-blue-600 dark:text-blue-400 mb-2">{{ project.category }}</p>
            <p class="text-gray-600 dark:text-gray-400 mb-4 whitespace-pre-line">
              {{ project.short_description }}
            </p>
            <div class="flex flex-wrap gap-2 mb-4">
              <span
                v-for="tech in project.technologies"
                :key="tech"
                class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-full text-sm"
              >
                {{ tech }}
              </span>
            </div>
            <div class="flex gap-4 mt-auto">
              <button
                @click="openModal(project)"
                class="text-blue-600 hover:text-blue-700 dark:text-blue-400 font-medium"
              >
                View Details →
              </button>
              <a
                v-if="project.demo_url"
                :href="project.demo_url"
                target="_blank"
                class="text-gray-600 hover:text-gray-700 dark:text-gray-400"
              >
                Live Demo →
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Project Detail Modal -->
    <Teleport to="body">
      <Transition name="modal">
        <div
          v-if="showModal"
          class="fixed inset-0 z-50 overflow-y-auto"
          @click.self="closeModal"
        >
          <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <!-- Background overlay -->
            <div
              class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"
              @click="closeModal"
            ></div>

            <!-- Modal panel -->
            <div class="relative inline-block w-full max-w-4xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-2xl rounded-2xl">
              <!-- Close button -->
              <button
                @click="closeModal"
                class="absolute top-4 right-4 z-10 p-2 rounded-full bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
              >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>

              <div v-if="selectedProject" class="max-h-[90vh] overflow-y-auto">
                <!-- Project Image -->
                <div class="aspect-video relative overflow-hidden">
                  <img
                    v-if="selectedProject.image_url"
                    :src="selectedProject.image_url"
                    :alt="selectedProject.title"
                    class="w-full h-full object-cover"
                  />
                  <div v-else class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600"></div>
                </div>

                <!-- Project Details -->
                <div class="p-8">
                  <!-- Title and Category -->
                  <div class="flex items-start justify-between mb-4">
                    <div>
                      <h2 class="text-3xl font-bold mb-2">{{ selectedProject.title }}</h2>
                      <p class="text-lg text-blue-600 dark:text-blue-400">{{ selectedProject.category }}</p>
                    </div>
                    <span
                      v-if="selectedProject.is_featured"
                      class="px-3 py-1 bg-yellow-400 text-yellow-900 rounded-full text-sm font-medium"
                    >
                      Featured
                    </span>
                  </div>

                  <!-- Description -->
                  <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-3">Description</h3>
                    <div class="text-gray-600 dark:text-gray-400 leading-relaxed" v-html="selectedProject.description"></div>
                  </div>

                  <!-- Technologies -->
                  <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-3">Technologies Used</h3>
                    <div class="flex flex-wrap gap-2">
                      <span
                        v-for="tech in selectedProject.technologies"
                        :key="tech"
                        class="px-4 py-2 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-full text-sm font-medium"
                      >
                        {{ tech }}
                      </span>
                    </div>
                  </div>

                  <!-- Links -->
                  <div class="flex gap-4">
                    <a
                      v-if="selectedProject.demo_url"
                      :href="selectedProject.demo_url"
                      target="_blank"
                      class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-center transition-colors"
                    >
                      View Live Demo →
                    </a>
                    <a
                      v-if="selectedProject.github_url"
                      :href="selectedProject.github_url"
                      target="_blank"
                      class="flex-1 px-6 py-3 bg-gray-800 hover:bg-gray-900 text-white rounded-lg font-medium text-center transition-colors"
                    >
                      View Source Code →
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useHead } from '@unhead/vue'
import { portfolioAPI } from '../services/api'

const projects = ref([])
const loading = ref(true)
const showModal = ref(false)
const selectedProject = ref(null)

const openModal = (project) => {
  selectedProject.value = project
  showModal.value = true
  document.body.style.overflow = 'hidden'
}

const closeModal = () => {
  showModal.value = false
  selectedProject.value = null
  document.body.style.overflow = ''
}

// Set meta tags for Projects page
useHead({
  title: 'Projects - Portfolio',
  meta: [
    { name: 'description', content: 'Explore my portfolio of web applications, platforms, and development projects. View live demos and source code.' },
    { name: 'keywords', content: 'portfolio projects, web development, web applications, software projects' },
    { name: 'robots', content: 'index, follow' },

    // Open Graph
    { property: 'og:type', content: 'website' },
    { property: 'og:title', content: 'Projects - Portfolio' },
    { property: 'og:description', content: 'Explore my portfolio of web applications, platforms, and development projects.' },
    { property: 'og:url', content: window.location.href },

    // Twitter Card
    { name: 'twitter:card', content: 'summary_large_image' },
    { name: 'twitter:title', content: 'Projects - Portfolio' },
    { name: 'twitter:description', content: 'Explore my portfolio of web applications, platforms, and development projects.' },
  ],
  link: [
    { rel: 'canonical', href: window.location.href },
  ],
})

onMounted(async () => {
  try {
    const response = await portfolioAPI.getProjects()
    projects.value = response.data
  } catch (error) {
    console.error('Error loading projects:', error)
  } finally {
    loading.value = false
  }
})
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

.modal-enter-active .inline-block,
.modal-leave-active .inline-block {
  transition: transform 0.3s ease;
}

.modal-enter-from .inline-block,
.modal-leave-to .inline-block {
  transform: scale(0.95);
}
</style>
