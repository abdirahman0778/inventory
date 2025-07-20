<template>
  <div class="p-6 bg-white rounded shadow-md">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit User</h1>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input v-model="form.name" type="text" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
        <p v-if="form.errors.name" class="text-sm text-red-500 mt-1">{{ form.errors.name }}</p>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input v-model="form.email" type="email" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Password (leave blank to keep current)</label>
        <input v-model="form.password" type="password" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <input v-model="form.password_confirmation" type="password" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Phone</label>
        <input v-model="form.phone" type="text" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Address</label>
        <input v-model="form.address" type="text" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" />
      </div>

      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow">
        Update User
      </button>
    </form>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({ user: Object })

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  password: '',
  password_confirmation: '',
  phone: props.user.phone,
  address: props.user.address,
})

const submit = () => {
  form.put(`/users/${props.user.id}`)
}
</script>
