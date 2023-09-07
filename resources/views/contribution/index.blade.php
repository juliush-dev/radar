<x-layouts.app>
    <div class="relative flex flex-col gap-8 h-full bg-slate-900/60 p-8 rounded-md shadow-2xl">
        <div class="flex flex-col gap-8 h-full">
            <h1 class="text-3xl capitalize flex gap-2 items.center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-10 h-10 my-auto">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                </svg>

                Contributions dashboard
            </h1>
            <div class="grid grid-cols-2 gap-4">
                <x-layouts.contribution-dashboard-card label="skills" type="skill" :total="$contributedSkills" :published="$contributedSkillsPublished"
                    :approved="$contributedSkillsApproved" :pending="$contributedSkillsPending" />
                <x-layouts.contribution-dashboard-card label="subjects" type="subject" :total="$contributedSubjects"
                    :published="$contributedSubjectsPublished" :approved="$contributedSubjectsApproved" :pending="$contributedSubjectsPending" />
                <x-layouts.contribution-dashboard-card label="topic" type="topic" :total="$contributedTopics" :published="$contributedTopicsPublished"
                    :approved="$contributedTopicsApproved" :pending="$contributedTopicsPending" />
                <x-layouts.contribution-dashboard-card label="learning materials" type="learning-material"
                    :total="$contributedLearningMaterials" :published="$contributedLearningMaterialsPublished" :approved="$contributedLearningMaterialsApproved" :pending="$contributedLearningMaterialsPending" />
            </div>
        </div>
    </div>
</x-layouts.app>
