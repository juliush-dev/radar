  @php($years = $rq->years())
  @php($fields = $rq->fields())
  @php($groups = $rq->groups())
  <skill v-slot="skill" :form="form">
      <div class="sticky right-0 overflow-x-auto top-0 z-10 flex bg-white gap-0 w-full flex-wrap shadow mb-4">
          <button class="px-6 py-4 cursor-pointer"
              v-bind:class=" skill.activeTab == 'skill' ? ' bg-pink-500 text-white' : 'text-slate-50 bg-slate-800' "
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
              <x-splade-submit class="bg-fuchsia-500 hover:bg-fuchsia-600 shadow-md" :label="$actionLabel" />
              <Link href="{{ $routeOnCancel }}"
                  class=" whitespace-nowrap flex items-center justify-center w-fit px-4 rounded-none text-white bg-slate-400 shadow hover:bg-slate-500 hover:shadow-md align-middle">
              Cancel
              </Link>
          </div>
      </section>
  </skill>
