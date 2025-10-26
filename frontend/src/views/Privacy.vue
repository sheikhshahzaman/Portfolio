<template>
  <div class="min-h-screen py-20 px-4 pt-24">
    <div class="max-w-4xl mx-auto">
      <h1 class="text-4xl font-bold mb-8 gradient-text">Privacy Policy</h1>

      <div class="prose dark:prose-invert max-w-none">
        <p class="text-lg mb-6">Last updated: {{ new Date().toLocaleDateString() }}</p>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">1. Information We Collect</h2>
          <p class="mb-4">
            When you visit our website or contact us, we may collect the following information:
          </p>
          <ul class="list-disc pl-6 mb-4 space-y-2">
            <li>Name and contact information (email address, phone number)</li>
            <li>Messages you send through our contact form</li>
            <li>Usage data and analytics (IP address, browser type, pages visited)</li>
            <li>Cookies and similar tracking technologies</li>
          </ul>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">2. How We Use Your Information</h2>
          <p class="mb-4">
            We use the information we collect for the following purposes:
          </p>
          <ul class="list-disc pl-6 mb-4 space-y-2">
            <li>To respond to your inquiries and provide customer support</li>
            <li>To improve our website and services</li>
            <li>To send periodic emails regarding your inquiry or other products and services</li>
            <li>To analyze website usage and optimize user experience</li>
          </ul>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">3. Information Sharing</h2>
          <p class="mb-4">
            We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except:
          </p>
          <ul class="list-disc pl-6 mb-4 space-y-2">
            <li>When required by law or to comply with legal processes</li>
            <li>To trusted service providers who assist us in operating our website</li>
            <li>To protect our rights, property, or safety</li>
          </ul>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">4. Cookies</h2>
          <p class="mb-4">
            Our website uses cookies to enhance user experience. Cookies are small files that a site or its service provider transfers to your computer's hard drive through your web browser (if you allow) that enables the site's systems to recognize your browser and capture and remember certain information.
          </p>
          <p class="mb-4">
            You can choose to disable cookies through your browser settings. However, this may affect your ability to use certain features of our website.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">5. Data Security</h2>
          <p class="mb-4">
            We implement appropriate security measures to protect your personal information from unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the internet or electronic storage is 100% secure.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">6. Your Rights</h2>
          <p class="mb-4">
            You have the right to:
          </p>
          <ul class="list-disc pl-6 mb-4 space-y-2">
            <li>Access the personal information we hold about you</li>
            <li>Request correction of inaccurate information</li>
            <li>Request deletion of your personal information</li>
            <li>Opt-out of receiving marketing communications</li>
          </ul>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">7. Third-Party Links</h2>
          <p class="mb-4">
            Our website may contain links to third-party websites. We are not responsible for the privacy practices or content of these external sites. We encourage you to review their privacy policies.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">8. Changes to This Policy</h2>
          <p class="mb-4">
            We may update this Privacy Policy from time to time. Any changes will be posted on this page with an updated revision date.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">9. Contact Us</h2>
          <p class="mb-4">
            If you have any questions about this Privacy Policy, please contact us through our
            <router-link to="/contact" class="text-blue-600 dark:text-blue-400 hover:underline">contact page</router-link>.
          </p>
        </section>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useHead } from '@unhead/vue'

useHead({
  title: 'Privacy Policy',
  meta: [
    { name: 'description', content: 'Privacy Policy - Learn how we collect, use, and protect your personal information.' }
  ]
})
</script>
