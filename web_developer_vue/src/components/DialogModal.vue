<script setup>
import { defineProps, defineEmits } from 'vue'

defineProps({
  open: { type: Boolean, default: false },
  title: { type: String, default: '' },
})

const emit = defineEmits(['update:open', 'submit'])

function closeModal() {
  emit('update:open', false)
}

function handleSubmit(e) {
  e.preventDefault()
  emit('submit', e)
  closeModal()
}
</script>

<template>
  <div v-if="open" class="modal-backdrop" @click.self="closeModal">
    <div class="modal">
      <form @submit="handleSubmit">
        <h2 class="modal-title">{{ title }}</h2>
        <slot />
        <div class="modal-actions">
          <slot name="actions"></slot>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
.modal-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.4);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 50;
}
.modal {
  background: white;
  padding: 2rem;
  border-radius: 1rem;
  width: 420px;
  max-width: 90%;
}
.modal-title {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 1rem;
}
.modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 0.5rem;
}
</style>
