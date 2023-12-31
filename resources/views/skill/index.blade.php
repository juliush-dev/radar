 <x-layouts.app active-page="Skills"
     icon="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5">
     <div class="px-6 lg:pl-0 mb-4">
         <x-skills-filter :years="$rq->years()" :types="$rq->types()" :groups="$rq->groups()" :fields="$rq->fields()" :assessments="$rq->assessments()">
             {{ $skills->appends(request()->query())->links() }}
         </x-skills-filter>
         <div class="grid grid-cols-1 lg:grid-cols-2 w-full gap-6">
             @foreach ($skills as $skill)
                 <x-skill :loop="$loop" :skill="$skill" :user-assessment="$rq->userSkillAssessment($skill)" />
             @endforeach
             @if ($filterIsSet && $skills->count() == 0)
                 <p class="text-xl dark:text-white">No skill matches the filter</p>
             @endif
         </div>
     </div>
 </x-layouts.app>
