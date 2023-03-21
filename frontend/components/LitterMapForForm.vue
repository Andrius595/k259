<template>
  <div id="map-component">
    <client-only>
      <l-map
        :useGlobalLeaflet="false"
        :zoom="zoom"
        :center="center"
        :options="{}"
      >
        <l-tile-layer
          url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
          layer-type="base"
          name="OpenStreetMap"
        />
        <template v-for="litterListCoordinate in litterListCoordinates">
          <l-marker
            :lat-lng="litterListCoordinate.geometry.coordinates"
            :radius="5"
            :draggable="true"
            @update:latLng="$emit('update:latLng', $event)"
            :options="{ color: 'red' }"
          >
            <l-popup>
              <div class="flex flex-col gap-1">
                <h3 class="text-xl font-bold">Litter</h3>
                <div class="flex flex-row">
                  <div class="font-bold">Description:</div>
                  <div class="ml-2">
                    {{ litterListCoordinate.properties.description }}
                  </div>
                </div>
                <div class="flex flex-row"></div>
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
import {
  LMap,
  LTileLayer,
  LMarker,
  LPopup,
  LCircle,
} from "@vue-leaflet/vue-leaflet";

//define props
const props = defineProps<{
  latitude: number;
  longitude: number;
  myAccuracy: number;
  myLatitude: number;
  myLongitude: number;
}>();

const zoom = ref(13);

var latitude = props.latitude;
var longitude = props.longitude;

const center: any = ref({ lat: latitude, lon: longitude });

const litterListCoordinates = computed(() => {
  return [
    {
      type: "Feature",
      properties: {
        //coordinates from props  as a description:
        description: `lat: ${latitude}, lon: ${longitude}`,
      },
      geometry: {
        type: "Point",
        coordinates: { lng: longitude, lat: latitude },
      },
    },
  ];
});
</script>
