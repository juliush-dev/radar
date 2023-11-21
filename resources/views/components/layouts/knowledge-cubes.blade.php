@props(['requireBigPadding' => true])
<div
    class="@if ($requireBigPadding)  @endif w-full overflow-hidden rounded-r-[6rem] md:rounded-r-full border-r dark:border-slate-500/0">
    <div
        class="tunnel flex flex-nowrap overflow-y-hidden overflow-x-auto @if ($requireBigPadding) px-72 pl-8 md:px-[500px] gap-32  py-10 @else px-8 gap-10  py-8 @endif w-full  bg-gradient-to-r from-white via-20% via-slate-200 to-slate-300  dark:from-slate-800 dark:via-30% dark:via-slate-700 dark:bg-slate-800">
        {{ $slot }}
    </div>
</div>
