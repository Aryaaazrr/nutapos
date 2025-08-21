<script setup>
import { ref } from 'vue'
import BaseLayout from '@/layouts/BaseLayout.vue'
import MainContent from '@/components/MainContent.vue'

const apiUrl = ref('')
</script>

<template>
  <BaseLayout>
    <MainContent v-model:apiUrl="apiUrl" title="Daftar Diskon" >
    </MainContent>
  </BaseLayout>
</template>
