@if ($model->is_update || $model->potentialReplacement || !$model->is_public)
    <span
        class="rounded whitespace-nowrap px-2 bg-pink-600 w-fit font-mono text-sm text-white dark:text-slate-200  my-auto grow-0">Volatile
        @if ($model->is_update)
            <span class="px-2 bg-amber-300 font-mono text-slate-700 text-sm">R</span>
        @else
            <span class="px-2 bg-slate-800 font-mono text-slate-50 text-sm">U</span>
        @endif
        @if (!$model->is_public)
            <span class="px-2 bg-zinc-300 font-mono text-slate-700 text-sm">P</span>
        @endif
    </span>
@endif
