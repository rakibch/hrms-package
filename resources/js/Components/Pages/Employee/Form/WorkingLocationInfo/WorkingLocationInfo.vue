<script setup lang="ts">
import { Location, OfficialInfo } from "@/App/Interfaces/employees";
import TextInput from '@/Components/Others/TextInput.vue';
import { Label, Select } from "@softzino/st-uikit";
import Checkbox from "@/Components/Checkbox.vue";
import { countries } from '@/App/Utils/const';
import 'leaflet/dist/leaflet.css';
import L from 'leaflet';
import { ref, onMounted, watch } from 'vue';


const model = defineModel<Location>({
    default: {
        isSameAsPresentAddress: false,
        country: '',
        city: '',
        streetAddress: '',
        stateOrProvince: '',
        postcode: '',
        lat: '23.8103',
        long: '90.4125',
    },
});

const countryOptions = ref(
    countries.map((country) => ({
        label: country.label,
        value: String(country.value),
    })),
);

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
        getPostcode(lat, lng);
    });

    // Update marker position when the map is clicked
    map.on('click', (event) => {
        const { lat, lng } = event.latlng;
        marker.setLatLng([lat, lng]);
        selectedLocation.value = { lat, lng };
        getPostcode(lat, lng);
    });
}

onMounted(() => {
    initMap();
});

watch(selectedLocation, (newLocation) => {
    model.value.lat = newLocation.lat.toFixed(4);
    model.value.long = newLocation.lng.toFixed(4);
});
</script>

<template>
    <div class="w-full rounded-xl border border-gray-200 p-4">
        <div class="mb-4 border-b border-gray-200 pb-4 font-semibold text-gray-800">
            Working Location
        </div>
        <div>
            <div class="grid grid-cols-2 gap-4">
                <!-- Checkbox for "Same as present address" -->
                <div class="col-span-2 flex items-center gap-2">
                    <Checkbox
                        id="is-permanent-address-same-as-present"
                        v-model="model.isSameAsPresentAddress"
                        :checked="model.isSameAsPresentAddress"
                    />
                    <Label
                        text="Same as present address"
                        for="is-permanent-address-same-as-present"
                        class="cursor-pointer font-medium text-gray-700"
                    />
                </div>

                <!-- Country -->
                <div>
                    <Label
                        text="Country"
                        for="present-country"
                        :required="true"
                        class="input-label"
                    />
                    <Select
                        id="present-country"
                        :required="true"
                        :options="countryOptions"
                        placeholder="Select"
                        v-model="model.country"
                        :disabled="model.isSameAsPresentAddress"
                        clearable
                        class="input mt-1.5"
                    />
                </div>

                <!-- City -->
                <TextInput
                    id="permanent-city"
                    required
                    label="City"
                    v-model="model.city"
                    :disabled="model.isSameAsPresentAddress"
                    type="text"
                    placeholder="Write Here"
                />

                <!-- Street Address -->
                <TextInput
                    id="permanent-street-address"
                    class="col-span-2"
                    required
                    label="Street Address"
                    v-model="model.street"
                    :disabled="model.isSameAsPresentAddress"
                    type="text"
                    placeholder="Write Here"
                />

                <!-- State/Province -->
                <TextInput
                    id="permanent-state"
                    required
                    label="State / Province"
                    v-model="model.state"
                    :disabled="model.isSameAsPresentAddress"
                    type="text"
                    placeholder="Write Here"
                />

                <!-- Postcode -->
                <TextInput
                    id="permanent-postcode"
                    required
                    label="Postcode"
                    v-model="model.postal_code"
                    :disabled="model.isSameAsPresentAddress"
                    type="text"
                    placeholder="Write Here"
                />

                <!-- Map and Selected Location -->
                <div class="col-span-2">
                    <div class="font-semibold text-gray-700">Basic Information</div>
                    <div class="text-gray-600">Write about employee basic information</div>
                    <div id="map" style="height: 400px; width: 100%;"></div>
                    <p class="mt-4">
                        Selected Location: Latitude: {{ selectedLocation.lat }}, Longitude: {{ selectedLocation.lng }}
<!--                        <br>Postcode: {{ postcode }}-->
                    </p>
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
