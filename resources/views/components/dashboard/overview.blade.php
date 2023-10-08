<div class="dark:text-slate-100">
    <section>
        <h1 class="text-3xl mb-5">Numbers</h1>
        <div class="flex flex-wrap gap-6 justify-evenly">
            <Link href="{{ route('dashboard.index', ['tab' => 'users']) }}"
                class="border grow shadow-md hover:shadow-lg focus:shadow-sm dark:shadow-cyan-400 transition-all duration-300 p-6 dark:border-cyan-400">
            <h1 class="mb-2 text-xl first-letter:uppercase">Users</h1>
            <span class="text-2xl">{{ $totalUsers }}</span>
            </Link>
            <Link href="{{ route('dashboard.index', ['tab' => 'topics']) }}"
                class="border grow shadow-md hover:shadow-lg focus:shadow-sm dark:shadow-cyan-400 transition-all duration-300 p-6 dark:border-cyan-400">
            <h1 class="mb-2 text-xl first-letter:uppercase">Topics</h1>
            <span class="text-2xl">{{ $totalTopics }}</span>
            </Link>
            <Link href="{{ route('dashboard.index', ['tab' => 'learning-materials']) }}"
                class="border grow shadow-md hover:shadow-lg focus:shadow-sm dark:shadow-cyan-400 transition-all duration-300 p-6 dark:border-cyan-400">
            <h1 class="mb-2 text-xl first-letter:uppercase">Learning materials</h1>
            <span class="text-2xl">{{ $totalLearningMaterials }}</span>
            </Link>
            <Link href="{{ route('skills.index') }}"
                class="border grow shadow-md hover:shadow-lg focus:shadow-sm dark:shadow-cyan-400 transition-all duration-300 p-6 dark:border-cyan-400">
            <h1 class="mb-2 text-xl first-letter:uppercase">Skills</h1>
            <span class="text-2xl">{{ $totalSkills }}</span>
            </Link>
        </div>
    </section>
</div>
