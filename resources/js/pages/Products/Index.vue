<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { useForm, usePage, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { Head } from '@inertiajs/vue3'

// Import Ziggy route helper correctly
import { route } from 'ziggy-js'

interface Product {
  id: number
  name: string
  quantity: number
  price: number
  total: number
}

const props = defineProps<{
  products: Product[]
  totalQuantity: number
}>()

const page = usePage()
const flashSuccess = computed(() => (page.props.flash as any)?.success || '')

const searchTerm = ref('')
const filteredProducts = computed(() =>
  props.products.filter(p =>
    p.name.toLowerCase().includes(searchTerm.value.toLowerCase())
  )
)

const form = useForm({
  id: null as number | null,
  name: '',
  quantity: 0,
  price: 0,
})

function submit() {
  if (form.id) {
    form.put(route('products.update', form.id), {
      onSuccess: () => resetForm(),
    })
  } else {
    form.post(route('products.store'), {
      onSuccess: () => resetForm(),
    })
  }
}

function edit(product: Product) {
  form.id = product.id
  form.name = product.name
  form.quantity = product.quantity
  form.price = product.price
}

function remove(id: number) {
  if (confirm('Are you sure?')) {
    router.delete(route('products.destroy', id), {
      preserveScroll: true,
    })
  }
}

function resetForm() {
  form.reset()
  form.clearErrors()
  form.id = null
}
</script>

<template>
  <AppLayout>
    <Head title="Products" />

    <div class="container">
      <h1 class="text-3xl font-bold text-blue-800  mb-6">
        {{'Product' }} Management
      </h1>

      <div v-if="flashSuccess" class="flash-message">
        {{ flashSuccess }}
      </div>

      <form @submit.prevent="submit" class="bg-white dark:bg-gray-900 rounded-xl shadow p-6 grid grid-cols-1 md:grid-cols-2 gap-6 mb-10 form-grid">
        <input v-model="form.name" type="text" placeholder="Product name" class="input" />
        <input v-model.number="form.quantity" type="number" placeholder="Quantity" class="input" />
        <input v-model.number="form.price" type="number" placeholder="Price" class="input" />
        <button type="submit" class="btn-primary">{{ form.id ? 'Update' : 'Add' }}</button>
      </form>

      <input v-model="searchTerm" placeholder="Search..." class="input search-input" />

      <table class=" product-table">
        <thead>
          <tr>
            <th>Name</th><th>Quantity</th><th>Price</th><th>Total</th><th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in filteredProducts" :key="product.id" class=" table-row">
            <td>{{ product.name }}</td>
            <td>{{ product.quantity }}</td>
            <td>${{ Number(product.price).toFixed(2) }}</td>
            <td>${{ (product.quantity * product.price).toFixed(2) }}</td>
            <td class="actions">
              <button @click="edit(product)" class="btn-edit">Edit</button>
              <button @click="remove(product.id)" class="btn-delete">Delete</button>
            </td>
          </tr>
          <tr v-if="filteredProducts.length === 0">
            <td colspan="5" class="no-data">No products found.</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="5" class="total-qty">Total Quantity: {{ totalQuantity }}</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </AppLayout>
</template>

<style scoped>
.container {
  max-width: 960px;
  margin: auto;
  padding: 24px 16px;
  font-family: Arial, sans-serif;
  color: #111;
}

.title {
  font-size: 28px;
  font-weight: 700;
  margin-bottom: 20px;
  color: #1e40af; /* blue */
}

.flash-message {
  margin-bottom: 16px;
  padding: 12px;
  background-color: #d1fae5;
  color: #065f46;
  border-radius: 6px;
  font-weight: 600;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  margin-bottom: 24px;
}

.input {
  padding: 8px 12px;
  border: 1px solid #cbd5e1;
  border-radius: 6px;
  font-size: 16px;
  transition: border-color 0.3s ease;
}

.input:focus {
  outline: none;
  border-color: #2563eb;
  box-shadow: 0 0 6px rgba(37, 99, 235, 0.5);
}

.search-input {
  width: 100%;
  margin-bottom: 24px;
}

.btn-primary {
  background-color: #2563eb;
  color: white;
  font-weight: 600;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  padding: 10px 16px;
}

.btn-primary:hover {
  background-color: #1d4ed8;
}

.product-table {
  width: 100%;
  border-collapse: collapse;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.product-table thead {
  background-color: #f3f4f6;
  font-weight: 600;
}

.product-table th,
.product-table td {
  padding: 12px 16px;
  border-bottom: 1px solid #e5e7eb;
  text-align: left;
}

.table-row:hover {
  background-color: #eff6ff;
}

.actions button {
  background: none;
  border: none;
  cursor: pointer;
  font-weight: 600;
  margin-right: 12px;
  text-decoration: underline;
  color: #2563eb;
  padding: 0;
  font-size: 14px;
  transition: color 0.2s ease;
}

.actions button:last-child {
  color: #dc2626;
  margin-right: 0;
}

.actions button:hover {
  opacity: 0.8;
}

.no-data {
  text-align: center;
  color: #6b7280;
  padding: 16px 0;
  font-style: italic;
}

.total-qty {
  text-align: right;
  font-weight: 700;
  padding: 12px 16px;
  background-color: #f9fafb;
  border-top: 1px solid #e5e7eb;
}
</style>
