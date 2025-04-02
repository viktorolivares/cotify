<template>
  <div>

    <Head title="Persons" />
    <h1 class="mb-8 text-3xl font-bold">Persons</h1>
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
      <Link class="btn-indigo" href="/persons/create">
      <span>Create</span>
      <span class="hidden md:inline">&nbsp;Person</span>
      </Link>
    </div>
    <div class="bg-white dark:bg-indigo-900 rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Name</th>
            <th class="pb-4 pt-6 px-6">Number Id</th>
            <th class="pb-4 pt-6 px-6">Address</th>
            <th class="pb-4 pt-6 px-6">Created</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(person, index) in persons.data" :key="person.id"
            class="hover:bg-gray-100 dark:hover:bg-indigo-800">
            <td class="border-t dark:border-gray-600">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/persons/${person.id}/edit`">
              {{ person.name }}
              <icon v-if="person.deleted_at" name="trash" class="shrink-0 ml-2 w-3 h-3 fill-red-400" />
              </Link>
            </td>
            <td class="border-t dark:border-gray-600">
              <Link class="flex items-center px-6 py-4" :href="`/persons/${person.id}/edit`" tabindex="-1">
              {{ person.number }}
              </Link>
            </td>
            <td class="border-t dark:border-gray-600">
              <Link class="flex items-center px-6 py-4" :href="`/persons/${person.id}/edit`" tabindex="-1">
              {{ person.address }}
              </Link>
            </td>
            <td class="border-t dark:border-gray-600">
              <Link class="flex items-center px-6 py-4" :href="`/persons/${person.id}/edit`" tabindex="-1">
              {{ person.created_at }}
              </Link>
            </td>
            <td class="w-px border-t dark:border-gray-600">
              <Link class="flex items-center px-4" :href="`/persons/${person.id}/edit`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
              </Link>
            </td>
          </tr>
          <tr v-if="persons.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="5">No Persons found.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination class="mt-6" :links="persons.links" />
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
    persons: Object,
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
        this.$inertia.get('/persons', pickBy(this.form), { preserveState: true })
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
