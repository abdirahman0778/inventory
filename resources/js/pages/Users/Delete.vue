<template>
  <div class="p-6 bg-white rounded shadow-md">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Delete User</h1>

    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input :value="user.name" type="text" disabled class="mt-1 w-full border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed" />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input :value="user.email" type="email" disabled class="mt-1 w-full border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed" />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Phone</label>
        <input :value="user.phone" type="text" disabled class="mt-1 w-full border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed" />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Address</label>
        <input :value="user.address" type="text" disabled class="mt-1 w-full border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed" />
      </div>

      <button
        @click="destroy"
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow mt-6"
      >
        Delete User
      </button>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  user: Object,
})

const form = useForm()

const destroy = () => {
  if (confirm('Ma hubtaa inaad tirtirayso user-kan?')) {
    form.delete(`/users/${props.user.id}`)
  }
}
</script>
