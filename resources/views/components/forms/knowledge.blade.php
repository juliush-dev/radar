<knowledge v-slot="card" :initial-value="knowledge">
    <x-splade-toggle>
        <div class="rounded p-4 bg-slate-100 lg:border lg:p-6 mb-10 shadow shadow-slate-400 w-full relative">
            <button @click.prevent.stop="toggle"
                class="absolute left-1/2 -translate-x-1/2 -top-4 border-t-2 border-slate-500 text-slate-500 rounded-full bg-slate-100 p-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                </svg>
            </button>
            <button @click.prevent.stop="toggle"
                class="absolute left-1/2 -translate-x-1/2 -bottom-4  border-b-2 border-slate-500 text-slate-500 rounded-full bg-slate-100 p-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                </svg>
            </button>
            <x-splade-textarea rows="5" required v-model="card.knowledge.information" label="Information"
                class="mb-6 first-letter:uppercase"
                placeholder="Host sind alle mit einem [Netzwerk] verbundenen Computer, die direkt an die [Netzwerkkommunikation] beteiligt sind."
                @keydown="card.wrapToken" />
            <x-splade-transition show="toggled" class="my-3" enter="duration-1000" leave="duration-500">
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
