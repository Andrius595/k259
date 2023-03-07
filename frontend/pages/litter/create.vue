<script setup lang="ts">

const data = ref({
  // liiter name
  litter_name: "",
  // liiter description
  litter_description: "",
  // liiter image
  litter_image: "",
  // liiter size
  litter_size: "",
  // liiter type
  litter_type: "",
  // liiter location
  litter_location: "",
  // liiter date
  litter_date: "",
  // liiter time
  litter_time: "",
});

const errors = ref<Record<string, string[]>>({});
async function submitForm() {
  errors.value = {};

  try {
    const response = await $fetch("/api/litter/create-litter", {
      method: "POST",
      body: data.value,
    });
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
          <!-- Name -->
          <div>
            <Label for="litter_name">Litter name</Label>
            <Input
              id="litter_name"
              type="text"
              class="block mt-1 w-full"
              v-model="data.litter_name"
              :errors="errors.litter_name"
              required
              autoFocus
            />
          </div>

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
            <Label for="litter_image">Litter image (url)</Label>
            <Input
              id="litter_image"
              type="file"
              class="block mt-1 w-full"
              v-model="data.litter_image"
              :errors="errors.litter_image"
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

          <div class="mt-4">
            <Label for="litter_type">Litter type</Label>
            <input
              list="litter_type_types"
              v-model="data.litter_type"
              id="litter_type"
              name="litter_type"
            />
            <datalist id="litter_type_types">
              <option value="dog">Dog</option>
              <option value="cat">Cat</option>
              <option value="bird">Bird</option>
              <option value="fish">Fish</option>
              <option value="reptile">Reptile</option>
              <option value="other">Other</option>
            </datalist>
          </div>

          <div class="mt-4">
            <Label for="litter_location">Litter location</Label>
            <Input
              id="litter_location"
              type="text"
              class="block mt-1 w-full"
              v-model="data.litter_location"
              :errors="errors.litter_location"
              required
            />
          </div>

          <div class="mt-4">
            <Label for="litter_date">Litter date</Label>
            <Input
              id="litter_date"
              type="date"
              class="block mt-1 w-full"
              v-model="data.litter_date"
              :errors="errors.litter_date"
              required
            />
          </div>

          <div class="mt-4">
            <Label for="litter_time">Litter time</Label>
            <Input
              id="litter_time"
              type="time"
              class="block mt-1 w-full"
              v-model="data.litter_time"
              :errors="errors.litter_time"
              required
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
