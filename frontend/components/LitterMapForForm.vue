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
        <l-circle
            v-if="showMyLocation"
          :latLng="{ lat: props.myLatitude, lng: props.myLongitude }"
          :radius="props.myAccuracy"
          :color="'#3388ff'"
        />
        <l-circle
            v-if="showMyLocation"
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
  latitude: {
    type: Number;
    default: 54.687157;
  };
  longitude: {
    type: Number;
    default: 25.279652;
  };
  myAccuracy: number;
  myLatitude: number;
  myLongitude: number;
}>();

const showMyLocation = computed(() => {
  return props.myLatitude !== Infinity && props.myLongitude !== Infinity && props.myAccuracy !== Infinity;
})

const center :any = ref(showMyLocation.value ? {lat: props.myLatitude, lon: props.myLongitude} : {lat: 54.687157, lon: 25.279652});
const zoom = ref(showMyLocation.value ? 13 : 7);

const litterListCoordinate = ref({
      type: "Feature",
      properties: {
        //coordinates from props  as a description:
        description: `lat: ${props.latitude}, lon: ${props.longitude}`,
      },
      geometry: {
        type: "Point",
        coordinates: { lng: props.longitude, lat: props.latitude },
      },
});
</script>
