<div
    class="w-full overflow-hidden flex justify-center note md:border-2 dark:border-slate-700/50 rounded-lg mb-6 shadow-sm transition-all duration-300">
    <x-splade-form action="{{ route('topics.notes.update', $note) }}" method="patch" :default="[
        'content' => $note->content,
        'is_public' => $note->is_public,
        'updated_at' => $note->updated_at,
        'categoriesOptions' => [],
        'categories' => $note->categoriesMap(),
        'getCategoriesOptions' => false,
    ]"
        class="flex flex-col justify-between lg:pl-6 py-6 overflow-hidden" stay background
        submit-on-change="content, is_public, getCategoriesOptions, categories">
        <div class="flex flex-wrap md:items-center gap-6 mb-6 w-full md:pr-6" id="{{ $note->id }}">
            <div class="text-xl font-medium text-slate-400 first-letter:uppercase dark:text-slate-600">
                {{ $note->author->name }}
            </div>
            @auth
                @can('edit-note', [$note])
                    <div class="flex gap-6 ml-auto">
                        <span v-text="notes.extractDate('{{ $note->created_at }}')" class="text-slate-400"></span>
                        <span
                            v-text="notes.extractDate(form.updated_at = (form.$response && form.$response.updated_at) ? form.$response.updated_at : form.updated_at)"
                            class="text-slate-400"></span>
                    </div>
                @endcan
            @endauth
        </div>

        @can('edit-note', [$note])
            <tip-tap v-model="form.content" />
        @else
            <div class="ProseMirror" v-html="form.content"></div>
        @endcan
        <section v-if="form.categories.length > 0" class="mb-6 md:mr-6">
            <h2 class="mb-3 text-md font-semibold">Exit links</h2>
            <ul class="flex flex-col gap-6">
                <li v-for="(note, index) in form.categories" :key="index"
                    class="text-sm flex flex-col gap-2 rounded-md p-3 shrink text-slate-700 dark:text-slate-100 bg-slate-100 dark:bg-slate-700">
                    <x-nav-link v-bind:href="`/topics/${note.topic_id}#${note.id}`" target="_blank"
                        class="whitespace-break-spaces" v-text="note.title">
                    </x-nav-link>
                    <Link v-bind:href="`/topics/${note.topic_id}`" class="font-mono" v-text="note.topic">
                    </Link>
                    <Link v-bind:href="`/notes/${note.id}/references`"
                        class="font-medium text-fuchsia-500 hover:text-fuchsia-600 transition-colors duration-300">
                    Vizualize
                    </Link>
                </li>
            </ul>
        </section>
        <x-splade-transition show="form.categoriesOptions.length > 0">
            <div class="w-full mb-8">
                <h2 class="mt-6 mb-3 text-md font-semibold">Categories</h2>
                <ul class="flex flex-col gap-6 ml-0">
                    <li v-for="(note, index) in form.categoriesOptions" :key="index"
                        class="flex gap-2 items-center">
                        <input type="checkbox" v-model="form.categories" v-bind:id="`input-${note.id}`"
                            v-bind:value="note" />
                        <label v-bind:for="`input-${note.id}`" class="flex flex-col gap-1">
                            <span v-text="`${note.title}`"></span>
                            <span class="text-sm font-semibold" v-text="`${note.topic}`"></span>
                        </label>
                    </li>
                </ul>
            </div>
        </x-splade-transition>
        <div class="flex items-center justify-between md:mr-6 mt-4 gap-6">
            @auth
                @can('edit-note', [$note])
                    <x-splade-checkbox inline label="Public" name="is_public" value="1" class="checked:bg-fuchsia-400" />
                    <button @click.prevent="form.$put('getCategoriesOptions', !form.getCategoriesOptions)"
                        class="transition-colors duration-300 text-sky-500 hover:text-sky-600">
                        <p
                            v-if="form.$response && form.$response.categoriesOptions && (form.categoriesOptions = form.$response.categoriesOptions)">
                        </p>
                        <span v-if="!form.getCategoriesOptions">Link/Unlink</span>
                        <span v-if="form.getCategoriesOptions">Done</span>
                    </button>
                    <button @click.prevent="notes.convertToMarkdown(form.content)" class="text-fuchsia-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                        </svg>
                    </button>
                    <Link href="{{ route('topics.notes.delete', $note) }}" method="delete" confirm="Deletion requested"
                        confirm-text="This note will be permanently deleted?" confirm-button="Yes, delete it!"
                        cancel-button="No, keep it!" class="text-red-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    </Link>
                @endcan
            @endauth
        </div>
    </x-splade-form>
</div>
