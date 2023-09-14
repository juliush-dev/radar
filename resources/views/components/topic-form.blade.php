 <x-splade-form :action="$action" {{ $attributes->class('flex flex-col gap-6 shadow-md') }}>
     <x-splade-input name="title" label="Topic" />
     <x-splade-select name="years_teached_at" :options="$yearsOptions" label="Year" />
     <x-splade-select name="topic_field" :options="$fieldsOptions" label="Field" />
     <x-splade-select name="subject" label="subject" option-label="title" option-value="id" :options="$subjectsOptions" />
     <div class="flex justify-end">
         <x-splade-submit>Submit it</x-splade-submit>
     </div>
 </x-splade-form>
