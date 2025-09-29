<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({ name: '', email: '', password: '', password_confirmation: '' });
const submit = () => { form.post(route('register'), { onFinish: () => form.reset('password', 'password_confirmation'), }); };
</script>

<template>
    <GuestLayout>
        <Head title="Register" />
        
        <!-- Kolom Kiri: Formulir Pendaftaran dengan Efek Transparan -->
        <div class="w-full md:w-1/2 bg-white/95 p-8">
            <div class="flex items-center gap-x-3 mb-6">
                <img src="/logo1.png" alt="EduMap Logo" class="h-16 w-auto">
                <span class="text-2xl font-semibold text-gray-800">EduMap</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Register</h1>
            <p class="text-gray-600 mb-6">Daftar untuk melanjutkan.</p>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="name" value="Name" />
                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <div class="mt-4">
                    <InputLabel for="email" value="Email" />
                    <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <div class="mt-4">
                    <InputLabel for="password" value="Password" />
                    <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
                <div class="mt-4">
                    <InputLabel for="password_confirmation" value="Confirm Password" />
                    <TextInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>
                <div class="flex items-center justify-end mt-6">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Register
                    </PrimaryButton>
                </div>
            </form>

            <div class="mt-8 text-center border-t pt-6">
                <h3 class="font-bold text-gray-700">Sudah Punya Akun?</h3>
                <p class="text-sm text-gray-600 my-2">Login untuk mengakses dasbor dan peta interaktif kami.</p>
                <Link :href="route('login')" class="inline-block w-full py-3 px-4 bg-primary hover:bg-teal-600 text-white font-bold rounded-lg shadow-md">
                    Login Sekarang
                </Link>
            </div>
        </div>

        <!-- Kolom Kanan: Ilustrasi -->
        <div class="hidden md:block md:w-1/2 relative">
            <img 
                src="/auth-bg.jpg" 
                alt="Ilustrasi Pendidikan"
                class="absolute h-full w-full object-cover" 
            />
        </div>
    </GuestLayout>
</template>