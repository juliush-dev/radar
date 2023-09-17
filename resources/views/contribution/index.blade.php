<x-layouts.app>
    <x-layouts.contributions type="contribution" label="Contributions"
        action-icon="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z">
        <div class="flex flex-col gap-6 h-full overflow-hidden">
            <div class="flex gap-6">
                <x-contribution-dashboard-card label="skill(s)" type="skills" :total="$contributedSkills" :published="$contributedSkillsPublished"
                    :approved="$contributedSkillsApproved" :pending="$contributedSkillsPending" />
                <x-contribution-dashboard-card label="subject(s)" type="subjects" :total="$contributedSubjects" :published="$contributedSubjectsPublished"
                    :approved="$contributedSubjectsApproved" :pending="$contributedSubjectsPending" />
                <x-contribution-dashboard-card label="topic(s)" type="topics" :total="$contributedTopics" :published="$contributedTopicsPublished"
                    :approved="$contributedTopicsApproved" :pending="$contributedTopicsPending" />
                <x-contribution-dashboard-card label="learning material(s)" type="learning-materials" :total="$contributedLearningMaterials"
                    :published="$contributedLearningMaterialsPublished" :approved="$contributedLearningMaterialsApproved" :pending="$contributedLearningMaterialsPending" />
            </div>
            <div class="f-full overflow-y-auto px-4 pb-4 relative" @preserveScroll('contributions-index')>
                <x-splade-table :for="$contributions" pagination-scroll="head">
                    <x-slot:empty-state>
                        <p class="p-6">No Contributions found!</p>
                    </x-slot>
                </x-splade-table>
            </div>
        </div>
    </x-layouts.contributions>
</x-layouts.app>
