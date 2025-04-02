<template>
    <div>
      <Head :title="form.name" />
      <div class="mb-8 grid grid-cols-2 gap-8 items-center">
        <h1 class="text-3xl font-bold">
          <Link class="text-indigo-400 hover:text-indigo-600" href="/persons">Persons</Link>
          <span class="text-indigo-400 font-medium">/</span>
          {{ form.name }}
        </h1>
      </div>
  
      <!-- Form -->
      <form @submit.prevent="update" class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-2 bg-white dark:bg-indigo-900 rounded-md shadow">
          <div class="flex flex-wrap -mb-8 -mr-6 p-8">
            <div class="pb-4 pr-6 w-full lg:w-1/2">
              <label class="form-label">Identity Document</label>
              <div class="relative">
                <select
                  class="form-select dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                  v-model="form.identity_document_type_id" :error="form.errors.identity_document_type_id">
                  <option value="" disabled>Select an identity document</option>
                  <option v-for="identityDocumentType in identityDocumentTypes"
                    :value="identityDocumentType.id" :key="identityDocumentType.id">
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
  
            <text-input v-model="form.name" :error="form.errors.name" class="pb-4 pr-6 w-full lg:w-1/2"
              label="Name" />
  
            <text-input v-model="form.trade_name" :error="form.errors.trade_name"
              class="pb-4 pr-6 w-full lg:w-1/2" label="Trade Name" />
  
            <text-input v-model="form.email" :error="form.errors.email" class="pb-4 pr-6 w-full lg:w-1/2"
              label="Email" />
  
            <text-input v-model="form.phone" :error="form.errors.phone" class="pb-4 pr-6 w-full lg:w-1/2"
              label="Phone" />
  
            <text-input v-model="form.address" :error="form.errors.address" class="pb-4 pr-6 w-full lg:w-1/2"
              label="Address" />
  
            <!-- Select Department -->
            <div class="pb-4 pr-6 w-full lg:w-1/2">
              <label class="form-label">Department</label>
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
              <label class="form-label">Province</label>
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
              <label class="form-label">District</label>
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
          <div class="flex items-center px-8 py-4 bg-gray-100 dark:bg-indigo-900 border-t border-gray-100">
            <trashed-message v-if="person.deleted_at" @restore="restore">
              This has been deleted.
            </trashed-message>
            <button v-if="!person.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button"
              @click="destroy">
              Delete Person
            </button>
            <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">
              Update Person
            </loading-button>
          </div>
        </div>
      </form>
    </div>
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
      TextInput,
      LoadingButton,
      TrashedMessage,
    },
    layout: Layout,
    props: {
      person: Object,
      departments: Array,
      provinces: Array,
      districts: Array,
    },
    data() {
      return {
        form: this.$inertia.form({
          _method: 'put',
          identity_document_type_id: this.person.identity_document_type_id,
          number: this.person.number,
          name: this.person.name,
          trade_name: this.person.trade_name,
          email: this.person.email,
          phone: this.person.phone,
          address: this.person.address,
          department_id: this.person.department_id,
          province_id: this.person.province_id,
          district_id: this.person.district_id,
        }),
        identityDocumentTypes: [
          { id: '1', description: 'DNI' },
          { id: '6', description: 'RUC' },
        ],
        selectedDepartment: this.person.department_id,
        selectedProvince: this.person.province_id,
        selectedDistrict: this.person.district_id,
      };
    },
    computed: {
      // Opciones de provincias filtradas basadas en el departamento seleccionado
      filteredProvinces() {
        return this.provinces.filter(province => province.department_id === this.selectedDepartment);
      },
      // Opciones de distritos filtradas basadas en la provincia seleccionada
      filteredDistricts() {
        return this.districts.filter(district => district.province_id === this.selectedProvince);
      },
    },
    methods: {
      update() {
        try {
          this.form.post(`/persons/${this.person.id}`, {
            onSuccess: () => this.form.reset('password', 'photo'),
          });
        } catch (error) {
          console.log(error.response.data.errors);
        }
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
        if (confirm('Are you sure you want to delete this person?')) {
          this.$inertia.delete(`/persons/${this.person.id}`);
        }
      },
      restore() {
        if (confirm('Are you sure you want to restore this person?')) {
          this.$inertia.put(`/persons/${this.person.id}/restore`);
        }
      },
    },
  };
  </script>
  