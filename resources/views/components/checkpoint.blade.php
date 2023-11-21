 <div
     class="transition-all group bg-white dark:bg-slate-700 dark:border-slate-700 border-slate-300 flex flex-col justify-between p-6 rounded-md whitespace-break-spaces border-2">
     <x-nav-link href="{{ route('checkpoints.preview', $checkpoint) }}"
         class="text-lg first-letter:uppercase w-full text-blue-400 dark:text-blue-200 group-hover:text-blue-500 dark:group-hover:text-blue-300 transition-colors duration-300">
         <h1 class="mb-2">{{ $checkpoint->title }}</h1>
     </x-nav-link>
     @if (Auth::check())
         @php
             $sessionsCount = $checkpoint
                 ->userSessions()
                 ->where('user_id', auth()->user()->id)
                 ->count();
         @endphp
         <span
             class="text-sm font-mono @if ($sessionsCount > 0) bg-gradient-to-r from-sky-600 to-blue-400 text-slate-50 @else bg-slate-400 text-slate-100 @endif  rounded-full px-2 mb-2">{{ $sessionsCount }}
             Session(s)</span>
     @endif


     <div class="flex gap-5 items-center justify-end mt-auto">
         <a href="{{ $checkpoint->source }}" target="_blank" rel="noopener noreferrer" class="mr-auto">Source</a>
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
