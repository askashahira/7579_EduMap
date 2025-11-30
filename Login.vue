<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});
const form = useForm({ email: '', password: '', remember: false });
const submit = () => { form.post(route('login'), { onFinish: () => form.reset('password'), }); };
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />
        
        <!-- Kolom Kiri: Formulir Login dengan Efek Transparan -->
        <div class="w-full md:w-1/2 bg-white/95 p-8">
            <div class="flex items-center gap-x-3 mb-6">
                <img src="/logo1.png" alt="EduMap Logo" class="h-16 w-auto">
                <span class="text-2xl font-semibold text-gray-800">EduMap</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Login</h1>
            <p class="text-gray-600 mb-6">Selamat datang kembali.</p>

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">{{ status }}</div>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="email" value="Email" />
                    <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username" />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <div class="mt-4">
                    <InputLabel for="password" value="Password" />
                    <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ms-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md">
                        Forgot your password?
                    </Link>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Log In
                    </PrimaryButton>
                </div>
            </form>

            <div class="mt-8 text-center border-t pt-6">
                <h3 class="font-bold text-gray-700">Belum Punya Akun?</h3>
                <p class="text-sm text-gray-600 my-2">Daftar sekarang dan ikut berkontribusi.</p>
                <Link :href="route('register')" class="inline-block w-full py-3 px-4 bg-primary hover:bg-teal-600 text-white font-bold rounded-lg shadow-md">
                    Daftar Sekarang
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