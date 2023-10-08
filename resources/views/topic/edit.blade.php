<x-layouts.app active-page="Edit Topic"
    icon="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10">
    <div class="relative h-full overflow-y-auto px-6 lg:px-80 md:px-60 pb-6">
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
            'routeOnSuccess' => $routeOnSuccess,
        ]">
            <x-forms.topic :$rq action-label="Save changes" :route-on-cancel="$routeOnCancel" />
        </x-splade-form>
    </div>
</x-layouts.app>
