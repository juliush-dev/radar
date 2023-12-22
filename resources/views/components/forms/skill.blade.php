  @php($years = $rq->years())
  @php($fields = $rq->fields())
  @php($groups = $rq->groups())
  @php($types = $rq->types())
  <skill v-slot="skill" :form="form">
      <div
          class="sticky right-0 overflow-x-auto top-0 z-10 flex bg-inherit backdrop-blur gap-0 w-full flex-wrap shadow mb-4">
          <button class="px-6 py-4 cursor-pointer w-full md:w-fit"
              v-bind:class=" skill.activeTab == 'skill' ? ' bg-pink-500 text-white' : 'text-slate-50 bg-slate-700' "
              @click.prevent="skill.setActiveTab('skill')">skill</button>
          <div class="flex justify-start md:ml-auto w-full md:w-fit order-first md:order-last">
              <x-splade-submit
                  class="bg-fuchsia-500 h-full w-full md:w-32 hover:bg-fuchsia-600 shadow-md whitespace-nowrap"
                  :label="$actionLabel" />
              <Link href="{{ Referer::get() }}"
                  class=" whitespace-nowrap flex items-center justify-center w-full md:w-fit px-4 rounded-none text-white bg-slate-400 shadow hover:bg-slate-500 hover:shadow-md align-middle">
              Cancel
              </Link>
          </div>
      </div>
      <section v-show="skill.activeTab == 'skill'"
          class="w-full flex flex-col bg-inherit border border-slate-200 dark:border-slate-700 p-8">
          <x-splade-textarea required name="title" label="Title" class="mb-6" />
          <div class="flex flex-col gap-4 mb-4">
              <x-splade-select name="type" label="Select a type" :options="$types" option-value="id"
                  option-label="title" placeholder="Choose or" />
              <x-splade-textarea name="newType" label="Or create a new type" />
          </div>
          <div class="flex flex-col gap-4 mb-4">
              <x-splade-select name="group" label="Select a group" :options="$groups" option-value="id"
                  option-label="title" placeholder="Choose or" />
              <x-splade-textarea name="newGroup" label="Or create a new group" />
          </div>
          <x-splade-select required name="years" label="Years" :options="$years" option-value="id"
              option-label="title" placeholder="Choose or" class="mb-6" multiple />
          <x-splade-select name="fields" label="Fields" :options="$fields" option-value="id" option-label="code"
              placeholder="Choose or" multiple />
      </section>
  </skill>
