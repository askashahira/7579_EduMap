<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const user = computed(() => usePage().props.auth.user);
</script>

<template>
    <Head title="EduMap" />

    <div class="h-screen flex flex-col">
        <!-- Header tetap menggunakan gradasi yang sama -->
        <header class="bg-gradient-to-r from-primary to-secondary relative z-[1000]">
            <nav class="max-w-[85rem] w-full mx-auto px-4 sm:px-6 lg:px-8" aria-label="Global">
                <div class="flex items-center justify-between h-20">
                    <div class="flex-shrink-0">
                        <Link class="flex items-center gap-x-4" :href="route('home')">
                            <img src="/logo1.png" alt="EduMap Logo" class="h-16 w-auto">
                            <span class="text-3xl font-semibold text-white">EduMap</span>
                        </Link>
                    </div>
                    <div class="hidden md:flex items-center space-x-8">
                        <Link :href="route('dashboard')" class="text-base font-medium" :class="{'text-white border-b-2 border-white': route().current('dashboard'), 'text-gray-200 hover:text-white': !route().current('dashboard')}">Dashboard</Link>
                        <Link :href="route('map.index')" class="text-base font-medium" :class="{'text-white border-b-2 border-white': route().current('map.index'), 'text-gray-200 hover:text-white': !route().current('map.index')}">Peta</Link>
                        <Link :href="route('report.create')" class="text-base font-medium" :class="{'text-white border-b-2 border-white': route().current('report.create'), 'text-gray-200 hover:text-white': !route().current('report.create')}">Lapor Data</Link>
                        <Link :href="route('about.us')" class="text-base font-medium" :class="{'text-white border-b-2 border-white': route().current('about.us'), 'text-gray-200 hover:text-white': !route().current('about.us')}">Tentang</Link>
                    </div>
                    <div class="hidden md:flex items-center justify-end">
                        <div v-if="user" class="ml-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-white/20 hover:bg-white/30 focus:outline-none transition ease-in-out duration-150">
                                            {{ user.name }}
                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                        </button>
                                    </span>
                                </template>
                                <template #content>
                                    <DropdownLink v-if="user.role === 'admin'" :href="route('admin.dashboard')">Admin Panel</DropdownLink>
                                    <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <!-- 
            PERBAIKAN DI SINI:
            Background <main> diubah agar menggunakan gradasi yang sama dengan header.
        -->
        <main class="flex-1 overflow-y-auto bg-gradient-to-br from-primary to-secondary scrollbar-hide">
            <slot />
        </main>
    </div>
</template>