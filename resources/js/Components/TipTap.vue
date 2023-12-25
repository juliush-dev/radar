<template>
    <div class="w-full">
        <editor-content :editor="editor" />
        <floating-menu :editor="editor" v-if="editor" :tippy-options="{
            offset: [35, 0]
        }" :shouldShow="({ editor, view, state, oldState }) => {
    return true;
}">
            <editor-menu :editor="editor" :noteId="noteId" :form="form" />
        </floating-menu>
    </div>
</template>

<script>
import StarterKit from '@tiptap/starter-kit'
import Image from '@tiptap/extension-image'
import Focus from '@tiptap/extension-focus'
import Link from '@tiptap/extension-link'
import TaskItem from '@tiptap/extension-task-item'
import TaskList from '@tiptap/extension-task-list'
import Highlight from '@tiptap/extension-highlight'
import Table from '@tiptap/extension-table'
import TableCell from '@tiptap/extension-table-cell'
import TableHeader from '@tiptap/extension-table-header'
import TableRow from '@tiptap/extension-table-row'
import Underline from '@tiptap/extension-underline'
import TextAlign from '@tiptap/extension-text-align'
import { CustomTextStyle } from './CustomTextStyle.vue'
import EditorMenu from './EditorMenu.vue'
import { ClassToggler } from './ClassToggler.vue'
import { Editor, EditorContent, FloatingMenu } from '@tiptap/vue-3'
import { Extension } from '@tiptap/core'
import tippy from 'tippy.js'
import 'tippy.js/themes/light-border.css';
import Youtube from '@tiptap/extension-youtube'

const CustomImage = Extension.create({
    addGlobalAttributes () {
        return [
            {
                // Extend the following extensions
                types: [
                    'image',
                ],
                // … with those attributes
                attributes: {
                    type: {
                        default: 'diagram',
                        renderHTML: attributes => {
                            // … and return an object with HTML attributes.
                            if (attributes.src?.includes('plantuml')) {
                                return {
                                    ...attributes,
                                    'data-type': `${attributes.type}`,
                                }
                            }
                        },
                    },
                }
            }];
    },
})


const Commander = Extension.create({
    name: "Commander",
    addKeyboardShortcuts () {
        return {
            'Mod-.': () => document.querySelector('#new-note').click(),
            'Mod-Shift-.': () => document.querySelector('#delete-note').click(),
            'Escape': () => this.editor.commands.blur()
        }
    },
})

export default {
    components: {
        EditorContent,
        FloatingMenu,
        EditorMenu
    },

    props: {
        modelValue: {
            type: String,
            default: 'Start writing here',
        },
        noteId: String,
        form: Object,
    },

    emits: ['update:modelValue'],

    data () {
        return {
            editor: null,
            tippyComment: null
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

    methods: {
        destroyComments () {
            if (this.tippyComment) {
                this.tippyComment.forEach(instance => instance.destroy());
            }
        },
        reloadComments () {
            this.tippyComment = tippy('span[data-tippy-content]', { theme: 'tomato' });
        }
    },

    mounted () {
        const vm = this;
        this.editor = new Editor({
            extensions: [
                StarterKit,
                Link,
                TaskList,
                TaskItem.configure({
                    nested: true,
                }),
                Focus.configure({
                    className: 'has-focus',
                    mode: 'deepest',
                }),
                Highlight.configure({ multicolor: true }),
                Table.configure({
                    resizable: true,
                }),
                TableRow,
                TableHeader,
                TableCell,
                Underline,
                TextAlign,
                ClassToggler,
                Commander,
                CustomTextStyle,
                Youtube,
                CustomImage,
                Image,
            ],
            content: this.modelValue,
            onFocus: () => {
                this.destroyComments();
                this.reloadComments();
            },
            onUpdate: () => {
                this.$emit('update:modelValue', this.editor.getHTML());
                this.destroyComments();
                this.reloadComments();
            },
        })
    },

    beforeUnmount () {
        this.destroyComments();
        this.editor.destroy()
    },
}
</script>
