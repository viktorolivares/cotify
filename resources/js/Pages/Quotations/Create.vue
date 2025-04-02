<template>
  <div>

    <Head title="Create Quotation" />
    <div class="mx-auto p-6 bg-white dark:bg-indigo-900 rounded shadow-2xl">
      <!-- Company Information -->
      <template v-if="company">
        <div class="border-b-2 border-indigo-800 pb-2 text-gray-600 dark:text-gray-300">
          <img v-if="logo" :src="logo" class="bg-gray-100 p-4 rounded-lg shadow-md" alt="company-logo">
          <p class="mt-4 text-2xl text-green-600 font-semibold">
            {{ company.trade_name }}
          </p>
          <p class="text-lg">
            {{ company.address }}
          </p>
          <p class="text-lg">
            {{ company.department.description }} - {{ company.province.description }} - {{ company.district.description
            }}
          </p>
          <p class="text-lg">
            {{ company.email }} - {{ company.phone }}
          </p>
          <p class="text-lg">
            RUC: {{ company.number }}
          </p>
        </div>
      </template>

      <!-- Client Information -->
      <div class="grid grid-cols-4 gap-8 items-center mt-8">
        <div class="col-span-4 sm:col-span-2 md:col-span-1">
          <label class="form-label">
            Establishments
          </label>
          <div class="relative">
            <select class="form-select dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
              v-model="form.establishment_id">
              <option value="" disabled selected>Selected a Establishment</option>
              <option v-for="establishment in company.establishments" :value="establishment.id" :key="establishment.id">
                {{ establishment.description }}
              </option>
            </select>
            <span class="form-error" v-if="form.errors.establishment_id">
              {{ form.errors.establishment_id }}
            </span>
          </div>
        </div>

        <select-input class="col-span-4 sm:col-span-2 md:col-span-1" v-model="form.customer_id" search-property="name"
          :options="persons" label="Client" :error="form.errors.customer_id"></select-input>
        <text-input v-model="form.date_of_issue" type="date" label="Date of issue"
          class="col-span-4 sm:col-span-2 md:col-span-1" />
        <text-input v-model="form.delivery_date" type="date" label="Delivery date"
          class="col-span-4 sm:col-span-2 md:col-span-1" />
        <text-input v-model="form.date_of_due" type="date" label="Date of due"
          class="col-span-4 sm:col-span-2 md:col-span-1" />
        <text-input disabled v-model="selectedExchange" label="Exchange Rate"
          class="col-span-4 sm:col-span-2 md:col-span-1" />

        <div class="col-span-4 sm:col-span-2 md:col-span-1">
          <label class="form-label">
            Payment Method
          </label>
          <div class="relative">
            <select class="form-select dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
              v-model="selectedPaymentMethod">
              <option v-for="paymentMethod in paymentMethods" :value="paymentMethod.id" :key="paymentMethod.id">
                {{ paymentMethod.description }}
              </option>
            </select>
            <span class="form-error" v-if="form.errors.payment_method_type_id">
              {{ form.errors.payment_method_type_id }}
            </span>
          </div>
        </div>

        <div class="col-span-4 sm:col-span-2 md:col-span-1">
          <label class="form-label">
            Currency
          </label>
          <div class="relative">
            <select class="form-select dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
              v-model="selectedCurrency">
              <option v-for="currency in currencies" :value="currency.id" :key="currency.id">
                {{ currency.description }}
              </option>
            </select>
            <span class="form-error" v-if="form.errors.currency_type_id">
              {{ form.errors.currency_type_id }}
            </span>
          </div>
        </div>

      </div>

      <button @click="onToggle"
        class="rounded-2xl py-2 px-4 bg-blue-700 hover:bg-blue-800 mt-6 text-sm font-semibold text-indigo-100">
        ✚ Add Product
      </button>

      <!-- Elementos de la factura -->
      <div v-if="form.items.length > 0" class="-mx-4 mt-8 flow-root sm:mx-0 text-gray-500 dark:text-gray-200">
        <div class="relative overflow-x-auto">
          <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-indigo-800 dark:text-gray-400">
              <tr>
                <th scope="col" class="px-6 py-3">Product name</th>
                <th scope="col" class="px-6 py-3">Unity</th>
                <th scope="col" class="px-6 py-3 text-right">Quantity</th>
                <th scope="col" class="px-6 py-3 text-right">Unit Value</th>
                <th scope="col" class="px-6 py-3 text-right">Unit price</th>
                <th scope="col" class="px-6 py-3 text-right">Subtotal</th>
                <th scope="col" class="px-6 py-3 text-right">Total</th>
                <th scope="col" class="px-6 py-3 text-right"></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in form.items" :key="index"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  <div class="font-medium ">{{ item.name }}</div>
                  <div class="mt-1 truncate text-gray-500">{{ item.description }}</div>
                </th>
                <td class="px-6 py-4">{{ item.unit_type_id }}</td>
                <td class="px-6 py-4 text-right">{{ item.quantity }}</td>
                <td class="px-6 py-4 text-right">{{ item.unit_value }}</td>
                <td class="px-6 py-4 text-right">{{ item.unit_price }}</td>
                <td class="px-6 py-4 text-right">{{ item.subtotal }}</td>
                <td class="px-6 py-4 text-right">{{ item.total }}</td>
                <td class="px-6 py-4 text-right">
                  <button @click="removeProduct(index)"
                    class="bg-red-600 font-bold rounded-md px-3 py-1 text-gray-100">✗</button>
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <th scope="row" colspan="7"
                  class="pl-4 pr-3 pt-5 text-right text-sm font-bold dark:text-gray-200 text-gray-500 sm:table-cell sm:pl-0">
                  OP. GRAVADA
                </th>
                <td class="pl-3 pr-6 pt-5 text-right text-sm text-gray-500 font-bold dark:text-gray-200 sm:pr-0">{{
                  form.subtotal }}</td>
              </tr>
              <tr>
                <th scope="row" colspan="7"
                  class="pl-4 pr-3 pt-2 text-right text-sm font-bold dark:text-gray-200 text-gray-500 sm:table-cell sm:pl-0">
                  IGV:
                </th>
                <td class="pl-3 pr-6 pt-2 text-right text-sm text-gray-500 font-bold dark:text-gray-200 sm:pr-0">
                  {{ form.total_igv }}
                </td>
              </tr>
              <tr>
                <th scope="row" colspan="7"
                  class="pl-4 pr-3 pt-2 text-right text-sm text-red-600 font-bold dark:text-red-500 sm:table-cell sm:pl-0">
                  Discount
                </th>
                <td class="pl-3 pr-6 pt-2 text-right text-sm text-red-600 font-bold dark:text-red-500 sm:pr-0">
                  ({{ form.total_discount }})
                </td>
              </tr>
              <tr>
                <th scope="row" colspan="7"
                  class="pl-4 pr-3 pt-2 text-right text-sm text-emerald-600 font-bold dark:text-emerald-500 sm:table-cell sm:pl-0">
                  Charge
                </th>
                <td class="pl-3 pr-6 pt-2 text-right text-sm text-emerald-600 font-bold dark:text-emerald-500 sm:pr-0">
                  ({{ form.total_charge }})
                </td>
              </tr>
              <tr>
                <th scope="row" colspan="7"
                  class="pl-4 pr-3 pt-2 text-right text-lg font-bold dark:text-blue-600 text-gray-800 sm:table-cell sm:pl-0">
                  Total</th>
                <td class="pl-3 pr-4 pt-4 text-right text-lg font-bold dark:text-blue-600 text-gray-800 sm:pr-0">
                  {{ form.total }}
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
        <hr class="mt-4 border-gray-300 dark:border-gray-600" />

        <!-- Save Button -->
        <div class="float-end">
          <button @click="store"
            class="rounded-2xl ms-2 py-2 px-8 bg-green-700 hover:bg-green-800 mt-6 text-sm font-semibold text-indigo-100">🖫
            Save Quotation
          </button>
        </div>
      </div>
    </div>

    <!-- Modal para agregar producto -->
    <modal v-if="showModal" size="3xl" title="Add Product" @close="onToggle">
      <div class="grid gap-4 grid-cols-4">
        <text-input v-model="newProduct.name" label="Name" class="col-span-2" />
        <text-input v-model="newProduct.description" label="Description" class="col-span-2" />

        <div class="col-span-2">
          <label class="form-label">
            Affectation IGV
          </label>
          <div class="relative">
            <select class="form-select dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
              v-model="newProduct.affectation_igv_type_id" disabled>
              <option v-for="affectation in affectation_igv_type" :value="affectation.id" :key="affectation.id">
                {{ affectation.description }}
              </option>
            </select>
            <span class="form-error" v-if="form.errors.affectation_igv_type_id">
              {{ form.errors.affectation_igv_type_id }}
            </span>
          </div>
        </div>

        <div class="col-span-2">
          <label class="form-label">
            Unit Type
          </label>
          <div class="relative">
            <select class="form-select dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
              v-model="newProduct.unit_type_id">
              <option v-for="unitType in unitTypes" :value="unitType.id" :key="unitType.id">
                {{ unitType.description }}
              </option>
            </select>
            <span class="form-error" v-if="form.errors.unit_type_id">
              {{ form.errors.unit_type_id }}
            </span>
          </div>
        </div>

        <div class="col-span-1">
          <label class="form-label">
            Incluido IGV?
          </label>
          <div class="relative">
            <select class="form-select dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
              v-model="selectedIgv">
              <option :value="1" selected>Sí</option>
              <option :value="0">No</option>
            </select>
          </div>
        </div>

        <text-input v-model="newProduct.quantity" min="0" label="Quantity" type="number" class="col-span-1" />
        <text-input v-model="selectedPrice" min="0" label="Price - S/" type="number" class="col-span-1" />
        <text-input v-model="newProduct.discount" disabled min="0" max="100" label="Discount %" type="number" class="col-span-1" />
        <text-input v-model="newProduct.charge" type="hidden"/>
      </div>
      <div class="my-5">
        <button @click="addProduct"
          class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
          Add new product
        </button>
        <button
          class="float-end text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
          @click="onToggle">
          Close
        </button>
      </div>
    </modal>

  </div>
</template>

<script>
import { Head } from '@inertiajs/vue3'
import Layout from '@/Layout/Layout.vue'
import TextInput from '@/Shared/TextInput.vue'
import SelectInput from '@/Shared/SelectInput.vue'
import Modal from '../../Shared/Modal.vue'

export default {
  components: {
    Head,
    TextInput,
    SelectInput,
    Modal,
  },
  props: {
    exchangeRate: Object,
    company: Object,
    persons: Array,
    logo: String,
  },
  layout: Layout,
  data() {
    return {
      showModal: false,
      form: this.$inertia.form({
        user_id: null,
        establishment_id: this.company.establishments[0].id,
        date_of_issue: null,
        date_of_due: null,
        delivery_date: null,
        state_type_id: null,
        customer_id: null,
        currency_type_id: null,
        payment_method_type_id: null,
        exchange_rate_sale: 0,
        total_charge: 0,
        total_discount: 0,
        total_igv: 0,
        subtotal: 0,
        total: 0,
        items: [],
      }),

      selectedExchange: this.exchangeRate.data.sale,
      selectedPaymentMethod: '01',
      selectedCurrency: 'PEN',
      selectUnitType: 'NIU',
      selectedIgv: true,
      selectedPrice: 0,

      newProduct: {
        name: null,
        description: null,
        unit_type_id: 'NIU',
        affectation_igv_type_id: 10,
        includes_igv: true,
        quantity: 0,
        unit_value: 0,
        unit_price: 0,
        discount: 0,
        charge: 0,
        igv: 0,
        subtotal: 0,
        total: 0,
      },

      affectation_igv_type: [
        { id: 10, description: 'Gravado – Operación Onerosa' },
      ],

      currencies: [
        { id: 'PEN', description: 'Soles' },
        { id: 'USD', description: 'Dólares Americanos' }
      ],

      paymentMethods: [
        { id: '01', description: 'Efectivo' },
        { id: '02', description: 'Crédito' },
        { id: '03', description: 'Tarjeta de Crédito' },
        { id: '04', description: 'Tarjeta de Débito' },
        { id: '05', description: 'Transferencia' },
        { id: '06', description: 'Contado contraentrega' },
        { id: '07', description: 'Factura a 30 días' },
      ],

      unitTypes: [
        { id: 'ZZ', description: 'Servicio' },
        { id: 'BX', description: 'Caja' },
        { id: 'GLL', description: 'Galones' },
        { id: 'GRM', description: 'Gramos' },
        { id: 'KGM', description: 'Kilos' },
        { id: 'LTR', description: 'Litros' },
        { id: 'MTR', description: 'Metros' },
        { id: 'FOT', description: 'Pies' },
        { id: 'INH', description: 'Pulgadas' },
        { id: 'NIU', description: 'Unidades' },
        { id: 'YRD', description: 'Yardas' },
        { id: 'HUR', description: 'Hora' },
      ],

    };
  },
  computed: {
    isModalVisible() {
      return this.showModal;
    },
    computedUnitPrice() {
      const price = Number(this.selectedPrice);
      return this.selectedIgv ? (price / 1.18).toFixed(2) : (price * 1.18).toFixed(2);
    },
    computedIgv() {
      const totalTax = 0.18;
      const price = Number(this.selectedPrice);
      const quantity = Number(this.newProduct.quantity);

      if (this.selectedIgv) {
        const igvIncluded = (price - (price / (1 + totalTax))) * quantity;
        return igvIncluded.toFixed(2);
      } else {
        const igvExcluded = (price * totalTax) * quantity;
        return igvExcluded.toFixed(2);
      }
    }
  },
  methods: {
    onToggle() {
      this.showModal = !this.showModal;
      this.resetNewProduct();
    },
    addProduct() {
      if (
        !this.selectedPrice ||
        !this.newProduct.name ||
        !this.newProduct.affectation_igv_type_id ||
        !this.newProduct.quantity ||
        !this.newProduct.unit_type_id ||
        this.newProduct.discount === null
      ) {
        alert('Please fill all the fields');
        console.log(this.newProduct);
        return;
      }

      const newItem = { ...this.newProduct };

      if (this.selectedIgv) {
        newItem.unit_value = this.computedUnitPrice;
        newItem.unit_price = this.selectedPrice;

      } else {
        newItem.unit_value = this.selectedPrice;
        newItem.unit_price = this.computedUnitPrice;
      }

      newItem.igv = this.computedIgv;
      newItem.includes_igv = this.selectedIgv;

      console.log(newItem);
      newItem.subtotal = (newItem.unit_value * newItem.quantity).toFixed(2);
      newItem.total = (newItem.unit_price * newItem.quantity).toFixed(2);
      const discountAmount = (newItem.unit_price * newItem.discount / 100).toFixed(2);

      this.form.items.push(newItem);

      console.log(newItem);
      this.calculateTotals();
      this.resetNewProduct();
      this.onToggle();
    },
    calculateTotals() {
      this.form.subtotal = this.form.items.reduce((acc, item) => acc + parseFloat(item.subtotal), 0).toFixed(2);
      this.form.total_igv = this.form.items.reduce((acc, item) => acc + parseFloat(item.igv), 0).toFixed(2);
      this.form.total_charge = (0).toFixed(2);
      this.form.total_discount = this.form.items.reduce((acc, item) => acc + parseFloat(item.unit_value * item.quantity * item.discount / 100), 0).toFixed(2);
      this.form.total = Number(parseFloat(this.form.subtotal) + parseFloat(this.form.total_igv) - parseFloat(this.form.total_discount)).toFixed(2);

    },
    resetNewProduct() {
      this.newProduct = {
        name: '',
        description: '',
        affectation_igv_type_id: 10,
        includes_igv: true,
        unit_type_id: 'NIU',
        discount: 0,
        charge: 0,
        quantity: 0,

      };

      this.selectedPrice = 0
    },
    removeProduct(index) {
      this.form.items.splice(index, 1);
      this.calculateTotals();
    },
    store() {
      this.form.exchange_rate_sale = this.selectedExchange
      this.form.payment_method_type_id = this.selectedPaymentMethod
      this.form.currency_type_id = this.selectedCurrency
      console.log(this.form);

      this.form.post('/quotations')
    }
  },
  watch: {
    selectedIgv(newValue) {
      this.newProduct.unit_price = this.computedUnitPrice;
    },
    'newProduct.unit_value': function () {
      this.newProduct.unit_price = this.computedUnitPrice;
    }
  },
}
</script>
