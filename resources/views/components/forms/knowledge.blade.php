<knowledge v-slot="card" :initial-value="knowledge">
    <x-splade-toggle>
        <div class="rounded p-4 bg-slate-100 lg:p-6 mb-10 shadow shadow-slate-400 w-full relative transition-all duration-150"
            v-bind:class="(knowledgeCube.reordering && knowledgeCube.reorder.index == index) && 'border-4 border-blue-400' || 'lg:border'">
            <button v-show="!toggled" @click.prevent.stop="toggle"
                class="absolute left-1/2 -translate-x-1/2 -top-4 border-t-2 border-slate-500 text-slate-500 rounded-full bg-slate-100 p-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <button v-show="toggled" @click.prevent.stop="toggle"
                class="absolute left-1/2 -translate-x-1/2 -bottom-4  border-b-2 border-slate-500 text-slate-500 rounded-full bg-slate-100 p-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                </svg>
            </button>
            <div class="mb-6">
                <label>Bridge <span class="text-sm font-mono">(automatically generated)</span></label>
                <div v-html="card.knowledge.bridge" class="my-6"></div>
            </div>
            <x-splade-transition show="toggled" class="my-3" enter="duration-1000" leave="duration-500">
                <x-splade-textarea rows="5" required v-model="card.knowledge.information"
                    label="Reformulated Information" class="mb-6 first-letter:uppercase"
                    placeholder="Host sind alle mit einem [Netzwerk] verbundenen Computer, die direkt an die [Netzwerkkommunikation] beteiligt sind."
                    @keydown="card.wrapToken" />
                <x-splade-wysiwyg v-model="card.knowledge.implications" label="Implications"
                    class="mb-4 prose jodit-wrapper overflow-hidden"
                    placeholder="This implied that, the sum of ... is calculated by adding ..." />
                <x-splade-input v-model="card.knowledge.external_reference" label="External reference" class="mb-6"
                    placeholder="https://moodle-hnbk.de/pluginfile.php/138211/mod_resource/content/1/%C3%9Cbung%20Grundbegriffe%20Datenbanken.pdf" />
            </x-splade-transition>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-6 bg-inherit w-full overflow-hidden">
                    <x-splade-toggle>
                        <x-splade-transition animation="slide-left" enter="duration-300" show="knowledgeCube.reordering"
                            class="flex gap-6">
                            <button @click.prevent.stop="setToggle(knowledgeCube.toggleReorder(index))"
                                class="flex w-fit gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 9.563C9 9.252 9.252 9 9.563 9h4.874c.311 0 .563.252.563.563v4.874c0 .311-.252.563-.563.563H9.564A.562.562 0 019 14.437V9.564z" />
                                </svg>
                                <span>Cancel</span>
                            </button>
                        </x-splade-transition>
                        <x-splade-transition animation="slide-left" enter="duration-300"
                            show="knowledgeCube.reordering && knowledgeCube.reorder.index != index && knowledgeCube.reorder.position != null">
                            <button @click.prevent.stop="knowledgeCube.setReorderingReference(index)"
                                class="flex w-fit gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7.5 3.75H6A2.25 2.25 0 003.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0120.25 6v1.5m0 9V18A2.25 2.25 0 0118 20.25h-1.5m-9 0H6A2.25 2.25 0 013.75 18v-1.5M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="first-letter:uppercase"
                                    v-text="knowledgeCube.reorder.position + ' Me'"></span>
                            </button>
                        </x-splade-transition>
                        <x-splade-transition animation="slide-left" enter="duration-300"
                            show="knowledgeCube.reorder.position == null"
                            class="flex items-center gap-6 w-fit overflow-hidden">
                            <button @click.prevent.stop="setToggle(knowledgeCube.setReorderingBefore(index))"
                                class="w-fit flex items-center gap-1 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-xs">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" />
                                </svg>
                                Reorder before
                            </button>
                            <button @click.prevent.stop="setToggle(knowledgeCube.setReorderingAfter(index))"
                                class="w-fit flex items-center gap-1 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-xs">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
                                </svg>
                                Reorder after
                            </button>
                        </x-splade-transition>
                    </x-splade-toggle>
                </div>
                <button @click.prevent.stop="knowledgeCube.removeKnowledge(index)" class="block w-fit">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6 text-red-400 hover:text-red-500
                            transition-color duration-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </x-splade-toggle>
</knowledge>
