<div class="flex flex-col  shrink-0 gap-6 border border-slate-300 grow p-6">
    {{ $skill->title }}
    <br>
    {{ $skill->group->title }}
    <br><br>
    @foreach ($skill->years as $year)
        {{ ucfirst($year->year) }}
        <br>
    @endforeach
    <br><br>
    @foreach ($skill->fields as $field)
        {{ ucfirst($field->field->title) }}
        @foreach ($field->field->years as $year)
            <br>-{{ ucfirst($year->year) }}
        @endforeach
        <br>
    @endforeach

    <br><br>
    @foreach ($skill->topics as $topic)
        {{ ucfirst($topic->title) }}
        <br> Subject: {{ ucfirst($topic->subject->title) }}
        @foreach ($topic->years as $year)
            <br>Year: {{ ucfirst($year->year) }}
        @endforeach
        <br> LM:{{ $topic->learningMaterials->count() }}
    @endforeach
</div>
