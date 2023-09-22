<div class="w-full px-20 group">
    <div class="flex gap-2 bg-slate-100 rounded-full">
        <h1 class="text-slate-500 text-xl p-2 flex gap-2 items-center">
            <span class="bg-slate-50 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 text-slate-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                </svg>
            </span>
        </h1>
        <div class="flex p-2 items-center w-full">
            {{-- BySubject, ByYears, ByFields, BySkill, ByFirstLetter --}}
            <x-splade-form method="get" preserve-scroll submit-on-change :default="[
                'subject' => request()->query('subject'),
                'year' => request()->query('year'),
                'skill' => request()->query('skill'),
            ]" class="flex w-full gap-6">
                <x-splade-select class="w-48" placeholder="Subject" name="subject" :options="$subjects" option-value="id"
                    option-label="title" />
                <x-splade-select class="w-48" placeholder="Year" name="year" :options="$years" option-value="id"
                    option-label="title" />
                <x-splade-select class="w-48" placeholder="Skill" name="skill" :options="$skills" option-value="id"
                    option-label="title" />
                {{-- <x-splade-select name="skill" :options="$skills" option-value="id" option-label="label" /> --}}
            </x-splade-form>
        </div>
    </div>
</div>
