<knowledge-cube v-slot="knowledgeCube" :cube="knowledgeCube">
    <x-splade-toggle>
        <div class="border-t pt-6 mt-6 mb-12 px-4 pb-4 bg-slate-100 lg:border rounded lg:p-6 relative">
            <button v-show="toggled" @click.prevent.stop="toggle"
                class="absolute left-1/2 -translate-x-1/2 -top-4 border-t-2 border-slate-500 text-slate-500 rounded-full bg-slate-100 p-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <button v-show="!toggled" @click.prevent.stop="toggle"
                class="absolute left-1/2 -translate-x-1/2 -bottom-4  border-b-2 border-slate-500 text-slate-500 rounded-full bg-slate-100 p-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                </svg>
            </button>
            <div class="flex items-center gap-4 whitespace-nowrap flex-nowrap mb-6 w-full">
                <x-splade-textarea v-model="knowledgeCube.cube.subject" label="Main Concept in this cube"
                    class="first-letter:uppercase whitespace-break-spaces grow" placeholder="Host" />
            </div>
            <x-splade-transition show="!toggled" class="mb-3  mt-6">
                <div v-for="(knowledge, index) in knowledgeCube.cube.knowledge">
                    <x-forms.knowledge />
                </div>
                <div v-if="knowledgeCube.cube.subject && knowledgeCube.cube.subject.length > 3"
                    class="flex gap-6 w-fit">
                    <x-splade-button type="call-to-action" @click.prevent="knowledgeCube.addKnowledge"
                        class="w-fit bg-amber-500 hover:bg-amber-600 text-sm text-white mr-auto">
                        Add knowledge
                    </x-splade-button>
                </div>
            </x-splade-transition>
            <button @click.prevent.stop="checkpoint.removeKnowledgeCube(index)" class="block w-fit ml-auto lg:mr-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6 text-red-400 hover:text-red-500
                            transition-color duration-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </x-splade-toggle>
</knowledge-cube>
