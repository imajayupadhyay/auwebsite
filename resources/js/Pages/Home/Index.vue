<script setup>
import { Head } from '@inertiajs/vue3';
import { useTheme } from '@/composables/useTheme';

const { isDark } = useTheme();
import Header from '@/Components/Global/Header.vue';
import Footer from '@/Components/Global/Footer.vue';
import Hero from './components/Hero.vue';
import Courses from './components/Courses.vue';
import Services from './components/Services.vue';
</script>

<template>
    <Head title="Ajay Upadhyay — DevOps Instructor & Cloud Architect" />

    <div
        class="relative min-h-screen overflow-hidden text-white antialiased transition-colors duration-300"
        :class="isDark ? 'bg-ink-950' : 'bg-[#eef2ff]'"
    >
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <!-- Radial top glow -->
            <div
                class="absolute inset-0 transition-all duration-500"
                :style="isDark
                    ? 'background: radial-gradient(ellipse at top, rgba(34,211,238,0.08), transparent 50%)'
                    : 'background: radial-gradient(ellipse at top, rgba(99,102,241,0.10), transparent 50%)'"
            ></div>
            <!-- Radial bottom-right glow -->
            <div
                class="absolute inset-0 transition-all duration-500"
                :style="isDark
                    ? 'background: radial-gradient(ellipse at bottom right, rgba(45,212,191,0.05), transparent 60%)'
                    : 'background: radial-gradient(ellipse at bottom right, rgba(139,92,246,0.07), transparent 60%)'"
            ></div>

            <!-- Grid -->
            <svg class="absolute inset-0 h-full w-full opacity-[0.07]" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="64" height="64" patternUnits="userSpaceOnUse">
                        <path d="M 64 0 L 0 0 0 64" fill="none" :stroke="isDark ? 'white' : '#0f172a'" stroke-width="1" />
                    </pattern>
                    <radialGradient id="fade" cx="50%" cy="40%" r="60%">
                        <stop offset="0%" stop-color="white" stop-opacity="1"/>
                        <stop offset="100%" stop-color="white" stop-opacity="0"/>
                    </radialGradient>
                    <mask id="gridMask">
                        <rect width="100%" height="100%" fill="url(#fade)"/>
                    </mask>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" mask="url(#gridMask)" />
            </svg>

            <!-- Glow blobs -->
            <div
                class="absolute -top-40 -left-32 h-[600px] w-[600px] rounded-full blur-[140px] transition-all duration-500"
                :class="isDark ? 'bg-cyan-500/[0.15]' : 'bg-indigo-400/[0.18]'"
            ></div>
            <div
                class="absolute top-[30%] -right-40 h-[500px] w-[500px] rounded-full blur-[130px] transition-all duration-500"
                :class="isDark ? 'bg-teal-400/[0.12]' : 'bg-violet-400/[0.14]'"
            ></div>
            <div
                class="absolute top-[70%] left-[20%] h-[420px] w-[420px] rounded-full blur-[140px] transition-all duration-500"
                :class="isDark ? 'bg-amber-500/[0.08]' : 'bg-blue-400/[0.12]'"
            ></div>

            <!-- Decorative SVGs -->
            <svg
                class="absolute right-[6%] top-[22%] h-56 w-56 transition-colors duration-300"
                :class="isDark ? 'text-cyan-300/20' : 'text-indigo-400/25'"
                viewBox="0 0 200 200" fill="none"
            >
                <circle cx="100" cy="100" r="90" stroke="currentColor" stroke-width="1" stroke-dasharray="3 5"/>
                <circle cx="100" cy="100" r="64" stroke="currentColor" stroke-width="1"/>
                <circle cx="100" cy="100" r="36" stroke="currentColor" stroke-width="1" stroke-dasharray="2 3"/>
                <circle cx="100" cy="10" r="4" :fill="isDark ? '#22d3ee' : '#6366f1'"/>
                <circle cx="190" cy="100" r="3" :fill="isDark ? '#2dd4bf' : '#8b5cf6'"/>
                <circle cx="100" cy="190" r="3" :fill="isDark ? '#f59e0b' : '#6366f1'"/>
                <circle cx="10" cy="100" r="3" :fill="isDark ? '#22d3ee' : '#6366f1'"/>
            </svg>

            <svg
                class="absolute left-[4%] top-[48%] h-72 w-72 transition-colors duration-300"
                :class="isDark ? 'text-teal-300/[0.12]' : 'text-violet-400/[0.18]'"
                viewBox="0 0 200 200" fill="none"
            >
                <path d="M30 50 L100 20 L170 50 L170 150 L100 180 L30 150 Z" stroke="currentColor" stroke-width="1"/>
                <path d="M30 50 L100 80 M170 50 L100 80 M100 80 L100 180" stroke="currentColor" stroke-width="1"/>
                <circle cx="100" cy="80" r="4" :fill="isDark ? '#22d3ee' : '#6366f1'" fill-opacity="0.8"/>
            </svg>

            <svg
                class="absolute right-[12%] top-[72%] h-40 w-40 transition-colors duration-300"
                :class="isDark ? 'text-amber-300/[0.18]' : 'text-blue-400/[0.22]'"
                viewBox="0 0 120 120" fill="none"
            >
                <path d="M60 10 L110 40 L110 90 L60 110 L10 90 L10 40 Z" stroke="currentColor" stroke-width="1"/>
                <path d="M60 10 L60 110 M10 40 L110 90 M110 40 L10 90" stroke="currentColor" stroke-width="0.5" stroke-dasharray="2 3"/>
            </svg>

            <!-- Bottom fade -->
            <div
                class="absolute inset-0 transition-all duration-300"
                :style="isDark
                    ? 'background: linear-gradient(to bottom, transparent, transparent, rgba(5,7,13,0.8))'
                    : 'background: linear-gradient(to bottom, transparent, transparent, rgba(238,242,255,0.8))'"
            ></div>
        </div>

        <Header />

        <main class="relative">
            <Hero />
            <Courses />
            <Services />
        </main>

        <Footer />
    </div>
</template>
