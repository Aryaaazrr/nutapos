<script setup>
import { computed, ref, reactive, watch } from 'vue'
import { Plus } from 'lucide-vue-next'
import ButtonPrimary from './ButtonPrimary.vue'
import ButtonSecondary from './ButtonSecondary.vue'
import DialogModal from './DialogModal.vue'
import InputField from './InputField.vue'

const props = defineProps({
  title: String,
  description: String,
  modelValue: { type: [String, Number, Object], default: '' },
})

const emit = defineEmits(['update:modelValue', 'save-url', 'save-diskon'])

const showModalApi = ref(false)
const showModalAddDiskon = ref(false)

const apiUrl = computed({
  get: () => props.modelValue,
  set: (val) => emit('update:modelValue', val),
})
const diskonList = ref([])

const inputUrl = ref(apiUrl.value)
watch(apiUrl, (val) => (inputUrl.value = val))

const diskon = reactive({
  nama: '',
  nilai: '',
  type: '%',
})

const errors = reactive({
  namaDiskon: false,
  nilaiDiskon: false,
})

function handleSaveApi(url) {
  apiUrl.value = url
  emit('save-url', url)
  showModalApi.value = false
  console.log(url)
}

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
    diskonList.value.push(data)
  } catch (err) {
    console.error(' Error fetch:', err)
  }
}
</script>

<template>
  <div class="empty-state">
    <div class="illustration" :class="{ placeholder: !apiUrl }">
      <img v-if="apiUrl" src="./../assets/Layer_1.svg" alt="Illustration" />
    </div>
    <h2>{{ title }}</h2>
    <p>{{ description }}</p>

    <ButtonSecondary v-if="!apiUrl" @click="showModalApi = true" text="Pilih outlet">
      <Plus />
    </ButtonSecondary>

    <ButtonPrimary v-else @click="showModalAddDiskon = true" text="Tambah Diskon">
      <Plus />
    </ButtonPrimary>

    <DialogModal
      :open="showModalApi"
      @update:open="(val) => (showModalApi = val)"
      @submit="handleSaveApi(inputUrl)"
    >
      <InputField v-model="inputUrl" placeholder="https://crudcrud.com/api/xxxxx/diskon" />
      <template #actions>
        <ButtonPrimary type="submit" text="Terapkan" />
      </template>
    </DialogModal>

    <DialogModal
      :open="showModalAddDiskon"
      title="Tambah Diskon"
      @update:open="(val) => (showModalAddDiskon = val)"
      @submit.prevent="handleSaveDiskon(diskon)"
    >
      <div class="form-add-diskon">
        <div class="form-group" :class="{ error: errors.namaDiskon }">
          <label style="text-align: start">Nama Diskon</label>
          <InputField
            v-model="diskon.nama"
            placeholder="Misal: Diskon opening, diskon akhir tahun"
          />
          <span v-if="errors.namaDiskon" class="error-text">Nama diskon tidak boleh kosong.</span>
        </div>

        <div class="form-group" :class="{ error: errors.nilaiDiskon }">
          <label style="text-align: start">Diskon</label>
          <div class="input-percent">
            <InputField type="number" v-model="diskon.nilai" placeholder="0" />
            <div class="toggle-type">
              <button @click="diskon.type = '%'" :class="{ active: diskon.type === '%' }">%</button>
              <button @click="diskon.type = 'Rp'" :class="{ active: diskon.type === 'Rp' }">
                Rp
              </button>
            </div>
          </div>
          <span v-if="errors.nilaiDiskon" class="error-text">Diskon tidak boleh kosong.</span>
        </div>
      </div>

      <template #actions>
        <ButtonPrimary type="submit" text="Simpan" />
      </template>
    </DialogModal>

  </div>
</template>

<style scoped>
.empty-state {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  width: 420px;
}

.illustration {
  font-size: 48px;
  margin-bottom: 1rem;
  width: 240px;
  height: 135px;
  background: transparent;
  border-radius: 1rem;
}

.placeholder {
  background: #f4f5f6;
}

h2 {
  font-size: 1.375rem;
  font-weight: 600;
  margin-bottom: 0.25rem;
}
p {
  font-size: 1rem;
  color: #212426;
  margin-bottom: 1rem;
}
.form-add-diskon {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
  text-align: left;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.4rem;
}

.form-group label {
  font-size: 0.9rem;
  font-weight: 500;
  color: #374151;
}

.form-group.error input {
  border: 1px solid #ef4444;
}

.error-text {
  color: #ef4444;
  font-size: 0.8rem;
  margin-top: 0.2rem;
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
</style>
