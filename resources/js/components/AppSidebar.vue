<script setup lang="ts">
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
  Sidebar, SidebarContent, SidebarFooter,
  SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem
} from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import {
  LayoutGrid, Users, ShoppingCart, Boxes, UserPlus
} from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
  { title: 'Dashboard', href: '/dashboard', icon: LayoutGrid },
  { title: 'Customers', href: '/customers', icon: Users },
  { title: 'Sales', href: '/sales', icon: ShoppingCart },
  { title: 'Products', href: '/products', icon: Boxes },
  { title: 'Create Users', href: '/users', icon: UserPlus },
];
</script>

<template>
  <div class="bg-red-20  border border-blue-500 rounded-lg shadow-lg p-6 sidebar-wrapper">
    <Sidebar class="custom-sidebar" collapsible="icon" variant="inset">
      <SidebarHeader class="sidebar-header">
        <SidebarMenu>
          <SidebarMenuItem>
            <SidebarMenuButton size="lg" as-child class="logo-button">
              <Link :href="route('dashboard')" class="logo-link">
                <AppLogo />
              </Link>
            </SidebarMenuButton>
          </SidebarMenuItem>
        </SidebarMenu>
      </SidebarHeader>

      <SidebarContent class="sidebar-content">
        <NavMain :items="mainNavItems" />
      </SidebarContent>

      <SidebarFooter class="sidebar-footer">
        <NavUser />
      </SidebarFooter>
    </Sidebar>
    <slot />
  </div>
</template>

<style scoped>
.custom-sidebar {
  width: 240px;
  background-color: #fff;
  border-right: 1px solid #ddd;
  border-radius: 8px 0 0 8px;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.05);
  font-family: sans-serif;
  display: flex;
  flex-direction: column;
  transition: all 0.3s ease;
}

.sidebar-header,
.sidebar-footer {
  padding: 1rem;
  border-bottom: 1px solid #eee;
  background-color: #fafafa;
  text-align: center;
}

.sidebar-footer {
  border-top: 1px solid #eee;
  border-bottom: none;
}

.sidebar-content {
  flex: 1;
  padding: 1rem;
  overflow-y: auto;
}

/* Example menu item inside NavMain.vue */
.sidebar-menu a {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 0.6rem 1rem;
  border-radius: 6px;
  color: #333;
  text-decoration: none;
  transition: background 0.2s ease;
}

.sidebar-menu a:hover {
  background-color: #f0f0f0;
  color: #000;
}

.sidebar-menu a.active {
  background-color: #16a34a;
  color: white;
}

.icon {
  width: 20px;
  height: 20px;
}

/* Scrollbar small touch */
.sidebar-content::-webkit-scrollbar {
  width: 5px;
}

.sidebar-content::-webkit-scrollbar-thumb {
  background: rgba(0, 0, 0, 0.1);
  border-radius: 3px;
}

</style>
