<x-layouts.app active-page="New Topic"
    icon="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z">
    @php($years = $rq->years())
    @php($fields = $rq->fields())
    @php($subjects = $rq->subjects())
    @php($skills = $rq->skills())
    <x-splade-form :action="route('topics.store')" class="mx-auto pb-20 px-6 lg:px-20" :default="[
        'newSubject' => null,
        'newFields' => [],
        'newSkills' => [],
        'learningMaterials' => [],
    ]">
        <topic v-slot="topic" :form="form">
            <div class="flex h-full">
                <section class="relative mx-auto pt-6 w-1/2 h-full flex flex-col">
                    <h1 class="text-xl mb-4">New Topic</h1>
                    <div class="flex flex-col gap-6 pr-6  h-full overflow-y-auto">
                        <x-splade-textarea name="title" label="Title" />
                        <x-splade-select name="years" label="Year" :options="$years" option-value="id"
                            option-label="title" placeholder="Choose one" multiple />
                        <div class="flex flex-col gap-2">
                            <x-splade-select v-if="form.newSubject == null" name="subject" label="Subject"
                                :options="$subjects" option-value="id" option-label="title" placeholder="Choose or" />
                            <x-splade-button v-if="form.newSubject == null" type="call-to-action"
                                @click.prevent="topic.newSubject" class="w-full">
                                Add new Subject
                            </x-splade-button>
                            <p v-if="form.newSubject != null">New subject added</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <x-splade-select name="fields" label="Fields" :options="$fields" option-value="id"
                                option-label="title" placeholder="Choose or" multiple />
                            <x-splade-button class="w-full" type="call-to-action" @click.prevent="topic.newField">
                                @{{ form.newFields.length == 0 ? 'Add new Fields' : 'Add more' }}
                            </x-splade-button>
                            <p v-if="form.newFields.length > 0">(@{{ form.newFields.length }}) fields added</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <x-splade-select name="skills" label="Skill" :options="$skills" option-value="id"
                                option-label="title" placeholder="Choose or" multiple />
                            <x-splade-button class="w-full" type="call-to-action" @click.prevent="topic.newSkill">
                                @{{ form.newSkills.length == 0 ? 'Add new skills' : 'Add more' }}
                            </x-splade-button>
                            <p v-if="form.newSkills.length > 0">(@{{ form.newSkills.length }}) skills added</p>
                        </div>
                        <x-splade-file label="Learning materials" name="documents[]" filepond preview multiple />
                    </div>
                    <div class="p-4 pl-0 pr-6">
                        <x-splade-button type="call-to-action" class="w-full">
                            Save topic
                        </x-splade-button>
                    </div>
                </section>
                <div v-if="topic.activeTab != null" class="flex flex-col gap-4 w-1/2">
                    <div class="flex gap-0 w-full px-6">
                        <button v-show="form.newSubject != null" class="px-4 py-2 text-slate-500 cursor-pointer"
                            v-bind:class=" topic.activeTab == 'subject' && 'bg-teal-200 text-slate-900' "
                            @click.prevent="topic.setActiveTab('subject')">New Subject</button>
                        <button v-show="form.newFields.length > 0" class="px-4 py-2 text-slate-500 cursor-pointer"
                            v-bind:class=" topic.activeTab == 'fields' && 'bg-teal-200 text-slate-900' "
                            @click.prevent="topic.setActiveTab('fields')">New Fields (@{{ form.newFields.length }}) </button>
                        <button v-show="form.newSkills.length > 0" class="px-4 py-2 text-slate-500 cursor-pointer"
                            v-bind:class=" topic.activeTab == 'skills' && 'bg-teal-200 text-slate-900' "
                            @click.prevent="topic.setActiveTab('skills')">New Skills (@{{ form.newSkills.length }})</button>
                    </div>
                    <div class="flex flex-col w-full h-full">
                        <section v-show="topic.activeTab == 'subject'"
                            class="relative px-6 pb-2 w-full h-full  flex flex-col">
                            <x-splade-button v-if="form.newSubject != null" type="call-to-action"
                                @click.prevent="topic.removeNewSubject" class="w-full mb-4 pr-6">
                                Remove new Subject
                            </x-splade-button>
                            <div class="h-full overflow-y-auto flex flex-col gap-6 pb-4">
                                <div v-if="form.newSubject != null" class="flex flex-col gap-6 ">
                                    <x-splade-input v-model="form.newSubject.title" label="title" />
                                    <x-splade-input v-model="form.newSubject.abbreviation" label="Abbreviation" />
                                    <x-splade-select v-model="form.newSubject.years" :options="$years" option-value="id"
                                        option-label="title" label="Years" />
                                </div>
                            </div>
                        </section>
                        <section v-show="topic.activeTab == 'fields'"
                            class="relative px-6 pb-2 w-full h-full  flex flex-col">
                            <x-splade-button v-if="form.newFields.length > 0" type="call-to-action"
                                @click.prevent="topic.removeField" class="mb-4 pr-6">
                                Remove all new fields
                            </x-splade-button>
                            <div class="relative h-full overflow-y-auto flex flex-col gap-6 pb-2 pr-6">
                                <div v-for="(field, index) in form.newFields" class="flex flex-col gap-6"
                                    v-bind:key="index">
                                    <x-splade-input v-model="field.title" label="title" />
                                    <x-splade-input v-model="field.code" label="code" />
                                    <x-splade-select v-model="field.years" :options="$years" option-value="id"
                                        option-label="title" label="Years" multiple />
                                    <x-splade-button type="call-to-action" @click.prevent="topic.removeField(index)">
                                        Remove this Field
                                    </x-splade-button>
                                </div>
                            </div>
                        </section>
                        <section v-show="topic.activeTab == 'skills'"
                            class="relative px-6 pb-2 w-full h-full flex flex-col">
                            <x-splade-button v-if="form.newSkills.length > 0" type="call-to-action"
                                @click.prevent="topic.removeSkill" class="mb-4 pr-6">
                                Remove all new skills
                            </x-splade-button>
                            <div class="h-full overflow-y-auto flex flex-col gap-6 pb-4 pr-6">
                                <div v-for="(skill, index) in form.newSkills" class="flex flex-col gap-6"
                                    v-bind:key="index">
                                    <x-splade-textarea v-model="skill.title" label="title" />
                                    <x-splade-textarea v-model="skill.newGroup" label="New group" />
                                    <x-splade-select v-model="skill.years" :options="$years" option-value="id"
                                        option-label="title" label="Years" multiple />
                                    <x-splade-select v-model="skill.fields" :options="$fields" option-value="id"
                                        option-label="title" label="Fields" multiple />
                                    <x-splade-button type="call-to-action" @click.prevent="topic.removeSkill(index)">
                                        Remove this skill
                                    </x-splade-button>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </topic>
    </x-splade-form>
</x-layouts.app>
