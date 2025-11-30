<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Tentang EduMap" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                
                <!-- Bagian Header Halaman -->
                 <div class="text-center mb-12 px-4">
                    <h1 class="text-5xl font-extrabold text-shadow-md">
                        <span class="text-white">Tentang</span>
                        <span class="text-primary-light"> EduMap</span>
                </h1>
                    <p class="mt-4 text-xl text-gray-600 max-w-3xl mx-auto">
                        Menjembatani Kesenjangan Data untuk Pemerataan Pendidikan Berkualitas
                    </p>
                </div>

                <!-- Bagian Konten Utama -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-8 space-y-8 text-lg text-gray-700 leading-relaxed">
                        
                        <!-- Paragraf Pembuka -->
                        <p class="text-center italic">
                            "Pendidikan adalah fondasi utama dalam membangun sumber daya manusia (SDM) yang berkualitas sekaligus memajukan bangsa."
                        </p>
                        
                        <!-- PERBAIKAN DI SINI: Menggunakan tag <strong> -->
                        <p>
                            <strong class="font-semibold">EduMap: Peta Ketimpangan Pendidikan Nasional</strong> adalah sebuah platform digital inovatif yang lahir dari keprihatinan mendalam terhadap disparitas akses dan kualitas pendidikan di Indonesia. Kami percaya bahwa setiap anak, di mana pun mereka berada, berhak atas kesempatan yang sama untuk meraih masa depan yang cerah melalui pendidikan yang layak.
                        </p>
                        
                        <!-- Visi Kami -->
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-4 border-l-4 border-primary pl-4">Visi Kami</h2>
                            <p>
                                Visi kami adalah menciptakan sebuah ekosistem data pendidikan yang transparan, partisipatif, dan berkelanjutan. Dengan menjembatani data resmi pemerintah dan realitas di lapangan melalui teknologi <strong>crowdsourcing</strong>, kami bercita-cita menjadi alat strategis dalam mendukung perumusan kebijakan berbasis bukti (<strong>evidence-based policy</strong>) untuk mencapai pemerataan pendidikan di seluruh pelosok negeri.
                            </p>
                        </div>

                        <!-- Misi Kami -->
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-4 border-l-4 border-primary pl-4">Misi Kami</h2>
                            <ul class="list-disc list-inside space-y-2">
                                <li>Memetakan ketimpangan pendidikan secara visual, interaktif, dan <strong>real-time</strong>.</li>
                                <li>Menyediakan sistem monitoring partisipatif yang inklusif bagi masyarakat, guru, dan pemangku kepentingan.</li>
                                <li>Mendorong distribusi sumber daya pendidikan yang lebih adil dengan menyoroti daerah-daerah prioritas.</li>
                                <li>Menjadi model proyek percontohan yang dapat diperluas ke tingkat nasional untuk mendukung pencapaian SDG 4.</li>
                            </ul>
                        </div>

                        <!-- Garis Pemisah -->
                        <div class="border-t border-gray-200"></div>

                        <!-- Bagian Tim -->
                        <div class="text-center pt-4">
                            <p class="text-sm text-gray-500">Created by:</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">EduMap</h3>
                            <p class="mt-4 text-gray-600">
                                Aska Shahira • Tasya Maulida 
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>