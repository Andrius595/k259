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
      <el-card v-if="company">
        <form @submit.prevent="submitForm">
          <!-- Name -->
          <div>
            <Label for="title">Pavadinimas</Label>
            <Input
              id="title"
              type="text"
              class="block mt-1 w-full"
              v-model="company.title"
              :errors="errors.title"
              required
              autoFocus
            />
          </div>

          <div class="mt-4">
            <Label for="description">Aprašymas</Label>
            <Input
              id="description"
              type="text"
              class="block mt-1 w-full"
              v-model="company.description"
              :errors="errors.description"
              required
            />
          </div>
          
          <div class="mt-4">
            <Label for="company_image_path">Nuotrauka</Label>
            <div v-if="company.image_path" class="flex">
              <div class="relative">
                <span class="absolute z-10 right-3 hover:cursor-pointer" @click="removeCurrentImage">
                  <el-icon :size="20">
                    <Close />
                  </el-icon>
                </span>

                <el-image
                    style="height: 200px"
                    :src="company.image_src"
                    fit="contain"
                    :preview-src-list="[company.image_src]"
                />
              </div>
            </div>
            <el-upload
                v-else
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

            <Button class="ml-3">Atnaujinti</Button>
          </div>
        </form>
      </el-card>
    </div>
  </NuxtLayout>
</template>

<script setup lang="ts">
import {genFileId, UploadInstance, UploadProps, UploadRawFile, UploadUserFile} from "element-plus";
import {serialize} from 'object-to-formdata'
import {ServerSideResponse} from "~/types/generalTypes";
import {Company} from "~/types/companyTypes";
import {Close} from "@element-plus/icons-vue";

definePageMeta({ middleware: ["auth"] });


const company: any= ref<Company | null>(null)
const route = useRoute();
const companyId = ref(route.params.id ?? null)
const deleteCurrentImage = ref<boolean>(false)

const fileList = ref<UploadUserFile[]>([])
const upload = ref<UploadInstance>()
const errors = ref<Record<string, string>>({});
const errorMessage = ref<string>("");
const successMessage = ref<string>("");



await loadCompany()

async function loadCompany() {
  const response: ServerSideResponse = await $fetch(`/api/company/${companyId.value}`)
  if (response.status) {
    company.value = response.data

    return
  }

  return await navigateTo('/company/list')
}

async function submitForm() {
  errors.value = {}
  errorMessage.value = ''
  successMessage.value = ''

  const data = {
    ...company.value,
    image: fileList.value[0]?.raw,
  };

  const body = serialize(data)

  
  const response: any = await $fetch(`/api/company/${companyId.value}`, {
    method: 'PUT',
    body,
  })

  if (response.status) {
    successMessage.value = 'Company updated successfully'

    return await navigateTo('/company/list')
  }

  if (response.data.errors) {
    errors.value = response.data.errors

    return
  }

  errorMessage.value = response.data.data
}

const handleExceed: UploadProps['onExceed'] = (files) => {
  upload.value!.clearFiles()
  const file = files[0] as UploadRawFile
  file.uid = genFileId()
  upload.value!.handleStart(file)
}

function removeCurrentImage() {
  company.value.image_src = null
  company.value.image_path = null
  deleteCurrentImage.value = true
}
</script>