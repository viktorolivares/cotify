<template>

  <Head title="Edit Establishment" />
  <h1 class="mb-8 text-3xl font-bold">
    <Link class="text-indigo-400 hover:text-indigo-600" href="/establishments">Establishments</Link>
    <span class="text-indigo-400 font-medium">/</span> {{ form.description }}
  </h1>

  
  <form @submit.prevent="update" class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <div class="md:col-span-2 bg-white dark:bg-indigo-900 rounded-md shadow">
      <div class="flex flex-wrap -mb-8 -mr-6 p-8">

        <text-input v-model="form.description" :error="form.errors.description" class="pb-4 pr-6 w-full lg:w-1/2"
          label="Description" />

        <text-input v-model="form.code" :error="form.errors.code" maxlength="4" class="pb-4 pr-6 w-full lg:w-1/2"
          label="Code" />
        
          <div class="pb-4 pr-6 w-full lg:w-1/2">
            <label class="form-label">Company</label>
            <div class="relative">
              <select class="form-select dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                v-model="form.company_id" disabled>
                <option value="" disabled>Select a company</option>
                <option v-for="company in companies" :value="company.id" :key="company.id">{{
                  company.name }}</option>
              </select>
              <span class="form-error" v-if="form.errors.company_id">{{ form.errors.company_id }}</span>
            </div>
          </div>

        

        <text-input v-model="form.email" :error="form.errors.email" class="pb-4 pr-6 w-full lg:w-1/2" label="Email" />
        <text-input v-model="form.phone" :error="form.errors.phone" class="pb-4 pr-6 w-full lg:w-1/2" label="Phone" />
        <text-input v-model="form.address" :error="form.errors.address" class="pb-4 pr-6 w-full lg:w-1/2"
          label="Address" />

        <!-- Seleccionar Departamento -->
        <div class="pb-4 pr-6 w-full lg:w-1/2">
          <label class="form-label">Department</label>
          <div class="relative">
            <select class="form-select dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
              v-model="selectedDepartment" @change="onDepartmentChange">
              <option value="" disabled>Select a department</option>
              <option v-for="department in departments" :value="department.id" :key="department.id">{{
                department.description }}</option>
            </select>
            <span class="form-error" v-if="form.errors.department_id">{{ form.errors.department_id }}</span>
          </div>
        </div>

        <!-- Seleccionar Provincia -->
        <div class="pb-4 pr-6 w-full lg:w-1/2">
          <label class="form-label">Province</label>
          <div class="relative">
            <select class="form-select dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
              v-model="selectedProvince" @change="onProvinceChange">
              <option value="" disabled>Select a province</option>
              <option v-for="province in filteredProvinces" :value="province.id" :key="province.id">{{
                province.description }}</option>
            </select>
            <span class="form-error" v-if="form.errors.province_id">{{ form.errors.province_id }}</span>
          </div>
        </div>

        <!-- Seleccionar Distrito -->
        <div class="pb-4 pr-6 w-full lg:w-1/2">
          <label class="form-label">District</label>
          <div class="relative">
            <select class="form-select dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
              v-model="selectedDistrict" @change="onDistrictChange">
              <option value="" disabled>Select a district</option>
              <option v-for="district in filteredDistricts" :value="district.id" :key="district.id">{{
                district.description }}</option>
            </select>
            <span class="form-error" v-if="form.errors.district_id">{{ form.errors.district_id }}</span>
          </div>
        </div>
      </div>

       <!-- Footer -->
       <div class="flex items-center px-8 py-4 bg-gray-100 dark:bg-indigo-900 border-t border-gray-100">
        <trashed-message v-if="establishment.deleted_at" @restore="restore">
          This has been deleted.
        </trashed-message>
        <button v-if="!establishment.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button"
          @click="destroy">
          Delete Establishment
        </button>
        <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">
          Update Establishment
        </loading-button>
      </div>
    </div>
  </form>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Layout from '@/Layout/Layout.vue'
import TextInput from '@/Shared/TextInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'
import TrashedMessage from '@/Shared/TrashedMessage.vue'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    TextInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    establishment: Object,
    companies: Array,
    departments: Array,
    provinces: Array,
    districts: Array,
  },
  data() {
    return {
      form: this.$inertia.form({
        description: this.establishment.description,
        code: this.establishment.code,
        company_id: this.establishment.company_id,
        email: this.establishment.email,
        phone: this.establishment.phone,
        address: this.establishment.address,
        department_id: this.establishment.department_id,
        province_id: this.establishment.province_id,
        district_id: this.establishment.district_id,
      }),

      selectedDepartment: this.establishment.department_id || '',
      selectedProvince: this.establishment.province_id || '',
      selectedDistrict: this.establishment.district_id || '',
    }
  },
  computed: {
    filteredProvinces() {
      return this.provinces.filter(province => province.department_id === this.selectedDepartment)
    },
    filteredDistricts() {
      return this.districts.filter(district => district.province_id === this.selectedProvince)
    },
  },
  methods: {
    update() {
      this.form.department_id = this.selectedDepartment
      this.form.province_id = this.selectedProvince
      this.form.district_id = this.selectedDistrict
      this.form.put(`/establishments/${this.establishment.id}`)
    },
    onDepartmentChange() {
      this.form.department_id = this.selectedDepartment;
      this.selectedProvince = null;
      this.form.province_id = null;
      this.selectedDistrict = null;
      this.form.district_id = null;
    },
    onProvinceChange() {
      this.form.province_id = this.selectedProvince;
      this.selectedDistrict = null;
      this.form.district_id = null;
    },
    onDistrictChange() {
      this.form.district_id = this.selectedDistrict;
    },
    destroy() {
      if (confirm('Are you sure you want to delete this establishment?')) {
        this.$inertia.delete(`/establishments/${this.establishment.id}`);
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this establishment?')) {
        this.$inertia.put(`/establishments/${this.establishment.id}/restore`);
      }
    },
  }
}
</script>
