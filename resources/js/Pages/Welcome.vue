<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const user = computed(() => usePage().props.auth.user);
</script>

<template>
    <Head title="Selamat Datang di EduMap" />

    <div class="bg-gradient-to-br from-primary to-secondary min-h-screen relative">

        <!-- ========== HEADER / NAVIGASI ========== -->
        <header class="absolute top-0 left-0 right-0 z-50">
            <nav class="max-w-[85rem] w-full mx-auto px-4 sm:flex sm:items-center sm:justify-between py-4" aria-label="Global">
                
                <!-- PERUBAHAN 1: LOGO DIPERBESAR & NAMA FILE DIUBAH -->
                <Link class="flex items-center gap-x-4 flex-none text-3xl font-semibold text-white" :href="route('home')">
                    <!-- Nama file diubah ke logo1.png dan ukuran diubah dari h-10 ke h-12 -->
                    <img src="/logo1.png" alt="EduMap Logo" class="h-20 w-auto">
                    <span>EduMap</span>
                </Link>

                <!-- Menu Navigasi -->
                <div class="flex items-center gap-x-8"> 
                    <!-- PERUBAHAN 2: TULISAN MENU DIPERBESAR -->
                    <div class="hidden md:flex items-center gap-x-8"> 
                        <Link :href="route('home')" class="font-medium text-lg text-gray-200 hover:text-white">Home</Link>
                        <Link :href="route('about.us')" class="font-medium text-lg text-gray-200 hover:text-white">Tentang</Link>
                        <Link :href="route('map.index')" class="font-medium text-lg text-gray-200 hover:text-white">Peta</Link>
                    </div>

                    <!-- Tombol Login / Link Dashboard -->
                    <div class="hidden md:block">
                        <Link v-if="!user" :href="route('login')" class="px-5 py-2.5 bg-white/20 text-white rounded-md font-semibold hover:bg-white/30 text-lg">
                            Login
                        </Link>
                        <div v-else class="flex items-center gap-x-8">
                            <Link :href="route('dashboard')" class="font-medium text-lg text-gray-200 hover:text-white">Dashboard</Link>
                            <Link :href="route('logout')" method="post" as="button" class="font-medium text-lg text-gray-200 hover:text-white">Logout</Link>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <!-- ========== END HEADER ========== -->

        <!-- ========== KONTEN UTAMA (Tidak ada perubahan di sini) ========== -->
        <main class="flex items-center justify-center min-h-screen">
            <div class="max-w-2xl text-center mx-auto px-4">
                <h1 class="block text-5xl font-bold text-white sm:text-6xl md:text-7xl">
                    Satu Peta untuk <span class="text-teal-300">Ketimpangan Pendidikan</span>
                </h1>
                <p class="mt-4 text-lg text-gray-200">
                    Mengidentifikasi daerah-daerah yang mengalami ketimpangan dan membantu menentukan kebijakan yang tepat.
                </p>
                <div class="mt-8">
                    <Link :href="route('map.index')" class="py-4 px-8 inline-flex items-center gap-x-2 text-base font-semibold rounded-lg border border-transparent bg-white text-secondary hover:bg-gray-200 shadow-lg">
                        Lihat Peta Sekarang
                    </Link>
                </div>
            </div>
        </main>
    </div>
</template>