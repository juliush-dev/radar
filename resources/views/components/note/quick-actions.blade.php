@props(['note'])
<section {{ $attributes->merge(['class' => 'flex flex-col gap-4']) }}>
    <h3 class="text-lg font-medium  flex flex-nowrap gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
        </svg>
        Quick actions
    </h3>
    <ul class="flex flex-col gap-4 soft text-blue-400 dark:text-blue-400/30">
        <li>
            <Link @click.prevent slideover href="{{ route('notes.relatives', $note) }}">
            Toggle references
            </Link>
        </li>
        <li>
            <Link @click.prevent slideover href="{{ route('categories.index', $note) }}">
            Toggle Categories
            </Link>
        </li>
        <li>
            <Link @click.prevent slideover href="{{ route('categories.edit', $note) }}">
            Edit Categories
            </Link>
        </li>
        <li>
            <Link @click.prevent slideover href="{{ route('categories.create', $note) }}">
            New Category
            </Link>
        </li>
        <li>
            <Link @click.prevent slideover href="{{ route('categories.delete', $note) }}">
            Delete Categories
            </Link>
        </li>
    </ul>
</section>
