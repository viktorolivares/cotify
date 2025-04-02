<template>
  <div>

    <Head title="Create User" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/users">Users</Link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="max-w-3xl bg-white dark:bg-indigo-900 rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.first_name" :error="form.errors.first_name" class="pb-8 pr-6 w-full lg:w-1/2"
            label="First name" />
          <text-input v-model="form.last_name" :error="form.errors.last_name" class="pb-8 pr-6 w-full lg:w-1/2"
            label="Last name" />
          <text-input v-model="form.email" :error="form.errors.email" class="pb-8 pr-6 w-full lg:w-1/2" label="Email" />
          <text-input v-model="form.password" :error="form.errors.password" class="pb-8 pr-6 w-full lg:w-1/2"
            type="password" autocomplete="new-password" label="Password" />

          <div class="pb-4 pr-6 w-full lg:w-1/2">
            <label class="form-label">
              Owner
            </label>
            <div class="relative">
              <select
                class="form-select dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                v-model="form.owner" disabled>
                <option :value="true">Yes</option>
                <option :value="false">No</option>
              </select>
              <span class="form-error" v-if="form.errors.owner">
                {{ form.errors.owner }}
              </span>
            </div>
          </div>

          <file-input v-model="form.photo" :error="form.errors.photo" class="pb-8 pr-6 w-full lg:w-1/2" type="file"
            accept="image/*" label="Photo" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-100 dark:bg-indigo-900  border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create User</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Layout from '@/Layout/Layout.vue'
import FileInput from '@/Shared/FileInput.vue'
import TextInput from '@/Shared/TextInput.vue'
import SelectInput from '@/Shared/SelectInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'

export default {
  components: {
    FileInput,
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  layout: Layout,
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        first_name: '',
        last_name: '',
        email: '',
        password: '',
        owner: false,
        photo: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/users')
    },
  },
}
</script>
