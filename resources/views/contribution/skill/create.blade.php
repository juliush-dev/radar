<x-layouts.app>
    <x-layouts.contributions label="New Skill"
        action-icon="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z">
        <x-splade-modal close-explicitly class="p-6 h-full">
            <x-splade-form :action="route('contributions.skills.store')" class="flex flex-col gap-8 m-auto grow" default="
            {
                items: [{name: ''}],
            }
            ">
                <form-aggregator v-slot="aggregator" :form="form">
                    <div class="flex gap-4 h-full">
                        <div class="w-1/2 h-full">
                            <x-splade-input name="title" label="Skill"
                                placeholder="The student should be able to ..." />
                            <x-splade-select class="text-slate-800" label="Group" name="group" :options="$groupsOptions" />
                            <x-splade-select label="Fields" name="fields" :options="$fieldsOptions" multiple />
                            <x-splade-select label="Years" name="years" :options="$yearsOptions" multiple />
                        </div>
                        {{-- form.fields.length > 0 && form.years.length > 0 --}}
                        <div v-if="true" class="h-full" id="new-topic">
                            <div v-for="(item, index) in form.items" :key="index" class="item">
                                <x-splade-input v-model="item.name" class="w-full" />
                                <button type="button" @click="aggregator.removeItem(index)">Remove Item</button>
                            </div>
                            <button type="button" @click="aggregator.addItem">Add an Item</button>

                        </div>
                    </div>
                    <div class="flex justify-end mt-5">
                        <x-splade-submit label="Submit it" />
                    </div>
                </form-aggregator>
            </x-splade-form>
        </x-splade-modal>
    </x-layouts.contributions>
</x-layouts.app>
