<template>
  <div>

    <Head title="Templates" />
    <h1 class="mb-6 text-3xl font-bold">Templates</h1>

    <div class="flex flex-wrap pb-8">
      <div class="w-full md:w-1/3">
        <select-input class="col-span-4 sm:col-span-2 md:col-span-1 w-35" v-model="selectedCompany"
          @update:modelValue="onCompanyChange" search-property="name" :options="companies" label="Company"
          :error="form.errors.company_id"></select-input>
      </div>
      <div class="w-1/3 ml-0 md:ml-3">
        <button @click="saveTemplate"
          class="bg-indigo-500 hover:bg-orange-400 text-gray-50 font-bold mt-5 py-3 px-6 rounded inline-flex items-center">
          <span>Save Template</span>
        </button>
      </div>
    </div>

    <h3 class="mb-5 text-lg font-medium text-gray-900 dark:text-white">Choose template:</h3>
    <ul class="grid w-full gap-4 md:grid-cols-5">
      <li v-for="template in templates" :key="template.id">
        <input type="radio" :id="'template_' + template.id" :value="template.id" v-model="selectedTemplate"
          class="hidden peer" required="" />
        <label :for="'template_' + template.id" :class="[
          'inline-flex items-center justify-center w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700',
          { 'peer-checked': template.id === form.template_id },
        ]">
          <div class="block">
            <div class="w-full text-lg font-semibold uppercase my-1">
              {{ template.id }}
            </div>
            <div class="w-full">
              <img :src="template.photo" :alt="'Template ' + template.id" class="shadow-lg rounded-md" />
            </div>
          </div>
        </label>
      </li>
    </ul>

  </div>

</template>

<script>
import { Head } from '@inertiajs/vue3'
import Layout from '@/Layout/Layout.vue'
import SelectInput from '@/Shared/SelectInput.vue'

export default {
  components: {
    Head,
    SelectInput,
  },
  props: {
    companies: Array,
    templates: Array,
  },
  layout: Layout,
  data() {
    return {
      selectedCompany: null,
      selectedTemplate: null,
      form: this.$inertia.form({
        _method: 'put',
        id: null,
        template_id: null,
      }),
    }
  },
  watch: {
    selectedCompany(newCompany) {
      this.onCompanyChange(newCompany)
    },
  },
  methods: {
    onCompanyChange(companyId) {
      if (companyId === null || companyId === undefined || companyId === '') {
        this.selectedTemplate = null
        return
      }
      const company = this.companies.find(c => c.id === companyId)

      if (company) {
        this.selectedTemplate = company.template_id
        this.form.id = companyId
        this.form.template_id = company.template_id
      }
    },
    saveTemplate() {
      this.form.template_id = this.selectedTemplate
      this.form.post(`/templates/${this.form.id}`)
    },
  },
}
</script>