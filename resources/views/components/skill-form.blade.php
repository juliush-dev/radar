<x-splade-form :action="$action" {{ $attributes->class('flex flex-col gap-8 shadow-md') }}>
    <x-splade-input name="title" label="Skill" placeholder="The student should be able to ..." />
    <x-splade-select class="text-slate-800" label="Group" name="topic_group_covering_it" :options="$groupsOptions" />
    <x-splade-select label="Fields" name="fields_covered_by_it" :options="$fieldsOptions" multiple />
    <x-splade-select label="Years" name="years_levels_covering_it" :options="$yearsOptions" multiple />
    <div class="flex justify-end mt-5">
        <x-splade-submit label="Submit it" />
    </div>
</x-splade-form>
