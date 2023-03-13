<script setup lang="ts">
const data = ref({
  //'size','latitude','longitude','image_path','description','is_accessible_by_car','is_located_in_hole','is_under_water','is_on_the_waterside','is_hard_to_reach'
  // liiter size
  litter_size: "",
  // liiter latitude
  litter_latitude: "",
  // liiter longitude
  litter_longitude: "",
  // liiter image path
  litter_image_path: "",
  // liiter description
  litter_description: "",
  // liiter is accessible by car
  litter_is_accessible_by_car: "",
  // liiter is located in hole
  litter_is_located_in_hole: "",
  // liiter is under water
  litter_is_under_water: "",
  // liiter is on the waterside
  litter_is_on_the_waterside: "",
  // liiter is hard to reach
  litter_is_hard_to_reach: "",
});

const errors = ref<Record<string, string[]>>({});
async function submitForm() {
  errors.value = {};

  try {
    const response = await $fetch("/api/litter/create-litter", {
      method: "PUT",
      body: data.value,
    });
    return await navigateTo("/dashboard");
    // TODO show success message
  } catch (e) {
    // TODO show errors
  }

  

}
</script>

<template>
  <NuxtLayout name="auth-layout">
    <div class="container mx-auto mt-10">
      <el-card>
        <form @submit.prevent="submitForm">
          <!-- Litter size -->
          <div class="mt-4">
            <Label for="litter_description">Litter description</Label>
            <Input
              id="litter_description"
              type="text"
              class="block mt-1 w-full"
              v-model="data.litter_description"
              :errors="errors.litter_description"
              required
            />
          </div>

          <div class="mt-4">
            <Label for="litter_latitude">Litter latitude</Label>
            <Input
              id="litter_latitude"
              type="text"
              class="block mt-1 w-full"
              v-model="data.litter_latitude"
              :errors="errors.litter_latitude"
              required
            />
          </div>

          <div class="mt-4">
            <Label for="litter_longitude">Litter longitude</Label>
            <Input
              id="litter_longitude"
              type="text"
              class="block mt-1 w-full"
              v-model="data.litter_longitude"
              :errors="errors.litter_longitude"
              required
            />
          </div>

          <div class="mt-4">
            <Label for="litter_image_path">Litter image</Label>
            <Input
              id="litter_image_path"
              type="file"
              class="block mt-1 w-full"
              v-model="data.litter_image_path"
              :errors="errors.litter_image_path"
              required
            />
          </div>

          <div class="mt-4">
            <Label for="litter_size">Litter size</Label>
            <input
              list="litter_size_sizes"
              v-model="data.litter_size"
              id="litter_size"
              name="litter_size"
            />
            <datalist id="litter_size_sizes">
              <option value="small">Small</option>
              <option value="medium">Medium</option>
              <option value="large">Large</option>
            </datalist>
          </div>

          <div class="mt-4 flex flex-col">
            <Label for="litter_is_accessible_by_car"
              >Litter is accessible by car</Label
            >
            <input
              type="checkbox"
              id="litter_is_accessible_by_car"
              name="litter_is_accessible_by_car"
              v-model="data.litter_is_accessible_by_car"
            />

            <Label for="litter_is_located_in_hole"
              >Litter is located in hole</Label
            >
            <input
              type="checkbox"
              id="litter_is_located_in_hole"
              name="litter_is_located_in_hole"
              v-model="data.litter_is_located_in_hole"
            />

            <Label for="litter_is_under_water">Litter is under water</Label>
            <input
              type="checkbox"
              id="litter_is_under_water"
              name="litter_is_under_water"
              v-model="data.litter_is_under_water"
            />

            <Label for="litter_is_on_the_waterside"
              >Litter is on the waterside</Label
            >
            <input
              type="checkbox"
              id="litter_is_on_the_waterside"
              name="litter_is_on_the_waterside"
              v-model="data.litter_is_on_the_waterside"
            />

            <Label for="litter_is_hard_to_reach">Litter is hard to reach</Label>
            <input
              type="checkbox"
              id="litter_is_hard_to_reach"
              name="litter_is_hard_to_reach"
              v-model="data.litter_is_hard_to_reach"
            />
          </div>

          

          <div class="flex items-center justify-end mt-4">
            <NuxtLink
              href="/login"
              class="underline text-sm text-gray-600 hover:text-gray-900"
            >
              cancel
            </NuxtLink>

            <Button class="ml-3">Save</Button>
          </div>
        </form>
      </el-card>
    </div>
  </NuxtLayout>
</template>
