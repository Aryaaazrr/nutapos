<script setup>
import { defineProps, defineEmits } from 'vue'

defineProps({
  modelValue: { type: String, default: '' },
  placeholder: { type: String, default: '' },
})

defineEmits(['update:modelValue'])
</script>

<template>
  <input
    type="text"
    class="modal-input"
    :placeholder="placeholder"
    :v-model="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
  />
</template>

<style scoped>
input {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  margin-bottom: 1.5rem;
}
</style>
