<script setup>
import { ref, computed, watch, reactive } from 'vue'

import DataTable from './DataTable.vue'
import DiskonContent from './DiskonContent.vue'
import DropdownMenu from './DropdownMenu.vue'
import InputField from './InputField.vue'
import DialogModal from './DialogModal.vue'
import ButtonPrimary from './ButtonPrimary.vue'
import { Plus } from 'lucide-vue-next'

/* ---------------- Props & Emit ---------------- */
const props = defineProps({
  title: { type: String, default: '' },
  apiUrl: { type: String, default: '' },
  modelValue: { type: [String, Number, Object], default: '' },
})
const emit = defineEmits(['update:apiUrl', 'update:modelValue', 'save-url', 'save-diskon'])

/* ---------------- State ---------------- */
const selectedOutlet = ref({ id: 1, name: 'Kopi Anak Bangsa' })
const selectedRow = ref(null)

const apiUrl = computed({
  get: () => props.apiUrl,
  set: (val) => emit('update:apiUrl', val),
})

const diskonData = ref([])
const loading = ref(false)
const error = ref(null)

const columns = [
  { key: 'name', label: 'Nama Diskon' },
  { key: 'value', label: 'Nilai Diskon' },
]

/* ---------------- Tambah Diskon ---------------- */
const showModalAddDiskon = ref(false)
const diskon = reactive({
  name: '',
  value: '',
  type: '%',
})

/* ---------------- Edit Diskon ---------------- */
const isEditModalOpen = ref(false)
const editingDiskon = reactive({
  id: '',
  name: '',
  value: '',
  type: '%',
})

/* ---------------- Validasi ---------------- */
const errors = reactive({
  name: false,
  value: false,
})

function validateDiskon(d) {
  errors.name = !d.name
  errors.value = !d.value
  return !errors.name && !errors.value
}

/* ---------------- CRUD Methods ---------------- */
// CREATE
async function handleSaveDiskon(diskon) {
  if (!diskon) {
    console.error(' Diskon kosong / undefined!')
    return
  }

  console.log('Payload diskon:', diskon)

  try {
    const res = await fetch(apiUrl.value, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(diskon),
    })

    if (!res.ok) throw new Error(`Gagal: ${res.status}`)
    const data = await res.json()
    console.log(' Berhasil:', data)
    diskonData.value.push(data)
  } catch (err) {
    console.error(' Error fetch:', err)
  }
}

// UPDATE
function handleEdit(row) {
  Object.assign(editingDiskon, {
    id: row.id,
    name: row.name,
    value: row.value,
    type: row.type,
  })
  isEditModalOpen.value = true
}

async function handleEditDiskon() {
  if (!validateDiskon(editingDiskon)) return

  try {
    const payload = {
      nama: editingDiskon.name,
      nilai: editingDiskon.value,
      type: editingDiskon.type,
    }

    const res = await fetch(`${apiUrl.value}/${editingDiskon.id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    })

    if (!res.ok) throw new Error(`HTTP ${res.status}`)

    // update local state
    const idx = diskonData.value.findIndex((d) => d.id === editingDiskon.id)
    if (idx !== -1) {
      diskonData.value[idx] = { ...editingDiskon }
    }

    isEditModalOpen.value = false
    alert('Diskon berhasil diperbarui')
  } catch (err) {
    console.error(err)
    alert('Gagal memperbarui diskon')
  }
}

// DELETE
async function handleDeleteSelected() {
  if (!selectedRow.value) return
  console.log("API URL:", apiUrl.value)
  console.log("Delete ID:", selectedRow.value.id)

  if (!selectedRow.value.id) {
    alert("ID kosong, tidak bisa hapus")
    return
  }

  try {
    const res = await fetch(`${apiUrl.value}/${selectedRow.value.id}`, {
      method: 'DELETE',
      headers: { "Content-Type": "application/json" }
    })

    if (!res.ok) {
      const errText = await res.text()
      throw new Error(`HTTP ${res.status}: ${errText}`)
    }

    diskonData.value = diskonData.value.filter(d => d.id !== selectedRow.value.id)
    selectedRow.value = null
    alert("Diskon berhasil dihapus")
  } catch (err) {
    console.error("Delete error:", err)
    alert("Gagal menghapus diskon")
  }
}

/* ---------------- Fetch Data (READ) ---------------- */
watch(
  apiUrl,
  async (newUrl) => {
    if (!newUrl) {
      diskonData.value = []
      return
    }
    await fetchData(newUrl)
  },
  { immediate: true },
)

async function fetchData(url) {
  loading.value = true
  error.value = null
  try {
    const res = await fetch(url)
    if (!res.ok) throw new Error(`HTTP ${res.status}`)
    const data = await res.json()

    if (!Array.isArray(data)) throw new Error('Format data tidak sesuai')

    diskonData.value = data.map((item) => ({
      id: item._id,
      name: item.nama,
      value: item.nilai,
      type: item.type,
    }))
  } catch (err) {
    console.error(err)
    error.value = `Gagal memuat data. Silahkan coba lagi`
    diskonData.value = []
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="card">
    <!-- Judul -->
    <h1 v-if="title" class="card-title">{{ title }}</h1>

    <div class="action-group">
      <div class="filter">
        <InputField
          v-if="apiUrl && diskonData.length > 0"
          class="search"
          type="text"
          v-model="diskon.name"
          placeholder="Cari diskon..."
        />
        <DropdownMenu v-if="apiUrl" v-model="selectedOutlet" style="margin-bottom: 2rem" />
      </div>
      <div class="button" v-if="apiUrl && diskonData.length > 0">
        <ButtonPrimary
          v-if="!selectedRow"
          @click="showModalAddDiskon = true"
          text="Tambah Diskon"
        >
          <Plus />
        </ButtonPrimary>

        <ButtonPrimary
          v-else
          class="btn-delete"
          @click="handleDeleteSelected"
          text="Hapus Diskon"
        />
      </div>
    </div>

    <div class="card-content">
      <!-- Loading / Error -->
      <p v-if="loading">Sedang mengambil data...</p>
      <p v-else-if="error" class="text-red-500">{{ error }}</p>

      <!-- Empty State -->
      <DiskonContent
        v-else-if="!apiUrl"
        title="Belum Ada Outlet"
        description="Silahkan pilih outlet terlebih dahulu."
        v-model="apiUrl"
      />
      <DiskonContent
        v-else-if="diskonData.length === 0"
        title="Belum Ada Diskon"
        description="Silahkan tambah diskon untuk menarik pelanggan dan meningkatkan penjualan."
        v-model="apiUrl"
      />

      <!-- Table -->
      <DataTable
        v-else
        :columns="columns"
        :rows="diskonData"
        v-model:selected="selectedRow"
        @edit="handleEdit"
      />

      <!-- Modal Tambah -->
      <DialogModal
        :open="showModalAddDiskon"
        title="Tambah Diskon"
        @update:open="(val) => (showModalAddDiskon = val)"
        @submit.prevent="handleSaveDiskon(diskon)"
      >
        <div class="form-add-diskon">
          <!-- Nama Diskon -->
          <div class="form-group" :class="{ error: errors.name }">
            <label>Nama Diskon</label>
            <InputField v-model="diskon.name" placeholder="Misal: Diskon opening, akhir tahun" />
            <span v-if="errors.name" class="error-text">Nama diskon tidak boleh kosong.</span>
          </div>

          <!-- Nilai Diskon -->
          <div class="form-group" :class="{ error: errors.value }">
            <label>Diskon</label>
            <div class="input-percent">
              <InputField type="number" v-model="diskon.value" placeholder="0" />
              <div class="toggle-type">
                <button
                  type="button"
                  @click="diskon.type = '%'"
                  :class="{ active: diskon.type === '%' }"
                >
                  %
                </button>
                <button
                  type="button"
                  @click="diskon.type = 'Rp'"
                  :class="{ active: diskon.type === 'Rp' }"
                >
                  Rp
                </button>
              </div>
            </div>
            <span v-if="errors.value" class="error-text">Diskon tidak boleh kosong.</span>
          </div>
        </div>

        <template #actions>
          <ButtonPrimary type="submit" text="Simpan" />
        </template>
      </DialogModal>

      <!-- Modal Edit -->
      <DialogModal
        :open="isEditModalOpen"
        title="Edit Diskon"
        @update:open="(val) => (isEditModalOpen = val)"
        @submit.prevent="handleEditDiskon"
      >
        <div class="form-add-diskon">
          <!-- Nama Diskon -->
          <div class="form-group">
            <label>Nama Diskon</label>
            <InputField v-model="editingDiskon.name" />
          </div>

          <!-- Nilai Diskon -->
          <div class="form-group" :class="{ error: errors.value }">
            <label>Diskon</label>
            <div class="input-percent">
              <InputField type="number" v-model="editingDiskon.value" placeholder="0" />
              <div class="toggle-type">
                <button
                  type="button"
                  @click="editingDiskon.type = '%'"
                  :class="{ active: editingDiskon.type === '%' }"
                >
                  %
                </button>
                <button
                  type="button"
                  @click="editingDiskon.type = 'Rp'"
                  :class="{ active: editingDiskon.type === 'Rp' }"
                >
                  Rp
                </button>
              </div>
            </div>
            <span v-if="errors.value" class="error-text">Diskon tidak boleh kosong.</span>
          </div>
        </div>

        <template #actions>
          <ButtonPrimary type="submit" text="Update" />
        </template>
      </DialogModal>

      <slot />
    </div>
  </div>
</template>

<style scoped>
.card {
  background: var(--vt-c-white);
  border-radius: 2rem;
  padding: 1.5rem;
  gap: 1.5rem;
}
.card-title {
  font-weight: 600;
  font-size: 28px;
  line-height: 42px;
  margin-bottom: 1rem;
}
.card-content {
  border-radius: 1rem;
  border: 1px solid var(--color-border);
  min-height: 400px;
  display: flex;
  justify-content: center;
  align-items: center;
}
.action-group {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.filter {
  display: flex;
  border-radius: 0.5rem;
  padding: 0.5rem 0;
  width: 400px;
  gap: 0.5rem;
}
.input-percent {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
.input-percent input {
  flex: 1;
}
.toggle-type {
  display: flex;
  gap: 0.25rem;
}
.toggle-type button {
  border: 1px solid #d1d5db;
  background: #fff;
  padding: 0.4rem 0.75rem;
  border-radius: 0.375rem;
  font-size: 0.9rem;
  cursor: pointer;
  transition: all 0.2s ease;
}
.toggle-type button:hover {
  background: #f3f4f6;
}
.toggle-type button.active {
  background: #dcfce7;
  border-color: #22c55e;
  color: #16a34a;
  font-weight: 600;
}
.error-text {
  color: red;
  font-size: 0.8rem;
}
.btn-delete {
  background: #ef4444; /* merah */
  border-color: #ef4444;
  color: white;
}
.btn-delete:hover {
  background: #dc2626;
}
</style>
