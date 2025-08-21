<script setup>
import { PenLine } from 'lucide-vue-next'
import { ref, computed } from 'vue'

const props = defineProps({
  columns: {
    type: Array,
    required: true,
  },
  rows: {
    type: Array,
    required: true,
  },
})

const emit = defineEmits(['edit', 'delete', 'update:selected'])

const selectedRows = ref([])
const sortKey = ref(null)
const sortOrder = ref('asc')

const sortedData = computed(() => {
  if (!sortKey.value) return props.rows
  return [...props.rows].sort((a, b) => {
    if (a[sortKey.value] < b[sortKey.value]) return sortOrder.value === 'asc' ? -1 : 1
    if (a[sortKey.value] > b[sortKey.value]) return sortOrder.value === 'asc' ? 1 : -1
    return 0
  })
})

const allSelected = computed(() => selectedRows.value.length === props.rows.length)

function toggleSelectAll(event) {
  if (event.target.checked) {
    selectedRows.value = [...props.rows]
  } else {
    selectedRows.value = []
  }
  emit('update:selected', selectedRows.value)
}

function sortBy(key) {
  if (sortKey.value === key) {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc'
  } else {
    sortKey.value = key
    sortOrder.value = 'asc'
  }
}
</script>

<template>
  <div class="datatable">
    <table>
      <thead>
        <tr>
          <th>
            <input type="checkbox" @change="toggleSelectAll" :checked="allSelected" />
          </th>

          <th v-for="column in columns" :key="column.key" @click="sortBy(column.key)">
            {{ column.label }}
            <span v-if="sortKey === column.key">
              {{ sortOrder === 'asc' ? '↑' : '↓' }}
            </span>
          </th>

          <th>Aksi</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="(row, index) in sortedData" :key="index">
          <td>
            <input type="checkbox" v-model="selectedRows" :value="row" />
          </td>

          <td v-for="column in columns" :key="column.key">
            {{ row[column.key] }}
          </td>

          <td>
            <button @click="$emit('edit', row)"><PenLine /></button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
.datatable {
  margin-top: 1rem;
  border: 1px solid #ddd;
  border-radius: 6px;
  overflow: hidden;
  width: 100%;
  height: 100%;
}

table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}

th,
td {
  border-bottom: 1px solid #ddd;
  padding: 10px;
  text-align: left;
}

th {
  background: #f9f9f9;
  cursor: pointer;
}

tr:hover {
  background: #f5f5f5;
}

button {
  margin-right: 6px;
  border: none;
  background: transparent;
  cursor: pointer;
}
</style>
