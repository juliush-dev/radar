<template>
    <editor-content :editor="editor" />
</template>

<script>
import StarterKit from '@tiptap/starter-kit'
import Image from '@tiptap/extension-image'
import Focus from '@tiptap/extension-focus'
import Link from '@tiptap/extension-link'
import { Editor, EditorContent } from '@tiptap/vue-3'

export default {
    components: {
        EditorContent,
    },

    props: {
        modelValue: {
            type: String,
            default: 'Start writing here',
        },
    },

    emits: ['update:modelValue'],

    data () {
        return {
            editor: null,
        }
    },

    watch: {
        addImage () {
            const url = window.prompt('URL')

            if (url) {
                this.editor.chain().focus().setImage({ src: url }).run()
            }
        },
        modelValue (value) {
            // HTML
            const isSame = this.editor.getHTML() === value
            // JSON
            // const isSame = JSON.stringify(this.editor.getJSON()) === JSON.stringify(value)
            if (isSame) {
                return
            }
            this.editor.commands.setContent(value, false)
        },
    },

    mounted () {
        this.editor = new Editor({
            extensions: [
                StarterKit,
                Image,
                Link,
                Focus.configure({
                    className: 'has-focus',
                    mode: 'deepest',
                }),
            ],
            content: this.modelValue,
            onUpdate: () => {
                // HTML
                this.$emit('update:modelValue', this.editor.getHTML())
                // JSON
                // this.$emit('update:modelValue', this.editor.getJSON())
            },
        })
    },

    beforeUnmount () {
        this.editor.destroy()
    },
}
</script>
