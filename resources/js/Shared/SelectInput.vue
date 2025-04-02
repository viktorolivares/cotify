<template>
  <div :class="$attrs.class">
    <label v-if="label" class="form-label" :for="id">{{ label }}:</label>
    <div class="relative">
      <input
        :disabled="disabled"
        type="text"
        v-model="searchTerm"
        @input="filterOptions"
        @focus="isDropdownVisible = true"
        @blur="hideDropdown"
        class="form-input dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
        placeholder="Search..."
      />
      <template v-if="searchTerm">
        <button @click="clearSearchTerm" type="button" class="absolute inset-y-0 right-0 px-3 flex items-center focus:outline-none">
          <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
            <path
              fill-rule="evenodd"
              d="M6.293 6.293a1 1 0 011.414 0L10 8.586l2.293-2.293a1 1 0 111.414 1.414L11.414 10l2.293 2.293a1 1 0 01-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 01-1.414-1.414L8.586 10 6.293 7.707a1 1 0 010-1.414z"
              clip-rule="evenodd"
            />
          </svg>
        </button>
      </template>
      <template v-else>
        <button @click="toggleDropdown" type="button" class="absolute inset-y-0 right-0 px-3 flex items-center focus:outline-none">
          <svg v-if="isDropdownVisible" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
          </svg>
          <svg v-else class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
      </template>
      <div
        v-show="isDropdownVisible"
        class="absolute mt-1 w-full bg-white border border-gray-300 dark:bg-indigo-900 rounded shadow-lg max-h-40 overflow-auto z-20"
        :disabled="disabled"
      >
        <div v-if="filteredOptions.length === 0" class="px-4 py-2 opacity-50 text-red-500 dark:text-red-300"> Not found... </div>
        <div
          v-else
          v-for="option in filteredOptions"
          :key="getOptionId(option)"
          @mousedown.prevent="selectOption(option)"
          class="cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600"
        >
          {{ optionDisplay(option) }}
        </div>
      </div>
    </div>

    <input type="hidden" :id="id" :value="selected" />
    <div v-if="error" class="form-error">{{ error }}</div>
  </div>
</template>

<script>
import { v4 as uuid } from 'uuid'

export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `select-input-${uuid()}`
      },
    },
    error: String,
    label: String,
    modelValue: [String, Number, Boolean],
    options: {
      type: Array,
      required: true,
    },
    searchProperty: {
      type: String,
      required: true,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },
  emits: ['update:modelValue'],
  data() {
    return {
      selected: this.modelValue,
      searchTerm: this.modelValue ? this.getSelectedName(this.modelValue) : '',
      isDropdownVisible: false,
    }
  },
  computed: {
    filteredOptions() {
      const lowerCaseSearchTerm = this.searchTerm.toLowerCase()
      return this.options.filter(option =>
        String(option[this.searchProperty]).toLowerCase().includes(lowerCaseSearchTerm)
      )
    },
  },
  watch: {
    selected(selected) {
      this.$emit('update:modelValue', selected)
      this.searchTerm = this.getSelectedName(selected)
    },
    modelValue(value) {
      this.selected = value
      this.searchTerm = this.getSelectedName(value)
    },
  },
  methods: {
    hideDropdown() {
      setTimeout(() => {
        this.isDropdownVisible = false
      }, 200)
    },
    filterOptions() {
      this.isDropdownVisible = true
    },
    selectOption(option) {
      if (this.filteredOptions.includes(option)) {
        this.selected = option.id
        this.searchTerm = option[this.searchProperty]
        this.isDropdownVisible = false
      }
    },
    clearSearchTerm() {
      this.searchTerm = ''
      this.selected = ''
      this.$emit('update:modelValue', '')
    },
    optionDisplay(option) {
      return option[this.searchProperty] || option.name || Object.values(option).join(' - ')
    },
    getOptionId(option) {
      return option.id
    },
    getSelectedName(selectedId) {
      const selectedOption = this.options.find(option => option.id === selectedId)
      return selectedOption ? selectedOption[this.searchProperty] || '' : ''
    },
    toggleDropdown() {
      this.isDropdownVisible = !this.isDropdownVisible
    },
  },
}
</script>
