

<template>
  <NuxtLayout name="auth-layout">

    <Head>
      <Title>Surinkti šiukšles</Title>
    </Head>

    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Surinkti šiukšles
        </h2>
        <div v-if="litter?.is_cleaned">
          <div class="bg-green-600 py-2 px-4 rounded">
            <span class="text-white">Išvalyta</span>
          </div>
        </div>
      </div>
    </template>



    <div class="container mx-auto mt-10">

      <el-card v-if="litter">

        <div v-if="litter.user">
          <span>Pranešė: </span>
          <span v-if="litter.user">{{ `${litter.user.first_name} ${litter.user.last_name}` }}</span>
          <span v-else>Anonimas</span>
        </div>

        <div class="mt-4">
          <span v-if="litter.image_src">
            <img :src="litter.image_src" class="w-64 h-64 object-cover rounded-lg" />
          </span>
          <span v-else>Nuotrauka nepridėta</span>
        </div>

        <div class="mt-4">
          <Label for="litter_description">Aprašymas: </Label>
          <span>{{ litter.description }}</span>
        </div>

        <div class="mt-4">
          <p class="text-gray-600">
            Laikas:
            {{ DateTime.fromISO(litter.created_at).toFormat("yyyy-MM-dd HH:mm") }}
          </p>
        </div>


        <form class="mt-5" @submit.prevent="submitForm">

          <el-upload 
          ref="upload" v-model:file-list="fileList" :on-exceed="handleExceed" :auto-upload="false"
            list-type="picture" :limit="1"> 
            <el-button type="primary">Įkelti išvalytą aplinką</el-button>
          </el-upload>

          <div class="flex items-center justify-end mt-4">
            <NuxtLink href="/litter/list" class="underline text-sm text-gray-600 hover:text-gray-900">
              Atšaukti
            </NuxtLink>

            <Button class="ml-3">Surinkti</Button>

          </div>
        </form>
      <el-alert
        v-if="errorMessage"
        :title="errorMessage"
        type="error"
        show-icon
        :closable="false"
        class="mt-5" />
      </el-card>

    </div>



    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
      <div class="overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
        </div>
      </div>
    </div>
  </NuxtLayout>
</template>
  
<script setup lang="ts">
import Select from "~/components/Select.vue";
import { TrashType } from "~/types/trashTypeTypes";
import { Litter } from "~/types/litterTypes";
import { useGeolocation } from '@vueuse/core'
import { genFileId, UploadInstance, UploadProps, UploadRawFile, UploadUserFile } from "element-plus";
import { Close } from "@element-plus/icons-vue";
import { serialize } from "object-to-formdata";
import { DateTime } from "luxon";

definePageMeta({ middleware: ["auth"] })

const { coords, locatedAt, error, resume, pause } = useGeolocation()
const route = useRoute();

const litterId = ref(route.params.id ?? null)


const litter: any = ref<Litter | null>(null)
const trashTypes = ref<TrashType[]>([])

const selectedTrashTypes = ref<number[]>([])

const fileList = ref<UploadUserFile[]>([])
const upload = ref<UploadInstance>()
const deleteCurrentImage = ref<boolean>(false)

const errors = ref<Record<string, string>>({})
const errorMessage = ref<string>('')
const successMessage = ref<string>('')



await loadLitter()
await loadTrashTypes()

async function loadLitter() {
  const response: any = await $fetch(`/api/litter/${litterId.value}`)
  if (response.status) {
    litter.value = response.data
    selectedTrashTypes.value = response.data.trash_types.map((trashType: TrashType) => trashType.id)

    return
  }

  return await navigateTo('/litter/list')
}

async function loadTrashTypes() {
  const response: any = await $fetch('/api/trash-types')
  if (response.status) {
    trashTypes.value = response.data

    return
  }

  // navigate to list, because unable to load trash types
  return await navigateTo('/litter/list')
}

async function submitForm() {
  errors.value = {}
  errorMessage.value = ''
  successMessage.value = ''

  const data = {
    ...litter.value,
    trash_types: selectedTrashTypes.value,
    is_accessible_by_car: litter.value.is_accessible_by_car ? 1 : 0,
    is_located_in_hole: litter.value.is_located_in_hole ? 1 : 0,
    is_under_water: litter.value.is_under_water ? 1 : 0,
    is_on_the_waterside: litter.value.is_on_the_waterside ? 1 : 0,
    is_hard_to_reach: litter.value.is_hard_to_reach ? 1 : 0,
    is_cleaned: litter.value.is_cleaned ? 1 : 0,
    image: fileList.value[0]?.raw,
  }

  const body = serialize(data)

  const response: any = await $fetch(`/api/litter/${litterId.value}/cleaned`, {
    method: 'POST',
    body,
  })

  if (response.status) {
    successMessage.value = 'Šiukšlė sėkmingai surinkta'

    return await navigateTo('/litter/list')
  }

  if (response.data.errors) {
    errors.value = response.data.errors
    errorMessage.value = 'Įkelkite išvalytos aplinkos nutorauką.'
    return
  }

  errorMessage.value = response.data.data
}



function removeCurrentImage() {
  litter.value.image_src = null
  litter.value.image_path = null
  deleteCurrentImage.value = true
}

const handleExceed: UploadProps['onExceed'] = (files) => {
  upload.value!.clearFiles()
  const file = files[0] as UploadRawFile
  file.uid = genFileId()
  upload.value!.handleStart(file)
}
</script>
  