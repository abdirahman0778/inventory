<template>
  <div class="p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">New Sale</h1>

    <div class="mb-4">
      <label class="block mb-1 font-medium">Customer</label>
      <select v-model="customer_id" class="w-full border rounded px-3 py-2">
        <option disabled value="">Select Customer</option>
        <option v-for="customer in customers" :key="customer.id" :value="customer.id">
          {{ customer.name }}
        </option>
      </select>
    </div>

    <div class="mb-4">
      <label class="block mb-2 font-medium">Add Products</label>

      <div v-for="(item, index) in saleItems" :key="index" class="mb-3 border p-3 rounded bg-gray-50">
        <div class="grid grid-cols-3 gap-3">
          <select v-model="item.product_id" class="border rounded px-2 py-1">
            <option disabled value="">Select Product</option>
            <option v-for="product in products" :key="product.id" :value="product.id">
              {{ product.name }} - ${{ product.price }}
            </option>
          </select>

          <input
            type="number"
            v-model.number="item.quantity"
            class="border rounded px-2 py-1"
            min="1"
            placeholder="Quantity"
          />

          <button @click="removeItem(index)" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">
            Remove
          </button>
        </div>
      </div>

      <button @click="addItem" class="mt-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
        + Add Item
      </button>
    </div>

    <div class="mb-4">
      <p class="text-lg font-semibold">Total: ${{ totalAmount }}</p>
    </div>

    <button
      @click="submitSale"
      class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700"
      :disabled="loading"
    >
      {{ loading ? 'Submitting...' : 'Submit Sale' }}
    </button>

    <div v-if="message" class="mt-4 text-green-600 font-semibold">{{ message }}</div>
    <div v-if="error" class="mt-4 text-red-600 font-semibold">{{ error }}</div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

const customers = ref([])
const products = ref([])
const saleItems = ref([{ product_id: '', quantity: 1 }])
const customer_id = ref('')
const message = ref('')
const error = ref('')
const loading = ref(false)

const addItem = () => {
  saleItems.value.push({ product_id: '', quantity: 1 })
}

const removeItem = (index) => {
  saleItems.value.splice(index, 1)
}

const totalAmount = computed(() => {
  return saleItems.value.reduce((total, item) => {
    const product = products.value.find(p => p.id === item.product_id)
    if (product) {
      return total + (product.price * item.quantity)
    }
    return total
  }, 0).toFixed(2)
})

const fetchCustomersAndProducts = async () => {
  try {
    const [customerRes, productRes] = await Promise.all([
      axios.get('/api/customers'),
      axios.get('/api/products'),
    ])
    customers.value = customerRes.data
    products.value = productRes.data
  } catch (err) {
    error.value = 'Failed to load data.'
  }
}

const submitSale = async () => {
  if (!customer_id.value || saleItems.value.length === 0) {
    error.value = 'Please select a customer and add at least one product.'
    return
  }

  try {
    loading.value = true
    error.value = ''
    message.value = ''

    const payload = {
      customer_id: customer_id.value,
      items: saleItems.value.map(item => ({
        product_id: item.product_id,
        quantity: item.quantity,
      })),
    }

    await axios.post('/api/sales', payload)

    message.value = 'Sale submitted successfully.'
    saleItems.value = [{ product_id: '', quantity: 1 }]
    customer_id.value = ''
  } catch (err) {
    error.value = err.response?.data?.message || 'Something went wrong.'
  } finally {
    loading.value = false
  }
}

onMounted(fetchCustomersAndProducts)
</script>

<style scoped>
select,
input {
  width: 100%;
}
</style>
