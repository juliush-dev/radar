 <div
     class="bg-white dark:bg-slate-700 dark:border-slate-700 border-slate-300 flex flex-col gap-3 justify-between p-6 rounded-md whitespace-break-spaces border">
     <x-nav-link href="{{ route('checkpoints.preview', $checkpoint) }}"
         class="text-lg first-letter:uppercase w-full text-violet-500 group-hover:text-violet-700 transition-colors duration-300">
         <h1 class="mb-2">{{ $checkpoint->title }}</h1>
     </x-nav-link>
     <div class="flex gap-2 dark:text-slate-300">
         <span>{{ $checkpoint->questionAnswerSets->count() }}Q</span>
         @if (Auth::check())
             <span class="mx-1">/</span>
             <span>{{ $checkpoint->userSessions()->where('user_id', auth()->user()->id)->count() }}S</span>
         @endif
     </div>

     <div class="flex gap-5 items-center justify-end">
         @can('update-checkpoint', $checkpoint)
             <x-layouts.navigation-link require-login="true" class=" w-fit text-sm text-fuchsia-500 hover:text-fuchsia-600"
                 resource="checkpoints" action="edit" :action-args="$checkpoint" label="edit" />
         @endcan
         @can('delete-checkpoint', $checkpoint)
             <x-splade-link method="delete" href="{{ route('checkpoints.destroy', $checkpoint) }}"
                 confirm="Deletion requested" confirm-text="This checkpoint will be permanently deleted?"
                 confirm-button="Yes, delete it!" cancel-button="No, keep it!"
                 class="text-red-500 hover:text-red-600 text-sm">
                 delete
             </x-splade-link>
         @endcan
         <x-volatile-sign :model="$checkpoint" />
     </div>
 </div>
