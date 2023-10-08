<div class="w-full overflow-x-auto">
    <x-splade-table :for="$users" class="whitespace-nowrap">
        @cell('name', $user)
            <span
                class="{{ $user->is_admin ? 'bg-yellow-400 text-slate-800 px-2 font-semibold font-mono text-md' : '' }}">{{ $user->name }}</span>
        @endcell
        @cell('blocked', $user)
            <x-splade-form submit-on-change :action="$user->blocked ? route('profile.unblock', $user) : route('profile.block', $user)" method="post" :default="['blocked' => $user->blocked]">
                <x-splade-checkbox name="blocked" value="1" class="checked:bg-red-400" />
            </x-splade-form>
        @endcell
        @cell('action', $user)
            @php
                \Facades\Spatie\Referer\Referer::put(Request::fullURL());
            @endphp
            <x-splade-link method="delete" href="{{ route('profile.destroy', ['profile' => $user]) }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6 text-red-500 hover:text-red-600 shadow
                hover:shadow-md transition-all duration-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </x-splade-link>
        @endcell
    </x-splade-table>
</div>
