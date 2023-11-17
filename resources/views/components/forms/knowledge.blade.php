<knowledge v-slot="card" :initial-value="knowledge">
    <x-splade-toggle>
        <div @click.self="toggle" class="rounded p-4 bg-slate-100 lg:border lg:p-6 mb-10 shadow shadow-slate-400 w-full">
            <div @click.self="toggle" v-text="card.knowledge.information" class="first-letter:uppercase mb-1">
            </div>
            <hr class="border-slate-300 mb-3">
            <x-splade-transition show="toggled" class="my-3" enter="duration-1000" leave="duration-500">
                <x-splade-textarea rows="5" required v-model="card.knowledge.information" label="Information"
                    class="my-6 first-letter:uppercase"
                    placeholder="Host sind alle mit einem [Netzwerk] verbundenen Computer, die direkt an die [Netzwerkkommunikation] beteiligt sind."
                    @keydown="card.wrapToken" />
                <div class="mb-6">
                    <label>Bridge <span class="text-sm font-mono">(automatically generated)</span></label>
                    <div v-html="card.knowledge.bridge" class="my-6"></div>
                </div>
                <x-splade-wysiwyg v-model="card.knowledge.implications" label="Implications"
                    class="mb-4 prose jodit-wrapper overflow-hidden"
                    placeholder="This implied that, the sum of ... is calculated by adding ..." />
                <x-splade-input v-model="card.knowledge.external_reference" label="External reference" class="mb-6"
                    placeholder="https://moodle-hnbk.de/pluginfile.php/138211/mod_resource/content/1/%C3%9Cbung%20Grundbegriffe%20Datenbanken.pdf" />
            </x-splade-transition>
            <button @click.prevent.stop="knowledgeCube.removeKnowledge(index)" class="block w-fit ml-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6 text-red-400 hover:text-red-500
                            transition-color duration-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </x-splade-toggle>
</knowledge>
