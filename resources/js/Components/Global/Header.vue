<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { motion } from 'motion-v';
import { useTheme } from '@/composables/useTheme';

const { isDark, toggleTheme } = useTheme();

const scrolled = ref(false);
const mobileOpen = ref(false);

const onScroll = () => {
    scrolled.value = window.scrollY > 12;
};

onMounted(() => {
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
});

onUnmounted(() => {
    window.removeEventListener('scroll', onScroll);
});

const nav = [
    { label: 'Home', href: '#home' },
    { label: 'Courses', href: '#courses' },
    { label: 'Services', href: '#services' },
    { label: 'About', href: '#about' },
    { label: 'Contact', href: '#contact' },
];
</script>

<template>
    <motion.header
        :initial="{ y: -24, opacity: 0 }"
        :animate="{ y: 0, opacity: 1 }"
        :transition="{ duration: 0.7, ease: [0.22, 1, 0.36, 1] }"
        class="fixed inset-x-0 top-0 z-50 transition-all duration-500"
        :class="scrolled ? 'pt-2' : 'pt-5'"
    >
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div
                class="flex items-center justify-between gap-6 rounded-2xl px-4 py-3 sm:px-5 sm:py-3.5 transition-all duration-500"
                :class="scrolled ? (isDark ? 'glass-strong shadow-[0_10px_40px_-15px_rgba(34,211,238,0.25)]' : 'glass-strong shadow-[0_10px_40px_-15px_rgba(99,102,241,0.18)]') : 'glass'"
            >
                <Link href="/" class="group flex items-center gap-2.5">
                    <div class="relative">
                        <div class="absolute inset-0 rounded-lg bg-cyan-glow/30 blur-md opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
                        <svg viewBox="0 0 36 36" class="relative h-9 w-9" fill="none">
                            <rect x="1" y="1" width="34" height="34" rx="9" stroke="url(#logoStroke)" stroke-width="1.2" />
                            <path d="M11 13 L8 18 L11 23" stroke="#22d3ee" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M25 13 L28 18 L25 23" stroke="#2dd4bf" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M20 11 L16 25" stroke="#f59e0b" stroke-width="1.8" stroke-linecap="round" />
                            <defs>
                                <linearGradient id="logoStroke" x1="0" y1="0" x2="36" y2="36">
                                    <stop offset="0%" stop-color="#22d3ee" stop-opacity="0.6" />
                                    <stop offset="100%" stop-color="#f59e0b" stop-opacity="0.4" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <div class="flex flex-col leading-none">
                        <span class="font-display text-[15px] font-semibold tracking-tight text-white">Ajay Upadhyay</span>
                        <span class="mt-0.5 font-mono text-[10px] uppercase tracking-[0.18em] text-cyan-300/70">devops · cloud</span>
                    </div>
                </Link>

                <nav class="hidden items-center gap-1 lg:flex">
                    <a
                        v-for="item in nav"
                        :key="item.label"
                        :href="item.href"
                        class="group relative rounded-xl px-4 py-2 text-sm font-medium text-white/70 transition hover:text-white"
                    >
                        <span class="relative z-10">{{ item.label }}</span>
                        <span class="absolute inset-0 rounded-xl bg-white/5 opacity-0 transition group-hover:opacity-100"></span>
                    </a>
                </nav>

                <div class="flex items-center gap-2">
                    <!-- Theme toggle -->
                    <button
                        @click="toggleTheme"
                        class="group grid h-9 w-9 place-items-center rounded-xl glass transition hover:border-white/20"
                        :aria-label="isDark ? 'Switch to light mode' : 'Switch to dark mode'"
                    >
                        <!-- Sun — shown in dark mode -->
                        <svg v-if="isDark" class="h-[17px] w-[17px] text-amber-300 transition group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="5"/>
                            <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
                        </svg>
                        <!-- Moon — shown in light mode -->
                        <svg v-else class="h-[17px] w-[17px] text-slate-500 transition group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                        </svg>
                    </button>

                    <a
                        href="#contact"
                        class="group relative hidden items-center gap-2 overflow-hidden rounded-xl border border-cyan-300/20 bg-gradient-to-br from-cyan-400/15 to-teal-400/5 px-4 py-2 text-sm font-semibold text-white shadow-[0_0_0_1px_rgba(34,211,238,0.05)_inset] transition hover:border-cyan-300/40 hover:shadow-[0_0_30px_-6px_rgba(34,211,238,0.5)] sm:flex"
                    >
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 shadow-[0_0_10px_rgba(52,211,153,0.9)]"></span>
                        Book a Call
                        <svg class="h-3.5 w-3.5 transition group-hover:translate-x-0.5" viewBox="0 0 20 20" fill="none">
                            <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>

                    <button
                        @click="mobileOpen = !mobileOpen"
                        class="lg:hidden rounded-xl p-2 text-white/80 transition hover:bg-white/5"
                        aria-label="Menu"
                    >
                        <svg v-if="!mobileOpen" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                        <svg v-else class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg>
                    </button>
                </div>
            </div>

            <div
                v-if="mobileOpen"
                class="glass mt-2 rounded-2xl p-3 lg:hidden"
            >
                <nav class="flex flex-col">
                    <a
                        v-for="item in nav"
                        :key="item.label"
                        :href="item.href"
                        @click="mobileOpen = false"
                        class="rounded-xl px-4 py-3 text-sm font-medium text-white/80 transition hover:bg-white/5"
                    >
                        {{ item.label }}
                    </a>
                    <a
                        href="#contact"
                        @click="mobileOpen = false"
                        class="mt-2 rounded-xl border border-cyan-300/20 bg-cyan-400/10 px-4 py-3 text-center text-sm font-semibold text-white"
                    >
                        Book a Call
                    </a>
                </nav>
            </div>
        </div>
    </motion.header>
</template>
