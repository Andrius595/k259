<script setup lang="ts">
import Select from "~/components/Select.vue";
import { useGeolocation } from '@vueuse/core'
import {genFileId, UploadInstance, UploadProps, UploadRawFile, UploadUserFile} from "element-plus";
import {serialize} from "object-to-formdata";

definePageMeta({middleware: ["auth"]})

const { coords, locatedAt, error, resume, pause } = useGeolocation()
const route = useRoute();

const eventId = ref(route.params.id ?? null)

const event : any= ref<Event | null>(null)
const trashTypes = ref<TrashType[]>([])

const selectedTrashTypes = ref<number[]>([])

const fileList = ref<UploadUserFile[]>([])
const upload = ref<UploadInstance>()
const deleteCurrentImage = ref<boolean>(false)

const errors = ref<Record<string, string>>({})
const errorMessage = ref<string>('')
const successMessage = ref<string>('')



await loadEvent()
await loadTrashTypes()

async function loadEvent() {
  const response :any = await $fetch(`/api/event/${eventId.value}`)

  // TODO also check if user is admin or event belongs to current user, otherwise redirect to list
  if (response.status) {
    event.value = response.data

    event.value.starting_date = response.data.starting_at.split(" ")[0];
    event.value.starting_time = response.data.starting_at.split(" ")[1];

    return
  }

  return await navigateTo('/event/list')
}

async function loadTrashTypes() {
  const response :any = await $fetch('/api/trash-types')
  if (response.status) {

    return
  }

  // navigate to list, because unable to load trash types
  return await navigateTo('/event/list')
}

async function submitForm() {
  errors.value = {}
  errorMessage.value = ''
  successMessage.value = ''

  const data = {
    ...event.value,
    image: fileList.value[0]?.raw,
  }

  const body = serialize(data)

  const response: any = await $fetch(`/api/event/${eventId.value}`, {
    method: 'PUT',
    body,
  })

  if (response.status) {
    successMessage.value = 'Event updated successfully'

    return await navigateTo('/event/list')
  }

  if (response.data.errors) {
    errors.value = response.data.errors

    return
  }

  errorMessage.value = response.data.data
}


function updateCoordinates(e:any) {
  event.value.latitude = e.lat 
  event.value.longitude = e.lng
}

function removeCurrentImage() {
  event.value.image_path = null
  deleteCurrentImage.value = true
}

const handleExceed: UploadProps['onExceed'] = (files) => {
  upload.value!.clearFiles()
  const file = files[0] as UploadRawFile
  file.uid = genFileId()
  upload.value!.handleStart(file)
}
</script>

<template>
  <NuxtLayout name="auth-layout">


    <Head>
      <Title>Atnaujinti renginį</Title>
    </Head>

    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Atnaujinti renginį
        </h2>
      </div>
    </template>

  
    <div class="container mx-auto mt-10">  
      <el-card>
        <form @submit.prevent="submitForm">
          <!-- Name -->

          <div>
            <Label for="event_title">Pavadinimas</Label>
            <Input
              id="event_title"
              type="text"
              class="block mt-1 w-full"
              v-model="event.title"
              :errors="errors.title"
              required
              autoFocus
            />
          </div>

          <div class="mt-4">
            <Label for="event_description">Aprašymas</Label>
            <Input
              id="event_description"
              type="text"
              class="block mt-1 w-full"
              v-model="event.description"
              :errors="errors.description"
              required
            />
          </div>

          <div class="mt-4">
            <Label for="starting_date">Data</Label>
            <Input
              id="starting_date"
              type="date"
              class="block mt-1 w-full"
              v-model="event.starting_date"
              :errors="errors.starting_date"
              required
            />
          </div>

          <div class="mt-4">
            <Label for="starting_time">Prasideda</Label>
            <Input
              id="starting_time"
              type="time"
              class="block mt-1 w-full"
              v-model="event.starting_time"
              :errors="errors.starting_time"
              required
            />
          </div>

          <div class="mt-4">
            <Label for="longitude">Ilguma</Label>
            <Input
              id="longitude"
              type="text"
              class="block mt-1 w-full"
              v-model="event.longitude"
              :errors="errors.longitude"
              required
            />
          </div>

          <div class="mt-4">
            <Label for="latitude">Platuma</Label>
            <Input
              id="latitude"
              type="text"
              class="block mt-1 w-full"
              v-model="event.latitude"
              :errors="errors.latitude"
              required
            />
          </div>

<!--  
          <div class="mt-4">
            <Label for="image_path">Nuotrauka</Label>
            <Input
              id="image_path"
              type="file"
              class="block mt-1 w-full"
              v-model="event.image_path"
              :errors="errors.image_path"
              required
            />
              <el-button type="primary">Patalpinti</el-button>
            </el-upload>
          </div>
-->
          <div class="mt-4">
            <Label for="event_image_path">Nuotrauka</Label>
            <div v-if="event.image_path" class="flex">
              <div class="relative">
                <span class="absolute z-10 right-3 hover:cursor-pointer" @click="removeCurrentImage">
                  <el-icon :size="20">
                    <Close />
                  </el-icon>
                </span>

                <el-image
                    style="height: 200px"
                    :src="event.image_src"
                    fit="contain"
                    :preview-src-list="[event.image_src]"
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

            <Button class="ml-3">Išsaugoti</Button>
          </div>
        </form>
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
