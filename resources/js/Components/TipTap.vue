<template>
    <div class="w-full mr-6">
        <editor-content :editor="editor" />
        <button v-bind:class="showTableMenu && 'text-sky-400' || 'text-slate-400'" @click="showTableMenu = !showTableMenu">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                 class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
            </svg>
        </button>
        <div v-if="editor && showTableMenu" class="controls-panel mb-3">
            <button class="soft"
                    @click.stop="editor.chain().focus().insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run()">
                insertTable
            </button>
            <button class="soft" @click.stop="editor.chain().focus().addColumnBefore().run()">
                addColumnBefore
            </button>
            <button class="soft" @click.stop="editor.chain().focus().addColumnAfter().run()">
                addColumnAfter
            </button>
            <button class="soft" @click.stop="editor.chain().focus().deleteColumn().run()">
                deleteColumn
            </button>
            <button class="soft" @click.stop="editor.chain().focus().addRowBefore().run()">
                addRowBefore
            </button>
            <button class="soft" @click.stop="editor.chain().focus().addRowAfter().run()">
                addRowAfter
            </button>
            <button class="soft" @click.stop="editor.chain().focus().deleteRow().run()">
                deleteRow
            </button>
            <button class="soft" @click.stop="editor.chain().focus().deleteTable().run()">
                deleteTable
            </button>
            <button class="soft" @click.stop="editor.chain().focus().mergeCells().run()">
                mergeCells
            </button>
            <button class="soft" @click.stop="editor.chain().focus().splitCell().run()">
                splitCell
            </button>
            <button class="soft" @click.stop="editor.chain().focus().toggleHeaderColumn().run()">
                toggleHeaderColumn
            </button>
            <button class="soft" @click.stop="editor.chain().focus().toggleHeaderRow().run()">
                toggleHeaderRow
            </button>
            <button class="soft" @click.stop="editor.chain().focus().toggleHeaderCell().run()">
                toggleHeaderCell
            </button>
            <button class="soft" @click.stop="editor.chain().focus().mergeOrSplit().run()">
                mergeOrSplit
            </button>
            <button class="soft" @click.stop="editor.chain().focus().setCellAttribute('colspan', 2).run()">
                setCellAttribute
            </button>
            <button class="soft" @click.stop="editor.chain().focus().fixTables().run()">
                fixTables
            </button>
            <button class="soft" @click.stop="editor.chain().focus().goToNextCell().run()">
                goToNextCell
            </button>
            <button class="soft" @click.stop="editor.chain().focus().goToPreviousCell().run()">
                goToPreviousCell
            </button>
        </div>
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
            showTableMenu: false,
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
