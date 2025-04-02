<template>
    <Head title="Create Person" />
    <h1 class="mb-8 text-3xl font-bold">
        <Link class="text-indigo-400 hover:text-indigo-600" href="/persons">Persons</Link>
        <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <form @submit.prevent="store" class="grid grid-cols-1 md:grid-cols-3 gap-8">
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

                <div class="pb-4 pr-6 w-full lg:w-1/2">
                    <label class="form-label">Number</label>
                    <div class="relative flex">
                        <input type="text" v-model="form.number"
                            class="form-input dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 rounded-s-md rounded-e-none dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <button type="button" @click="getDniInfo"
                            class="py-1 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-e-md border border-transparent bg-indigo-600 text-white hover:bg-orange-400 disabled:opacity-50 disabled:pointer-events-none">
                            <div v-if="loading" class="text-sm text-gray-50">
                                Searching...
                            </div>
                            <div v-else>
                                Search
                            </div>
                        </button>
                    </div>
                    
                </div>

                <text-input v-model="form.name" :error="form.errors.name" class="pb-4 pr-6 w-full lg:w-1/2"
                    label="Name" />
                <text-input v-model="form.trade_name" :error="form.errors.trade_name" class="pb-4 pr-6 w-full lg:w-1/2"
                    label="Trade Name" />
                <text-input v-model="form.email" :error="form.errors.email" class="pb-4 pr-6 w-full lg:w-1/2"
                    label="Email" />
                <text-input v-model="form.phone" :error="form.errors.phone" class="pb-4 pr-6 w-full lg:w-1/2"
                    label="Phone" />
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

            <div class="flex items-center justify-end px-8 py-4 border-t bg-gray-100 dark:bg-indigo-900">
                <loading-button :loading="form.processing" class="btn-indigo" type="submit">
                    Create Person
                </loading-button>
            </div>
        </div>
    </form>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Layout from '@/Layout/Layout.vue'
import TextInput from '@/Shared/TextInput.vue'
import SelectInput from '@/Shared/SelectInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'
import FileInput from '@/Shared/FileInput.vue'
import axios from 'axios'

export default {
    components: {
        Head,
        Link,
        LoadingButton,
        SelectInput,
        TextInput,
        FileInput,
    },
    layout: Layout,
    remember: 'form',
    props: {
        accounts: Array,
        departments: Array,
        provinces: Array,
        districts: Array,
    },
    data() {
        return {
            form: this.$inertia.form({
                identity_document_type_id: 1,
                number: null,
                name: null,
                trade_name: null,
                email: null,
                phone: null,
                address: null,
                department_id: null,
                province_id: null,
                district_id: null,
            }),

            identityDocumentTypes: [
                { id: '1', description: 'DNI' },
                { id: '6', description: 'RUC' },
            ],

            selectedDepartment: null,
            selectedProvince: null,
            selectedDistrict: null,
            loading: false, 
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
        store() {
            this.form.department_id = this.selectedDepartment
            this.form.province_id = this.selectedProvince
            this.form.district_id = this.selectedDistrict
            this.form.post('/persons')
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
        async getDniInfo() {
            this.loading = true;
            let type = null;
            this.form.identity_document_type_id === 1 ? type = 'dni' : type = 'ruc';
            let number = this.form.number;

            try {
                const response = await axios.get(`/apis/query`, {
                    params: { type, number }
                });

                const data = response.data[0].data;
                console.log(data);

                if (this.form.identity_document_type_id === 1) {
                    this.form.name = data.nombre_completo;
                } else {
                    this.form.name = data.nombre_o_razon_social;
                    this.form.trade_name = data.nombre_o_razon_social;
                    this.form.address = data.direccion;
                    this.selectedDepartment = data.ubigeo[0];
                    this.selectedProvince = data.ubigeo[1];
                    this.selectedDistrict = data.ubigeo[2];

                }
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        }
    },
}
</script>
