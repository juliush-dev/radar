  @php($years = $rq->years())
  @php($fields = $rq->fields())
  @php($groups = $rq->groups())
  <skill v-slot="skill" :form="form">
      <div
          class="sticky top-0 z-10 flex gap-0 bg-white border border-slate-200 dark:border-white w-full shadow-sm mb-4 pt-4">
          <button class="px-6 py-4 cursor-pointer"
              v-bind:class=" skill.activeTab == 'skill' ? ' bg-pink-500 text-white' : 'text-slate-50 bg-slate-950' "
              @click.prevent="skill.setActiveTab('skill')">skill</button>
      </div>
      <section v-show="skill.activeTab == 'skill'"
          class="w-full flex flex-col bg-white border border-slate-200 dark:border-white p-8">
          <x-splade-textarea required name="title" label="Title" class="mb-6" />
          <div class="flex flex-col gap-4 mb-4">
              <x-splade-select name="group" label="Select a group" :options="$groups" option-value="id"
                  option-label="title" placeholder="Choose or" />
              <x-splade-textarea name="newGroup" label="Or create a new group" />
          </div>
          <x-splade-select required name="years" label="Years" :options="$years" option-value="id"
              option-label="title" placeholder="Choose or" class="mb-6" multiple />
          <x-splade-select name="fields" label="Fields" :options="$fields" option-value="id" option-label="code"
              placeholder="Choose or" multiple />
          <div class="flex justify-between my-6 gap-6">
              <x-splade-submit class="bg-fuchsia-500 hover:bg-fuchsia-600 shadow-md" :label="__('Create')" />
              <Link href="{{ route('skills.index') }}"
                  class=" whitespace-nowrap flex items-center justify-center w-fit px-4 rounded-none text-white bg-slate-400 shadow hover:bg-slate-500 hover:shadow-md align-middle">
              Cancel creation
              </Link>
          </div>
      </section>
  </skill>
