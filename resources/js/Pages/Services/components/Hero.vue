<script setup>
import { motion } from 'motion-v';
import { services } from '@/data/services';

defineEmits(['open-inquiry']);

const ease = [0.22, 1, 0.36, 1];

const dotMap = {
    amber:  'bg-amber-400',
    cyan:   'bg-cyan-400',
    teal:   'bg-teal-400',
    violet: 'bg-violet-400',
    rose:   'bg-rose-400',
};

const shortMap = {
    'AWS Cloud Setup':             'AWS Cloud',
    'AWS Serverless & Events':     'Serverless',
    'Azure Cloud Engineering':     'Azure',
    'Azure DevOps Pipelines':      'Azure DevOps',
    'Kubernetes Engineering':      'Kubernetes',
    'Docker & Containers':         'Docker',
    'Terraform & IaC':             'Terraform',
    'CI/CD Automation':            'CI/CD',
    'Observability Stack':         'Observability',
    'Cloud Monitoring & APM':      'Monitoring',
    'Full-Stack Web Development':  'Web Dev',
    'AI Dev Tooling':              'AI Tooling',
};

const shortName = (title) => shortMap[title] || title;
</script>

<template>
    <section id="top" class="relative pt-32 pb-6 sm:pt-36 sm:pb-10">
        <div class="mx-auto max-w-7xl px-6">

            <!-- Breadcrumb -->
            <motion.nav
                :initial="{ opacity: 0, y: 8 }"
                :animate="{ opacity: 1, y: 0 }"
                :transition="{ duration: 0.5, ease }"
                class="flex items-center gap-2 text-xs text-white/35"
                aria-label="Breadcrumb"
            >
                <a href="/" class="transition hover:text-white/65">Home</a>
                <svg class="h-3 w-3 opacity-50" viewBox="0 0 20 20" fill="none">
                    <path d="M7 7l3 3-3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="text-white/60">Services</span>
            </motion.nav>

            <!-- Meta row -->
            <motion.div
                :initial="{ opacity: 0, y: 16 }"
                :animate="{ opacity: 1, y: 0 }"
                :transition="{ duration: 0.6, delay: 0.05, ease }"
                class="mt-6 flex flex-wrap items-center gap-x-3 gap-y-2"
            >
                <div class="inline-flex items-center gap-2.5 rounded-full glass px-3.5 py-1.5">
                    <span class="relative flex h-1.5 w-1.5">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-amber-spark opacity-70"></span>
                        <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-amber-spark shadow-[0_0_10px_rgba(245,158,11,0.9)]"></span>
                    </span>
                    <span class="font-mono text-[10px] uppercase tracking-[0.18em] text-white/70">§ Services</span>
                </div>
                <span class="font-mono text-[10px] uppercase tracking-[0.14em] text-white/40">12 Offerings</span>
                <span class="font-mono text-[10px] text-white/20">·</span>
                <span class="font-mono text-[10px] uppercase tracking-[0.14em] text-white/40">Booking Q2</span>
                <span class="font-mono text-[10px] text-white/20">·</span>
                <span class="font-mono text-[10px] uppercase tracking-[0.14em] text-emerald-400">&lt; 24h reply</span>
            </motion.div>

            <!-- Headline -->
            <motion.h1
                :initial="{ opacity: 0, y: 24 }"
                :animate="{ opacity: 1, y: 0 }"
                :transition="{ duration: 0.85, delay: 0.15, ease }"
                class="mt-6 max-w-[18ch] font-display text-5xl font-semibold leading-[1.02] tracking-tight text-white sm:text-6xl md:text-7xl lg:text-[92px]"
            >
                DevOps, delivered
                <span class="relative inline-block">
                    <span class="text-gradient-cyan">on&nbsp;rails.</span>
                    <svg class="absolute -bottom-3 left-0 w-full" height="14" viewBox="0 0 300 14" preserveAspectRatio="none" fill="none">
                        <path d="M2 8 Q 75 2 150 7 T 298 6" stroke="url(#svcUnderline)" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                        <defs>
                            <linearGradient id="svcUnderline" x1="0" x2="1">
                                <stop offset="0"   stop-color="#22d3ee" stop-opacity="0"/>
                                <stop offset="0.5" stop-color="#22d3ee"/>
                                <stop offset="1"   stop-color="#f59e0b" stop-opacity="0.8"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </span>
            </motion.h1>

            <!-- Subcopy + CTAs -->
            <motion.div
                :initial="{ opacity: 0, y: 16 }"
                :animate="{ opacity: 1, y: 0 }"
                :transition="{ duration: 0.7, delay: 0.3, ease }"
                class="mt-10 grid gap-6 md:grid-cols-[1fr_auto] md:items-end"
            >
                <p class="max-w-[56ch] text-base leading-relaxed text-white/65 sm:text-lg">
                    Fixed scope. Weekly demos. Documented handover. Pick an engagement,
                    send a brief — reply within 24&nbsp;hours.
                </p>
                <div class="flex flex-wrap items-center gap-3">
                    <button
                        @click="$emit('open-inquiry')"
                        class="group inline-flex items-center gap-2 rounded-full px-5 py-3 font-mono text-[11px] font-semibold uppercase tracking-[0.12em] transition bg-white text-ink-900 shadow-[0_15px_40px_-12px_rgba(34,211,238,0.45)] hover:shadow-[0_15px_50px_-12px_rgba(34,211,238,0.65)] hover:-translate-y-0.5"
                    >
                        <span>Send brief</span>
                        <span class="transition group-hover:translate-x-0.5">→</span>
                    </button>
                    <a
                        href="#offerings"
                        class="group inline-flex items-center gap-2 rounded-full glass px-5 py-3 font-mono text-[11px] font-semibold uppercase tracking-[0.12em] text-white/75 transition hover:border-white/20 hover:text-white"
                    >
                        <span>Browse</span>
                        <span class="transition group-hover:translate-y-0.5">↓</span>
                    </a>
                </div>
            </motion.div>

            <!-- Service tag rail -->
            <motion.div
                :initial="{ opacity: 0 }"
                :animate="{ opacity: 1 }"
                :transition="{ duration: 0.7, delay: 0.45, ease }"
                class="mt-10 border-t border-white/5 pt-5"
            >
                <div class="flex flex-wrap items-center gap-x-3.5 gap-y-2 font-mono text-[11px]">
                    <span class="pr-1 uppercase tracking-[0.14em] text-white/35">// rail</span>
                    <template v-for="(s, i) in services" :key="s.id">
                        <a
                            href="#offerings"
                            class="group inline-flex items-center gap-1.5 text-white/60 transition hover:text-white"
                        >
                            <span :class="['h-1 w-1 rounded-full transition-transform duration-300 group-hover:scale-[2.5]', dotMap[s.accent]]"></span>
                            <span>{{ shortName(s.title) }}</span>
                        </a>
                        <span v-if="i < services.length - 1" class="text-white/15">·</span>
                    </template>
                </div>
            </motion.div>
        </div>
    </section>
</template>
