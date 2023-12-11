<x-splade-table :for="$users" class="whitespace-nowrap">
    @cell('blocked', $user)
        @if (!$user->is_admin)
            <x-splade-form submit-on-change :action="$user->blocked ? route('profile.unblock', $user) : route('profile.block', $user)" method="post" :default="['blocked' => $user->blocked]">
                <x-splade-checkbox name="blocked" value="1" class="checked:bg-red-400" />
            </x-splade-form>
        @else
            <span class="px-2 bg-yellow-500 text-slate-800 text-xs">Admin</span>
        @endif
    @endcell
    @cell('action', $user)
        <Link method="delete" href="{{ route('profile.destroy', ['profile' => $user]) }}" confirm-danger="Delete requested"
            confirm-text="This user will be permanently deleted" confirm-button="Yes, delete this user permanently"
            cancel-button="No don't delete" class="ml-auto text-red-500 hover:text-red-600 transition-all duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
        </Link>
    @endcell
</x-splade-table>
