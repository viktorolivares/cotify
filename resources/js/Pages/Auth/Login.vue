<template>

  <Head title="Login" />
  
  <div class="flex items-center justify-center p-6 min-h-screen bg-indigo-800">
    <div class="w-full max-w-md dark:bg-indigo-900 bg-white">
      <form class="mt-8 rounded-lg shadow-xl overflow-hidden" @submit.prevent="login">
        <div class="px-10 py-12">
          <h1 class="text-center text-3xl font-bold">Sign In</h1>
          <div class="mt-6 mx-auto w-24 border-b-2" />
          <text-input v-model="form.email" :error="form.errors.email" class="mt-10" label="Email" type="email" autofocus
            autocapitalize="off" />
          <text-input v-model="form.password" :error="form.errors.password" class="mt-6" label="Password"
            type="password" />
          <label class="flex items-center mt-6 select-none" for="remember">
            <input id="remember" v-model="form.remember" class="mr-1" type="checkbox" />
            <span class="text-sm">Remember Me</span>
          </label>
        </div>
        <div class="flex px-10 py-4 bg-gray-100 dark:bg-indigo-900 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Login</loading-button>
        </div>
      </form>
    </div>
    <span class="absolute bottom-0 right-50 p-4 text-white text-sm">Cotify v1.0 © 2024</span>
  </div>
</template>

<script>

import LoadingButton from '@/Shared/LoadingButton.vue'
import TextInput from '@/Shared/TextInput.vue'
import { Head } from '@inertiajs/vue3'

export default {
  components: {
    LoadingButton,
    TextInput,
    Head,
  },
  data() {
    return {
      form: this.$inertia.form({
        email: '',
        password: '',
        remember: true,
      }),
    }
  },
  methods: {
    login() {
      this.form.post('/login')
    },
  },
}
</script>
