<template>
  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="dashboard-container">
      <div class="card-grid">
        <div class="card">
          <PlaceholderPattern />
        </div>
        <div class="card">
          <PlaceholderPattern />
        </div>
        <div class="card">
          <PlaceholderPattern />
        </div>
      </div>
      <div class="full-card">
        <PlaceholderPattern />
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: '/dashboard',
  },
];
</script>

<style scoped>
.dashboard-container {
  padding: 1rem;
  display: flex;
  flex-direction: column;
  gap: 1rem;
  height: 100%;
  overflow-x: auto;
}

.card-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1rem;
}

.card {
  position: relative;
  aspect-ratio: 16 / 9;
  border: 1px solid #d1d5db; /* sidebar-border light */
  border-radius: 12px;
  overflow: hidden;
  background-color: #fff;
}

.full-card {
  position: relative;
  min-height: 100vh;
  border: 1px solid #d1d5db;
  border-radius: 12px;
  overflow: hidden;
  background-color: #fff;
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
  .card,
  .full-card {
    background-color: #1e293b;
    border-color: #334155; /* sidebar-border dark */
  }
}
</style>
