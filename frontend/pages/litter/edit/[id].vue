<template>
  <NuxtLayout name="auth-layout">
    <Head>
      <Title>Edit litter</Title>
    </Head>

    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Edit litter
        </h2>
        <div v-if="litter?.is_cleaned">
          <div class="bg-green-600 py-2 px-4 rounded">
            <span class="text-white">Cleaned</span>
          </div>
        </div>
      </div>
    </template>

    <div class="container mx-auto mt-10">
      <div v-if="errorMessage.length" class="mb-4 text-sm text-red-600">
        {{ errorMessage }}
      </div>
      <div v-if="successMessage.length" class="mb-4 text-sm text-green-600">
        {{ successMessage }}
      </div>

      <el-card v-if="litter">
        <div v-if="litter.user">
          <span>Reported by: </span>
          <span v-if="litter.user">{{ `${litter.user.first_name} ${litter.user.last_name}` }}</span>
          <span v-else>Anonymously</span>
        </div>
        <form @submit.prevent="submitForm">
          <!-- Litter size -->
          <div class="mt-4">
            <Label for="litter_size">Size</Label>
            <Select
                v-model="litter.size"
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
                v-model="litter.description"
                :errors="errors.description"
            />
          </div>

          <div class="mt-4">
            <Label for="litterMapForForm">Location</Label>
             <!--coordinates net to map-->
             <div class="flex flex-row gap-4 text-xs">
              <div class="flex flex-col">
                <span>Latitude:</span>
                <span>{{litter.latitude}}</span>
              </div>
              <div class="flex flex-col">
                <span>Longitude:</span>
                <span>{{litter.longitude}}</span>
              </div>

            </div>
            <!--LitterMapForForm with latitude and longitude passed in as props-->
            <LitterMapForForm
              id="litterMapForForm"
              style="height: 500px;"
              :latitude="litter.latitude"
              :longitude="litter.longitude"
              :myAccuracy="coords.accuracy"
              :myLatitude="coords.latitude"
              :myLongitude="coords.longitude"
              @update:latLng="updateCoordinates"
            />
        </div>

          <div class="mt-4 hidden">
            <Label for="litter_latitude">Latitude</Label>
            <Input
                id="litter_latitude"
                type="text"
                class="block mt-1 w-full"
                v-model="litter.latitude"
                :errors="errors.latitude"
                required
            />
          </div>

          <div class="mt-4 hidden">
            <Label for="litter_longitude">Longitude</Label>
            <Input
                id="litter_longitude"
                type="text"
                class="block mt-1 w-full"
                v-model="litter.longitude"
                :errors="errors.longitude"
                required
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
                    @change="litter.is_accessible_by_car = $event.target.checked"
                    :checked="litter.is_accessible_by_car"
                />
                <Label for="litter_is_accessible_by_car">Litter is accessible by car</Label>
              </div>

              <div class="flex gap-4">
                <Input
                    type="checkbox"
                    id="litter_is_located_in_hole"
                    name="litter_is_located_in_hole"
                    @change="litter.is_located_in_hole = $event.target.checked"
                    :checked="litter.is_located_in_hole"
                />
                <Label for="litter_is_located_in_hole">Litter is located in hole</Label>
              </div>

              <div class="flex gap-4">
                <Input
                    type="checkbox"
                    id="litter_is_under_water"
                    name="litter_is_under_water"
                    @change="litter.is_under_water = $event.target.checked"
                    :checked="litter.is_under_water"
                />
                <Label for="litter_is_under_water">Litter is under water</Label>
              </div>

              <div class="flex gap-4">
                <Input
                    type="checkbox"
                    id="litter_is_on_the_waterside"
                    name="litter_is_on_the_waterside"
                    @change="litter.is_on_the_waterside = $event.target.checked"
                    :checked="litter.is_on_the_waterside"
                />
                <Label for="litter_is_on_the_waterside">Litter is on the waterside</Label>
              </div>
              <div class="flex gap-4">
                <Input
                    type="checkbox"
                    id="litter_is_hard_to_reach"
                    name="litter_is_hard_to_reach"
                    @change="litter.is_hard_to_reach = $event.target.checked"
                    :checked="litter.is_hard_to_reach"
                />
                <Label for="litter_is_hard_to_reach">Litter is hard to reach</Label>
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

            <Button class="ml-3">Update</Button>
            
          </div>
        </form>
      </el-card>
    </div>
  </NuxtLayout>
</template>

<script setup lang="ts">
import Select from "~/components/Select.vue";
import {TrashType} from "~/types/trashTypeTypes";
import {Litter} from "~/types/litterTypes";
import { useGeolocation } from '@vueuse/core'
const { coords, locatedAt, error, resume, pause } = useGeolocation()
definePageMeta({middleware: ["auth"]})

const route = useRoute();

const litterId = ref(route.params.id ?? null)

const litter : any= ref<Litter | null>(null)
const trashTypes = ref<TrashType[]>([])

const selectedTrashTypes = ref<number[]>([])

const errors = ref<Record<string, string>>({})
const errorMessage = ref<string>('')
const successMessage = ref<string>('')

const litterSizeOptions = [
  {value: 1, label: 'Small'},
  {value: 2, label: 'Medium'},
  {value: 3, label: 'Large'},
]

const trashTypesOptions = computed(() => {
  return trashTypes.value.map((trashType: TrashType) => {
    return {
      value: trashType.id,
      label: trashType.title,
    }
  })
})

await loadLitter()
await loadTrashTypes()

async function loadLitter() {
  const response :any = await $fetch(`/api/litter/${litterId.value}`)
  if (response.status) {
    litter.value = response.data
    selectedTrashTypes.value = response.data.trash_types.map((trashType: TrashType) => trashType.id)

    return
  }

  return await navigateTo('/litter/list')
}

async function loadTrashTypes() {
  const response :any = await $fetch('/api/trash-types')
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
  }

  const response :any = await $fetch(`/api/litter/${litterId.value}`, {
    method: 'PUT',
    body: data,
  })

  if (response.status) {
    successMessage.value = 'Litter updated successfully'

    return await navigateTo('/litter/list')
  }

  if (response.data.errors) {
    errors.value = response.data.errors

    return
  }

  errorMessage.value = response.data.data
}


function updateCoordinates(e:any) {
  litter.value.latitude = e.lat 
  litter.value.longitude = e.lng
}



</script>
