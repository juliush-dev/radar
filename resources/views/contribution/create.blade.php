<x-splade-modal class="bg-slate-900" max-width="2xl">
    <h1 class="text-xl mb-8 first-letter:uppercase">Skill required to pass the IHK exam</h1>
    <x-splade-form action="{{ route('contribution.store') }}" class="flex flex-col gap-8">
        <x-splade-input name="title" label="Which Skill?" placeholder="The student should be able to ..." />
        <div class="p-3 rounded-md border border-slate-500">
            <x-splade-group class="mb-4" name="source" label="Where did you get this info from?" inline>
                @foreach ($sourcesOptions as $key => $value)
                    <x-splade-radio name="source" value="{{ $key }}" label="{{ $value }}" />
                @endforeach
            </x-splade-group>
            <div class="transition duration-500"
                v-bind:class="{'blur-sm': form.source != '{{ App\Enums\Source::InternetPage->value }}'}">
                <x-splade-input v-bind:disabled="form.source != '{{ App\Enums\Source::InternetPage->value }}'"
                    name="link" label="Please provide the link to that page" />
            </div>
        </div>
        <x-splade-select label="Which years of the training cover the subjects about this skill?"
            name="years_levels_covering_it" :options="$yearsLevelsOptions" multiple />
        <x-splade-select label="Which fields of the training does this skill covers?" name="fields_covered_by_it"
            :options="$knowledgeFieldsOptions" multiple />
        <x-splade-select class="text-slate-800" label="Which knowledge group covers this skill?"
            name="knowledge_group_covering_it" :options="$knowledgeGroupsOptions" />

        <x-splade-select class="text-slate-800" label="Decide for the visibility of this skill" name="modification_type"
            :options="$modificationsTypesOptions" />
        <div class="flex justify-end mt-5">
            <x-splade-submit label="Submit it" />
        </div>
    </x-splade-form>
</x-splade-modal>
