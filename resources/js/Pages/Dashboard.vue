<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { Bar, Pie } from 'vue-chartjs';
import {
    Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement
} from 'chart.js';
import { debounce } from 'lodash';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement);

const props = defineProps({
    dashboardData: Object,
    filters: Object,
    prioritySchools: Object,
});

const barChartDataVue = ref({
    labels: ['Banda Aceh', 'Aceh Besar', 'Pidie Jaya', 'Aceh Jaya', 'Sabang'],
    datasets: [{
        label: 'Rasio Murid per Guru',
        backgroundColor: '#14B8A6',
        data: props.dashboardData.barChartData
    }]
});
const pieChartDataVue = ref({
    labels: ['Memiliki Akses', 'Tidak Memiliki Akses'],
    datasets: [{
        backgroundColor: ['#14B8A6', '#FDBA74'],
        data: props.dashboardData.pieChartData
    }]
});
const chartOptions = { responsive: true, maintainAspectRatio: false };

const regencies = ref([
    { id: 1, name: 'Kab. Aceh Besar' }, { id: 2, name: 'Kota Banda Aceh' },
    { id: 3, name: 'Kab. Pidie' }, { id: 4, name: 'Kab. Aceh Jaya' },
]);
const allVillages = {
    1: [{ id: 101, name: 'Desa Lhoknga' }, { id: 102, name: 'Desa Peukan Bada' }],
    2: [{ id: 201, name: 'Kel. Kuta Alam' }, { id: 202, name: 'Kel. Merduati' }],
};
const villages = ref([]);
const selectedRegency = ref(props.filters.regency_id || '');
const selectedVillage = ref(props.filters.village_id || '');
const selectedTimeFilter = ref(props.filters.time_filter || 'yearly');

watch([selectedRegency, selectedVillage, selectedTimeFilter], debounce(() => {
    router.get(route('dashboard'), {
        regency_id: selectedRegency.value,
        village_id: selectedVillage.value,
        time_filter: selectedTimeFilter.value,
    }, {
        preserveState: true,
        replace: true,
        preserveScroll: true,
    });
}, 300));

if(selectedRegency.value) {
    villages.value = allVillages[selectedRegency.value] || [];
}
watch(selectedRegency, (newRegencyId) => {
    villages.value = newRegencyId ? allVillages[newRegencyId] : [];
    if(newRegencyId) selectedVillage.value = '';
});

watch(() => props.dashboardData, (newData) => {
    barChartDataVue.value.datasets[0].data = newData.barChartData;
    pieChartDataVue.value.datasets[0].data = newData.pieChartData;
});

const getPdfUrl = () => {
    return route('report.pdf', { regency_id: selectedRegency.value, village_id: selectedVillage.value });
};
const getCsvUrl = () => {
    return route('report.csv', { regency_id: selectedRegency.value, village_id: selectedVillage.value });
};
</script>

<template>
    <Head title="Dashboard Analitik" />

    <AppLayout>
      <div class="bg-gradient-to-br from-content-start to-content-end min-h-full">
        <div class="p-8">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-4xl font-bold text-gray-800 mb-8">Dasbor Analitik & Laporan</h1>
                
                <!-- KARTU SUMMARY YANG HILANG (DIKEMBALIKAN) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                        <div class="bg-blue-100 text-blue-600 p-4 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 8v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg></div>
                        <div class="ml-4"><p class="text-gray-500">Jumlah Sekolah</p><p class="text-3xl font-bold text-gray-900">{{ dashboardData.schoolCount.toLocaleString() }}</p></div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                        <div class="bg-green-100 text-green-600 p-4 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg></div>
                        <div class="ml-4"><p class="text-gray-500">Rasio Guru-Murid</p><p class="text-3xl font-bold text-gray-900">{{ dashboardData.teacherStudentRatio }}</p></div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                        <div class="bg-yellow-100 text-yellow-600 p-4 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071a10 10 0 0114.142 0M1.394 8.532a15 15 0 0121.212 0" /></svg></div>
                        <div class="ml-4"><p class="text-gray-500">Akses Internet</p><p class="text-3xl font-bold text-gray-900">{{ dashboardData.internetAccess }}%</p></div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                        <div class="bg-red-100 text-red-600 p-4 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6h12a6 6 0 00-6-6z" /></svg></div>
                        <div class="ml-4"><p class="text-gray-500">Putus Sekolah</p><p class="text-3xl font-bold text-gray-900">{{ dashboardData.dropoutRate }}%</p></div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-semibold">Visualisasi Data</h3>
                            <div>
                                <select v-model="selectedTimeFilter" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                                    <option value="yearly">Tahun Ini</option>
                                    <option value="monthly">Bulan Ini</option>
                                    <option value="weekly">Minggu Ini</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" style="height: 350px;">
                            <div class="flex flex-col"><p class="font-medium text-center mb-2 flex-shrink-0">Rasio Guru-Murid</p><div class="relative flex-1"><Bar :data="barChartDataVue" :options="chartOptions" /></div></div>
                            <div class="flex flex-col"><p class="font-medium text-center mb-2 flex-shrink-0">Akses Internet</p><div class="relative flex-1"><Pie :data="pieChartDataVue" :options="chartOptions" /></div></div>
                        </div>
                    </div>

                    <!-- FILTER UNDUH LAPORAN YANG HILANG (DIKEMBALIKAN) -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                         <h3 class="text-xl font-semibold mb-4">Filter & Unduh Laporan</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="kabupaten" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                                <select id="kabupaten" v-model="selectedRegency" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm">
                                    <option value="">Semua Kab/Kota</option>
                                    <option v-for="regency in regencies" :key="regency.id" :value="regency.id">{{ regency.name }}</option>
                                </select>
                            </div>
                             <div>
                                <label for="desa" class="block text-sm font-medium text-gray-700">Desa/Kelurahan</label>
                                <select id="desa" v-model="selectedVillage" :disabled="!selectedRegency" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm">
                                    <option value="">Semua Desa</option>
                                    <option v-for="village in villages" :key="village.id" :value="village.id">{{ village.name }}</option>
                                </select>
                            </div>
                            <div class="mt-6 pt-4 border-t">
                                <a :href="getPdfUrl()" class="block w-full text-center bg-secondary hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg">
                                    Unduh Laporan PDF
                                </a>
                                <a :href="getCsvUrl()" class="block w-full text-center mt-2 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg">
                                    Unduh Excel (CSV)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Rekomendasi Intervensi Prioritas</h2>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <p class="text-gray-600 mb-4">
                                Berdasarkan data yang disetujui, berikut adalah 5 sekolah dengan skor ketimpangan tertinggi.
                            </p>
                            <ul class="divide-y divide-gray-200">
                                <li v-if="!prioritySchools || prioritySchools.length === 0" class="py-4 text-center text-gray-500">
                                    Tidak ada data untuk menampilkan rekomendasi.
                                </li>
                                <li v-for="school in prioritySchools" :key="school.id" class="py-4 flex justify-between items-center">
                                    <div>
                                        <p class="font-semibold text-lg text-gray-800">{{ school.school_name }}</p>
                                        <p class="text-sm text-gray-500">{{ school.regency }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-xl text-red-500">{{ school.score.toFixed(1) }}</p>
                                        <p class="text-xs text-gray-500">Skor Ketimpangan</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
    </AppLayout>
</template>