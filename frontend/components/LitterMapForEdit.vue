<template>
  <div id="map-component">
    <client-only>
      <l-map :useGlobalLeaflet="false" :zoom="zoom" :center="center" :options="{ }">
        <l-tile-layer
            url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
            layer-type="base"
            name="OpenStreetMap"
        />
        <template v-for="litterListCoordinate in litterListCoordinates">
          <l-marker :lat-lng="litterListCoordinate.geometry.coordinates" :radius="5" :draggable="true" 
          @update:latLng="$emit('update:latLng', $event)" 
          
          :options="{color: 'red'}">
            <l-popup>
              <div class="flex flex-col gap-1">
                <h3 class="text-xl font-bold">Litter</h3>
                <div class="flex flex-row">
                  <div class="font-bold">Description:</div>
                  <div class="ml-2">{{litterListCoordinate.properties.description}}</div>
                </div>
                <div class="flex flex-row">
                </div>
              </div>
            </l-popup>
          </l-marker>
        </template>
      </l-map>
    </client-only>
  </div>
</template>

<script setup lang="ts">
import "leaflet/dist/leaflet.css";
import {LMap, LTileLayer, LMarker, LPopup} from "@vue-leaflet/vue-leaflet";
import {Litter} from "~/types/litterTypes";
import { emit } from "process";

//define props
const props = defineProps<{
  latitude: number;
  longitude: number;
}>()

const zoom = ref(13);

var latitude = props.latitude;
var longitude = props.longitude;

const center = ref({lat: latitude , lon: longitude});

const updatedLatLng = (e: any) => {
  console.log(e);
  latitude = e.lat;
  longitude = e.lng;
};



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
        coordinates: { lon: longitude, lat: latitude },
       
      },
    },
  ];
});



</script>
