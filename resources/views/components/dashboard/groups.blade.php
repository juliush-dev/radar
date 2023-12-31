<x-splade-table :for="$groups">
    @cell('action', $group)
        <x-splade-link modal :href="route('skills.groups.edit', $group)" class="mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-5 h-5 text-violet-400 hover:text-violet-500 transition-all duration-300">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
        </x-splade-link>

        <Link method="delete" href="{{ route('skills.groups.remove', $group) }}" confirm-danger="Delete requested"
            confirm-text="This group will be permanently deleted" confirm-button="Yes, delete this group permanently"
            cancel-button="No don't delete" class="ml-auto text-red-500 hover:text-red-600 transition-all duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
        </Link>
    @endcell
</x-splade-table>
