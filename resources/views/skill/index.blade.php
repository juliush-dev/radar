 <x-layouts.app active-page="Skills" icon="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z">
     <div class="h-full overflow-y-auto pb-8">
         <x-skills-filter :years="$rq->years()" :types="$rq->types()" :groups="$rq->groups()" :fields="$rq->fields()" />
         <div class="space-y-4 columns-1 lg:columns-3 w-full mb-4 gap-4 px-6 lg:px-10">
             @foreach ($skills as $skill)
                 <x-skill :loop="$loop" :skill="$skill" />
             @endforeach
             @if ($filterIsSet && $skills->count() == 0)
                 <p class="text-xl dark:text-white">No skill matches the filter</p>
             @endif
         </div>
         @can('create-skill')
             <div class="px-6 lg:px-10">
                 <Link href="{{ Auth::check() ? route('skills.create') : '#login-required' }}"
                     class="text-sky-400 hover:text-sky-500">
                 Create new skill
                 </Link>
             </div>
         @endcan
     </div>
 </x-layouts.app>
