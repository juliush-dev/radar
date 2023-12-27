<template>
    <div v-if="this.content"
         class="pt-6 modal-note fixed w-full lg:w-[900px] left-1/2 -translate-x-1/2 mx-auto h-1/2 bg-slate-100 dark:bg-slate-950 border border-slate-400/40 rounded-xl -ml-0.5 transition-all duration-300"
         :class="this.show ? '-bottom-3' : '-bottom-1/2'">
        <div class="h-full overflow-y-auto px-6 pb-6">
            <div class="ProseMirror" v-html="this.content"></div>
        </div>
        <div
             class="absolute border border-slate-400/40 px-3 py-1 top-0 right-0 flex gap-3 backdrop-blur rounded-xl rounded-tl-none rounded-br-none rounded-tr-xl">
            <Link :href="`/notes/${this.id}/edit`">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                 class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            </Link>
            <button @click.prevent="this.hide" class="">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </button>
        </div>
    </div>
</template>

<script>

export default {

    props: ['formResponse'],
    data () {
        return {
            content: this.formResponse?.content,
            id: this.formResponse?.id,
            show: false,
        }
    },
    methods: {
        hide () {
            this.show = false;
            setTimeout(() => {
                this.content = null;
                this.id = null;
            }, 300);
        }
    },
    mounted () {
        if (this.content) {
            setTimeout(() => {
                this.show = true;
            }, 300);
        }
    }
}
</script>
