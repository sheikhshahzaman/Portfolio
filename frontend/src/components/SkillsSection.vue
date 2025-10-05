<template>
  <section id="skills" class="py-20 px-4 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-6xl mx-auto">
      <h2 class="text-4xl font-bold text-center mb-12 gradient-text">
        Skills & Expertise
      </h2>

      <div class="space-y-8">
        <div v-for="(categorySkills, category) in skills" :key="category">
          <h3 class="text-2xl font-bold mb-4">{{ category }}</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div v-for="skill in categorySkills" :key="skill.id" class="space-y-2">
              <div class="flex justify-between">
                <span class="font-medium">{{ skill.name }}</span>
                <span class="text-gray-500">{{ skill.proficiency }}%</span>
              </div>
              <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div
                  class="bg-gradient-to-r from-blue-600 to-purple-600 h-2 rounded-full transition-all duration-500"
                  :style="{ width: skill.proficiency + '%' }"
                ></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
defineProps({
  skills: {
    type: Object,
    default: () => ({})
  }
})
</script>
