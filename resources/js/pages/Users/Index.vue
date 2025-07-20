<template>
  <div class="p-6 bg-white rounded shadow-md">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-semibold text-gray-800">Users</h1>
      <Link href="/users/create" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow">
        + Create User
      </Link>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
        <thead>
          <tr class="bg-gray-100 text-left">
            <th class="px-4 py-2 border-b">Name</th>
            <th class="px-4 py-2 border-b">Email</th>
            <th class="px-4 py-2 border-b">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50 transition">
            <td class="px-4 py-2 border-b">{{ user.name }}</td>
            <td class="px-4 py-2 border-b">{{ user.email }}</td>
            <td class="px-4 py-2 border-b">
              <Link :href="`/users/${user.id}/edit`" class="text-indigo-600 hover:underline text-sm font-medium">
                Edit
              </Link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
defineProps({ users: Object })
</script>
