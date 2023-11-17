<knowledge-cube v-slot="knowledgeCube" :cube="knowledgeCube">
    <x-splade-toggle>
        <div @click.self="toggle" class="border-t pt-6 px-4 pb-4 bg-slate-100 lg:border rounded lg:p-6">
            <div @click.capture="toggle" class="flex items-center gap-4 whitespace-nowrap flex-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                </svg>
                <h2 v-text="knowledgeCube.cube.subject" class="text-xl font-medium first-letter:uppercase"></h2>
            </div>
            <x-splade-transition show="!toggled" class="mb-3  mt-6">
                <x-splade-textarea v-model="knowledgeCube.cube.subject" label="What is this cube about?"
                    class="mb-6 first-letter:uppercase whitespace-break-spaces" placeholder="Host" />
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
