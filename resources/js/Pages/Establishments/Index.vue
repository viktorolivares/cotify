<template>
  <div>

    <Head title="Establishments" />
    <h1 class="mb-8 text-3xl font-bold">Establishments</h1>
    <!--<search-filter v-model="form.search" :hasFilters="false" class="mr-4 w-full max-w-md" @reset="reset" /></div>-->
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
        <label class="block dark:text-gray-200">Enabled:</label>
        <select v-model="form.enabled"
          class="form-select mt-1 w-full dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
          <option value="true">Active</option>
          <option value="false">Inactive</option>
        </select>
        <label class="block dark:text-gray-200 mt-4">Company Trashed:</label>
        <select v-model="form.with_deleted_companies"
          class="form-select mt-1 w-full dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
      <Link class="btn-indigo" href="/establishments/create">
      <span>Create</span>
      <span class="hidden md:inline">&nbsp;Establishment</span>
      </Link>
    </div>
    <div class="bg-white dark:bg-indigo-900 rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Description</th>
            <th class="pb-4 pt-6 px-6">Company</th>
            <th class="pb-4 pt-6 px-6">Code</th>
            <th class="pb-4 pt-6 px-6">Address</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="establishment in establishments.data" :key="establishment.id"
            :class="[establishment.company.deleted_at ? 'text-red-300' : 'hover:bg-gray-100 dark:hover:bg-indigo-800']">
            <td class="border-t dark:border-gray-600">
              <Link v-if="!establishment.company.deleted_at" class="flex items-center px-6 py-4 focus:text-indigo-500"
                :href="`/establishments/${establishment.id}/edit`">
              {{ establishment.description }}
              <icon v-if="establishment.deleted_at" name="trash" class="shrink-0 ml-2 w-3 h-3 fill-red-400" />
              </Link>
              <span v-else class="flex items-center px-6 py-4 focus:text-red-500">
                {{ establishment.description }}
              </span>
            </td>
            <td class="border-t dark:border-gray-600">
              <Link v-if="!establishment.company.deleted_at" class="flex items-center px-6 py-4"
                :href="`/establishments/${establishment.id}/edit`" tabindex="-1">
              <div v-if="establishment.company">
                {{ establishment.company.name }}
              </div>
              </Link>
              <span v-else class="flex items-center px-6 py-4 focus:text-red-500">
                {{ establishment.company.name }} 
                <icon name="trash" class="shrink-0 ml-2 w-3 h-3 fill-red-400" />
              </span>
            </td>
            <td class="border-t dark:border-gray-600">
              <Link v-if="!establishment.company.deleted_at" class="flex items-center px-6 py-4"
                :href="`/establishments/${establishment.id}/edit`" tabindex="-1">
              {{ establishment.code }}
              </Link>
              <span v-else class="flex items-center px-6 py-4 focus:text-red-500">
                {{ establishment.code }}
              </span>
            </td>
            <td class="border-t dark:border-gray-600">
              <Link v-if="!establishment.company.deleted_at" class="flex items-center px-6 py-4"
                :href="`/establishments/${establishment.id}/edit`" tabindex="-1">
              {{ establishment.address }}
              </Link>
              <span v-else class="flex items-center px-6 py-4 focus:text-red-500">
                {{ establishment.address }}
              </span>
            </td>
            <td class="w-px border-t dark:border-gray-600">
              <Link v-if="!establishment.company.deleted_at" class="flex items-center px-4"
                :href="`/establishments/${establishment.id}/edit`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
              </Link>
              <span v-else class="flex items-center px-4 focus:text-red-500">
                <icon name="x-mark" class="block w-6 h-6" />
              </span>
            </td>
          </tr>
          <tr v-if="establishments.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="4">No establishments found.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination class="mt-6" :links="establishments.links" />
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Icon from '@/Shared/Icon.vue'
import pickBy from 'lodash/pickBy'
import Layout from '@/Layout/Layout.vue'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination.vue'
import SearchFilter from '@/Shared/SearchFilter.vue'

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
    establishments: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        enabled: this.filters.enabled,
        with_deleted_companies: this.filters.with_deleted_companies,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/establishments', pickBy(this.form), { preserveState: true })
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
