<template>
    <div class="modal-note fixed w-full inset-x-1/2 -translate-x-1/2 z-5 lg:w-[945px] h-[53%] bg-slate-100 dark:bg-slate-950 border border-slate-400/40 rounded-xl transition-all duration-300"
         :class="this.bottomData ? '-bottom-3' : '-bottom-2/3'">
        <div class="h-full overflow-y-auto p-3 md:p-6 pb-20 lg:pb-6">
            <div class="ProseMirror" v-html="this.bottomData?.content"></div>
        </div>
        <div
             class="absolute border border-slate-400/40 px-3 py-1 top-0 right-0 flex gap-3 backdrop-blur rounded-xl rounded-tl-none rounded-br-none rounded-tr-xl">
            <Link :href="this.bottomData?.src">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                 class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            </Link>
            <button @click.prevent="emitClearBottomData" class="">
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
    props: ['bottomData'],
    methods: {
        emitClearBottomData () {
            this.$splade.emit('clearBottomData');
        }
    }

}
</script>
