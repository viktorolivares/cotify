<template>
  <div>
    <div class="mb-2">
      <Link class="group flex items-center py-3" href="/">
      <icon name="dashboard" class="mr-2 w-4 h-4"
        :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
      <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dashboard</div>
      </Link>
    </div>
    <div class="mb-2">
      <Link class="group flex items-center py-3" href="/companies">
      <icon name="office" class="mr-2 w-4 h-4"
        :class="isUrl('companies') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
      <div :class="isUrl('companies') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Companies</div>
      </Link>
    </div>
    <div class="mb-2">
      <Link class="group flex items-center py-3" href="/establishments">
      <icon name="store" class="mr-2 w-4 h-4"
        :class="isUrl('establishments') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
      <div :class="isUrl('establishments') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Establishments
      </div>
      </Link>
    </div>
    <div class="mb-2">
      <Link class="group flex items-center py-3" href="/quotations">
      <icon name="document" class="mr-2 w-4 h-4"
        :class="isUrl('quotations') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
      <div :class="isUrl('quotations') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Quotations</div>
      </Link>
    </div>
    <div class="mb-2">
      <Link class="group flex items-center py-3" href="/persons">
      <icon name="users" class="mr-2 w-4 h-4"
        :class="isUrl('persons') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
      <div :class="isUrl('persons') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Persons</div>
      </Link>
    </div>
    <div class="mb-2">
      <Link class="group flex items-center py-3" href="/templates">
      <icon name="printer" class="mr-2 w-4 h-4"
        :class="isUrl('templates') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
      <div :class="isUrl('templates') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Templates</div>
      </Link>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import Icon from '@/Shared/Icon.vue'

export default {
  components: {
    Icon,
    Link,
  },
  methods: {
    isUrl(...urls) {
      let currentUrl = this.$page.url.substr(1)
      if (urls[0] === '') {
        return currentUrl === ''
      }
      return urls.filter((url) => currentUrl.startsWith(url)).length
    },
  },
}
</script>
