<x-layouts.app>
    <div class="h-full bg-slate-900/60 p-8 rounded-md shadow-2xl">

        @if ($skills->count() > 0)
            @foreach ($skills as $skill)
                {{ $skill->contribution->title }} <br>
                {{ $skill->fields_covered_by_it }} <br>
                {{ $skill->years_levels_covering_it }} <br>
                {{ $skill->topic_group_covering_it }} <br>
            @endforeach
        @else
            <div class="h-full flex flex-col items.center justify-center gap-8">
                <p class="text-xl text-slate-400 text-center">
                    Look like an empty board? 😳
                </p>
                <div class="text-center">
                    <x-nav-link :href="route('contribution.index')" type="call-to-action">
                        Submit a new information
                    </x-nav-link>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
