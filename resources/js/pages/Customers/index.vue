<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

defineProps<{
  customers: Array<{ id: number; name: string; email: string; phone: string }>
}>();

const form = useForm({
  name: '',
  email: '',
  phone: ''
});

const submit = () => {
  form.post(route('customers.store'));
};
</script>

<template>
  <Head title="Customers" />
  <AppLayout>
    <div class="p-6 space-y-8">
      <h1 class="text-2xl font-bold">Create New Customer</h1>

      <form @submit.prevent="submit" class="space-y-4 max-w-md">
        <input v-model="form.name" type="text" placeholder="Name" class="w-full border p-2 rounded" />
        <input v-model="form.email" type="email" placeholder="Email" class="w-full border p-2 rounded" />
        <input v-model="form.phone" type="text" placeholder="Phone" class="w-full border p-2 rounded" />
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Add Customer</button>
      </form>

      <h2 class="text-xl font-semibold mt-10">Customer List</h2>
      <div class="overflow-x-auto">
        <table class="w-full text-left border mt-2">
          <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
              <th class="px-4 py-2">Name</th>
              <th class="px-4 py-2">Email</th>
              <th class="px-4 py-2">Phone</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="customer in customers" :key="customer.id" class="border-t">
              <td class="px-4 py-2">{{ customer.name }}</td>
              <td class="px-4 py-2">{{ customer.email }}</td>
              <td class="px-4 py-2">{{ customer.phone }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>
