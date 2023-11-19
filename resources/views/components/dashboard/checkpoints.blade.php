 <x-splade-table :for="$checkpoints">
     @cell('title', $checkpoint)
         <x-splade-link :href="route('checkpoints.preview', $checkpoint)"
             class=" text-violet-500 hover:text-violet-800 dark:text-violet-600 transition-colors duration-300">
             {{ $checkpoint->title }}
         </x-splade-link>
     @endcell
     @cell('knowledge', $checkpoint)
         <span class="text-md">
             {{ $checkpoint->knowledgeCubes->count() }}
         </span>
     @endcell
     @cell('public', $checkpoint)
         @if (!$checkpoint->is_update)
             <x-splade-form submit-on-change :action="$checkpoint->is_public
                 ? route('checkpoints.unpublish', $checkpoint)
                 : route('checkpoints.publish', $checkpoint)" method="post" :default="['is_public' => $checkpoint->is_public]">
                 <x-splade-checkbox name="is_public" value="1" class="checked:bg-fuchsia-400" />
             </x-splade-form>
         @else
             <span>NN</span>
         @endif
     @endcell
     @cell('potentialReplacementOf.title', $checkpoint)
         @if ($checkpoint->potentialReplacementOf == null)
             -
         @else
             <x-splade-link :href="route('checkpoints.preview', $checkpoint->potentialReplacementOf)"
                 class="text-teal-500 hover:text-teal-800 dark:text-teal-600 transition-colors duration-300">
                 {{ $checkpoint->potentialReplacementOf->title }}
             </x-splade-link>
         @endif
     @endcell
     @cell('action', $checkpoint)
         @if ($checkpoint->topic->is_update && $checkpoint->is_update)
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-6 h-6 text-yellow-500 hover:text-yellow-600">
                 <path stroke-linecap="round" stroke-linejoin="round"
                     d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
             </svg>
         @endif
         @if (!$checkpoint->topic->is_update && $checkpoint->is_update && $checkpoint->potentialReplacement == null)
             <x-splade-link confirm method="post" :href="route('checkpoints.apply-update', $checkpoint)" class="mr-4">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor"
                     class="w-6 h-6 text-teal-500 hover:text-teal-600 shadow
                hover:shadow-md transition-all duration-300">
                     <path stroke-linecap="round" stroke-linejoin="round"
                         d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                 </svg>
             </x-splade-link>
         @endif
         @if (!$checkpoint->topic->is_update && $checkpoint->potentialReplacement == null)
             <x-splade-link :href="route('checkpoints.edit', $checkpoint)" class="mr-4">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor"
                     class="w-6 h-6 text-violet-400 hover:text-violet-500 shadow
                hover:shadow-md transition-all duration-300">
                     <path stroke-linecap="round" stroke-linejoin="round"
                         d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                 </svg>
             </x-splade-link>
         @endif
         @if ($checkpoint->potentialReplacement)
             <span class="px-2 bg-yellow-400 font-mono text-sm">Update available</span>
         @elseif ($checkpoint->topic->potentialReplacement == null && !$checkpoint->topic->is_update)
             <x-splade-link confirm method="delete" href="{{ route('checkpoints.destroy', $checkpoint) }}">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor"
                     class="w-6 h-6 text-red-500 hover:text-red-600 shadow
                hover:shadow-md transition-all duration-300">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                 </svg>
             </x-splade-link>
         @endif
     @endcell
 </x-splade-table>
