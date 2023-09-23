<div class="flex gap-2 w-full px-6 group border-b border-slate-300">
    <h1 class="text-slate-500 text-xl p-2 flex gap-2 items-center">
        Filter:
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
