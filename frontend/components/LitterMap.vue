<template>
  <div id="map-component">
    <client-only>
      <l-map :useGlobalLeaflet="false" :zoom="zoom" :center="center">
        <l-tile-layer
            url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
            layer-type="base"
            name="OpenStreetMap"
        />
        <template v-for="litterListCoordinate in litterListCoordinates">
          <l-marker :lat-lng="litterListCoordinate.geometry.coordinates" :radius="5" :options="{color: 'red'}" >
            <l-popup>
              <div class="flex flex-col gap-1">
                <h3 class="text-xl font-bold">Litter</h3>
                <div class="flex flex-row">
                  <div class="font-bold">Description:</div>
                  <div class="ml-2">{{litterListCoordinate.properties.description}}</div>
                </div>
                <div class="flex flex-row">
                  <div class="font-bold">ID:</div>
                  <div class="ml-2">{{litterListCoordinate.properties.id}}</div>
                </div>
                <button class="bg-blue-500 hover:bg-blue-700 transition font-bold py-2 px-4 rounded mt-2">
                  <NuxtLink :href="`/litter/edit/${litterListCoordinate.properties.id}`"><span class="text-white">Edit litter</span></NuxtLink>
                </button>
              </div>
            </l-popup>
          </l-marker>
        </template>
        <l-circle
          :latLng="{ lat: props.myLatitude, lng: props.myLongitude }"
          :radius="props.myAccuracy"
          :color="'#3388ff'"
        />
        <l-circle
          :latLng="{ lat: props.myLatitude, lng: props.myLongitude }"
          :radius="0"
          :color="'red'"
        />
      </l-map>
    </client-only>
  </div>
</template>

<script setup lang="ts">
import "leaflet/dist/leaflet.css";
import {LMap, LTileLayer, LMarker, LPopup, LCircle} from "@vue-leaflet/vue-leaflet";
import {Litter} from "~/types/litterTypes";



const LittersList = ref<Litter[]>([])
await loadLitters()
const props = defineProps<{
  myAccuracy: number;
  myLatitude: number;
  myLongitude: number;
}>();

const zoom = ref(13);
const center :any = ref({lat: props.myLatitude, lon: props.myLongitude});

const litterListCoordinates :any = computed(() => {
  return LittersList.value.map((litter) => {
    return {
      type: "Feature",
      properties: {
        description: litter.description,
        id: litter.id,
      },
      geometry: {
        type: "Point",
        coordinates: { lon: litter.longitude, lat: litter.latitude },
      },
    };
  });
})

async function loadLitters() {
  const response : any = await $fetch('/api/litter')
  if (response.status) {
    LittersList.value = response.data
  }
}





</script>
