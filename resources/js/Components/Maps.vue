<script setup>
import { GoogleMap, Marker } from 'vue3-google-map';

const props = defineProps({
  place_id: {
    type: String,
    required: true,
  },
});

const emits = defineEmits(['notFound']);

const API_KEY = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;

const url = `https://maps.googleapis.com/maps/api/geocode/json?place_id=${props.place_id}&key=${API_KEY}`;

const center = { lat: 0, lng: 0 };

try {
  const response = await fetch(url);
  const data = await response.json();

  const location = data.results[0].geometry.location;

  center.lat = location.lat;
  center.lng = location.lng;
} catch (error) {
  emits('notFound', error);
}
</script>

<template>
  <div
    class='h-54 w-54 relative shadow-xl lg:h-72 lg:w-72 rounded-full overflow-hidden'>
    <GoogleMap
      :api-key='API_KEY'
      :center='center'
      :disable-default-ui='true'
      :gesture-handling="'none'"
      :max-zoom='20'
      :min-zoom='16'
      :zoom='18'
      :zoom-control='true'
      class='absolute inset-0'
      map-type-id='satellite'
      zoom-control-position='BOTTOM_CENTER'>
      <Marker :options='{ position: center }' />
    </GoogleMap>
  </div>
</template>

<style>
.gm-style-cc {
  display:none;
}
</style>
