<script setup lang="ts">
import { defineProps,ref,onMounted,watch } from 'vue';
import L from 'leaflet';

// Store the selected location and postcode
const selectedLocation = ref({ lat: 23.8103, lng: 90.4125 }); // Default to Dhaka
const postcode = ref('');

// Fetch postcode using reverse geocoding (Nominatim API)
async function getPostcode(lat: number, lng: number) {
    const url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json&addressdetails=1`;
    try {
        const response = await fetch(url);
        const data = await response.json();
        if (data?.address?.postcode) {
            postcode.value = data.address.postcode;
        } else {
            postcode.value = 'Postcode not found';
        }
    } catch (error) {
        console.error('Error fetching postcode:', error);
    }
}
// Initialize the map
function initMap() {
    const map = L.map('map').setView([23.8103, 90.4125], 12); // Center on Dhaka
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map);

    // Add a draggable marker
    const marker = L.marker([23.8103, 90.4125], { draggable: true }).addTo(map);

    // Update selected location when the marker is dragged
    marker.on('moveend', (event) => {
        const { lat, lng } = event.target.getLatLng();
        selectedLocation.value = { lat, lng };
        getPostcode(lat, lng); // Fetch postcode when marker is dragged
    });

    // Update marker position when the map is clicked
    map.on('click', (event) => {
        const { lat, lng } = event.latlng;
        marker.setLatLng([lat, lng]);
        selectedLocation.value = { lat, lng };
        getPostcode(lat, lng); // Fetch postcode when map is clicked
    });
}

// Initialize the map on mount
onMounted(() => {
    initMap();
});

watch(selectedLocation, (newLocation) => {
    model.value.lat = newLocation.lat.toFixed(4);
    model.value.long = newLocation.lng.toFixed(4);
});

const props = defineProps(['workLocationInformation']);
</script>
<template>
    <!-- Working Location Info -->
    <div class="mx-48 rounded-xl border border-gray-300 bg-white p-4">
        <div class="mb-2 flex justify-between items-center">
            <div class="text-start font-semibold text-gray-800">Working Location</div>
            <button class="flex items-center text-[#4285F5] font-semibold hover:text-blue-800 text-sm">
                <SvgIcon name="map" :width="13" class="mr-2"/>
                View Map
            </button>
        </div>
        <hr class="mb-4" />

        <div class="mb-4 flex justify-between">
            <div class="w-full">
                <p class="text-sm text-gray-600">{{ props.workLocationInformation.work_location_street }},{{ props.workLocationInformation.work_location_state}},{{ props.workLocationInformation.work_location_city}},{{ props.workLocationInformation.work_postal_code}},{{ props.workLocationInformation.work_location_country}}</p>
                <div class="p-2">
                    <div class="col-span-2">
                        <div id="map" style="height: 400px; width: 100%;"></div>
                        <p class="mt-4">
                            Selected Location: Latitude: {{ selectedLocation.lat }}, Longitude: {{ selectedLocation.lng }}
                            <!--                        <br>Postcode: {{ postcode }}-->
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
#map {
    border: 1px solid #ccc;
    border-radius: 8px;
}
</style>
