<script setup>
import { ref } from 'vue'
import { ChevronDown, Store } from 'lucide-vue-next'

defineProps({
  outlets: {
    type: Array,
    default: () => [
      { id: 1, name: 'Kopi Anak Bangsa' },
    ],
  },
  modelValue: {
    type: Object,
    default: () => ({}),
  },
  dropdownClass: {
    type: [String, Object, Array],
    default: ''
  },
  dropdownStyle: {
    type: [String, Object],
    default: ''
  }
})

const emit = defineEmits(['update:modelValue'])

const isOpen = ref(false)

function toggleDropdown() {
  isOpen.value = !isOpen.value
}

function selectOutlet(outlet) {
  emit('update:modelValue', outlet)
  isOpen.value = false
}
</script>

<template>
  <div class="outlet-select">
    <!-- Selected -->
    <button class="outlet-button" @click="toggleDropdown">
      <span class="icon">
        <Store />
      </span>
      <span class="label">
        {{ modelValue.name || 'Pilih Outlet' }}
      </span>
      <span class="arrow"><ChevronDown /></span>
    </button>

    <!-- Dropdown -->
    <ul v-if="isOpen" class="dropdown">
      <li v-for="outlet in outlets" :key="outlet.id"  @click="selectOutlet(outlet)">
        {{ outlet.name }}
      </li>
    </ul>
  </div>
</template>

<style scoped>
.outlet-select {
  position: relative;
  display: inline-block;
}

.outlet-button {
  display: inline-flex;
  align-items: center;
  text-align: center;
  gap: 0.5rem;
  padding: .375rem 1rem;
  border: 1px solid #CDD2D5;
  border-radius: 12px;
  background: #fff;
  cursor: pointer;
  font-size: 0.875rem;
  font-weight: 400;
  min-width: 200px;
  height: 40px;
  color: #4B5258;
}

.outlet-button:hover {
  background: #f9fafb;
}

.label {
  flex: 1;
  text-align: left;
}

.arrow {
  font-size: 0.75rem;
  color: #6b7280;
}

/* Dropdown */
.dropdown {
  position: absolute;
  top: 110%;
  left: 0;
  right: 0;
  background: white;
  border: 1px solid #e5e7eb;
  border-radius: 0.5rem;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  margin: 0;
  padding: 0.5rem 0;
  list-style: none;
  z-index: 10;
}

.dropdown li {
  padding: 0.5rem 1rem;
  cursor: pointer;
}

.dropdown li:hover {
  background: #f3f4f6;
}
</style>
