<script setup>
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Link from '@tiptap/extension-link'
import Underline from '@tiptap/extension-underline'
import TextAlign from '@tiptap/extension-text-align'
import Image from '@tiptap/extension-image'
import TextStyle from '@tiptap/extension-text-style'
import Color from '@tiptap/extension-color'
import Highlight from '@tiptap/extension-highlight'
import { watch, ref } from 'vue'

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
})

const emit = defineEmits(['update:modelValue'])

const showHtmlEditor = ref(false)
const htmlContent = ref('')

const editor = useEditor({
    content: props.modelValue,
    extensions: [
        StarterKit,
        Link.configure({
            openOnClick: false,
        }),
        Underline,
        TextAlign.configure({
            types: ['heading', 'paragraph'],
        }),
        Image.configure({
            inline: true,
            allowBase64: true,
        }),
        TextStyle,
        Color,
        Highlight.configure({
            multicolor: true,
        }),
    ],
    onUpdate: ({ editor }) => {
        emit('update:modelValue', editor.getHTML())
    },
})

watch(() => props.modelValue, (value) => {
    const isSame = editor.value.getHTML() === value
    if (!isSame) {
        editor.value.commands.setContent(value, false)
    }
})

const addImage = () => {
    const url = prompt('Enter image URL:')
    if (url) {
        editor.value.chain().focus().setImage({ src: url }).run()
    }
}

const addLink = () => {
    const url = prompt('Enter URL:')
    if (url) {
        editor.value.chain().focus().setLink({ href: url }).run()
    }
}

const toggleHtmlEditor = () => {
    if (!showHtmlEditor.value) {
        htmlContent.value = editor.value.getHTML()
    } else {
        editor.value.commands.setContent(htmlContent.value, false)
        emit('update:modelValue', htmlContent.value)
    }
    showHtmlEditor.value = !showHtmlEditor.value
}

const setColor = () => {
    const color = prompt('Enter color (e.g., #ff0000, red):')
    if (color) {
        editor.value.chain().focus().setColor(color).run()
    }
}

const setHighlight = () => {
    const color = prompt('Enter highlight color (e.g., #ffff00, yellow):')
    if (color) {
        editor.value.chain().focus().setHighlight({ color }).run()
    }
}
</script>

<template>
    <div class="tiptap-editor border border-gray-300 dark:border-gray-700 rounded-md">
        <!-- Toolbar -->
        <div v-if="editor" class="border-b border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-2 flex flex-wrap gap-1">
            <!-- Text Formatting -->
            <button
                type="button"
                @click="editor.chain().focus().toggleBold().run()"
                :class="{ 'bg-gray-300 dark:bg-gray-600': editor.isActive('bold') }"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm font-bold"
            >
                B
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleItalic().run()"
                :class="{ 'bg-gray-300 dark:bg-gray-600': editor.isActive('italic') }"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm italic"
            >
                I
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleUnderline().run()"
                :class="{ 'bg-gray-300 dark:bg-gray-600': editor.isActive('underline') }"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm underline"
            >
                U
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleStrike().run()"
                :class="{ 'bg-gray-300 dark:bg-gray-600': editor.isActive('strike') }"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm line-through"
            >
                S
            </button>

            <div class="w-px h-6 bg-gray-300 dark:bg-gray-600 mx-1"></div>

            <!-- Headings -->
            <button
                type="button"
                @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
                :class="{ 'bg-gray-300 dark:bg-gray-600': editor.isActive('heading', { level: 1 }) }"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm font-bold"
            >
                H1
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
                :class="{ 'bg-gray-300 dark:bg-gray-600': editor.isActive('heading', { level: 2 }) }"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm font-bold"
            >
                H2
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
                :class="{ 'bg-gray-300 dark:bg-gray-600': editor.isActive('heading', { level: 3 }) }"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm font-bold"
            >
                H3
            </button>

            <div class="w-px h-6 bg-gray-300 dark:bg-gray-600 mx-1"></div>

            <!-- Lists -->
            <button
                type="button"
                @click="editor.chain().focus().toggleBulletList().run()"
                :class="{ 'bg-gray-300 dark:bg-gray-600': editor.isActive('bulletList') }"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm"
            >
                • List
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleOrderedList().run()"
                :class="{ 'bg-gray-300 dark:bg-gray-600': editor.isActive('orderedList') }"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm"
            >
                1. List
            </button>

            <div class="w-px h-6 bg-gray-300 dark:bg-gray-600 mx-1"></div>

            <!-- Blockquote & Code -->
            <button
                type="button"
                @click="editor.chain().focus().toggleBlockquote().run()"
                :class="{ 'bg-gray-300 dark:bg-gray-600': editor.isActive('blockquote') }"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm"
            >
                Quote
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleCodeBlock().run()"
                :class="{ 'bg-gray-300 dark:bg-gray-600': editor.isActive('codeBlock') }"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm font-mono"
            >
                &lt;/&gt;
            </button>

            <div class="w-px h-6 bg-gray-300 dark:bg-gray-600 mx-1"></div>

            <!-- Alignment -->
            <button
                type="button"
                @click="editor.chain().focus().setTextAlign('left').run()"
                :class="{ 'bg-gray-300 dark:bg-gray-600': editor.isActive({ textAlign: 'left' }) }"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm"
            >
                ⇐
            </button>
            <button
                type="button"
                @click="editor.chain().focus().setTextAlign('center').run()"
                :class="{ 'bg-gray-300 dark:bg-gray-600': editor.isActive({ textAlign: 'center' }) }"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm"
            >
                ⇔
            </button>
            <button
                type="button"
                @click="editor.chain().focus().setTextAlign('right').run()"
                :class="{ 'bg-gray-300 dark:bg-gray-600': editor.isActive({ textAlign: 'right' }) }"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm"
            >
                ⇒
            </button>

            <div class="w-px h-6 bg-gray-300 dark:bg-gray-600 mx-1"></div>

            <!-- Link & Image -->
            <button
                type="button"
                @click="addLink"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm"
                title="Add Link"
            >
                🔗
            </button>
            <button
                type="button"
                @click="addImage"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm"
                title="Add Image"
            >
                🖼️
            </button>

            <div class="w-px h-6 bg-gray-300 dark:bg-gray-600 mx-1"></div>

            <!-- Color & Highlight -->
            <button
                type="button"
                @click="setColor"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm"
                title="Text Color"
            >
                🎨
            </button>
            <button
                type="button"
                @click="setHighlight"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm"
                title="Highlight"
            >
                ✨
            </button>

            <div class="w-px h-6 bg-gray-300 dark:bg-gray-600 mx-1"></div>

            <!-- Undo/Redo -->
            <button
                type="button"
                @click="editor.chain().focus().undo().run()"
                :disabled="!editor.can().undo()"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm disabled:opacity-50"
            >
                ↶
            </button>
            <button
                type="button"
                @click="editor.chain().focus().redo().run()"
                :disabled="!editor.can().redo()"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm disabled:opacity-50"
            >
                ↷
            </button>

            <div class="w-px h-6 bg-gray-300 dark:bg-gray-600 mx-1"></div>

            <!-- HTML Editor Toggle -->
            <button
                type="button"
                @click="toggleHtmlEditor"
                :class="{ 'bg-blue-300 dark:bg-blue-600': showHtmlEditor }"
                class="px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm font-mono"
                title="Edit HTML"
            >
                &lt;HTML&gt;
            </button>
        </div>

        <!-- HTML Editor -->
        <div v-if="showHtmlEditor" class="p-4 border-b border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
            <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">
                Edit HTML (Paste your HTML here):
            </label>
            <textarea
                v-model="htmlContent"
                class="w-full h-64 p-3 font-mono text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="<p>Paste your HTML here...</p>"
            />
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                Click the &lt;HTML&gt; button again to apply changes and return to visual editor
            </p>
        </div>

        <!-- Editor Content -->
        <EditorContent
            v-show="!showHtmlEditor"
            :editor="editor"
            class="prose dark:prose-invert max-w-none p-4 min-h-[300px] focus:outline-none dark:bg-gray-900 dark:text-gray-300"
        />
    </div>
</template>

<style>
/* Tiptap Editor Styles */
.tiptap {
    outline: none;
}

.tiptap p {
    margin-bottom: 1em;
}

.tiptap h1 {
    font-size: 2em;
    font-weight: bold;
    margin-bottom: 0.5em;
}

.tiptap h2 {
    font-size: 1.5em;
    font-weight: bold;
    margin-bottom: 0.5em;
}

.tiptap h3 {
    font-size: 1.25em;
    font-weight: bold;
    margin-bottom: 0.5em;
}

.tiptap ul,
.tiptap ol {
    padding-left: 1.5em;
    margin-bottom: 1em;
}

.tiptap ul {
    list-style-type: disc;
}

.tiptap ol {
    list-style-type: decimal;
}

.tiptap blockquote {
    border-left: 4px solid #e5e7eb;
    padding-left: 1em;
    margin-left: 0;
    font-style: italic;
    color: #6b7280;
}

.dark .tiptap blockquote {
    border-left-color: #4b5563;
    color: #9ca3af;
}

.tiptap pre {
    background: #1f2937;
    color: #f3f4f6;
    padding: 1em;
    border-radius: 0.5em;
    overflow-x: auto;
    margin-bottom: 1em;
}

.tiptap code {
    background: #f3f4f6;
    color: #1f2937;
    padding: 0.2em 0.4em;
    border-radius: 0.25em;
    font-family: monospace;
}

.dark .tiptap code {
    background: #374151;
    color: #f3f4f6;
}

.tiptap a {
    color: #2563eb;
    text-decoration: underline;
}

.dark .tiptap a {
    color: #60a5fa;
}

.tiptap img {
    max-width: 100%;
    height: auto;
    display: block;
    margin: 1em 0;
    border-radius: 0.5em;
}

.tiptap mark {
    background-color: #fef08a;
    padding: 0.1em 0.2em;
    border-radius: 0.25em;
}

.dark .tiptap mark {
    background-color: #854d0e;
    color: #fef3c7;
}
</style>
