<script setup>
import { motion } from 'motion-v';
import { useTheme } from '@/composables/useTheme';
const { isDark } = useTheme();

const stats = [
    { value: '12K+', label: 'Engineers trained' },
    { value: '50+', label: 'Cohorts shipped' },
    { value: '5', label: 'Cloud platforms' },
    { value: '4.9', label: 'Avg. rating' },
];

const ease = [0.22, 1, 0.36, 1];
</script>

<template>
    <section id="home" class="relative pt-36 pb-16 sm:pt-40 sm:pb-20">
        <div class="mx-auto max-w-7xl px-6">
            <div class="mx-auto max-w-4xl text-center">
                <motion.div
                    :initial="{ opacity: 0, y: 12 }"
                    :animate="{ opacity: 1, y: 0 }"
                    :transition="{ duration: 0.8, delay: 0.1, ease }"
                    class="inline-flex items-center gap-2.5 rounded-full glass px-4 py-1.5"
                >
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-cyan-400 opacity-60"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-cyan-300"></span>
                    </span>
                    <span class="font-mono text-[11px] uppercase tracking-[0.18em]" :class="isDark ? 'text-white/80' : 'text-slate-600'">
                        new cohort · june 2026
                    </span>
                </motion.div>

                <motion.h1
                    :initial="{ opacity: 0, y: 20 }"
                    :animate="{ opacity: 1, y: 0 }"
                    :transition="{ duration: 0.9, delay: 0.2, ease }"
                    class="mt-7 font-display text-5xl font-semibold leading-[1.02] tracking-tight text-white sm:text-6xl md:text-7xl lg:text-[84px]"
                >
                    Ship infrastructure
                    <br class="hidden sm:block" />
                    <span class="relative inline-block">
                        <span class="text-gradient-cyan">that scales.</span>
                        <svg class="absolute -bottom-3 left-0 w-full" height="14" viewBox="0 0 300 14" preserveAspectRatio="none" fill="none">
                            <path d="M2 8 Q 75 2 150 7 T 298 6" stroke="url(#heroUnderline)" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                            <defs>
                                <linearGradient id="heroUnderline" x1="0" x2="1">
                                    <stop offset="0" stop-color="#22d3ee" stop-opacity="0"/>
                                    <stop offset="0.5" stop-color="#22d3ee"/>
                                    <stop offset="1" stop-color="#f59e0b" stop-opacity="0.8"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </span>
                </motion.h1>

                <motion.p
                    :initial="{ opacity: 0, y: 20 }"
                    :animate="{ opacity: 1, y: 0 }"
                    :transition="{ duration: 0.9, delay: 0.35, ease }"
                    class="mx-auto mt-8 max-w-2xl text-lg leading-relaxed text-white/65 sm:text-xl"
                >
                    Practical DevOps courses and 1:1 mentorship from an engineer who's shipped
                    production systems across AWS, Azure, and GCP. No jargon. No fluff. Just
                    the patterns that actually work.
                </motion.p>

                <motion.div
                    :initial="{ opacity: 0, y: 20 }"
                    :animate="{ opacity: 1, y: 0 }"
                    :transition="{ duration: 0.9, delay: 0.5, ease }"
                    class="mt-10 flex flex-col items-center justify-center gap-3 sm:flex-row"
                >
                    <a
                        href="#courses"
                        class="group relative inline-flex items-center gap-2 overflow-hidden rounded-xl px-6 py-3.5 text-sm font-semibold transition"
                        :class="isDark
                            ? 'bg-white text-ink-900 shadow-[0_20px_50px_-12px_rgba(34,211,238,0.5)] hover:shadow-[0_20px_60px_-12px_rgba(34,211,238,0.7)]'
                            : 'bg-indigo-600 text-[#ffffff] shadow-[0_20px_50px_-12px_rgba(99,102,241,0.45)] hover:shadow-[0_20px_60px_-12px_rgba(99,102,241,0.65)] hover:bg-indigo-500'"
                    >
                        <span>Browse Courses</span>
                        <svg class="h-4 w-4 transition group-hover:translate-x-0.5" viewBox="0 0 20 20" fill="none">
                            <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <a
                        href="#services"
                        class="group inline-flex items-center gap-2 rounded-xl glass px-6 py-3.5 text-sm font-semibold text-white transition hover:border-white/20"
                    >
                        <svg class="h-4 w-4 text-cyan-300" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10" cy="10" r="7"/><path d="m8 7 5 3-5 3z" fill="currentColor"/></svg>
                        Watch intro · 2 min
                    </a>
                </motion.div>
            </div>

            <motion.div
                :initial="{ opacity: 0, y: 30 }"
                :animate="{ opacity: 1, y: 0 }"
                :transition="{ duration: 1, delay: 0.7, ease }"
                class="mx-auto mt-14 grid max-w-4xl grid-cols-2 gap-px overflow-hidden rounded-2xl glass sm:grid-cols-4"
            >
                <div
                    v-for="s in stats"
                    :key="s.label"
                    class="bg-ink-950/20 px-6 py-7 text-center"
                >
                    <div class="font-display text-3xl font-semibold tracking-tight text-white sm:text-4xl">
                        {{ s.value }}
                    </div>
                    <div class="mt-2 font-mono text-[10px] uppercase tracking-[0.15em] text-cyan-300/70">
                        {{ s.label }}
                    </div>
                </div>
            </motion.div>

            <motion.div
                :initial="{ opacity: 0 }"
                :animate="{ opacity: 1 }"
                :transition="{ duration: 1.2, delay: 1, ease }"
                class="mt-10 text-center"
            >
                <div class="font-mono text-[10px] uppercase tracking-[0.25em] text-white/30">
                    — Trusted by engineers at —
                </div>
                <div class="mt-5 flex flex-wrap items-center justify-center gap-x-10 gap-y-4 font-display text-sm font-semibold uppercase tracking-widest text-white/35">
                    <span>Razorpay</span>
                    <span class="h-1 w-1 rounded-full bg-white/20"></span>
                    <span>Swiggy</span>
                    <span class="h-1 w-1 rounded-full bg-white/20"></span>
                    <span>Zerodha</span>
                    <span class="h-1 w-1 rounded-full bg-white/20"></span>
                    <span>Flipkart</span>
                    <span class="h-1 w-1 rounded-full bg-white/20"></span>
                    <span>PhonePe</span>
                </div>
            </motion.div>
        </div>
    </section>
</template>
