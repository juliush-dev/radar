<template>
    <div class="h-full overflow-y-auto">
        <div
             class="flex flex-wrap md:items-center w-full sticky top-0 z-[5] bg-slate-100 dark:bg-slate-950 shadow-sm md:shadow border border-slate-400/10 border-t-0 px-3 lg:px-6 py-2">
            <span class="font-medium" v-text="title"></span>
            <div class="flex gap-6 ml-auto flex-nowrap items-center">
                <button v-show="definitionsVisible" @click.prevent="form.$put('editable', !editable)">
                    <svg v-if="!editable" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                    <svg v-if="editable" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </button>

                <Link id="new-note" method="post" v-bind:href="newNoteEndpoint">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-5 h-5 -mb-0.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                </Link>
                <Link id="delete-note" method="delete" v-bind:href="deleteNoteEndpoint" confirm-danger="Delete requested"
                      confirm-text="This note will be permanently deleted"
                      confirm-button="Yes, delete this note permanently" cancel-button="No don't delete">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-5 h-5 -mb-0.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                </Link>
            </div>
        </div>
        <editor-content class="p-3 lg:p-6 mb-[130%] lg:mb-[45%] border border-slate-400/10 shadow-sm overflow-hidden"
                        id="editor" :editor="editor" />
        <floating-menu :editor="editor" v-if="editor" :tippy-options="{
            offset: [35, 0]
        }" :shouldShow="() => { return editor.isEditable; }">
            <editor-menu :editor="editor" />
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
import { CustomTextStyle } from './CustomTextStyle'
import { DefinitionTerm } from './DefinitionTerm'
import EditorMenu, { selectionIsPlantUMLCode, selectionIsPlantUMLDiagram } from './EditorMenu.vue'
import { ClassToggler } from './ClassToggler.vue'
import { Editor, EditorContent, FloatingMenu } from '@tiptap/vue-3'
import { Extension } from '@tiptap/core'
import tippy from 'tippy.js'
import 'tippy.js/themes/light-border.css';
import Youtube from '@tiptap/extension-youtube'

const CustomImage = Extension.create({
    addKeyboardShortcuts () {
        return {
            'Mod-,': () => {
                if (selectionIsPlantUMLCode(this.editor)) {
                    document.querySelector('#render-plantuml').click();
                } else if (selectionIsPlantUMLDiagram(this.editor)) {
                    document.querySelector('#resolve-plantuml').click();
                } else {
                    alert("Selection is not a valid plantuml code or diagram");
                }
            },
        }
    },
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
        form: Object,
        author: {
            type: String
        },
        title: {
            type: String
        },
        editable: {
            type: Boolean
        },
        createdAt: {
            type: String
        },
        updatedAt: {
            type: String
        },
        newNoteEndpoint: {
            type: String
        },
        deleteNoteEndpoint: {
            type: String
        }
    },

    emits: ['update:modelValue'],


    data () {
        return {
            editor: null,
            tippyComment: null,
            definitionsVisible: true,
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
        editable (value) {
            this.editor.setEditable(value);
        }
    },
    computed: {
        createTime () {
            return this.extractDate(this.createdAt);
        },
        updateTime () {
            return this.extractDate(this.updatedAt);
        }
    },

    methods: {
        destroyComments () {
            if (this.tippyComment) {
                this.tippyComment.forEach(instance => instance.destroy());
            }
        },
        reloadComments () {
            this.tippyComment = tippy('span[data-tippy-content]', { theme: 'tomato' });
        },
        extractDate (dateStr) {
            // Create a new Date object with the given string
            var dateObj = new Date(dateStr);

            // Extract the year, month, day, hour, and minute from the Date object
            var year = dateObj.getUTCFullYear();
            var month = dateObj.getUTCMonth() + 1; // getUTCMonth() is zero-based
            var day = dateObj.getUTCDate();
            var hour = dateObj.getUTCHours();
            var minute = dateObj.getUTCMinutes();
            var second = dateObj.getUTCSeconds();

            // Format the date as a string
            var date = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')} ${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;

            return date;
        },
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
                DefinitionTerm,
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
        });
        this.editor.setEditable(this.editable);
        this.$splade.on('lockEditor', () => {
            this.editor.setEditable(false);
        });
        this.$splade.on('toggleDefinitionsQuiz', () => {
            if (this.editable) {
                alert('lock editor first');
            } else {
                const elements = document.querySelectorAll('#editor p:has(dfn)');
                this.definitionsVisible = document.querySelector('#editor p.blind') != undefined;
                elements.forEach(definition => {
                    definition.classList.toggle('blind');
                })
            }
        });
        this.$splade.on('edited', (data) => {
            if (this.form.title != data.title) {
                this.form.$put('title', data.title);
            }
            if (this.form.updated_at != data.updated_at) {
                this.form.$put('updated_at', data.updated_at);
            }
        });
    },


    beforeUnmount () {
        this.destroyComments();
        this.editor.destroy()
    },

}
</script>
