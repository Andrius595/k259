<template>
  <NuxtLayout name="auth-layout">
  


    <Head>
      <Title>Pridėti remėją</Title>
    </Head>

    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Pridėti remėją
        </h2>
      </div>
    </template>


    <div class="container mx-auto mt-10">  
      <el-card>
        <form @submit.prevent="submitForm">
          <!-- Name -->
          <div>
            <Label for="title">Pavadinimas</Label>
            <Input
              id="title"
              type="text"
              class="block mt-1 w-full"
              v-model="data.title"
              :errors="errors.title"
              required
              autoFocus
            />
          </div>

          <div class="mt-4">
            <Label for="description">Aprašymas</Label>
            <Textarea
                id="description"
                class="block mt-1 w-full"
                v-model="data.description"
                :errors="errors.description"
            />
          </div>
          
          <div class="mt-4">
            <Label for="litter_image_path">Nuotrauka</Label>
            <el-upload
                ref="upload"
                v-model:file-list="fileList"
                :on-exceed="handleExceed"
                :auto-upload="false"
                list-type="picture"
                :limit="1"
            >
              <el-button type="primary">Patalpinti</el-button>
            </el-upload>
          </div>

          <div class="flex items-center justify-end mt-4">
            <NuxtLink
              href="/login"
              class="underline text-sm text-gray-600 hover:text-gray-900"
            >
              Atšaukti
            </NuxtLink>

            <Button class="ml-3">Išsaugoti</Button>
          </div>
        </form>
      </el-card>
    </div>
  </NuxtLayout>
</template>

<script setup lang="ts">
import type {UploadInstance, UploadProps, UploadRawFile, UploadUserFile} from 'element-plus'
import {genFileId} from 'element-plus'
import {serialize} from 'object-to-formdata'
import {ServerSideResponse} from "~/types/generalTypes";

definePageMeta({ middleware: ["auth"] });

const fileList = ref<UploadUserFile[]>([])
const upload = ref<UploadInstance>()
const errors = ref<Record<string, string>>({});
const errorMessage = ref<string>("");
const successMessage = ref<string>("");


async function submitForm() {
  errors.value = {}
  errorMessage.value = ''
  successMessage.value = ''

  const datato = {
    ...data.value,
    image: fileList.value[0].raw,
  };

  const body = serialize(datato)

  const response: ServerSideResponse = await $fetch(`/api/company/`, {
    method: "POST",
    body,
  });

  if (response.status) {
    successMessage.value = 'Company created successfully'

    return await navigateTo('/company/list')
  }

  if (response.data.errors) {
    errors.value = response.data.errors

    return
  }

  errorMessage.value = response.data.data
}

const data = ref({
  // company title
  title: "",
  // company description
  description: "",
});

const handleExceed: UploadProps['onExceed'] = (files) => {
  upload.value!.clearFiles()
  const file = files[0] as UploadRawFile
  file.uid = genFileId()
  upload.value!.handleStart(file)
}
</script>