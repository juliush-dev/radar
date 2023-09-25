<x-layouts.app active-page="New Topic"
    icon="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z">
    @php($years = $rq->years())
    @php($fields = $rq->fields())
    @php($subjects = $rq->subjects())
    @php($skills = $rq->skills())
    <x-splade-form :action="route('topics.store')" class="overflow-auto p-6 absolute top-0 left-0 right-0 bottom-0.5 pb-20"
        :default="[
            'title' => $topic->title,
            'years' => $topic->years,
            'subject' => $topic->subject,
            'fields' => $topic->fields,
            'skills' => $topic->skills,
            'newSubject' => null,
            'newFields' => [],
            'newSkills' => [],
            'learningMaterials' => [],
        ]">
        <topic v-slot="topic" :form="form">
            <div class="flex gap-6">
                <section class="relative mx-auto pt-6 w-1/2 flex flex-col">
                    <h1 class="text-2xl my-4">New Topic</h1>
                    <div class="flex flex-col gap-6 mb-4">
                        <x-splade-textarea name="title" label="Title" />
                        <x-splade-select name="years" label="Year" :options="$years" option-value="id"
                            option-label="title" placeholder="Choose one" multiple />
                        <div class="flex flex-col gap-2">
                            <x-splade-select v-if="form.newSubject == null" name="subject" label="Subject"
                                :options="$subjects" option-value="id" option-label="title" placeholder="Choose or" />
                            <x-splade-button v-if="form.newSubject == null" type="call-to-action"
                                @click.prevent="topic.newSubject"
                                class="w-fit ml-auto bg-amber-500 hover:bg-amber-600 text-white">
                                Add new Subject
                            </x-splade-button>
                            <p v-if="form.newSubject != null"
                                class="p-4 border border-slate-50 rounded-md bg-sky-200 flex gap-2 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                New subject added
                            </p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <x-splade-select name="fields" label="Fields" :options="$fields" option-value="id"
                                option-label="title" placeholder="Choose or" multiple />
                            <p v-if="form.newFields.length > 0"
                                class="border border-slate-50 rounded-md bg-sky-200 p-4 flex gap-2 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>

                                <span>
                                    (@{{ form.newFields.length }})
                                    fields added
                                </span>
                            </p>
                            <x-splade-button class="w-fit ml-auto bg-amber-500 hover:bg-amber-600 text-white"
                                type="call-to-action" @click.prevent="topic.newField">
                                @{{ form.newFields.length == 0 ? 'Add a new Field' : 'Add another field' }}
                            </x-splade-button>
                        </div>
                        <div class="flex flex-col gap-2">
                            <x-splade-select name="skills" label="Skill" :options="$skills" option-value="id"
                                option-label="title" placeholder="Choose or" multiple />
                            <p v-if="form.newSkills.length > 0"
                                class="border border-slate-50 rounded-md bg-sky-200 p-4 flex gap-2 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                <span>
                                    (@{{ form.newSkills.length }}) skills added
                                </span>
                            </p>
                            <x-splade-button class="w-fit ml-auto bg-amber-500 hover:bg-amber-600 text-white"
                                type="call-to-action" @click.prevent="topic.newSkill">
                                @{{ form.newSkills.length == 0 ? 'Add new skill' : 'Add another skill' }}
                            </x-splade-button>
                        </div>
                        <x-splade-file label="Learning materials" name="documents[]" filepond preview multiple />
                    </div>
                    <div class="flex justify-between">
                        <x-splade-button type="call-to-action"
                            class="w-fit text-center text-white bg-cyan-500 hover:bg-cyan-600">
                            Save changes
                        </x-splade-button>
                        <Link href="{{ route('topics.index') }}"
                            class=" flex items-center justify-center w-fit px-4 rounded-md text-white bg-pink-500 align-middle">
                        Cancel changes
                        </Link>
                    </div>
                </section>
                <div v-if="topic.activeTab != null" class="flex h-full overflow-hidden flex-col gap-4 w-1/2">
                    <div class="flex gap-0 w-full px-6">
                        <button v-show="form.newSubject != null" class="px-4 py-2 text-slate-500 cursor-pointer"
                            v-bind:class=" topic.activeTab == 'subject' && 'bg-slate-200 text-slate-900' "
                            @click.prevent="topic.setActiveTab('subject')">New Subject</button>
                        <button v-show="form.newFields.length > 0" class="px-4 py-2 text-slate-500 cursor-pointer"
                            v-bind:class=" topic.activeTab == 'fields' && 'bg-slate-200 text-slate-900' "
                            @click.prevent="topic.setActiveTab('fields')">New Fields (@{{ form.newFields.length }}) </button>
                        <button v-show="form.newSkills.length > 0" class="px-4 py-2 text-slate-500 cursor-pointer"
                            v-bind:class=" topic.activeTab == 'skills' && 'bg-slate-200 text-slate-900' "
                            @click.prevent="topic.setActiveTab('skills')">New Skills (@{{ form.newSkills.length }})</button>
                    </div>
                    <div class="flex flex-col w-full h-full">
                        <section v-show="topic.activeTab == 'subject'"
                            class="relative px-6 pb-2 w-full h-full  flex flex-col">
                            <div class="h-full overflow-y-auto flex flex-col gap-6 pb-4">
                                <div v-if="form.newSubject != null" class="flex flex-col gap-6 ">
                                    <x-splade-input v-model="form.newSubject.title" label="title" />
                                    <x-splade-input v-model="form.newSubject.abbreviation" label="Abbreviation" />
                                    <x-splade-select v-model="form.newSubject.years" :options="$years"
                                        option-value="id" option-label="title" label="Years" />
                                </div>
                                <x-splade-button v-if="form.newSubject != null" type="call-to-action"
                                    @click.prevent="topic.removeNewSubject"
                                    class="w-fit mb-4 ml-auto bg-pink-500 hover:bg-pink-600 text-white">
                                    Remove this Subject
                                </x-splade-button>
                            </div>
                        </section>
                        <section v-show="topic.activeTab == 'fields'"
                            class="relative px-6 pb-20 w-full h-full  flex flex-col">
                            <x-splade-button v-if="form.newFields.length > 0" type="call-to-action"
                                @click.prevent="topic.removeField"
                                class="w-fit mb-4 bg-pink-500 hover:bg-pink-600 text-white">
                                Remove all new fields
                            </x-splade-button>
                            <div class="relative h-full overflow-y-auto flex flex-col gap-6 pb-2 pr-6">
                                <div v-for="(field, index) in form.newFields" class="flex flex-col gap-6"
                                    v-bind:key="index">
                                    <x-splade-input v-model="field.title" label="title" />
                                    <x-splade-input v-model="field.code" label="code" />
                                    <x-splade-select v-model="field.years" :options="$years" option-value="id"
                                        option-label="title" label="Years" multiple />
                                    <x-splade-button class="w-fit ml-auto bg-pink-500 hover:bg-pink-600 text-white"
                                        type="call-to-action" @click.prevent="topic.removeField(index)">
                                        Remove this Field
                                    </x-splade-button>
                                </div>
                            </div>
                        </section>
                        <section v-show="topic.activeTab == 'skills'"
                            class="relative px-6 pb-20 w-full h-full flex flex-col">
                            <x-splade-button v-if="form.newSkills.length > 0" type="call-to-action"
                                @click.prevent="topic.removeSkill"
                                class="w-fit mb-4 bg-pink-500 hover:bg-pink-600 text-white">
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
                                    <x-splade-button class="w-fit ml-auto bg-pink-500 hover:bg-pink-600 text-white"
                                        type="call-to-action" @click.prevent="topic.removeSkill(index)">
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
