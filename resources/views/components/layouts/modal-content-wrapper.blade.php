@props(['applyBasicClassesOnly' => false])
<div
    {{ $attributes->merge(['class' => 'text-slate-800 dark:text-slate-100 shadow dark:shadow-slate-900'])->class(['bg-slate-100/80 dark:bg-slate-800/80 min-h-screen w-full' => !$applyBasicClassesOnly]) }}>
    {{ $slot }}
</div>
