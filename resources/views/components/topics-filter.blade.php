<div class="w-full px-20 group">
    <div class="flex gap-0 bg-slate-100 hover:shadow rounded-full">
        <h1 class="text-slate-500 text-xl p-2 flex gap-2 items-center">
            <span class="bg-slate-50 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 text-slate-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                </svg>
            </span>
        </h1>
        <div class="flex gap-4 p-2 items-center">
            {{-- BySubject, ByYears, ByFields, BySkill, ByFirstLetter --}}
            <x-splade-form :action="route('topics.filter')" submit-on-change class="flex gap-4">
                <x-splade-select name="subject" :options="$subjects" option-value="id" option-label="title" />
                <x-splade-select name="year" :options="$years" option-value="id" option-label="title" />
                <x-splade-select name="skill" :options="$skills" option-value="id" option-label="title" />
                {{-- <x-splade-select name="skill" :options="$skills" option-value="id" option-label="label" /> --}}
            </x-splade-form>
        </div>
    </div>
</div>
