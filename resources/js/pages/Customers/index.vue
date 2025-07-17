<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { useForm, router, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps<{
  customers: Array<{ id: number; name: string; email: string; phone: string; address: string }>
}>();

const editing = ref(false);
const selectedCustomerId = ref<number|null>(null);

const form = useForm({
  name: '',
  email: '',
  phone: '',
  address: ''
});

const submit = () => {
  if (editing.value && selectedCustomerId.value !== null) {
    form.put(route('customers.update', selectedCustomerId.value), {
      onSuccess: () => {
        editing.value = false;
        selectedCustomerId.value = null;
        form.reset();
      }
    });
  } else {
    form.post(route('customers.store'), {
      onSuccess: () => form.reset()
    });
  }
};

const editCustomer = (customer: { id: number; name: string; email: string; phone: string; address: string }) => {
  form.name = customer.name;
  form.email = customer.email;
  form.phone = customer.phone;
  form.address = customer.address;
  selectedCustomerId.value = customer.id;
  editing.value = true;
};

const deleteCustomer = (id: number) => {
  if (confirm('Are you sure you want to delete this customer?')) {
    router.delete(route('customers.destroy', id));
  }
};
</script>

<template>
  <Head title="Customers" />
  <AppLayout>
    <div class="p-6 max-w-6xl mx-auto">
      <h1 class="text-3xl font-bold text-blue-800  mb-6">
        {{ editing ? 'Edit' : 'Create' }} Customer
      </h1>

      <form @submit.prevent="submit" class="bg-white dark:bg-gray-900 rounded-xl shadow p-6 grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <div>
          <label class="text-white mb-1 font-semibold">Name</label>
          <input v-model="form.name" type="text" placeholder="Enter name" class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded bg-white dark:bg-gray-800 text-black dark:text-white" />
        </div>

        <div>
          <label class="text-white mb-1 font-semibold">Email</label>
          <input v-model="form.email" type="email" placeholder="Enter email" class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded bg-white dark:bg-gray-800 text-black dark:text-white" />
        </div>

        <div class="md:col-span-2">
          <label class="text-white mb-1 font-semibold">Phone</label>
          <input v-model="form.phone" type="text" placeholder="Enter Phone" class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded bg-white dark:bg-gray-800 text-black dark:text-white" />
        </div>

        <div class="md:col-span-2">
          <label class="text-white mb-1 font-semibold">Address</label>
          <input v-model="form.address" type="text" placeholder="Enter address" class="w-full border border-gray-300 dark:border-gray-700 p-2 rounded bg-white dark:bg-gray-800 text-black dark:text-white" />
        </div>

        <div class="md:col-span-2 flex space-x-2 mt-2">
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
            {{ editing ? 'Update' : 'Add' }}
          </button>
          <button
            type="button"
            v-if="editing"
            @click="() => { editing = false; selectedCustomerId = null; form.reset(); }"
            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded shadow"
          >
            Cancel
          </button>
        </div>
      </form>

      <div>
        <h2 class="text-blue-800 text-2xl  font-semibold  mb-4">Customer List</h2>
        <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
          <table class="min-w-full text-left">
            <thead class="bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200">
              <tr>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Phone</th>
                <th class="px-4 py-2">Address</th>
                <th class="px-4 py-2 text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="customer in customers" :key="customer.id" class="border-t border-gray-200 text-white dark:text-gray-300">
                <td class="px-4 py-2">{{ customer.name }}</td>
                <td class="px-4 py-2">{{ customer.email }}</td>
                <td class="px-4 py-2">{{ customer.phone }}</td>
                <td class="px-4 py-2">{{ customer.address }}</td>
                <td class="px-4 py-2 flex justify-center space-x-4">
                  <button @click="editCustomer(customer)" class="text-blue-600 hover:underline">Edit</button>
                  <button @click="deleteCustomer(customer.id)" class="text-red-600 hover:underline">Delete</button>
                </td>
              </tr>
              <tr v-if="customers.length === 0">
                <td colspan="5" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">No customers found.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AppLayout>
</template>


