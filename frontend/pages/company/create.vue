<template>
  <NuxtLayout name="auth-layout">
    <Head>
      <Title>Create litter</Title>
    </Head>

    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Create litter
        </h2>
      </div>
    </template>

    <div class="container mx-auto mt-10">
      <el-card>
        <form @submit.prevent="submitForm">
          <!-- Litter size -->
          <div class="mt-4">
            <Label for="litter_size">Size</Label>
            <Select
                v-model="data.size"
                :errors="errors.size"
                :options="litterSizeOptions"
                class="block mt-1 w-full"
            />
          </div>

          <div class="mt-4">
            <Label for="litter_description">Description</Label>
            <Textarea
                id="litter_description"
                class="block mt-1 w-full"
                v-model="data.description"
                :errors="errors.description"
            />
          </div>

          <!-- litter image_path-->
          <div class="mt-4">
            <Label for="litter_image_path">Image</Label>
            <el-upload
                ref="upload"
                v-model:file-list="fileList"
                :on-exceed="handleExceed"
                :auto-upload="false"
                list-type="picture"
                :limit="1"
            >
              <el-button type="primary">Click to upload</el-button>
            </el-upload>
          </div>

          <!-- REPLACE WITH MAP-->
          <div class="mt-4">
            <Label for="litterMapForForm">Location</Label>
            <!--coordinates net to map-->
            <div class="flex flex-row gap-4 text-xs">
              <div class="flex flex-col">
                <span>Latitude:</span>
                <span>{{ data.latitude }}</span>
              </div>
              <div class="flex flex-col">
                <span>Longitude:</span>
                <span>{{ data.longitude }}</span>
              </div>
            </div>
            <!--LitterMapForForm with latitude and longitude passed in as props-->
            <LitterMapForForm
                id="litterMapForForm"
                v-if="coordsLoaded"
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
            <Label>Accessibility</Label>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-x-4">
              <div class="flex gap-4">
                <Input
                    type="checkbox"
                    id="litter_is_accessible_by_car"
                    name="litter_is_accessible_by_car"
                    @change="data.is_accessible_by_car = $event.target.checked"
                    :checked="data.is_accessible_by_car"
                />
                <Label for="litter_is_accessible_by_car"
                >Litter is accessible by car</Label
                >
              </div>

              <div class="flex gap-4">
                <Input
                    type="checkbox"
                    id="litter_is_located_in_hole"
                    name="litter_is_located_in_hole"
                    @change="data.is_located_in_hole = $event.target.checked"
                    :checked="data.is_located_in_hole"
                />
                <Label for="litter_is_located_in_hole"
                >Litter is located in hole</Label
                >
              </div>

              <div class="flex gap-4">
                <Input
                    type="checkbox"
                    id="litter_is_under_water"
                    name="litter_is_under_water"
                    @change="data.is_under_water = $event.target.checked"
                    :checked="data.is_under_water"
                />
                <Label for="litter_is_under_water">Litter is under water</Label>
              </div>

              <div class="flex gap-4">
                <Input
                    type="checkbox"
                    id="litter_is_on_the_waterside"
                    name="litter_is_on_the_waterside"
                    @change="data.is_on_the_waterside = $event.target.checked"
                    :checked="data.is_on_the_waterside"
                />
                <Label for="litter_is_on_the_waterside"
                >Litter is on the waterside</Label
                >
              </div>
              <div class="flex gap-4">
                <Input
                    type="checkbox"
                    id="litter_is_hard_to_reach"
                    name="litter_is_hard_to_reach"
                    @change="data.is_hard_to_reach = $event.target.checked"
                    :checked="data.is_hard_to_reach"
                />
                <Label for="litter_is_hard_to_reach"
                >Litter is hard to reach</Label
                >
              </div>
            </div>
          </div>

          <div class="mt-4">
            <Label for="litter_description">Trash type</Label>
            <Select
                v-model="selectedTrashTypes"
                :errors="errors.trash_types"
                :options="trashTypesOptions"
                class="block mt-1 w-full"
                multiple
            />
          </div>

          <div class="flex items-center justify-end mt-4">
            <NuxtLink
                href="/litter/list"
                class="underline text-sm text-gray-600 hover:text-gray-900"
            >
              Cancel
            </NuxtLink>

            <Button class="ml-3">Create</Button>
          </div>
        </form>
      </el-card>
    </div>
  </NuxtLayout>
</template>

<script setup lang="ts">
import Select from "~/components/Select.vue";
import {TrashType} from "~/types/trashTypeTypes";
import type {UploadInstance, UploadProps, UploadRawFile, UploadUserFile} from 'element-plus'
import {genFileId} from 'element-plus'
import {serialize} from 'object-to-formdata'
import {useGeolocation} from '@vueuse/core'
import {ServerSideResponse} from "~/types/generalTypes";

const {coords} = useGeolocation();
var coordsLoaded = false
console.log(coords.value.latitude)
//wait for coords to change, then continue
watch(coords, (newCoords) => {
  if (newCoords) {
    console.log(coords.value.latitude)
    coordsLoaded = true
  }
})

definePageMeta({middleware: ["auth"]});
const trashTypes = ref<TrashType[]>([]);

const fileList = ref<UploadUserFile[]>([])
const upload = ref<UploadInstance>()

const selectedTrashTypes = ref<number[]>([]);
const errors = ref<Record<string, string>>({});
const errorMessage = ref<string>("");
const successMessage = ref<string>("");

const litterSizeOptions = [
  {value: 1, label: "Small"},
  {value: 2, label: "Medium"},
  {value: 3, label: "Large"},
];

const trashTypesOptions = computed(() => {
  return trashTypes.value.map((trashType: TrashType) => {
    return {
      value: trashType.id,
      label: trashType.title,
    };
  });
});

await loadTrashTypes();

async function loadTrashTypes() {
  const response: ServerSideResponse = await $fetch("/api/trash-types");
  if (response.status) {
    trashTypes.value = response.data;
    return;
  }

  // navigate to list, because unable to load trash types
  return await navigateTo('/litter/list')
}

async function submitForm() {
  errors.value = {}
  errorMessage.value = ''
  successMessage.value = ''

  const datato = {
    trash_types: selectedTrashTypes.value,
    ...data.value,
    is_accessible_by_car: data.value.is_accessible_by_car ? 1 : 0,
    is_located_in_hole: data.value.is_located_in_hole ? 1 : 0,
    is_under_water: data.value.is_under_water ? 1 : 0,
    is_on_the_waterside: data.value.is_on_the_waterside ? 1 : 0,
    is_hard_to_reach: data.value.is_hard_to_reach ? 1 : 0,
    image: fileList.value[0].raw,
  };

  const body = serialize(datato)

  const response: ServerSideResponse = await $fetch(`/api/litter/`, {
    method: "POST",
    body,
  });

  if (response.status) {
    successMessage.value = 'Litter created successfully'

    return await navigateTo('/litter/list')
  }

  if (response.data.errors) {
    errors.value = response.data.errors

    return
  }

  errorMessage.value = response.data.data
}

function updateCoordinates(e: any) {
  data.value.latitude = e.lat
  data.value.longitude = e.lng
}

const data = ref({
  //'size','latitude','longitude','image_path','description','is_accessible_by_car','is_located_in_hole','is_under_water','is_on_the_waterside','is_hard_to_reach'
  // liiter size
  size: "",
  // liiter latitude
  latitude: coords.value?.latitude,
  // liiter longitude
  longitude: coords.value?.longitude,
  // liiter image path
  image_path: "",
  // liiter description
  description: "",
  // liiter is accessible by car
  is_accessible_by_car: 0,
  // liiter is located in hole
  is_located_in_hole: 0,
  // liiter is under water
  is_under_water: 0,
  // liiter is on the waterside
  is_on_the_waterside: 0,
  // liiter is hard to reach
  is_hard_to_reach: 0,
});

const handleExceed: UploadProps['onExceed'] = (files) => {
  upload.value!.clearFiles()
  const file = files[0] as UploadRawFile
  file.uid = genFileId()
  upload.value!.handleStart(file)
}
</script>
