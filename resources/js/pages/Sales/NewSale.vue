<template>
  <div class="p-6 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">New Sale</h1>

    <!-- Customer -->
    <div class="mb-4">
      <label class="block font-semibold">Customer</label>
      <select v-model="form.customer_id" class="w-full p-2 border rounded">
        <option disabled value="">Select Customer</option>
        <option v-for="customer in customers" :key="customer.id" :value="customer.id">
          {{ customer.name }}
        </option>
      </select>
    </div>

    <!-- Product -->
    <div class="mb-4">
      <label class="block font-semibold">Add Product</label>
      <select v-model="selectedProductId" @change="addProduct" class="w-full p-2 border rounded">
        <option disabled value="">Select Product</option>
        <option v-for="product in products" :key="product.id" :value="product.id">
          {{ product.name }} ({{ product.quantity }} in stock) - ${{ product.price }}
        </option>
      </select>
    </div>

    <!-- Selected Items -->
    <div v-if="form.items.length" class="overflow-x-auto">
      <table class="w-full border-collapse">
        <thead>
          <tr class="bg-gray-100">
            <th class="p-2 border">Product</th>
            <th class="p-2 border">Price</th>
            <th class="p-2 border">Quantity</th>
            <th class="p-2 border">Total</th>
            <th class="p-2 border">Remove</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in form.items" :key="item.product_id">
            <td class="p-2 border">{{ item.name }}</td>
            <td class="p-2 border">${{ item.price }}</td>
            <td class="p-2 border">
              <input type="number" v-model.number="item.quantity" :max="item.stock" min="1" class="w-20 p-1 border rounded">
            </td>
            <td class="p-2 border">${{ (item.price * item.quantity).toFixed(2) }}</td>
            <td class="p-2 border text-center">
              <button @click="removeItem(index)" class="text-red-600 font-bold">X</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Submit -->
    <div class="mt-6">
      <button @click="submitSale" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
        Submit Sale
      </button>
    </div>
  </div>
</template>

<script>
import { ref, reactive, onMounted } from 'vue'
import axios from 'axios'
import { router } from '@inertiajs/vue3'

export default {
  setup() {
    const customers = ref([])
    const products = ref([])
    const selectedProductId = ref('')

    const form = reactive({
      customer_id: '',
      items: []
    })

    // Fetch data on mount
    onMounted(async () => {
      const [customersRes, productsRes] = await Promise.all([
        axios.get('/api/customers'),
        axios.get('/api/products')
      ])
      customers.value = customersRes.data
      products.value = productsRes.data
    })

    const addProduct = () => {
      const product = products.value.find(p => p.id === selectedProductId.value)
      if (!product) return

      if (form.items.find(i => i.product_id === product.id)) {
        alert('Product already added')
        return
      }

      form.items.push({
        product_id: product.id,
        name: product.name,
        price: product.price,
        quantity: 1,
        stock: product.quantity
      })

      selectedProductId.value = ''
    }

    const removeItem = index => {
      form.items.splice(index, 1)
    }

    const submitSale = async () => {
      if (!form.customer_id) {
        alert('Please select a customer')
        return
      }
      if (form.items.length === 0) {
        alert('Please add at least one product')
        return
      }

      try {
        const payload = {
          customer_id: form.customer_id,
          items: form.items.map(i => ({
            product_id: i.product_id,
            quantity: i.quantity,
            price: i.price,
          }))
        }

        await axios.post('/sales', payload)
        alert('Sale successful!')
        router.visit('/dashboard') // redirect after success
      } catch (error) {
        console.error(error)
        alert(error.response?.data?.error || 'Error processing sale')
      }
    }

    return {
      customers,
      products,
      form,
      selectedProductId,
      addProduct,
      removeItem,
      submitSale
    }
  }
}
</script>

<style scoped>
th, td {
  text-align: left;
}
</style>
