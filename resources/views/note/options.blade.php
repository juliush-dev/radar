 <div class="flex flex-col gap-8 flex-wrap lg:flex-nowrap mt-4">
     <x-splade-transition show="form.categories.length > 0" class="mb-6 md:mr-6 flex-1">
         <h2 class="mb-4 font-medium">Related with</h2>
         <ul class="flex flex-col gap-6">
             <li v-for="(note, index) in form.categories" :key="index"
                 class="text-sm flex flex-col gap-0 rounded-md p-3 shrink text-slate-700 dark:text-slate-100 bg-slate-200 dark:bg-slate-700">
                 <x-nav-link v-bind:href="`/topics/${note.topic_id}#${note.id}`" target="_blank"
                     class="whitespace-break-spaces" v-text="note.title">
                 </x-nav-link>
                 <Link v-bind:href="`/topics/${note.topic_id}`" class="font-normal text-xs text-slate-400 mb-2"
                     v-text="note.topic">
                 </Link>
                 <Link v-bind:href="`/notes/${note.id}/references`"
                     class="font-medium text-fuchsia-500 hover:text-fuchsia-600 transition-colors duration-300">
                 Vizualize
                 </Link>
             </li>
         </ul>
     </x-splade-transition>
     <x-splade-transition show="form.categoriesOptions.length > 0"
         class="grow md:grow-0 md:w-1/2 whitespace-break-spaces ml-1 md:ml-0 dark:text-slate-400">
         <div class="w-full mb-8">
             <h2 class="mb-4 font-semibold">Link/Unlink relations</h2>
             <ul class="flex flex-col gap-6 ml-0">
                 <li>
                     <button @click.prevent="form.$put('getCategoriesOptions', !form.getCategoriesOptions)"
                         class="transition-colors duration-300 text-sky-500 hover:text-sky-600 -ml-0.5">
                         Done
                     </button>
                 </li>
                 <li v-for="(note, index) in form.categoriesOptions" :key="index"
                     class="flex gap-2 items-start">
                     <input type="checkbox" v-model="form.categories" v-bind:id="`input-${note.id}`"
                         v-bind:value="note" />
                     <label v-bind:for="`input-${note.id}`" class="flex flex-col -mt-1">
                         <span v-text="`${note.title}`"></span>
                         <span class="text-sm font-semibold" v-text="`${note.topic}`"></span>
                     </label>
                 </li>
                 <li>
                     <button @click.prevent="form.$put('getCategoriesOptions', !form.getCategoriesOptions)"
                         class="transition-colors duration-300 text-sky-500 hover:text-sky-600 -ml-0.5">
                         Done
                     </button>
                 </li>
             </ul>
         </div>
     </x-splade-transition>
 </div>
 <div class="flex items-center mt-4 gap-6">
     @auth
         @can('edit-note', [$note])
             <x-splade-checkbox inline label="Public" name="is_public" value="1" class="checked:bg-fuchsia-400" />
             @php $referersCount = $note->categoryOf()->count(); @endphp
             <Link href="{{ route('topics.references', $note) }}" v-if="@js($referersCount)"
                 class="flex items-center gap-1 text-fuchsia-400 hover:text-fuchsia-500 transition-colors duration-300">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                 class="w-5 h-5">
                 <path stroke-linecap="round"
                     d="M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 10-2.636 6.364M16.5 12V8.25" />
             </svg>
             <span class="text-lg">{{ $referersCount }}x</span>
             </Link>
             <button v-show="!form.getCategoriesOptions"
                 @click.prevent="form.$put('getCategoriesOptions', !form.getCategoriesOptions)"
                 class="transition-colors duration-300 text-sky-500 hover:text-sky-600">
                 <p
                     v-if="form.$response && form.$response.categoriesOptions && (form.categoriesOptions = form.$response.categoriesOptions)">
                 </p>
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-5 h-5">
                     <path stroke-linecap="round" stroke-linejoin="round"
                         d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                 </svg>
             </button>
             <button @click.prevent="notes.convertToMarkdown(form.content)" class="text-sky-500">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-5 h-5">
                     <path stroke-linecap="round" stroke-linejoin="round"
                         d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                 </svg>
             </button>
             <Link href="{{ route('topics.notes.delete', $note) }}" method="delete" confirm="Deletion requested"
                 confirm-text="This note will be permanently deleted?" confirm-button="Yes, delete it!"
                 cancel-button="No, keep it!" class="text-red-400 md:ml-auto">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                 class="w-5 h-5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
             </svg>
             </Link>
         @endcan
     @endauth
 </div>
