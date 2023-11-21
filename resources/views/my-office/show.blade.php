<x-layouts.app active-page="My Office"
    icon="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z">
    <my-office v-slot="myOffice" :subjects="@js(
        $myOffice->subjects()->with('subject:id,title')->get()
    )" @if (isset($myActiveSubject))
        :active-subject="@js($myActiveSubject)"
        :active-subject-topics="@js(
            $myActiveSubject->topics()->with('topic:id,title')->get()
        )"
        @endif
        @if (isset($myActiveTopic))
            :active-topic="@js($myActiveTopic)"
        @endif>
        <x-splade-data default="{explorer:true, panel: true}">
            <div class="relative h-full flex gap-0 overflow-hidden dark:text-slate-400">
                <div class="absolute left-0 z-20 lg:relative border-r border-slate-300 flex flex-col h-full overflow-hidden border-l dark:border-slate-700 bg-transparent"
                    v-bind:class="data.explorer && 'backdrop-blur'">
                    <x-splade-transition show="data.explorer" animation="slide-left" leave="duration-300">
                        <div
                            class="shadow flex items-center justify-between sticky top-0 p-8 py-4 border-r border-y border-fuchsia-400 shadow-fuchsia-400 bg-white dark:bg-slate-800  border-t ">
                            <h1 class="text-lg ">
                                Explorer
                            </h1>
                            <button class="lg:hidden" @click="data.explorer = false">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 19.5L8.25 12l7.5-7.5" />
                                </svg>
                            </button>
                        </div>
                        <div class="w-96 h-screen pb-52 lg:pb-32 overflow-hidden overflow-y-auto" @preserveScroll('explorer')>
                            <template v-for="(mySubject, index) in myOffice.mySubjects">
                                <template v-if="myOffice.activeSubject && myOffice.activeSubject.id == mySubject.id">
                                    <x-splade-form v-bind:action="`/my-office/${mySubject.my_office_id}`"
                                        method="get">
                                        <button
                                            class="transition-all duration-300 font-medium bg-blue-400 hover:bg-blue-500 text-white dark:bg-slate-950 dark:hover:bg-sky-950 dark:text-slate-100 px-8 py-4 w-full text-left border-b border-slate-300 dark:border-slate-700">
                                            @{{ mySubject.subject.title }}
                                        </button>
                                    </x-splade-form>
                                    <div class="flex flex-col">
                                        <template v-for="(myTopic, index) in myOffice.myTopics">
                                            <template
                                                v-if="myOffice.activeTopic && myOffice.activeTopic.id == myTopic.id">
                                                <x-splade-form
                                                    v-bind:action="`/my-office/subjects/${myOffice.activeSubject.id}`"
                                                    method="get">
                                                    <button
                                                        class="ml-8 transition-all duration-300 bg-sky-400 hover:bg-sky-500 text-white dark:bg-slate-950 dark:hover:bg-blue-950 dark:text-slate-100 pl-4 pr-8 py-4 w-full text-left border-b border-l border-slate-300 dark:border-slate-700">
                                                        @{{ myTopic.topic.title }}
                                                    </button>
                                                </x-splade-form>
                                            </template>
                                            <template v-else>
                                                <x-splade-form v-bind:action="`/my-office/topics/${myTopic.id}`"
                                                    method="get">
                                                    <button
                                                        class="font-medium ml-8 transition-all duration-300 bg-slate-200 hover:bg-slate-300 text-slate-900 dark:bg-slate-800 dark:hover:bg-slate-900 dark:text-slate-100 pl-4 pr-8 py-4 w-full text-left border-b border-l border-slate-300 dark:border-slate-700">
                                                        @{{ myTopic.topic.title }}
                                                    </button>
                                                </x-splade-form>
                                            </template>
                                            @if (Route::is('my-office.subjects.show'))
                                                <x-splade-form :action="route('my-office.topics.reorder', $myOffice)" default="{newOrder: null}"
                                                    submit-on-change="newOrder"
                                                    class="flex items-center gap-6 bg-inherit w-fit whitespace-nowrap overflow-hidden p-2 ml-6 text-sm mb-3 font-normal">
                                                    <x-utils.reorder-trigger showCancel="myOffice.reordering"
                                                        onCancel="myOffice.toggleReorder(index)"
                                                        showReference="myOffice.reordering && myOffice.reorder.index != index && myOffice.reorder.position != null"
                                                        onReference="myOffice.setReorderingReference(index); form.newOrder = myOffice.myTopics;"
                                                        position="myOffice.reorder.position"
                                                        showReorderPosition="myOffice.reorder.position == null"
                                                        onReorderBefore="myOffice.setReorderingBefore(index, true)"
                                                        onReorderAfter="myOffice.setReorderingAfter(index, true)" />
                                                </x-splade-form>
                                            @endif
                                        </template>
                                    </div>
                                </template>
                                <template v-else>
                                    <x-splade-form v-bind:action="`/my-office/subjects/${mySubject.id}`" method="get">
                                        <button
                                            class="font-medium transition-all duration-300 bg-slate-200 hover:bg-slate-300 text-slate-800 dark:bg-slate-600 dark:hover:bg-slate-700 dark:text-slate-100 px-8 py-4 w-full text-left border-b border-slate-300 dark:border-slate-700">
                                            @{{ mySubject.subject.title }}
                                        </button>
                                    </x-splade-form>
                                </template>
                                @if (Route::is('my-office.show'))
                                    <x-splade-form :action="route('my-office.subjects.reorder', $myOffice)" default="{newOrder: null}"
                                        submit-on-change="newOrder"
                                        class="flex items-center gap-6 bg-inherit w-fit whitespace-nowrap  overflow-hidden p-2 text-sm mb-3 font-normal">
                                        <x-utils.reorder-trigger showCancel="myOffice.reordering"
                                            onCancel="myOffice.toggleReorder(index)"
                                            showReference="myOffice.reordering && myOffice.reorder.index != index && myOffice.reorder.position != null"
                                            onReference="myOffice.setReorderingReference(index); form.newOrder = myOffice.mySubjects;"
                                            position="myOffice.reorder.position"
                                            showReorderPosition="myOffice.reorder.position == null"
                                            onReorderBefore="myOffice.setReorderingBefore(index)"
                                            onReorderAfter="myOffice.setReorderingAfter(index)" />
                                    </x-splade-form>
                                @endif
                            </template>
                        </div>
                    </x-splade-transition>
                </div>
                <div class="h-full grow overflow-hidden pb-20" @preserveScroll('checkpoint')>
                    <div
                        class="flex items-center whitespace-nowrap gap-6 justify-between px-10 py-4 sticky top-0 shadow shadow-fuchsia-400 bg-white dark:bg-slate-800">
                        <button @click="data.explorer = !data.explorer">
                            <svg v-show="!data.explorer" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
                            </svg>
                            <svg v-show="data.explorer" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                        </button>
                        <h1 class="text-xl w-52 md:w-72 lg:w-fit overflow-hidden text-ellipsis">
                            @if (isset($myActiveTopic))
                                {{ $myActiveSubject->subject->title }}
                                /
                                {{ $myActiveTopic->topic->title }}
                            @else
                                Navigate to subjec > topic in the explorer
                            @endif
                        </h1>
                        <button @click="data.panel = !data.panel">
                            <svg v-show="!data.panel" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6 13.5V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 9.75V10.5" />
                            </svg>
                            <svg v-show="data.panel" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                    </div>
                    <div class="h-full overflow-hidden overflow-y-auto pt-8">
                        @if (isset($myActiveTopic))
                            @php
                                $checkpoints = $myActiveTopic->topic->publicCheckpoints()->get();
                                $checkpointsCount = $checkpoints->count();
                            @endphp
                            <div
                                @if ($checkpointsCount > 0) class="grid grid-cols-1 lg:grid-cols-2 w-full gap-6 px-6 mb-2"
                        v-bind:class="(!data.explorer || !data.panel)&& 'lg:grid-cols-3'"
                        @else
                        class="flex grow justify-center items-center h-full" @endif>
                                @forelse ($checkpoints as $checkpoint)
                                    <x-checkpoint :$checkpoint />
                                @empty
                                    <p class="text-xl text-slate-400">No checkpoints to exercise</p>
                                @endforelse
                            </div>
                        @else
                            <div class="h-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="absolute right-0 z-20 lg:relative flex flex-col h-full border-l border-slate-300 dark:border-slate-700 bg-transparent"
                    v-bind:class="data.panel && 'backdrop-blur'">
                    <x-splade-transition show="data.panel" animation="slide-right" leave="duration-300">
                        <div
                            class="w-full shadow flex items-center justify-between sticky top-0 p-8 py-4 border-l border-y border-fuchsia-400 shadow-fuchsia-400 bg-white dark:bg-slate-800">
                            <h1 class="text-lg">
                                @if (!isset($myActiveSubject))
                                    Available Subjects
                                @else
                                    Available Topics
                                @endif
                            </h1>
                            <button class="lg:hidden" @click="data.panel = false">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </button>
                        </div>
                        <div class="w-96 h-screen pb-52 lg:pb-32 overflow-hidden overflow-y-auto" @preserveScroll('panel')>
                            @if (!isset($myActiveSubject))
                                @foreach (\App\Models\Subject::all() as $subject)
                                    @if ($mySubject = $myOffice->subjects()->where('subject_id', $subject->id)->first())
                                        <x-splade-form :action="route('my-office.subjects.remove', ['subject' => $mySubject])" method="post">
                                            <button
                                                class="shadow transition-all duration-300 bg-green-400 hover:bg-green-500 text-white px-8 py-4 w-full text-left border-b border-slate-300 dark:border-slate-400/50">
                                                {{ $subject->title }} <br><span
                                                    class="font-medium mt-2 text-xs w-fit px-2 inline-flex items-center justify-center rounded-md border-2 border-slate-100">
                                                    {{ $subject->topics()->count() }} T</span>
                                            </button>
                                        </x-splade-form>
                                    @else
                                        <x-splade-form :action="route('my-office.subjects.add', [
                                            'office' => $myOffice,
                                            'subject' => $subject,
                                        ])" method="post">
                                            <button
                                                class="transition-all duration-300 bg-slate-200 hover:bg-slate-300 text-slate-800 dark:bg-slate-600 dark:hover:bg-slate-700 dark:text-white px-8 py-4 w-full text-left border-b border-slate-300 dark:border-slate-500">
                                                {{ $subject->title }} <br><span
                                                    class="font-medium mt-2 text-xs w-fit px-2 inline-flex items-center justify-center rounded-md border-2 border-slate-100">
                                                    {{ $subject->topics()->count() }} T</span>
                                            </button>
                                        </x-splade-form>
                                    @endif
                                @endforeach
                            @endif
                            @if (isset($myActiveSubject))
                                @foreach ($myActiveSubject->subject->publicTopics()->get() as $topic)
                                    @if ($myTopic = $myActiveSubject->topics()->where('topic_id', $topic->id)->first())
                                        <x-splade-form :action="route('my-office.topics.remove', ['topic' => $myTopic])" method="post">
                                            <button
                                                class="transition-all duration-300 bg-green-400 hover:bg-green-500 text-white px-8 py-4 w-full text-left border-b border-slate-300 dark:border-slate-400/50">
                                                {{ $topic->title }} <br><span
                                                    class="font-medium mt-2 text-xs w-fit px-2 inline-flex items-center justify-center rounded-md border-2 border-slate-100">
                                                    {{ $topic->checkpoints()->count() }} C</span>
                                            </button>
                                        </x-splade-form>
                                    @else
                                        <x-splade-form :action="route('my-office.topics.add', [
                                            'subject' => $myActiveSubject,
                                            'topic' => $topic,
                                        ])" method="post">
                                            <button
                                                class="transition-all duration-300 bg-slate-200 hover:bg-slate-300 text-slate-800 dark:bg-slate-600 dark:hover:bg-slate-700 dark:text-white px-8 py-4 w-full text-left border-b border-slate-300 dark:border-slate-500">
                                                {{ $topic->title }} <br><span
                                                    class="font-medium mt-2 text-xs w-fit px-2 inline-flex items-center justify-center rounded-md border-2 border-slate-400">
                                                    {{ $topic->checkpoints()->count() }} C</span>
                                            </button>
                                        </x-splade-form>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </x-splade-transition>
                </div>
            </div>
        </x-splade-data>
    </my-office>
</x-layouts.app>
