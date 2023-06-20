<template>
  <NuxtLayout name="auth-layout">
  


    <Head>
      <Title>Sukurti įvykį</Title>
    </Head>

    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Sukurti įvykį
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
              v-model="data.event_title"
              id="event_title"
              type="text"
              class="block mt-1 w-full"
              
              :errors="errors.event_title"
              required
              autoFocus
            />
          </div>

          <div class="mt-4">
            <Label for="event_description">Aprašymas</Label>
            <Textarea
                id="event_description"
                class="block mt-1 w-full"
                v-model="data.event_description"
                :errors="errors.event_description"
            />
          </div>


          <div class="mt-4">
            <Label for="starting_date">Data</Label>
            <Input
              id="starting_date"
              type="date"
              class="block mt-1 w-full"
              v-model="data.starting_date"
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
              v-model="data.starting_time"
              :errors="errors.starting_time"
              required
            />
          </div>

          <!-- REPLACE WITH MAP-->
          <div class="mt-4">
            <Label for="litterMapForForm">Vieta</Label>
            <!--coordinates net to map-->
            <div class="flex flex-row gap-4 text-xs">
              <div class="flex flex-col">
                <span>Platuma:</span>
                <span>{{ data.latitude }}</span>
              </div>
              <div class="flex flex-col">
                <span>Ilguma:</span>
                <span>{{ data.longitude }}</span>
              </div>
            </div>
            <!--LitterMapForForm with latitude and longitude passed in as props-->
            <LitterMapForForm
              id="litterMapForForm"
              style="height: 500px"
              :latitude="data.latitude"
              :longitude="data.longitude"
              :myAccuracy="coords.accuracy"
              :myLatitude="coords.latitude"
              :myLongitude="coords.longitude"
              @update:latLng="updateCoordinates"
            />
          </div>

          <div class="mt-4">
            <Label for="image_path">Nuotrauka</Label>
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
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
      <div class="overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
        </div>
      </div>
    </div>
  </NuxtLayout>
</template>

<script setup lang="ts">
import { useGeolocation } from "@vueuse/core";
import {serialize} from 'object-to-formdata'

definePageMeta({ middleware: ["auth"] });
const { coords } = useGeolocation();
var coordsLoaded = false
//wait for coords to change, then continue
watch(coords, (newCoords) => {
  if (newCoords) {
    coordsLoaded = true
  }
})


const fileList = ref<UploadUserFile[]>([])
const upload = ref<UploadInstance>()

const errors = ref<Record<string, string[]>>({});


async function submitForm() {
  errors.value = {};

 

  const datato = {
    ...data.value,
    image: fileList.value[0].raw,
    starting_date: data.value.starting_date + " " + data.value.starting_time,
  };

  const body = serialize(datato)

  const response = await $fetch("/api/event/", {
    method: "POST",
    body,
  });

    if (response.status) {
  return await navigateTo('/event/list')
  }

}

function updateCoordinates(e:any) {
  data.value.latitude = e.lat 
  data.value.longitude = e.lng
}

const data = ref({
  // event title
  event_title: "",
  // event description
  event_description: "",
  // starting at date
  starting_date: "",
  // starting at time
  starting_time: "",
  // latitude
  latitude: coords.value?.latitude === Infinity ? 54.687157 : coords.value.latitude,
  // longitude
  longitude: coords.value?.longitude === Infinity ? 25.279652 : coords.value.longitude,
  // has ended
  has_ended: "",
  // image path
  image_path: ""
});


const handleExceed: UploadProps['onExceed'] = (files) => {
  upload.value!.clearFiles()
  const file = files[0] as UploadRawFile
  file.uid = genFileId()
  upload.value!.handleStart(file)
}
</script>