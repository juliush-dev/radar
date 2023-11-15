<question v-slot="card" :initialContent="question">
    <x-splade-toggle>
        <div @click.self="toggle" class="rounded p-4 bg-slate-100 lg:border lg:p-6 mb-10 shadow shadow-slate-400 w-full">
            <h4 @click.self="toggle" v-text="card.content.subject" class="text-lg font-medium first-letter:uppercase mb-1">
            </h4>
            <hr class="border-slate-300 mb-3">
            <x-splade-transition show="toggled" class="my-3" enter="duration-1000" leave="duration-500">
                <x-splade-textarea v-model="card.content.subject" label="What is the core message of this question?"
                    class="mb-3 first-letter:uppercase" placeholder="There are other words for Hosts" />
                <div v-if="card.content.is_cloze">
                    <x-forms.cloze-q-a />
                </div>
                <div v-if="card.content.is_flash_card">
                    <x-forms.flash-card-q-a />
                </div>
            </x-splade-transition>
            <button @click.prevent.stop="questionsCube.removeQuestion(index)" class="block w-fit ml-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6 text-red-400 hover:text-red-500
                            transition-color duration-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </x-splade-toggle>
</question>
