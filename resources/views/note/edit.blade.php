<x-layouts.app
    icon="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25">
    <x-slot:leftSide>
        <div class="w-full h-full border-r border-slate-400/10 flex flex-col justify-stretch">
            <x-splade-form method="get" action="{{ route('notes.modal') }}" stay background submit-on-change
                @success="main.setBottomData" class="absolute top-0 bottom-0">
                <x-note.categories inEditor="true" :$note class="h-1/2 shadow overflow-y-auto" />
                <div class="flex flex-col gap-6 h-1/2 overflow-y-auto p-6 pb-16">
                    <x-note.referers :$note />
                    <x-note.relatives :category="null" :$note />
                </div>
            </x-splade-form>
        </div>
    </x-slot>
    <note v-slot="note">
        <x-note :$note />
    </note>
    <x-slot:rightSide>
        <div class="w-full h-full border-l border-slate-400/10">
            <x-note.quick-actions :$note class="shadow p-6" />
            <x-note.last-opened :$lastOpened class="p-6 h-[66%] overflow-y-auto pb-28" />
        </div>
    </x-slot>
</x-layouts.app>
