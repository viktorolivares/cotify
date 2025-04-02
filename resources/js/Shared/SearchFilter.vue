<template>
  <div class="flex items-center">
    <div v-if="hasFilters" class="flex w-full bg-white dark:bg-indigo-900 rounded shadow">
      <dropdown :auto-close="false"
        class="focus:z-10 px-4 hover:bg-gray-100 dark:hover:bg-indigo-800 border-r focus:border-white rounded-l focus:ring md:px-6"
        placement="bottom-start">
        <template #default>
          <div class="flex items-baseline">
            <span class="hidden text-gray-700 dark:text-gray-100 md:inline">Filter</span>
            <svg class="w-2 h-2 fill-gray-400 md:ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 961.243 599.998">
              <path
                d="M239.998 239.999L0 0h961.243L721.246 240c-131.999 132-240.28 240-240.624 239.999-.345-.001-108.625-108.001-240.624-240z" />
            </svg>
          </div>
        </template>
        <template #dropdown>
          <div class="mt-2 px-4 py-6 w-screen bg-white dark:bg-indigo-800 rounded shadow-xl"
            :style="{ maxWidth: `${maxWidth}px` }">
            <slot />
          </div>
        </template>
      </dropdown>
      <input class="relative px-6 py-3 w-full rounded-r focus:shadow-outline dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" autocomplete="off"
        type="text" name="search" :placeholder="placeholder" :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)" />
    </div>
    <div v-else class="flex w-full bg-white dark:bg-indigo-900 rounded shadow">
      <input class="relative px-6 py-3 w-full rounded focus:shadow-outline dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" autocomplete="off"
        type="text" name="search" :placeholder="placeholder" :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)" />
    </div>
    <button class="ml-3 dark:text-gray-100 hover:text-gray-700 focus:text-indigo-500 text-sm" type="button"
      @click="$emit('reset')">Reset</button>
  </div>
</template>

<script>
import Dropdown from '@/Shared/Dropdown.vue'

export default {
  components: {
    Dropdown,
  },
  props: {
    modelValue: String,
    hasFilters: {
      type: Boolean,
      default: true,
    },
    maxWidth: {
      type: Number,
      default: 300,
    },
    placeholder: {
      type: String,
      default: 'Search...', 
    },
  },
  emits: ['update:modelValue', 'reset'],
}
</script>
