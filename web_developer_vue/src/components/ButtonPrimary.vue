<script setup>

defineProps({
  text: {
    type: String,
    default: 'Belum Ada Data',
  },
})
</script>

<template>
  <button class="btn-primary">
    <slot />
    {{ text }}
  </button>
</template>

<style>
.btn-primary {
  background: var(--color-button);
  color: white;
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

.btn-primary .icon {
  color: white;
  font-weight: 800;
}

.btn-primary:hover {
  background-color: var(--color-button-hover);
}
</style>
