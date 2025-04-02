<template>
  <div>

    <Head title="Companies" />
    <h1 class="mb-8 text-3xl font-bold">Companies</h1>
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
        <label class="block dark:text-gray-200">Trashed:</label>
        <select v-model="form.trashed"
          class="form-select mt-1 w-full dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
          <option :value="null" disabled>Select an option</option>
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
      <Link class="btn-indigo" href="/companies/create">
      <span>Create</span>
      <span class="hidden md:inline">&nbsp;Company</span>
      </Link>
    </div>
    <div class="bg-white dark:bg-indigo-900 rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Trade Name</th>
            <th class="pb-4 pt-6 px-6">Name</th>
            <th class="pb-4 pt-6 px-6">Number Id</th>
            <th class="pb-4 pt-6 px-6">Phone</th>
            <th class="pb-4 pt-6 px-6">Email</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(company, index) in companies.data" :key="company.id"
            class="hover:bg-gray-100 dark:hover:bg-indigo-800">
            <td class="border-t dark:border-gray-600">
              <Link class="flex items-center px-6 py-4" :href="`/companies/${company.id}/edit`">
              {{ company.trade_name }}
              <icon v-if="company.deleted_at" name="trash" class="shrink-0 ml-2 w-3 h-3 fill-red-400" />
              </Link>
            </td>
            <td class="border-t dark:border-gray-600">
              <Link class="flex items-center px-6 py-4" :href="`/companies/${company.id}/edit`" tabindex="-1">
              {{ company.name }}
              </Link>
            </td>
            <td class="border-t dark:border-gray-600">
              <Link class="flex items-center px-6 py-4" :href="`/companies/${company.id}/edit`" tabindex="-1">
              {{ company.number }}
              </Link>
            </td>
            <td class="border-t dark:border-gray-600">
              <Link class="flex items-center px-6 py-4" :href="`/companies/${company.id}/edit`" tabindex="-1">
              {{ company.phone }}
              </Link>
            </td>
            <td class="border-t dark:border-gray-600">
              <Link class="flex items-center px-6 py-4" :href="`/companies/${company.id}/edit`" tabindex="-1">
              {{ company.email }}
              </Link>
            </td>
            <td class="w-px border-t dark:border-gray-600">
              <Link class="flex items-center px-4" :href="`/companies/${company.id}/edit`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
              </Link>
            </td>
          </tr>
          <tr v-if="companies.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="5">No Companies found.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination class="mt-6" :links="companies.links" />
  </div>
</template>

<script>
import SearchFilter from '@/Shared/SearchFilter.vue'
import Pagination from '@/Shared/Pagination.vue'
import { Head, Link } from '@inertiajs/vue3'
import mapValues from 'lodash/mapValues'
import Layout from '@/Layout/Layout.vue'
import throttle from 'lodash/throttle'
import Icon from '@/Shared/Icon.vue'
import pickBy from 'lodash/pickBy'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    filters: Object,
    companies: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/companies', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
