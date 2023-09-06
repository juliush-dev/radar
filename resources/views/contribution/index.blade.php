<x-layouts.app>
    <div class="relative flex flex-col gap-8 h-full bg-slate-900/60 p-8 rounded-md shadow-2xl">
        <div class="flex flex-col gap-8 h-full">
            <h1 class="text-3xl capitalize">Contributions dashboard</h1>
            <div class="grid grid-cols-2 gap-4">
                <x-layouts.contribution-dashboard-card label="skills" type="skill" :total="$contributedSkills" :published="$contributedSkillsPublished"
                    :private="$contributedSkillsPrivate" :approved="$contributedSkillsApproved" :pending="$contributedSkillsPending" />
                <x-layouts.contribution-dashboard-card label="teachers" type="teacher" :total="$contributedTeachers" :published="$contributedTeachersPublished"
                    :private="$contributedTeachersPrivate" :approved="$contributedTeachersApproved" :pending="$contributedTeachersPending" />
                <x-layouts.contribution-dashboard-card label="subjects" type="subject" :total="$contributedSubjects"
                    :published="$contributedSubjectsPublished" :private="$contributedSubjectsPrivate" :approved="$contributedSubjectsApproved" :pending="$contributedSubjectsPending" />
                <x-layouts.contribution-dashboard-card label="knowledge" type="knowledge" :total="$contributedKnowledge"
                    :published="$contributedKnowledgePublished" :private="$contributedKnowledgePrivate" :approved="$contributedKnowledgeApproved" :pending="$contributedKnowledgePending" />
                <x-layouts.contribution-dashboard-card label="learning materials" type="learning-material"
                    :total="$contributedLearningMaterials" :published="$contributedLearningMaterialsPublished" :private="$contributedLearningMaterialsPrivate" :approved="$contributedLearningMaterialsApproved" :pending="$contributedLearningMaterialsPending" />
            </div>
        </div>
    </div>
</x-layouts.app>
