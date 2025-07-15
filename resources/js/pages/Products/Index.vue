<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { useForm, usePage, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { Head } from '@inertiajs/vue3'

// ✅ Import Ziggy route helper correctly
import { route } from 'ziggy-js'

// ✅ Product interface
interface Product {
  id: number
  name: string
  quantity: number
  price: number
  total: number
}

// ✅ Props from backend
const props = defineProps<{
  products: Product[]
  totalQuantity: number
}>()

// ✅ Flash success message
const page = usePage()
const flashSuccess = computed(() => (page.props.flash as any)?.success || '')

// ✅ Search
const searchTerm = ref('')
const filteredProducts = computed(() =>
  props.products.filter(p =>
    p.name.toLowerCase().includes(searchTerm.value.toLowerCase())
  )
)

// ✅ Form
const form = useForm({
  id: null as number | null,
  name: '',
  quantity: 0,
  price: 0,
})

// ✅ Add / Update
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

    <div class="max-w-6xl mx-auto py-6 px-4">
      <h1 class="text-2xl font-bold mb-4">Product Management</h1>

      <!-- ✅ Flash Message -->
      <div v-if="flashSuccess" class="mb-4 p-3 bg-green-100 text-green-800 rounded">
        {{ flashSuccess }}
      </div>

      <!-- ✅ Form -->
      <form @submit.prevent="submit" class="grid grid-cols-4 gap-4 mb-6">
        <input v-model="form.name" type="text" placeholder="Product name" class="p-2 border rounded col-span-1" />
        <input v-model.number="form.quantity" type="number" placeholder="Quantity" class="p-2 border rounded col-span-1" />
        <input v-model.number="form.price" type="number" placeholder="Price" class="p-2 border rounded col-span-1" />
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
          {{ form.id ? 'Update' : 'Add' }}
        </button>
      </form>

      <!-- ✅ Search -->
      <input v-model="searchTerm" placeholder="Search..." class="mb-4 p-2 border rounded w-full" />

      <!-- ✅ Product Table -->
      <table class="w-full border rounded overflow-hidden">
        <thead class="bg-gray-100">
          <tr>
            <th class="text-left p-2">Name</th>
            <th class="text-left p-2">Quantity</th>
            <th class="text-left p-2">Price</th>
            <th class="text-left p-2">Total</th>
            <th class="text-left p-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in filteredProducts" :key="product.id" class="border-t">
            <td class="p-2">{{ product.name }}</td>
            <td class="p-2">{{ product.quantity }}</td>
            <td class="p-2">${{ Number(product.price).toFixed(2) }}</td>
            <td class="p-2">${{ (product.quantity * product.price).toFixed(2) }}</td>
            <td class="p-2 space-x-2">
              <button @click="edit(product)" class="text-blue-600 hover:underline">Edit</button>
              <button @click="remove(product.id)" class="text-red-600 hover:underline">Delete</button>
            </td>
          </tr>
        </tbody>
        <tfoot class="bg-gray-50">
          <tr>
            <td colspan="5" class="p-2 text-right font-semibold">
              Total Quantity: {{ totalQuantity }}
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  </AppLayout>
</template>
