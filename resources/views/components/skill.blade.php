<div
    class="bg-emerald-400 flex flex-col w-full shadow-sm rounded-3xl rounded-bl-none rounded-br-none sm:w-full md:w-1/2 lg:w-1/4 shrink-0 border border-slate-200/70 grow-0  overflow-hidden">
    <div class="p-6 text-lg text-white font-medium uppercase">
        {{ $skill->title }}
    </div>
    <div class="rounded-tr-3xl bg-white  rounded-tl-3xl flex flex-col gap-6  my-auto p-6  h-full overflow-auto">
        <div class="bg-slate-100 rounded-3xl border border-slate-200 shadow-sm">
            <x-splade-toggle>
                <h1 class="text-xl p-6" @click="toggle">Group</h1>
                <x-splade-transition show="toggled">
                    <p class="p-6 pl-8">
                        {{ $skill->group->title }}
                    </p>
                </x-splade-transition>
            </x-splade-toggle>
        </div>
        <div class="bg-slate-100 rounded-3xl border border-slate-200 shadow-sm">
            <x-splade-toggle>
                <h1 class="text-xl p-6" @click="toggle">Years</h1>
                <x-splade-transition show="toggled">
                    <ul class="p-6 pl-8 flex flex-col gap-4">
                        @foreach ($skill->years as $year)
                            <li>
                                {{ $skill->group->title }}
                            </li>
                        @endforeach
                    </ul>

                </x-splade-transition>
            </x-splade-toggle>
        </div>
        <div class="bg-slate-100 rounded-3xl border border-slate-200 shadow-sm">
            <x-splade-toggle>
                <h1 class="text-xl p-6" @click="toggle">Fields</h1>
                <x-splade-transition show="toggled">
                    @foreach ($skill->fields as $field)
                        {{ ucfirst($field->field->title) }}
                        @foreach ($field->field->years as $year)
                            <br>-{{ ucfirst($year->year) }}
                        @endforeach
                        <br>
                    @endforeach
                </x-splade-transition>
            </x-splade-toggle>
        </div>
        <div class="bg-slate-100 rounded-3xl border border-slate-200 shadow-sm">
            <x-splade-toggle>
                <h1 class="text-2xl p-6" @click="toggle">Content</h1>
                <x-splade-transition show="toggled">
                    @foreach ($skill->topics as $topic)
                        {{ ucfirst($topic->title) }}
                        <br> Subject: {{ ucfirst($topic->subject->title) }}
                        @foreach ($topic->years as $year)
                            <br>Year: {{ ucfirst($year->year) }}
                        @endforeach
                        <br> LM:{{ $topic->learningMaterials->count() }}
                    @endforeach
                </x-splade-transition>
            </x-splade-toggle>
        </div>
    </div>
</div>
