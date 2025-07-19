<template>
  <div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Sales</h1>

    <form @submit.prevent="submit">
      <div class="mb-3">
        <label class="block font-medium">Customer</label>
        <select v-model="form.customer_id" class="border p-2 w-full">
          <option disabled value="">Select customer</option>
          <option v-for="customer in customers" :key="customer.id" :value="customer.id">
            {{ customer.name }}
          </option>
        </select>
      </div>

      <div class="mb-3">
        <label class="block font-medium">Product</label>
        <select v-model="form.product_id" class="border p-2 w-full">
          <option disabled value="">Select product</option>
          <option v-for="product in products" :key="product.id" :value="product.id">
            {{ product.name }} (Stock: {{ product.quantity }}, Price: {{ product.price }})
          </option>
        </select>
      </div>

      <div class="mb-3">
        <label class="block font-medium">Quantity</label>
        <input type="number" v-model="form.quantity" class="border p-2 w-full" min="1" />
      </div>

      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit Sale</button>
    </form>
  </div>
</template>

<script setup>
import { reactive } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';

const { customers, products } = usePage().props;

const form = useForm({
  customer_id: '',
  product_id: '',
  quantity: 1,
});

function submit() {
  form.post('/sales');
}
</script>