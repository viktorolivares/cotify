<template>
    <div>

        <Head title="Quoatation" />
        <h1 class="mb-8 text-3xl font-bold">Quotation</h1>
        <div class="flex items-center justify-between mb-6">
            <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset"
                placeholder="Search by quotation number...">
                <label class="block dark:text-gray-200">Customer:</label>
                <input v-model="form.customer_search" type="text"
                    class="form-input mt-1 w-full dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
                <label class="block dark:text-gray-200 mt-4">Company:</label>
                <input v-model="form.company_search" type="text"
                    class="form-input mt-1 w-full dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
                <label class="block dark:text-gray-200 mt-4">Start Date:</label>
                <input v-model="form.date_start" type="date"
                    class="form-input mt-1 w-full dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
                <label class="block dark:text-gray-200 mt-4">End Date:</label>
                <input v-model="form.date_end" type="date"
                    class="form-input mt-1 w-full dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
            </search-filter>
            <button class="btn-indigo" @click="onToggle">
                <span>✚ New</span>
                <span class="hidden md:inline">&nbsp;Quoatation</span>
            </button>
        </div>
        <div class="bg-white dark:bg-indigo-900 rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="text-left font-bold">
                        <th class="pb-4 pt-6 px-6">Date of Issue</th>
                        <th class="pb-4 pt-6 px-6">Company</th>
                        <th class="pb-4 pt-6 px-6">Customer</th>
                        <th class="pb-4 pt-6 px-6">State</th>
                        <th class="pb-4 pt-6 px-6">Series</th>
                        <th class="pb-4 pt-6 px-6">Currency</th>
                        <th class="pb-4 pt-6 px-6">Subtotal</th>
                        <th class="pb-4 pt-6 px-6">Total IGV</th>
                        <th class="pb-4 pt-6 px-6">Total</th>
                        <th class="pb-4 pt-6 px-6">PDF</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(quotation, index) in quotations.data" :key="quotation.id"
                        class="hover:bg-gray-100 dark:hover:bg-indigo-800 ">
                        <td class="border-t dark:border-gray-600">
                            <Link class="flex items-center px-6 py-4" :href="`/quotations/${quotation.id}/edit`">
                            {{ quotation.date_of_issue }}
                            </Link>
                        </td>
                        <td class="border-t dark:border-gray-600">
                            <Link class="flex items-center px-6 py-4" :href="`/quotations/${quotation.id}/edit`"
                                tabindex="-1">
                            {{ quotation.company }}
                            <icon v-if="quotation.deleted_at_company" name="trash" class="shrink-0 ml-2 w-3 h-3 fill-red-400" />
                            </Link>
                        </td>
                        <td class="border-t dark:border-gray-600">
                            <Link class="flex items-center px-6 py-4" :href="`/quotations/${quotation.id}/edit`"
                                tabindex="-1">
                            {{ quotation.customer }}
                            <icon v-if="quotation.deleted_at_person" name="trash" class="shrink-0 ml-2 w-3 h-3 fill-red-400" />
                            </Link>
                        </td>
                        <td class="border-t dark:border-gray-600">
                            <span class="flex items-center px-6 py-4">
                                <span v-if="quotation.state_type_id === '01'"
                                    class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Registrado</span>
                                <span v-else-if="quotation.state_type_id === '02'"
                                    class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Enviado</span>
                                <span v-else-if="quotation.state_type_id === '03'"
                                    class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Aceptado</span>
                                <span v-else-if="quotation.state_type_id === '04'"
                                    class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Rechazado</span>
                                <span v-else-if="quotation.state_type_id === '05'"
                                    class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Anulado</span>
                            </span>
                        </td>
                        <td class="border-t dark:border-gray-600">
                            <Link class="flex items-center px-6 py-4" :href="`/quotations/${quotation.id}/edit`"
                                tabindex="-1">
                            {{ quotation.prefix }}
                            </Link>
                        </td>
                        <td class="border-t dark:border-gray-600 text-yellow-600">
                            <Link class="flex items-center px-6 py-4" :href="`/quotations/${quotation.id}/edit`"
                                tabindex="-1">
                            {{ quotation.currency_type_id }}
                            </Link>
                        </td>
                        <td class="border-t dark:border-gray-600 text-blue-500">
                            <Link class="flex items-center px-6 py-4" :href="`/quotations/${quotation.id}/edit`"
                                tabindex="-1">
                            {{ quotation.subtotal }}
                            </Link>
                        </td>
                        <td class="border-t dark:border-gray-600 text-blue-500">
                            <Link class="flex items-center px-6 py-4" :href="`/quotations/${quotation.id}/edit`"
                                tabindex="-1">
                            {{ quotation.total_igv }}
                            </Link>
                        </td>
                        <td class="border-t dark:border-gray-600 text-blue-500">
                            <Link class="flex items-center px-6 py-4" :href="`/quotations/${quotation.id}/edit`"
                                tabindex="-1">
                            {{ quotation.total }}
                            </Link>
                        </td>
                        <td class="border-t dark:border-gray-600">
                            <a :href="`/quotations/${quotation.id}/pdf`" target="_blank" class="flex items-center px-6 py-4">
                                <Icon name="pdf" class="w-5 h-5" />
                            </a>
                        </td>
                    </tr>
                    <tr v-if="quotations.data.length === 0">
                        <td class="px-6 py-4 border-t" colspan="10">No quotations found.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <pagination class="mt-6" :links="quotations.links" />

        <!-- Modal -->
        <modal v-if="showModal" size="sm" title="Select Company" @close="onToggle">
            <div class="grid gap-4 grid-cols-3 mt-5 mb-3">
                <select-input v-model="selectedCompany" class="col-span-3" search-property="name" :options="companies"
                    label="Company"></select-input>
                <button class="col-span-3 my-3 text-white dark:bg-green-800 bg-green-500 p-3 rounded w-full"
                    @click="createQuotation">
                    <span>✚ Create Quotation</span>
                </button>
            </div>
        </modal>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Icon from '@/Shared/Icon.vue'
import pickBy from 'lodash/pickBy'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination.vue'
import SearchFilter from '@/Shared/SearchFilter.vue'
import Layout from '@/Layout/Layout.vue'
import Modal from '../../Shared/Modal.vue'
import SelectInput from '@/Shared/SelectInput.vue'
import { ref, computed } from 'vue'

export default {
    components: {
        Head,
        Icon,
        Link,
        Pagination,
        SearchFilter,
        Modal,
        SelectInput,
    },
    layout: Layout,
    props: {
        filters: Object,
        quotations: Object,
        companies: Array,
    },
    data() {
        return {
            form: {
                search: this.filters.search,
                company_search: this.filters.company_search,
                customer_search: this.filters.customer_search,
            },
            showModal: false,
            selectedCompany: null,
        }
    },
    computed: {
        isModalVisible() {
            return this.showModal;
        },
    },
    watch: {
        form: {
            deep: true,
            handler: throttle(function () {
                this.$inertia.get('/quotations', pickBy(this.form), { preserveState: true })
            }, 150),
        },
    },
    methods: {
        reset() {
            this.form = mapValues(this.form, () => null)
        },
        onToggle() {
            this.showModal = !this.showModal;
        },
        createQuotation() {
            if (this.selectedCompany === null) {
                alert('Por favor, seleccione una compañía antes de crear una cotización.');
            } else {
                window.location.href = this.quoteUrl;
            }
        },
        generatePdf(){
         //
      },
    },
    setup() {
        const selectedCompany = ref(null)

        const quoteUrl = computed(() => {
            if (selectedCompany.value) {
                return `/quotations/create/${selectedCompany.value}`
            } else {
                return '#'
            }
        })

        return {
            selectedCompany,
            quoteUrl
        }
    }
}
</script>
