<template>
    <div id="menu"
         class="px-2 py-1 shadow-lg bg-slate-100 border-2 border-slate-300 rounded-md transition-all duration-300 flex gap-4 items-center w-fit">
        <div class="flex items-center">
            <button id="table" class="w-fit" @click.prevent>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                </svg>
            </button>
            <div id="template" class="controls-panel mb-3">
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
        <button id="get-image" @click.prevent>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                 class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
            </svg>
        </button>
        <div class="flex items-center">
            <button id="highlights" class="w-fit" @click.prevent>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4.098 19.902a3.75 3.75 0 005.304 0l6.401-6.402M6.75 21A3.75 3.75 0 013 17.25V4.125C3 3.504 3.504 3 4.125 3h5.25c.621 0 1.125.504 1.125 1.125v4.072M6.75 21a3.75 3.75 0 003.75-3.75V8.197M6.75 21h13.125c.621 0 1.125-.504 1.125-1.125v-5.25c0-.621-.504-1.125-1.125-1.125h-4.072M10.5 8.197l2.88-2.88c.438-.439 1.15-.439 1.59 0l3.712 3.713c.44.44.44 1.152 0 1.59l-2.879 2.88M6.75 17.25h.008v.008H6.75v-.008z" />
                </svg>
            </button>
            <div id="highlights-colors" class="controls-panel mb-3">
                <button class="unmark" @click.stop="editor.commands.unsetClass()">
                    Unmark
                </button>
                <button class="mark-relative" @click.stop="editor.commands.setClass('mark-relative')">
                    Mark as relative
                </button>
                <button class="mark-subject" @click.stop="editor.commands.setClass('mark-subject')">
                    Subject
                </button>
                <button class="mark-verb" @click.stop="editor.commands.setClass('mark-verb')">
                    Verb
                </button>
                <button class="mark-complement" @click.stop="editor.commands.setClass('mark-complement')">
                    Complement
                </button>
                <button class="mark-preposition" @click.stop="editor.commands.setClass('mark-preposition')">
                    Preposition
                </button>
            </div>
        </div>
        <div class="flex items-center">
            <button id="comment" class="w-fit" @click.prevent>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z" />
                </svg>
            </button>
            <div id="comment-box" class="controls-panel mb-3">
                <div class="flex flex-col gap-2">
                    <label class="text-slate-400">Comment</label>
                    <textarea class="text-sm border-fuchsia-400 rounded" id="comment-input" cols="30" rows="3"
                              v-model="comment"></textarea>
                </div>
                <div class="flex gap-4">
                    <button class="bg-sky-100 text-sky-900 dark:bg-sky-900 dark:text-sky-100 font-medium py-1 px-2 shadow rounded"
                            @click.stop="setComment">
                        Comment
                    </button>
                    <button class="bg-slate-200 text-slate-900 dark:bg-slate-900 dark:text-slate-100 font-medium py-1 px-2 shadow rounded"
                            @click.stop="unsetComment">
                        Uncomment
                    </button>
                </div>
            </div>
        </div>
        <div class="flex items-center">
            <button class="w-fit" @click.prevent="unsetComment(); editor.commands.unsetClass();">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
import tippy from 'tippy.js'

export default {

    props: {
        editor: Object,
        noteId: String,
        form: Object,
    },

    data () {
        return {
            relatives: null,
            categories: null,
            comment: null
        }
    },

    methods: {
        setComment () {
            this.editor.commands.setComment(this.comment);
            this.comment = null;
        },
        unsetComment () {
            this.comment = null;
            this.editor.commands.unsetComment();
        }
    },

    mounted () {
        const vm = this;

        const onImageLoadingLabelContent = '<span class="px-4 rounded bg-slate-100 border border-blue-400 py-1">Loading...</span>';
        const onImageLoadingFailedLabelContent = (error) => `<span class="px-4 rounded bg-red-400 border border-red-400 text-white py-1">Request failed ${error}</span>`;

        tippy('#table', {
            interactive: true,
            content: document.getElementById('template'),
            allowHTML: true,
            placement: 'bottom',
            trigger: 'click',
        });
        tippy('#get-image', {
            content: onImageLoadingLabelContent,
            allowHTML: true,
            placement: 'bottom',
            interactive: true,
            trigger: 'click',
            onCreate (instance) {
                // Setup our own custom state properties
                instance._isFetching = false;
                instance._src = null;
                instance._error = null;
            },
            onShow (instance) {
                if (instance._isFetching || instance._src || instance._error) {
                    return;
                }

                instance._isFetching = true;

                fetch('https://source.unsplash.com/random')
                    .then((response) => response.blob())
                    .then((blob) => {
                        const src = URL.createObjectURL(blob);
                        instance._src = src;
                        const image = document.createElement('img');
                        image.width = 200;
                        image.height = 200;
                        image.style.display = 'block';
                        image.style.cursor = 'pointer';
                        image.classList.add('rounded-md', 'shadow-lg');
                        image.onclick = () => vm.editor.commands.setImage({ src });
                        image.src = src;
                        // Update the tippy content with the image
                        instance.setContent(image);
                    })
                    .catch((error) => {
                        instance._error = error;
                        instance.setContent(onImageLoadingFailedLabelContent(error));
                    })
                    .finally(() => {
                        instance._isFetching = false;
                    });
            },
            onHidden (instance) {
                instance.setContent(onImageLoadingLabelContent);
                // Unset these properties so new network requests can be initiated
                instance._src = null;
                instance._error = null;
            },
        });
        tippy('#highlights', {
            interactive: true,
            content: document.getElementById('highlights-colors'),
            allowHTML: true,
            placement: 'bottom',
            trigger: 'click',
        });

        tippy('#comment', {
            interactive: true,
            content: document.getElementById('comment-box'),
            allowHTML: true,
            placement: 'bottom',
            trigger: 'click',
        });
    },
    beforeUnmount () {
        // this.destroy()
    },
}
</script>
