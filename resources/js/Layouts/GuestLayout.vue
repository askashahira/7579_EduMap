<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <!-- Menggunakan kembali kelas gradasi dengan warna kustom -->
     <div class="min-h-screen bg-gradient-to-br from-primary to-secondary flex items-center justify-center p-4">
        
        <div class="max-w-4xl w-full flex rounded-2xl shadow-2xl overflow-hidden">
            <slot />
        </div>
    </div>
</template>