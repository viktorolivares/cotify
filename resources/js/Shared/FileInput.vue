<template>
  <div>
    <label v-if="label" class="form-label">{{ label }}:</label>
    <div
      class="form-input p-0 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
      :class="{ error: error }">
      <input ref="file" type="file" :accept="accept" class="hidden " @change="change" />
      <div v-if="!modelValue" class="p-2">
        <button type="button" class="px-4 py-1 text-white text-xs font-medium bg-blue-500 dark:bg-indigo-700 hover:bg-blue-800 dark:hover:bg-indigo-900 rounded-sm"
          @click="browse">Browse</button>
      </div>
      <div v-else class="flex items-center justify-between p-2">
        <div class="flex-1 pr-1">
          {{ modelValue.name }} <span class="text-green-500 dark:text-red-400 text-xs">({{ filesize(modelValue.size) }})</span>
        </div>
        <button type="button" class="px-4 py-1 text-white text-xs font-medium bg-blue-500 dark:bg-indigo-700 hover:bg-blue-800 dark:hover:bg-indigo-900 rounded-sm"
          @click="remove">Remove</button>
      </div>
    </div>
    <div v-if="error" class="form-error">{{ error }}</div>

    <!-- Mostrar la imagen seleccionada -->
    <div v-if="modelValue && isImage(modelValue.type)" class="mt-3 p-4 bg-slate-50 dark:bg-gray-300 rounded shadow flex justify-center">
      <img :src="getObjectURL(modelValue)" alt="Selected Image" class="max-w-full h-auto" />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    modelValue: File,
    label: String,
    accept: String,
    error: String,
  },
  emits: ['update:modelValue'],
  watch: {
    modelValue(value) {
      if (!value) {
        this.$refs.file.value = ''
      }
    },
  },
  methods: {
    filesize(size) {
      var i = Math.floor(Math.log(size) / Math.log(1024))
      return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i]
    },
    browse() {
      this.$refs.file.click()
    },
    change(e) {
      this.$emit('update:modelValue', e.target.files[0])
    },
    remove() {
      this.$emit('update:modelValue', null)
    },
    isImage(mimeType) {
      console.log("mimeType: ", mimeType);
      return mimeType.startsWith('image/')
    },
    getObjectURL(file) {
      return URL.createObjectURL(file)
    },
  },
}
</script>
