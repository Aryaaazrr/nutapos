<script setup>
defineProps({
  text: {
    type: String,
    default: 'Belum Ada Data',
  },
})
</script>

<template>
  <button class="btn-secondary">
    <slot />
    {{ text }}
  </button>
</template>

<style>
.btn-secondary {
  background: #f0fbef;
  color: var(--color-button);
  padding: 8px 24px 8px 16px;
  border-radius: 1.25rem;
  border: none;
  font-weight: 600;
  cursor: pointer;
  height: 40px;
  display: inline-flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 0.5rem;
  transition: all;
  transition-duration: 300ms;
}

.btn-secondary .icon {
  color: var(--color-button);
  font-weight: 800;
}

.btn-secondary:hover {
  background-color: #d7f0d5;
}
</style>
