<template>
  <div class="min-h-screen py-20 px-4 pt-24">
    <div class="max-w-4xl mx-auto">
      <h1 class="text-4xl font-bold mb-8 gradient-text">Terms & Conditions</h1>

      <div class="prose dark:prose-invert max-w-none">
        <p class="text-lg mb-6">Last updated: {{ new Date().toLocaleDateString() }}</p>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">1. Agreement to Terms</h2>
          <p class="mb-4">
            By accessing and using this website, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to these Terms & Conditions, please do not use this website.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">2. Use License</h2>
          <p class="mb-4">
            Permission is granted to temporarily download one copy of the materials (information or software) on this website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:
          </p>
          <ul class="list-disc pl-6 mb-4 space-y-2">
            <li>Modify or copy the materials</li>
            <li>Use the materials for any commercial purpose or for any public display</li>
            <li>Attempt to decompile or reverse engineer any software contained on the website</li>
            <li>Remove any copyright or other proprietary notations from the materials</li>
            <li>Transfer the materials to another person or "mirror" the materials on any other server</li>
          </ul>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">3. Intellectual Property</h2>
          <p class="mb-4">
            All content on this website, including but not limited to text, graphics, logos, images, audio clips, video clips, digital downloads, and software, is the property of the website owner or its content suppliers and is protected by international copyright laws.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">4. Disclaimer</h2>
          <p class="mb-4">
            The materials on this website are provided on an 'as is' basis. We make no warranties, expressed or implied, and hereby disclaim and negate all other warranties including, without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">5. Limitations</h2>
          <p class="mb-4">
            In no event shall the website owner or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on this website.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">6. Accuracy of Materials</h2>
          <p class="mb-4">
            The materials appearing on this website could include technical, typographical, or photographic errors. We do not warrant that any of the materials on this website are accurate, complete, or current. We may make changes to the materials contained on this website at any time without notice.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">7. Links</h2>
          <p class="mb-4">
            We have not reviewed all of the sites linked to our website and are not responsible for the contents of any such linked site. The inclusion of any link does not imply endorsement by us of the site. Use of any such linked website is at the user's own risk.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">8. User Content</h2>
          <p class="mb-4">
            If you submit any content to our website (through contact forms, comments, etc.), you grant us a non-exclusive, royalty-free, perpetual, and worldwide license to use, modify, and display such content.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">9. Prohibited Activities</h2>
          <p class="mb-4">
            You are prohibited from using the website:
          </p>
          <ul class="list-disc pl-6 mb-4 space-y-2">
            <li>For any unlawful purpose</li>
            <li>To solicit others to perform or participate in any unlawful acts</li>
            <li>To violate any international, federal, provincial, or state regulations, rules, laws, or local ordinances</li>
            <li>To infringe upon or violate our intellectual property rights or the intellectual property rights of others</li>
            <li>To harass, abuse, insult, harm, defame, slander, disparage, intimidate, or discriminate</li>
            <li>To submit false or misleading information</li>
          </ul>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">10. Modifications</h2>
          <p class="mb-4">
            We may revise these Terms & Conditions at any time without notice. By using this website, you are agreeing to be bound by the then-current version of these Terms & Conditions.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">11. Governing Law</h2>
          <p class="mb-4">
            These terms and conditions are governed by and construed in accordance with the laws of your jurisdiction, and you irrevocably submit to the exclusive jurisdiction of the courts in that location.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-bold mb-4">12. Contact Information</h2>
          <p class="mb-4">
            If you have any questions about these Terms & Conditions, please contact us through our
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
  title: 'Terms & Conditions',
  meta: [
    { name: 'description', content: 'Terms & Conditions - Read the terms and conditions for using our website and services.' }
  ]
})
</script>
