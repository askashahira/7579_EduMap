<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref, watch } from 'vue';
import 'leaflet/dist/leaflet.css';
import L from 'leaflet';
import 'leaflet.heat';
import axios from 'axios';

let map = null;
let heatLayer = null; 
const mapContainer = ref(null);
const isHeatmapVisible = ref(false);
const markerLayers = L.layerGroup();

// --- DATA DUMMY (Diperbanyak) ---
const schools = ref([
    { id: 1, name: 'SDN 1 Banda Aceh', lat: 5.558, lng: 95.322, status: 'Rendah' },
    { id: 2, name: 'SDN 5 Meuraxa', lat: 5.565, lng: 95.310, status: 'Sedang' },
    { id: 3, name: 'SDN 10 Lhoknga', lat: 5.480, lng: 95.250, status: 'Tinggi' },
    { id: 4, name: 'SDN 2 Peukan Bada', lat: 5.510, lng: 95.290, status: 'Rendah' },
    { id: 5, name: 'SDN 3 Sabang', lat: 5.890, lng: 95.320, status: 'Sedang' },
    { id: 6, name: 'SDN 1 Sigli', lat: 5.383, lng: 95.960, status: 'Tinggi' },
    { id: 7, name: 'SDN 2 Calang', lat: 4.635, lng: 95.598, status: 'Tinggi' },
    { id: 8, name: 'SDN 1 Lhokseumawe', lat: 5.178, lng: 97.150, status: 'Rendah' },
    { id: 9, name: 'SDN 4 Langsa', lat: 4.468, lng: 97.969, status: 'Sedang' },
    { id: 10, name: 'SDN 1 Takengon', lat: 4.621, lng: 96.852, status: 'Tinggi' },
    { id: 11, name: 'SDN 2 Meulaboh', lat: 4.143, lng: 96.128, status: 'Sedang' },
    { id: 12, name: 'SDN 7 Kutacane', lat: 3.483, lng: 97.805, status: 'Tinggi' },
    { id: 13, name: 'SDN 1 Blangkejeren', lat: 3.998, lng: 97.294, status: 'Tinggi' },
    { id: 14, name: 'SDN 2 Tapaktuan', lat: 3.265, lng: 97.185, status: 'Sedang' },
    { id: 15, name: 'SDN 1 Singkil', lat: 2.285, lng: 97.798, status: 'Tinggi' },
    { id: 16, name: 'SDN 1 Bireuen', lat: 5.205, lng: 96.702, status: 'Rendah' },
]);
const regencies = ref([
    { id: 1, name: 'Kab. Aceh Besar', lat: 5.43, lng: 95.45, zoom: 10 },
    { id: 2, name: 'Kota Banda Aceh', lat: 5.55, lng: 95.32, zoom: 12 },
    { id: 3, name: 'Kab. Pidie', lat: 5.00, lng: 96.00, zoom: 10 },
    { id: 4, name: 'Kota Sabang', lat: 5.85, lng: 95.32, zoom: 11 },
    { id: 5, name: 'Kab. Aceh Jaya', lat: 4.80, lng: 95.60, zoom: 10 },
]);
const allVillages = {
    1: [{ id: 101, name: 'Desa Lhoknga', lat: 5.48, lng: 95.25, zoom: 14 }, { id: 102, name: 'Desa Peukan Bada', lat: 5.51, lng: 95.29, zoom: 14 }],
    2: [{ id: 201, name: 'Kel. Kuta Alam', lat: 5.56, lng: 95.33, zoom: 15 }, { id: 202, name: 'Kel. Merduati', lat: 5.55, lng: 95.31, zoom: 15 }],
    3: [{ id: 301, name: 'Desa Mutiara', lat: 5.15, lng: 96.10, zoom: 13 }],
    4: [{ id: 401, name: 'Kel. Ie Meulee', lat: 5.88, lng: 95.34, zoom: 14 }],
    5: [{ id: 501, name: 'Desa Calang', lat: 4.63, lng: 95.60, zoom: 13 }],
};

const selectedRegency = ref('');
const selectedVillage = ref('');
const villages = ref([]);
const statusFilters = ref({
    Rendah: true,
    Sedang: true,
    Tinggi: true,
});

const applyMarkerFilters = () => {
    if (!markerLayers) return;
    markerLayers.clearLayers();
    
    const filteredSchools = schools.value.filter(school => statusFilters.value[school.status]);

    filteredSchools.forEach(school => {
        const markerOptions = getMarkerOptions(school.status);
        L.circleMarker([school.lat, school.lng], markerOptions)
            .bindPopup(`<b>${school.name}</b><br>Status Ketimpangan: ${school.status}`)
            .addTo(markerLayers);
    });
};

watch(statusFilters, applyMarkerFilters, { deep: true });

watch(selectedRegency, (newRegencyId) => {
    selectedVillage.value = '';
    villages.value = newRegencyId ? allVillages[newRegencyId] : [];
});

const getMarkerOptions = (status) => {
    let color = '#71717A';
    if (status === 'Rendah') color = '#22C55E';
    if (status === 'Sedang') color = '#EAB308';
    if (status === 'Tinggi') color = '#EF4444';
    return { radius: 8, fillColor: color, color: "#000", weight: 1, opacity: 1, fillOpacity: 0.9 };
};

const applyFilter = () => {
    if (!map) return;
    if (selectedVillage.value) {
        const village = villages.value.find(v => v.id === selectedVillage.value);
        if (village) map.flyTo([village.lat, village.lng], village.zoom);
    } 
    else if (selectedRegency.value) {
        const regency = regencies.value.find(r => r.id === selectedRegency.value);
        if (regency) map.flyTo([regency.lat, regency.lng], regency.zoom);
    }
};

const toggleHeatmap = async () => {
    if (heatLayer) {
        map.removeLayer(heatLayer);
        heatLayer = null;
        isHeatmapVisible.value = false;
        map.addLayer(markerLayers);
    } else {
        try {
            const response = await axios.get('/api/heatmap-data');
            const points = response.data.filter(p => p[0] && p[1]);
            
            if (points.length > 0) {
                map.removeLayer(markerLayers);
                heatLayer = L.heatLayer(points, { 
                    radius: 35, blur: 25, maxZoom: 12, max: 1.0,
                    gradient: {0.4: 'blue', 0.65: 'lime', 1: 'red'}
                }).addTo(map);
                isHeatmapVisible.value = true;
            } else {
                alert('Tidak ada data heatmap yang tersedia.');
            }
        } catch (error) {
            console.error("Gagal mengambil data heatmap:", error);
            alert('Gagal memuat data heatmap.');
        }
    }
};

onMounted(() => {
    if (mapContainer.value) {
        map = L.map(mapContainer.value).setView([4.6951, 96.7494], 8);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        applyMarkerFilters();
        map.addLayer(markerLayers);

        const legend = L.control({ position: 'bottomright' });
        legend.onAdd = function (map) {
            const div = L.DomUtil.create('div', 'info legend');
            const statuses = [
                { status: 'Rendah', color: '#22C55E' },
                { status: 'Sedang', color: '#EAB308' },
                { status: 'Tinggi', color: '#EF4444' }
            ];
            let legendHtml = '<h4>Status Ketimpangan</h4>';
            
            statuses.forEach(item => {
                legendHtml += 
                    '<div class="legend-item">' +
                        '<i style="background:' + item.color + '"></i> ' +
                        '<span>' + item.status + '</span>' +
                    '</div>';
            });

            div.innerHTML = legendHtml;
            return div;
        };
        legend.addTo(map);
    }
});
</script>

<style>
/* CSS untuk mempercantik legenda */
.info.legend {
    background: white;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
    line-height: 24px;
}
.info.legend h4 {
    margin: 0 0 5px;
    font-weight: bold;
    color: #333;
}
.legend-item {
    display: flex;
    align-items: center;
}
.legend-item i {
    width: 18px;
    height: 18px;
    float: left;
    margin-right: 8px;
    opacity: 0.9;
    border: 1px solid #999;
}
</style>

<template>
    <Head title="Peta Interaktif EduMap" />
    
    <AppLayout>
        <div class="flex h-full">
            <aside class="w-1/4 bg-gray-100 p-4 border-r border-gray-200 overflow-y-auto scrollbar-hide">
                <h3 class="text-xl font-bold mb-4 text-gray-800">Filter</h3>

                <div class="mb-4">
                    <h4 class="font-semibold mb-2 text-gray-700">Pilih Lokasi</h4>
                    <div class="mb-3">
                        <label for="regency" class="block text-sm font-medium mb-1 text-gray-600">Kota/Kabupaten</label>
                        <select id="regency" v-model="selectedRegency" class="w-full rounded border-gray-300 text-gray-800 focus:ring-primary focus:border-primary">
                            <option value="" disabled>Pilih Kota/Kabupaten...</option>
                            <option v-for="regency in regencies" :key="regency.id" :value="regency.id">{{ regency.name }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="village" class="block text-sm font-medium mb-1 text-gray-600">Desa/Kelurahan</label>
                        <select id="village" v-model="selectedVillage" :disabled="!selectedRegency" class="w-full rounded border-gray-300 text-gray-800 focus:ring-primary focus:border-primary disabled:bg-gray-200">
                            <option value="" disabled>Pilih Desa/Kelurahan...</option>
                            <option v-for="village in villages" :key="village.id" :value="village.id">{{ village.name }}</option>
                        </select>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 my-4"></div>

                <div class="mb-4">
                    <h4 class="font-semibold mb-2 text-gray-700">Fokus Jenjang</h4>
                    <div class="bg-gray-200 border border-gray-300 p-3 rounded-lg text-center">
                        <span class="font-bold text-gray-800">Sekolah Dasar (SD)</span>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="font-semibold mb-2 text-gray-700">Status Ketimpangan</h4>
                    <div class="space-y-2 text-gray-700">
                        <label class="flex items-center">
                            <input type="checkbox" v-model="statusFilters.Rendah" class="rounded border-gray-300 text-primary focus:ring-primary">
                            <span class="ml-2">Rendah</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" v-model="statusFilters.Sedang" class="rounded border-gray-300 text-primary focus:ring-primary">
                            <span class="ml-2">Sedang</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" v-model="statusFilters.Tinggi" class="rounded border-gray-300 text-primary focus:ring-primary">
                            <span class="ml-2">Tinggi</span>
                        </label>
                    </div>
                </div>

                <button @click="applyFilter" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-lg shadow-md">
                    Terapkan Filter
                </button>
                
                <div class="border-t border-gray-200 my-4"></div>

                <div class="mb-4">
                    <h4 class="font-semibold mb-2 text-gray-700">Visualisasi Tambahan</h4>
                    <button @click="toggleHeatmap" class="w-full font-bold py-2 px-4 rounded-lg"
                        :class="isHeatmapVisible ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-indigo-100 text-indigo-700 hover:bg-indigo-200'">
                        {{ isHeatmapVisible ? 'Sembunyikan Heatmap' : 'Tampilkan Heatmap' }}
                    </button>
                </div>
            </aside>

            <main class="w-3/4">
                <div ref="mapContainer" class="w-full h-full"></div>
            </main>

        </div>
    </AppLayout>
</template>