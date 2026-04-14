<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import { useTheme } from '@/composables/useTheme';
import Header        from '@/Components/Global/Header.vue';
import Footer        from '@/Components/Global/Footer.vue';
import Hero          from './components/Hero.vue';
import ServiceStrip  from './components/ServiceStrip.vue';
import ServicesGrid  from './components/ServicesGrid.vue';
import Process       from './components/Process.vue';
import CTA           from './components/CTA.vue';
import InquiryModal  from './components/InquiryModal.vue';

const { isDark } = useTheme();

const modalOpen = ref(false);
const selectedService = ref(null);

const openModal = (service) => {
    selectedService.value = service;
    modalOpen.value = true;
};
</script>

<template>
    <Head title="Services — Ajay Upadhyay | DevOps & Cloud Engineering">
        <meta
            head-key="description"
            name="description"
            content="Twelve fixed-price DevOps and cloud engineering services — AWS and Azure architecture, Kubernetes, CI/CD pipelines, Terraform IaC, monitoring and SRE. Reply within 24 hours."
        />
    </Head>

    <div
        class="relative min-h-screen overflow-hidden text-white antialiased transition-colors duration-300"
        :class="isDark ? 'bg-ink-950' : 'bg-[#f5f7fa]'"
    >
        <!-- ── Background decorations ─────────────────────── -->
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div
                class="absolute inset-0 transition-all duration-500"
                :style="isDark
                    ? 'background: radial-gradient(ellipse at top left, rgba(245,158,11,0.06), transparent 55%)'
                    : 'background: radial-gradient(ellipse at top left, rgba(99,102,241,0.22), transparent 55%)'"
            />
            <div
                class="absolute inset-0 transition-all duration-500"
                :style="isDark
                    ? 'background: radial-gradient(ellipse at bottom right, rgba(34,211,238,0.08), transparent 60%)'
                    : 'background: radial-gradient(ellipse at bottom right, rgba(14,165,233,0.22), transparent 60%)'"
            />

            <!-- Grid -->
            <svg class="absolute inset-0 h-full w-full" :class="isDark ? 'opacity-[0.05]' : 'opacity-[0.18]'" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="svcGrid" width="64" height="64" patternUnits="userSpaceOnUse">
                        <path d="M 64 0 L 0 0 0 64" fill="none" :stroke="isDark ? 'white' : '#4338ca'" stroke-width="1"/>
                    </pattern>
                    <radialGradient id="svcFade" cx="50%" cy="30%" r="70%">
                        <stop offset="0%" stop-color="white" stop-opacity="1"/>
                        <stop offset="100%" stop-color="white" stop-opacity="0"/>
                    </radialGradient>
                    <mask id="svcGridMask">
                        <rect width="100%" height="100%" fill="url(#svcFade)"/>
                    </mask>
                </defs>
                <rect width="100%" height="100%" fill="url(#svcGrid)" mask="url(#svcGridMask)"/>
            </svg>

            <!-- Glow blobs -->
            <div class="absolute -top-32 -right-24 h-[520px] w-[520px] rounded-full blur-[130px] transition-all duration-500"
                :style="isDark
                    ? 'background: rgba(245,158,11,0.08);'
                    : 'background: rgba(124,58,237,0.32);'" />
            <div class="absolute top-[45%] -left-40 h-[460px] w-[460px] rounded-full blur-[140px] transition-all duration-500"
                :style="isDark
                    ? 'background: rgba(34,211,238,0.10);'
                    : 'background: rgba(99,102,241,0.32);'" />
            <div class="absolute top-[82%] right-[22%] h-[360px] w-[360px] rounded-full blur-[140px] transition-all duration-500"
                :style="isDark
                    ? 'background: rgba(45,212,191,0.08);'
                    : 'background: rgba(8,145,178,0.26);'" />

            <!-- Decorative SVG: pipeline rail -->
            <svg
                class="absolute left-[5%] top-[28%] h-52 w-52 transition-colors duration-300"
                viewBox="0 0 200 200" fill="none"
                :style="{ color: isDark ? 'rgba(34,211,238,0.15)' : 'rgba(67,56,202,0.34)' }"
            >
                <circle cx="40" cy="100" r="10" stroke="currentColor" stroke-width="1.4"/>
                <circle cx="100" cy="100" r="10" stroke="currentColor" stroke-width="1.4"/>
                <circle cx="160" cy="100" r="10" stroke="currentColor" stroke-width="1.4"/>
                <line x1="50" y1="100" x2="90" y2="100" stroke="currentColor" stroke-width="1.2" stroke-dasharray="2 3"/>
                <line x1="110" y1="100" x2="150" y2="100" stroke="currentColor" stroke-width="1.2" stroke-dasharray="2 3"/>
                <path d="M25 60 L175 60" stroke="currentColor" stroke-width="0.8" stroke-dasharray="1 4"/>
                <path d="M25 140 L175 140" stroke="currentColor" stroke-width="0.8" stroke-dasharray="1 4"/>
            </svg>

            <!-- Decorative SVG: service node cluster -->
            <svg
                class="absolute right-[5%] top-[60%] h-56 w-56 transition-colors duration-300"
                viewBox="0 0 200 200" fill="none"
                :style="{ color: isDark ? 'rgba(245,158,11,0.14)' : 'rgba(124,58,237,0.32)' }"
            >
                <rect x="30" y="30" width="50" height="50" rx="6" stroke="currentColor" stroke-width="1.3"/>
                <rect x="120" y="30" width="50" height="50" rx="6" stroke="currentColor" stroke-width="1.3"/>
                <rect x="75" y="120" width="50" height="50" rx="6" stroke="currentColor" stroke-width="1.3"/>
                <path d="M80 55 L120 55 M100 80 L100 120 M55 80 L75 120 M145 80 L125 120" stroke="currentColor" stroke-width="1" stroke-dasharray="2 3"/>
                <circle cx="55" cy="55" r="3" :fill="isDark ? '#22d3ee' : '#4338ca'"/>
                <circle cx="145" cy="55" r="3" :fill="isDark ? '#2dd4bf' : '#7c3aed'"/>
                <circle cx="100" cy="145" r="3" :fill="isDark ? '#f59e0b' : '#0891b2'"/>
            </svg>
        </div>

        <Header />

        <main class="relative">
            <Hero @open-inquiry="openModal(null)" />
            <ServiceStrip />
            <ServicesGrid @inquire="openModal" />
            <Process />
            <CTA @open-inquiry="openModal(null)" />
        </main>

        <Footer />

        <InquiryModal
            :show="modalOpen"
            :service="selectedService"
            @close="modalOpen = false"
        />
    </div>
</template>
