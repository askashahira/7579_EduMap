<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    success: String,
});

const form = useForm({
    school_name: '',
    province: 'Aceh',
    regency: '',
    teacher_count: null,
    student_count: null,
    internet_access: 'stabil',
    report_date: new Date().toISOString().slice(0, 10),
    latitude: null,
    longitude: null,
});

const submit = () => {
    form.post(route('report.store'), {
        onSuccess: () => form.reset('school_name', 'regency', 'teacher_count', 'student_count'),
    });
};

const getLocation = () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                form.latitude = position.coords.latitude;
                form.longitude = position.coords.longitude;
            },
            (error) => {
                console.error("Error GPS: ", error.message);
                alert("Gagal mendapatkan lokasi GPS. Pastikan Anda mengizinkan akses lokasi di browser Anda.");
            }
        );
    } else {
        alert("Geolocation tidak didukung oleh browser ini.");
    }
};

onMounted(() => {
    getLocation();
});
</script>

<template>
    <Head title="Lapor Data Sekolah" />

    <AppLayout>
        <!-- PERBAIKAN: Hapus kelas 'bg-white' dan 'overflow-hidden' dari sini -->
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h1 class="text-4xl font-bold text-white">Formulir Lapor Data Sekolah</h1>
                    <p class="text-lg text-gray-650 mt-2">Bantu kami memetakan kondisi pendidikan dengan data yang akurat.</p>
                </div>

                <div v-if="success" class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                    <p class="font-bold">Sukses!</p>
                    <p>{{ success }}</p>
                </div>
                
                <!-- Kartu formulir sekarang diberi background putihnya sendiri -->
                <div class="bg-white p-8 rounded-lg shadow-xl">
                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="school_name" class="block text-sm font-medium text-gray-700">Nama Sekolah</label>
                                <input v-model="form.school_name" type="text" id="school_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" required>
                            </div>

                            <div>
                                <label for="province" class="block text-sm font-medium text-gray-700">Provinsi</label>
                                <input v-model="form.province" type="text" id="province" disabled class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100">
                            </div>

                            <div>
                                <label for="regency" class="block text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                                <input v-model="form.regency" type="text" id="regency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" required>
                            </div>

                            <div>
                                <label for="teacher_count" class="block text-sm font-medium text-gray-700">Jumlah Guru</label>
                                <input v-model="form.teacher_count" type="number" id="teacher_count" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" required>
                            </div>

                            <div>
                                <label for="student_count" class="block text-sm font-medium text-gray-700">Jumlah Siswa</label>
                                <input v-model="form.student_count" type="number" id="student_count" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" required>
                            </div>

                            <div>
                                <label for="internet_access" class="block text-sm font-medium text-gray-700">Akses Internet</label>
                                <select v-model="form.internet_access" id="internet_access" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                                    <option value="stabil">Akses Internet Stabil</option>
                                    <option value="terbatas">Akses Internet Terbatas</option>
                                    <option value="tidak_tersedia">Akses Internet Tidak Tersedia</option>
                                </select>
                            </div>

                            <div>
                                <label for="report_date" class="block text-sm font-medium text-gray-700">Tanggal Lapor</label>
                                <input v-model="form.report_date" type="date" id="report_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" required>
                            </div>
                        </div>

                        <div class="text-xs text-gray-500 pt-2">
                            <p>Koordinat GPS Anda: {{ form.latitude ? `${form.latitude.toFixed(5)}, ${form.longitude.toFixed(5)}` : 'Mencari lokasi...' }}</p>
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-4 border-t">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Kirim Laporan
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>