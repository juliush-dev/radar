@props(['applyBasicClassesOnly' => false])
<div
    {{ $attributes->merge(['class' => 'bg-slate-100 dark:text-slate-100/400 dark:border-slate-400/50 text-slate-600  dark:bg-slate-950/60 shadow dark:shadow-slate-900 '])->class(['bg-slate-100/80 dark:bg-slate-800/80 min-h-screen w-full' => !$applyBasicClassesOnly]) }}>
    {{ $slot }}
</div>
