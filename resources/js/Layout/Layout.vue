<template>
  <div>
    <div id="dropdown" />
    <div class="md:flex md:flex-col">
      <div class="md:flex md:flex-col md:h-screen">
        <div class="md:flex md:shrink-0">
          <div
            class="flex items-center justify-between px-6 py-4 dark:bg-indigo-900 bg-indigo-700 md:shrink-0 md:justify-center md:w-56">
            <Link class="mt-1" href="/">
            <span class="font-semibold text-white">Cotify</span>
            </Link>
            <dropdown class="md:hidden" placement="bottom-end">
              <template #default>
                <svg class="w-6 h-6 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                </svg>
              </template>
              <template #dropdown>
                <div class="px-8 py-4 bg-indigo-800 rounded shadow-lg">
                  <main-menu />
                </div>
              </template>
            </dropdown>
          </div>
          <div
            class="md:text-md flex items-center justify-between p-4 w-full text-sm bg-white dark:bg-slate-800 border-b dark:border-b-black md:px-12 md:py-0">
            <div class="mr-4 mt-1">{{ auth.user.account.name }}</div>
            <UseDark v-slot="{ isDark, toggleDark }">
              <button @click="toggleDark()">
                <icon v-if="isDark" class="fill-gray-400" name="moon" />
                <icon v-else class="fill-yellow-400" name="sun" />
              </button>
            </UseDark>
            <dropdown class="mt-1 ms-4" placement="bottom-end">
              <template #default>
                <div class="group flex items-center cursor-pointer select-none">
                  <div class="mr-1 group-hover:text-indigo-600 focus:text-indigo-600 whitespace-nowrap">
                    <span>{{ auth.user.first_name }}</span>
                    <span class="hidden md:inline">&nbsp;{{ auth.user.last_name }}</span>
                  </div>
                  <icon class="w-5 h-5 fill-gray-400 group-hover:fill-indigo-600 focus:fill-indigo-600"
                    name="cheveron-down" />
                </div>
              </template>
              <template #dropdown>
                <div class="mt-2 py-2 text-sm bg-white dark:bg-indigo-800 rounded shadow-xl">
                  <Link class="block px-6 py-2 hover:text-white hover:bg-indigo-500"
                    :href="`/users/${auth.user.id}/edit`">My Profile</Link>
                  <Link class="block px-6 py-2 hover:text-white hover:bg-indigo-500" href="/users">Manage Users</Link>
                  <Link class="block px-6 py-2 w-full text-left hover:text-white hover:bg-indigo-500" href="/logout"
                    method="delete" as="button">Logout</Link>
                </div>
              </template>
            </dropdown>
          </div>
        </div>
        <div class="md:flex md:grow md:overflow-hidden">
          <main-menu class="hidden shrink-0 p-6 w-56 bg-indigo-700 dark:bg-indigo-900 overflow-y-auto md:block" />
          <div class="px-4 py-8 md:flex-1 md:p-6 md:overflow-y-auto" scroll-region>
            <flash-messages />
            <slot />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import FlashMessages from '@/Shared/FlashMessages.vue'
import Dropdown from '@/Shared/Dropdown.vue'
import MainMenu from '@/Layout/MainMenu.vue'
import { UseDark } from '@vueuse/components'
import { Link } from '@inertiajs/vue3'
import Icon from '@/Shared/Icon.vue'

export default {
  components: {
    FlashMessages,
    MainMenu,
    Dropdown,
    Icon,
    Link,
    UseDark,
  },
  props: {
    auth: Object,
  },
}
</script>
