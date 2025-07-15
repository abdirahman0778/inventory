<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
  inheritAttrs: false,
});

interface Props {
  className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
  <img
    src="/images/yiksi.png"
    alt="App Logo"
    class="h-10 w-auto object-contain"
    :class="className"
    v-bind="$attrs"
  />
</template>
