@php
    $relatives = $note->relatives
        ->map(function ($relative) {
            return ['id' => $relative->id, 'title' => $relative->extractTitle()];
        })
        ->all();
@endphp
<section v-if="@js(count($relatives) > 0)">
    <ul class="flex gap-4 flex-wrap">
        @foreach ($relatives as $relative)
            <li class="w-fit px-2 border-2 border-slate-500 text-slate-500 rounded-full">
                <Link href="{{ route('topics.references', ['note' => $relative['id']]) }}" class="flex gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 my-auto">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M20.25 3.75v4.5m0-4.5h-4.5m4.5 0l-6 6m3 12c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 014.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 00-.38 1.21 12.035 12.035 0 007.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 011.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 01-2.25 2.25h-2.25z" />
                </svg>
                {{ $relative['title'] }}
                </Link>
            </li>
        @endforeach
    </ul>
</section>
