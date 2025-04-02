<template>
  <div>

    <Head :title="form.name" />
    <div class="mb-8 grid grid-cols-2 gap-8 items-center">
      <h1 class="text-3xl font-bold">
        <Link class="text-indigo-400 hover:text-indigo-600" href="/companies">Companies</Link>
        <span class="text-indigo-400 font-medium">/</span>
        {{ form.name }}
      </h1>
      <div class="flex justify-end">
        <img v-if="company.logo" :src="company.logo" class="bg-gray-100 py-1 px-2 rounded-lg shadow-md"
          alt="company-logo">
      </div>
    </div>

    <!-- Form -->
    <form @submit.prevent="update" class="grid grid-cols-1 md:grid-cols-3 gap-2" enctype="multipart/form-data">
      <div class="md:col-span-2 bg-white dark:bg-indigo-900 rounded-md shadow">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">

          <div class="pb-4 pr-6 w-full lg:w-1/2">
            <label class="form-label">
              Identity Document
            </label>
            <div class="relative">
              <select
                class="form-select dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                v-model="form.identity_document_type_id" :error="form.errors.identity_document_type_id">
                <option value="" disabled>Select an identity document</option>
                <option v-for="identityDocumentType in identityDocumentTypes" :value="identityDocumentType.id"
                  :key="identityDocumentType.id">
                  {{ identityDocumentType.description }}
                </option>
              </select>
              <span class="form-error" v-if="form.errors.identity_document_type_id">
                {{ form.errors.identity_document_type_id }}
              </span>
            </div>
          </div>

          <text-input v-model="form.number" :error="form.errors.number" class="pb-4 pr-6 w-full lg:w-1/2"
            label="Number" />

          <text-input v-model="form.name" :error="form.errors.name" class="pb-4 pr-6 w-full lg:w-1/2" label="Name" />

          <text-input v-model="form.trade_name" :error="form.errors.trade_name" class="pb-4 pr-6 w-full lg:w-1/2"
            label="Trade Name" />

          <text-input v-model="form.email" :error="form.errors.email" class="pb-4 pr-6 w-full lg:w-1/2" label="Email" />

          <text-input v-model="form.phone" :error="form.errors.phone" class="pb-4 pr-6 w-full lg:w-1/2" label="Phone" />

          <text-input v-model="form.address" :error="form.errors.address" class="pb-4 pr-6 w-full lg:w-1/2"
            label="Address" />

          <!-- Select Department -->
          <div class="pb-4 pr-6 w-full lg:w-1/2">
            <label class="form-label">
              Department
            </label>
            <div class="relative">
              <select
                class="form-select dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                v-model="selectedDepartment" @change="onDepartmentChange">
                <option value="" disabled>Select a department</option>
                <option v-for="department in departments" :value="department.id" :key="department.id">
                  {{ department.description }}
                </option>
              </select>
              <span class="form-error" v-if="form.errors.department_id">
                {{ form.errors.department_id }}
              </span>
            </div>
          </div>

          <!-- Select Province -->
          <div class="pb-4 pr-6 w-full lg:w-1/2">
            <label class="form-label">
              Province
            </label>
            <div class="relative">
              <select
                class="form-select dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                v-model="selectedProvince" :error="form.errors.province_id" @change="onProvinceChange">
                <option value="" disabled>Select a province</option>
                <option v-for="province in filteredProvinces" :value="province.id" :key="province.id">
                  {{ province.description }}
                </option>
              </select>
              <span class="form-error" v-if="form.errors.province_id">
                {{ form.errors.province_id }}
              </span>
            </div>
          </div>

          <!-- Select District -->
          <div class="pb-4 pr-6 w-full lg:w-1/2">
            <label class="form-label">
              District
            </label>
            <div class="relative">
              <select
                class="form-select dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                v-model="selectedDistrict" :error="form.errors.district_id" @change="onDistrictChange">
                <option value="" disabled>Select a district</option>
                <option v-for="district in filteredDistricts" :value="district.id" :key="district.id">
                  {{ district.description }}
                </option>
              </select>
              <span class="form-error" v-if="form.errors.district_id">
                {{ form.errors.district_id }}
              </span>
            </div>
          </div>

        </div>

        <!-- Footer -->
        <div class="flex items-center px-8 py-6 bg-gray-100 dark:bg-indigo-900 border-t border-gray-100">

          <trashed-message v-if="company.deleted_at" @restore="restore">
            This has been deleted.
          </trashed-message>

          <button v-if="!company.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button"
            @click="destroy">Delete company</button>

          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">
            Update company
          </loading-button>
        </div>
      </div>
      <div class="md:col-span-1 bg-white dark:bg-indigo-900 rounded-md shadow">
        <div class="flex flex-wrap p-6">
          <!-- Select Account -->
          <div class="my-3 w-full">
            <label class="form-label">Account</label>
            <div class="relative">
              <select
                class="form-select dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                v-model="form.account_id" :error="form.errors.account_id" disabled>
                <option value="">Select an account</option>
                <option v-for="account in accounts" :value="account.id" :key="account.id">{{ account.name }}</option>
              </select>
              <span class="form-error" v-if="form.errors.account_id">{{ form.errors.account_id }}</span>
            </div>
          </div>

          <!-- Select Template -->
          <div class="my-3 w-full">
            <label class="form-label">Templates</label>
            <div class="relative">
              <select
                class="form-select dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                v-model="form.template_id" :error="form.errors.template_id" :disabled="form.processing">
                <option value="" disabled>Select an Temmplate</option>
                <option v-for="template in templates" :value="template.id" :key="template.id">{{ template.description }}
                </option>
              </select>
              <span class="form-error" v-if="form.errors.template_id">{{ form.errors.template_id }}</span>
            </div>
          </div>

          <!-- Logo -->
          <div class="w-full">
            <file-input ref="fileInput" class="my-3 w-full" v-model="form.logo" :error="form.errors.logo" type="file"
              accept="image/*" label="Logo" />
          </div>
        </div>
      </div>
    </form>

    <!-- Alert -->
    <div v-if="company.deleted_at" id="alert-border-2"
      class="flex items-center px-4 py-4 my-4  w-2/3 text-red-800 border-s-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800"
      role="alert">
      <div class="ms-3 text-sm font-medium">
        The establishments are inaccessible due to company deletion.
      </div>
    </div>
    <div v-else>
      <h2 class="mt-12 text-2xl font-bold">Establishments</h2>
      <div class="mt-6 bg-white dark:bg-indigo-900 rounded shadow overflow-x-auto">
        <table class="w-full whitespace-nowrap">
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Description</th>
            <th class="pb-4 pt-6 px-6">Code</th>
            <th class="pb-4 pt-6 px-6">Email</th>
            <th class="pb-4 pt-6 px-6" colspan="2">Address</th>
          </tr>
          <tr v-for="establishment in company.establishments" :key="establishment.id"
            class="hover:bg-gray-100 dark:hover:bg-indigo-800 focus-within:bg-gray-100">
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500"
                :href="`/establishments/${establishment.id}/edit`">
              {{ establishment.description }}
              <icon v-if="establishment.deleted_at" name="trash" class="shrink-0 ml-2 w-3 h-3 fill-gray-400" />
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/establishments/${establishment.id}/edit`"
                tabindex="-1">
              {{ establishment.code }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/establishments/${establishment.id}/edit`"
                tabindex="-1">
              {{ establishment.email }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/establishments/${establishment.id}/edit`"
                tabindex="-1">
              {{ establishment.address }}
              </Link>
            </td>
            <td class="w-px border-t">
              <Link class="flex items-center px-4" :href="`/establishments/${establishment.id}/edit`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
              </Link>
            </td>
          </tr>
          <tr v-if="company.establishments.length === 0">
            <td class="px-6 py-4 border-t" colspan="4">No establishments found.</td>
          </tr>
        </table>
      </div>

    </div>

  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Icon from '@/Shared/Icon.vue'
import Layout from '@/Layout/Layout.vue'
import TextInput from '@/Shared/TextInput.vue'
import FileInput from '@/Shared/FileInput.vue'
import SelectInput from '@/Shared/SelectInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'
import TrashedMessage from '@/Shared/TrashedMessage.vue'

export default {
  components: {
    Head,
    Icon,
    Link,
    FileInput,
    TextInput,
    SelectInput,
    TrashedMessage,
    LoadingButton,
  },
  layout: Layout,
  props: {
    company: Object,
    accounts: Array,
    departments: Array,
    provinces: Array,
    districts: Array,
    templates: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        _method: 'put',
        identity_document_type_id: this.company.identity_document_type_id,
        account_id: this.company.account_id,
        number: this.company.number,
        name: this.company.name,
        trade_name: this.company.trade_name,
        email: this.company.email,
        phone: this.company.phone,
        address: this.company.address,
        template_id: this.company.template_id,
        department_id: this.company.department_id,
        province_id: this.company.province_id,
        district_id: this.company.district_id,
        logo: null,
      }),
      identityDocumentTypes: [
        { id: '1', description: 'DNI' },
        { id: '6', description: 'RUC' },
      ],
      selectedDepartment: this.company.department_id,
      selectedProvince: this.company.province_id,
      selectedDistrict: this.company.district_id,
    }
  },
  computed: {
    // Opciones de provincias filtradas basado en el departamento seleccionado
    filteredProvinces() {
      return this.provinces.filter(province => province.department_id === this.selectedDepartment)
    },
    // Opciones de distritos filtradas basado en la provincia seleccionada
    filteredDistricts() {
      return this.districts.filter(district => district.province_id === this.selectedProvince)
    },
  },
  methods: {
    update() {
      try {
        this.form.post(`/companies/${this.company.id}`)
        this.form.logo = null;
      } catch (error) {
        console.log(error.response.data.errors);
      }
    },
    destroy() {
      if (confirm('Are you sure you want to delete this company?')) {
        this.form.delete(`/companies/${this.company.id}`).then(() => {
          this.$inertia.visit('/companies')
        })
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this company?')) {
        this.$inertia.visit(`/companies/${this.company.id}/restore`, { method: 'put' })
      }
    },
    onDepartmentChange() {
      this.form.department_id = this.selectedDepartment;
      this.selectedProvince = null;
      this.form.province_id = null;
      this.selectedDistrict = null
      this.form.district_id = null;

      console.log(this.form);
    },
    onProvinceChange() {
      this.form.province_id = this.selectedProvince;
      this.selectedDistrict = null;
      this.form.district_id = null;

    },
    onDistrictChange() {
      this.form.district_id = this.selectedDistrict;
      console.log(this.form);
    },
  },
}
</script>
