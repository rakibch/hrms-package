<template>
    <div>
        <div class="flex justify-between mb-1.5">
            <Label
                class="text-darkslategrey-800"
                text="Address"
            />
            <Button
                type="button"
                @click="getLocation()"
                class="text-primary-600 bg-white hover:bg-white text-sm font-medium gap-2 flex  p-0"
            >
                <img src="/icon/mark.svg"  alt="mark"/>
                Get Current Location
            </Button>
        </div>
        <div class="mt-2 relative" ref="addressInput">
            <textarea
                id="address"
                required
                v-model="address"
                maxlength="255"
                type="text"
                placeholder="Search for an address"
                class="w-full text-base bg-white rounded border border-gray-300"
                rows="3"
                @input="onAddressInput"
            />
            <ul v-if="searchList?.length && showDropdown" class="absolute w-108 bg-white border border-gray-300 z-10 max-h-48 overflow-y-auto rounded">
                <li
                    v-for="(location, index) in searchList"
                    :key="index"
                    class="p-2 hover:bg-gray-100 cursor-pointer"
                    @click="onSelectLocation(location)"
                >
                    {{ location.display_name }}
                </li>
            </ul>
        </div>
    </div>

    <div v-if="!isLoading" ref="mapContainer" class="w-full h-24" style="z-index: 1"></div>
    <div v-if="isLoading" class="w-full h-52 flex justify-center items-center">
        <Spinner height="40" width="40" class="z-50"/>
    </div>
</template>

<script lang="ts" setup>
import {Label, Button, Spinner} from "@softzino/st-uikit";
import {computed, defineModel, ref, watch, onMounted, onUnmounted} from "vue";
import {Toast} from "@/App/Utils";
import L, {LeafletMouseEvent, Marker, Map} from "leaflet";
import {MAP_TILES, BASE_MAP_URL} from "@/App/Utils/const";

interface Location {
    display_name: string;
    lat: number;
    lon: number;
    place_id: number;
}

const emit = defineEmits<{
    (e: "close"): void;
}>();

const map = ref<Map>();
const mapContainer = ref<HTMLElement | null>();
const selectedLocation = ref<number | undefined>()
const currentMarker = ref<Marker | null>(null);
const searchList = ref<Location[] | null>(null);
const showDropdown = ref(false);
const addressInput = ref<HTMLElement | null>(null);
const isSearching = ref<boolean>(false);
const isGettingLocation = ref<boolean>(false);
const address = defineModel<string>('address', { default: '' });
const latitude = defineModel<number>('latitude', { default: 0 });
const longitude = defineModel<number>('longitude', { default: 0 });

const customIcon = L.icon({
    iconUrl: 'icon/marker.svg',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34]
});

const isLoading = computed(() => {
    return (
        isSearching.value || isGettingLocation.value
    );
});

const initializeMarker = (lat: number, lon: number) =>{
    if(map.value){
        currentMarker.value = L.marker([lat, lon], {draggable: true, icon: customIcon})
            .addTo(map.value)
        return
    }
    Toast.Error('Map is not initialized')
}

const initializeMap = () => {
    if (mapContainer.value) {
        map.value = L.map(mapContainer.value).setView([latitude.value, longitude.value], 13);
        L.tileLayer(MAP_TILES, {
            maxZoom: 19,
        }).addTo(map.value);

        initializeMarker(latitude.value, longitude.value);

        map.value.on('click', (event: LeafletMouseEvent) => {
            const { lat, lng } = event.latlng;
            pickLocation(lat, lng);
        });
    }
};

const onAddressInput = async (event: Event) => {
    const input = (event.target as HTMLInputElement).value;
    if (input.length > 0) {
        isSearching.value = true;
        try {
            const response = await fetch(
                `${BASE_MAP_URL}/search?format=json&q=${encodeURIComponent(input)}`
            );
            searchList.value = await response.json();
            showDropdown.value = true;
        } catch (error) {
            Toast.Error("Error fetching locations: " + error);
        } finally {
            isSearching.value = false;
        }

        return
    }
    searchList.value = [];
    showDropdown.value = false;
};

const getLocation = () => {
    if (navigator.geolocation) {
        isGettingLocation.value = true;
        navigator.geolocation.getCurrentPosition(async (position) => {
            try {
                latitude.value = position.coords.latitude;
                longitude.value = position.coords.longitude;

                map.value?.setView([latitude.value, longitude.value], 13);

                if (currentMarker.value) {
                    map.value?.removeLayer(currentMarker.value as L.Marker);
                }

                initializeMarker(latitude.value, longitude.value)

                const response = await fetch(
                    `${BASE_MAP_URL}/reverse?format=json&lat=${position.coords.latitude}&lon=${position.coords.longitude}`
                );
                const data = await response.json();

                address.value = data.display_name || "Unknown Location";
                selectedLocation.value = data.place_id;
                searchList.value = [data];
            } catch (error) {
                Toast.Error("Error getting location: " + error);
            } finally {
                isGettingLocation.value = false;
            }
        });
        return
    }
    Toast.Error("Geolocation is not supported by this browser.");
};

const onSelectLocation = (location: Location) => {
    address.value = location.display_name;
    latitude.value = location.lat;
    longitude.value = location.lon;

    if (currentMarker.value) {
        map.value?.removeLayer(currentMarker.value as L.Marker);
    }

    map.value?.setView([location.lat, location.lon], 13);

    initializeMarker(location.lat, location.lon)
    showDropdown.value = false;
};

const pickLocation = async (lat: number, lng: number) => {
    latitude.value = lat;
    longitude.value = lng;

    const response = await fetch(
        `${BASE_MAP_URL}/reverse?format=json&lat=${lat}&lon=${lng}`
    );
    const data = await response.json();

    address.value = data.display_name || "Unknown Location";
    selectedLocation.value = data.place_id
    searchList.value = [data]


    if (currentMarker.value) {
        map.value?.removeLayer(currentMarker.value as L.Marker);
    }

    if (!map.value) {
        Toast.Error('Map is not initialized')
        return
    }

    if (currentMarker.value) {
        map.value.removeLayer(currentMarker.value as L.Marker);
    }

    currentMarker.value = L.marker([lat, lng], {draggable: true, icon: customIcon}).addTo(map.value);
};

const handleClickOutside = (event: MouseEvent) => {
    if (addressInput.value && !addressInput.value.contains(event.target as Node) ) {
        showDropdown.value = false;
    }
};

onMounted(() => {
    document.addEventListener('mousedown', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('mousedown', handleClickOutside);
});

watch(
    () => mapContainer.value,
    (newValue) => {
        if (!newValue) {
            return
        }
        initializeMap()
    }
);
</script>
