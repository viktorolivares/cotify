<template>
  <div>

    <Head title="Users" />
    <h1 class="mb-8 text-3xl font-bold">Users</h1>
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
        <label class="block dark:text-gray-200">Role:</label>
        <select v-model="form.role"  class="form-select mt-1 w-full dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
          <option value="user">User</option>
          <option value="owner">Owner</option>
        </select>
        <label class="block mt-4 dark:text-gray-200">Trashed:</label>
        <select v-model="form.trashed"  class="form-select mt-1 w-full dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
      <Link class="btn-indigo" href="/users/create">
      <span>Create</span>
      <span class="hidden md:inline">&nbsp;User</span>
      </Link>
    </div>
    <div class="bg-white dark:bg-indigo-900 rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Name</th>
          <th class="pb-4 pt-6 px-6">Email</th>
          <th class="pb-4 pt-6 px-6" colspan="2">Role</th>
        </tr>
        <tr v-for="(user, index) in users.data" :key="user.id"
          class="hover:bg-gray-100 dark:hover:bg-indigo-800">
          <td class="border-t dark:border-gray-600">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/users/${user.id}/edit`">
            <img v-if="user.photo" class="block -my-2 mr-2 w-5 h-5 rounded-full" :src="user.photo" />
            {{ user.name }}
            <icon v-if="user.deleted_at" name="trash" class="shrink-0 ml-2 w-3 h-3 fill-gray-400" />
            </Link>
          </td>
          <td class="border-t dark:border-gray-600">
            <Link class="flex items-center px-6 py-4" :href="`/users/${user.id}/edit`" tabindex="-1">
            {{ user.email }}
            </Link>
          </td>
          <td class="border-t dark:border-gray-600">
            <Link class="flex items-center px-6 py-4" :href="`/users/${user.id}/edit`" tabindex="-1">
            {{ user.owner ? 'Owner' : 'User' }}
            </Link>
          </td>
          <td class="w-px border-t dark:border-gray-600">
            <Link class="flex items-center px-4" :href="`/users/${user.id}/edit`" tabindex="-1">
            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </Link>
          </td>
        </tr>
        <tr v-if="users.data.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">No users found.</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="users.links" />
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Icon from '@/Shared/Icon.vue'
import pickBy from 'lodash/pickBy'
import Layout from '@/Layout/Layout.vue'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import SearchFilter from '@/Shared/SearchFilter.vue'
import Pagination from '@/Shared/Pagination.vue'

export default {
  components: {
    Head,
    Icon,
    Link,
    SearchFilter,
    Pagination,
  },
  layout: Layout,
  props: {
    filters: Object,
    users: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        role: this.filters.role,
        trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/users', pickBy(this.form), { preserveState: true })
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
