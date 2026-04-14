<script setup>
import { Head } from '@inertiajs/vue3';
import { useTheme } from '@/composables/useTheme';
import Header         from '@/Components/Global/Header.vue';
import Footer         from '@/Components/Global/Footer.vue';
import Hero           from './components/Hero.vue';
import Marquee        from './components/Marquee.vue';
import Skills         from './components/Skills.vue';
import Certifications from './components/Certifications.vue';
import Contact        from './components/Contact.vue';

const { isDark } = useTheme();
</script>

<template>
    <Head title="Portfolio — Ajay Upadhyay | DevOps & Cloud Engineer" />

    <div
        class="relative min-h-screen overflow-hidden text-white antialiased transition-colors duration-300"
        :class="isDark ? 'bg-ink-950' : 'bg-[#f5f7fa]'"
    >
        <!-- ── Background decorations ─────────────────────── -->
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div
                class="absolute inset-0 transition-all duration-500"
                :style="isDark
                    ? 'background: radial-gradient(ellipse at top right, rgba(34,211,238,0.08), transparent 55%)'
                    : 'background: radial-gradient(ellipse at top right, rgba(99,102,241,0.22), transparent 55%)'"
            />
            <div
                class="absolute inset-0 transition-all duration-500"
                :style="isDark
                    ? 'background: radial-gradient(ellipse at bottom left, rgba(245,158,11,0.06), transparent 60%)'
                    : 'background: radial-gradient(ellipse at bottom left, rgba(124,58,237,0.22), transparent 60%)'"
            />

            <!-- Grid -->
            <svg class="absolute inset-0 h-full w-full" :class="isDark ? 'opacity-[0.05]' : 'opacity-[0.18]'" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="pfGrid" width="64" height="64" patternUnits="userSpaceOnUse">
                        <path d="M 64 0 L 0 0 0 64" fill="none" :stroke="isDark ? 'white' : '#4338ca'" stroke-width="1"/>
                    </pattern>
                    <radialGradient id="pfFade" cx="50%" cy="30%" r="70%">
                        <stop offset="0%" stop-color="white" stop-opacity="1"/>
                        <stop offset="100%" stop-color="white" stop-opacity="0"/>
                    </radialGradient>
                    <mask id="pfGridMask">
                        <rect width="100%" height="100%" fill="url(#pfFade)"/>
                    </mask>
                </defs>
                <rect width="100%" height="100%" fill="url(#pfGrid)" mask="url(#pfGridMask)"/>
            </svg>

            <!-- Glow blobs -->
            <div class="absolute -top-32 -left-32 h-[520px] w-[520px] rounded-full blur-[130px] transition-all duration-500"
                :style="isDark
                    ? 'background: rgba(34,211,238,0.12);'
                    : 'background: rgba(99,102,241,0.34);'" />
            <div class="absolute top-[40%] -right-40 h-[440px] w-[440px] rounded-full blur-[140px] transition-all duration-500"
                :style="isDark
                    ? 'background: rgba(45,212,191,0.10);'
                    : 'background: rgba(14,165,233,0.28);'" />
            <div class="absolute top-[78%] left-[25%] h-[380px] w-[380px] rounded-full blur-[140px] transition-all duration-500"
                :style="isDark
                    ? 'background: rgba(245,158,11,0.06);'
                    : 'background: rgba(124,58,237,0.24);'" />

            <!-- Decorative SVG: crosshair ring -->
            <svg
                class="absolute right-[6%] top-[30%] h-48 w-48 transition-colors duration-300"
                viewBox="0 0 200 200" fill="none"
                :style="{ color: isDark ? 'rgba(34,211,238,0.18)' : 'rgba(67,56,202,0.38)' }"
            >
                <circle cx="100" cy="100" r="85" stroke="currentColor" stroke-width="1.2" stroke-dasharray="2 4"/>
                <circle cx="100" cy="100" r="52" stroke="currentColor" stroke-width="1.2"/>
                <circle cx="100" cy="100" r="22" stroke="currentColor" stroke-width="1.2"/>
                <path d="M100 5 L100 195 M5 100 L195 100" stroke="currentColor" stroke-width="0.8" stroke-dasharray="1 4"/>
            </svg>

            <!-- Decorative SVG: hex prism -->
            <svg
                class="absolute left-[4%] top-[55%] h-60 w-60 transition-colors duration-300"
                viewBox="0 0 200 200" fill="none"
                :style="{ color: isDark ? 'rgba(45,212,191,0.12)' : 'rgba(124,58,237,0.32)' }"
            >
                <path d="M30 50 L100 20 L170 50 L170 150 L100 180 L30 150 Z" stroke="currentColor" stroke-width="1.4"/>
                <path d="M30 50 L100 80 M170 50 L100 80 M100 80 L100 180" stroke="currentColor" stroke-width="1.2"/>
                <circle cx="100" cy="80" r="4" :fill="isDark ? '#22d3ee' : '#4338ca'" fill-opacity="0.9"/>
            </svg>
        </div>

        <Header />

        <main class="relative">
            <Hero />
            <Marquee />
            <Skills />
            <Certifications />
            <Contact />
        </main>

        <Footer />
    </div>
</template>
