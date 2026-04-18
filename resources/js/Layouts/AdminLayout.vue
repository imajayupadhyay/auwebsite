<script setup>
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Pages/Admin/components/Sidebar.vue';
import Topbar from '@/Pages/Admin/components/Topbar.vue';

defineProps({
    title: { type: String, default: 'Dashboard' },
});
</script>

<template>
    <Head>
        <meta head-key="robots" name="robots" content="noindex, nofollow" />
    </Head>

    <div class="min-h-screen antialiased" style="background: #05070d; color: rgba(255,255,255,0.88);">
        <Sidebar />

        <div class="flex flex-col" style="padding-left: 240px;">
            <Topbar :title="title" />

            <main class="flex-1 p-6 sm:p-8">
                <slot />
            </main>
        </div>
    </div>
</template>
