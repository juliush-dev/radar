<x-splade-form method="get" preserve-scroll submit-on-change="reset" :default="[
    'year' => request()->query('year'),
]"
    class="w-full z-20 flex flex-col gap-4 grow px-6 lg:px-10 my-4 flex-wrap">
    <x-splade-toggle class="w-full">

        <div class="flex gap-6 md:justify-end flex-wrap items-center overflow-x-auto">
            {{-- <div class="whitespace-nowrap items-center lg:my-8 md:grow dark:text-sky-500">
                {{ $slot }}
            </div> --}}
            @can('create-field')
                <Link title="Create New field" href="{{ Auth::check() ? route('fields.create') : '#login-required' }}"
                    class="text-pink-500 hover:text-pink-600 whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                </Link>
            @endcan
            <button @click.prevent="toggle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 text-pink-500 group-hover:text-pink-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        v-bind:d="toggled ? 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z' : 'M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z'" />
                </svg>
            </button>
            <button title="reset filter" v-show="form.year ||toggled" @click="form.reset=true;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 text-pink-500 group-hover:text-pink-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.412 15.655L9.75 21.75l3.745-4.012M9.257 13.5H3.75l2.659-2.849m2.048-2.194L14.25 2.25 12 10.5h8.25l-4.707 5.043M8.457 8.457L3 3m5.457 5.457l7.086 7.086m0 0L21 21" />
                </svg>
            </button>
        </div>
        <x-splade-transition show="toggled"
            class="w-full flex flex-wrap gap-6 mb-4 dark:bg-slate-200 dark:p-4 dark:md:p-6">
            <x-splade-select class="grow whitespace-normal" label="Where year is" placeholder="..." name="year"
                :options="$years" option-value="id" option-label="title" />
            <div class="flex gap-6 w-full">
                <x-splade-submit label="Filter" class="bg-fuchsia-500 hover:bg-fuchsia-600 text-white grow" />
                <button class="bg-slate-500 hover:bg-slate-600 text-white grow px-6"
                    @click.prevent="toggle">Cancel</button>
            </div>
        </x-splade-transition>
    </x-splade-toggle>
</x-splade-form>
