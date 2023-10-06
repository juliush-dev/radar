<x-layouts.app active-page="Edit Topic"
    icon="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10">
    <div class="relative h-full overflow-y-auto px-6 lg:px-80 md:px-60 pb-6">
        @php($years = $rq->years())
        @php($fields = $rq->fields())
        @php($subjects = $rq->subjects())
        @php($skills = $rq->skills())
        <x-splade-form :action="route('topics.update', $topic)" method="patch" :default="[
            'title' => $topic->title,
            'years' => $topic->years->pluck('year'),
            'subject' => $topic->subject->id,
            'fields' => $topic->fields->pluck('field_id'),
            'skills' => $topic->skills->pluck('skill_id'),
            'documents' => $topic->learningMaterials->map(function ($lm) {
                return ProtoneMedia\Splade\FileUploads\ExistingFile::fromDisk('public')->get($lm->alternative);
            }),
            'newSubject' => null,
            'learningMaterials' => [],
        ]">
            <topic v-slot="topic" :form="form">
                <div class="sticky top-0 z-10 flex gap-0 bg-white w-full flex-wrap shadow mb-4 pt-4">
                    <button class="px-6 py-4 cursor-pointer"
                        v-bind:class=" topic.activeTab == 'topic'? 'bg-pink-500 text-white' : 'text-slate-50 bg-slate-950'"
                        @click.prevent="topic.setActiveTab('topic')">Topic</button>
                    <button v-show="form.newSubject != null" class="px-6 py-4 cursor-pointer"
                        v-bind:class=" topic.activeTab == 'subject'? ' bg-pink-500 text-white' : 'text-slate-50 bg-slate-950'"
                        @click.prevent="topic.setActiveTab('subject')">New Subject</button>
                </div>
                <section v-show="topic.activeTab == 'topic'" class="w-full flex flex-col bg-white p-8">
                    <x-splade-input required name="title" label="Title" class="mb-6" />
                    <x-splade-select required name="years" label="Years" :options="$years" option-value="id"
                        option-label="title" placeholder="Choose or" class="mb-6" multiple />
                    <div class="flex flex-col gap-4">
                        <x-splade-select required v-if="form.newSubject == null" name="subject" label="Subject"
                            :options="$subjects" option-value="id" option-label="title" placeholder="Choose or" />
                        <x-splade-button v-if="form.newSubject == null" type="call-to-action"
                            @click.prevent="topic.newSubject"
                            class="w-fit ml-auto bg-amber-500 hover:bg-amber-600 text-white">
                            Add new Subject
                        </x-splade-button>
                        <p v-if="form.newSubject != null"
                            class="p-4 mb-6 border border-slate-50  bg-sky-200 flex gap-2 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                            New subject added
                        </p>
                    </div>
                    <x-splade-select name="fields" label="Fields" :options="$fields" option-value="id"
                        option-label="title" placeholder="Choose or" multiple class="mb-4" />
                    <x-splade-select name="skills" label="Skill" :options="$skills" option-value="id"
                        option-label="title" placeholder="Choose or" multiple class="mb-4" />
                    <x-splade-file label="Learning materials" name="documents[]" filepond preview multiple />
                    <div class="flex justify-between my-6 gap-6">
                        <x-splade-submit class="bg-fuchsia-500 hover:bg-fuchsia-600 shadow-md" :label="__('Save')" />
                        <Link href="{{ route('topics.show', $topic) }}"
                            class=" whitespace-nowrap flex items-center justify-center w-fit px-4 rounded-none text-white bg-slate-400 shadow hover:bg-slate-500 hover:shadow-md align-middle">
                        Cancel changes
                        </Link>
                    </div>
                </section>
                <section v-show="topic.activeTab == 'subject'" class="w-full flex flex-col bg-white p-8">
                    <div class="flex flex-col gap-6">
                        <div v-if="form.newSubject != null" class="flex flex-col gap-6 ">
                            <x-splade-input v-model="form.newSubject.title" label="title" />
                            <x-splade-input v-model="form.newSubject.abbreviation" label="Abbreviation" />
                            <x-splade-select v-model="form.newSubject.years" :options="$years" option-value="id"
                                option-label="title" label="Years" />
                        </div>
                        <x-splade-button v-if="form.newSubject != null" type="call-to-action"
                            @click.prevent="topic.removeNewSubject"
                            class="w-fit ml-auto mb-4 bg-pink-500 hover:bg-pink-600 text-white">
                            Remove this Subject
                        </x-splade-button>
                    </div>
                </section>
            </topic>
        </x-splade-form>
    </div>
</x-layouts.app>
