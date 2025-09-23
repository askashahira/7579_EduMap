<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    reports: Object,
    success: String,
});

const updateStatus = (reportId, newStatus) => {
    if (confirm(`Anda yakin ingin ${newStatus === 'approved' ? 'menyetujui' : 'menolak'} laporan ini?`)) {
        router.patch(route('admin.report.update', { report: reportId }), {
            status: newStatus,
        }, {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Admin Dashboard" />
    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="text-3xl text-white font-bold mb-6">Laporan Menunggu Verifikasi</h1>
                
                <div v-if="success" class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                    <p>{{ success }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left">Nama Sekolah</th>
                                <th class="px-6 py-3 text-left">Kab/Kota</th>
                                <th class="px-6 py-3 text-left">Jml Guru / Siswa</th>
                                <th class="px-6 py-3 text-left">Internet</th>
                                <th class="px-6 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-if="reports.data.length === 0">
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada laporan yang menunggu verifikasi.</td>
                            </tr>
                            <tr v-for="report in reports.data" :key="report.id">
                                <td class="px-6 py-4">{{ report.school_name }}</td>
                                <td class="px-6 py-4">{{ report.regency }}</td>
                                <td class="px-6 py-4">{{ report.teacher_count }} / {{ report.student_count }}</td>
                                <td class="px-6 py-4 capitalize">{{ report.internet_access.replace('_', ' ') }}</td>
                                <td class="px-6 py-4">
                                    <button @click="updateStatus(report.id, 'approved')" class="text-green-600 hover:text-green-900 font-semibold">Setujui</button>
                                    <button @click="updateStatus(report.id, 'rejected')" class="ml-4 text-red-600 hover:text-red-900 font-semibold">Tolak</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginasi -->
                <div v-if="reports.links.length > 3" class="mt-6">
                    <div class="flex flex-wrap -mb-1">
                        <template v-for="(link, key) in reports.links" :key="key">
                            <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded" v-html="link.label" />
                            <Link v-else class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-primary focus:text-primary" :class="{ 'bg-primary text-white': link.active }" :href="link.url" v-html="link.label" />
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>