<template>

  <Head title="Dashboard" />

  <section
    class="bg-center bg-no-repeat bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/conference.jpg')] bg-gray-700 bg-blend-multiply">
    <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-48">
      <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">¡Hola!
        Bienvenido a Cotify</h1>
      <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">una aplicación de demostración
        diseñada para realizar cotizaciones multiempresas</p>
      <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
        <a href="/quotations"
          class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
          Get started
        </a>
      </div>
      <div>
        <a class="text-indigo-500 hover:text-orange-600 underline block mt-3" href="https://inertiajs.com">
          <span class="text-lg">Hecho con Inertia.js, Vue.js y Laravel</span> 
        </a>
      </div>
    </div>
  </section>
</template>

<script>
import { Head } from '@inertiajs/vue3'
import Layout from '@/Layout/Layout.vue'

export default {
  components: {
    Head,
  },
  layout: Layout,
}
</script>
