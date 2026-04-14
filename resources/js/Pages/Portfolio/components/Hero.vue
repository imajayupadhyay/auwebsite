<script setup>
import { motion } from 'motion-v';
import { useTheme } from '@/composables/useTheme';
import { heroStats } from '@/data/resume';

const { isDark } = useTheme();
const ease = [0.22, 1, 0.36, 1];

const profileImg = '/profile.webp';

const statAccents = {
    cyan:   { dot: 'bg-cyan-400',  text: 'text-cyan-300' },
    teal:   { dot: 'bg-teal-400',  text: 'text-teal-300' },
    amber:  { dot: 'bg-amber-400', text: 'text-amber-300' },
    violet: { dot: 'bg-violet-400', text: 'text-violet-300' },
};
</script>

<template>
    <section id="home" class="relative pt-32 pb-10 sm:pt-36 sm:pb-14">
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
                <span class="text-white/60">Portfolio</span>
            </motion.nav>

            <!-- Headline row -->
            <div class="mt-6 grid gap-10 md:grid-cols-[1.35fr_1fr] md:items-center">
                <!-- Left: headline -->
                <div class="min-w-0">
                    <motion.div
                        :initial="{ opacity: 0, y: 16 }"
                        :animate="{ opacity: 1, y: 0 }"
                        :transition="{ duration: 0.6, delay: 0.05, ease }"
                        class="inline-flex items-center gap-2.5 rounded-full glass px-3.5 py-1.5"
                    >
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-70"></span>
                            <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-emerald-400 shadow-[0_0_10px_rgba(52,211,153,0.9)]"></span>
                        </span>
                        <span class="font-mono text-[10px] uppercase tracking-[0.18em] text-white/70">Available for new roles</span>
                        <span class="text-white/25">·</span>
                        <span class="font-mono text-[10px] uppercase tracking-[0.18em] text-white/50">New Delhi · IST</span>
                    </motion.div>

                    <motion.h1
                        :initial="{ opacity: 0, y: 24 }"
                        :animate="{ opacity: 1, y: 0 }"
                        :transition="{ duration: 0.8, delay: 0.15, ease }"
                        class="mt-6 font-display text-5xl font-semibold leading-[1.02] tracking-tight text-white sm:text-6xl md:text-7xl lg:text-[84px]"
                    >
                        DevOps built<br />
                        for
                        <span class="relative inline-block">
                            <span class="text-gradient-cyan">uptime.</span>
                            <svg class="absolute -bottom-3 left-0 w-full" height="14" viewBox="0 0 300 14" preserveAspectRatio="none" fill="none">
                                <path d="M2 8 Q 75 2 150 7 T 298 6" stroke="url(#pfUnderline)" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                                <defs>
                                    <linearGradient id="pfUnderline" x1="0" x2="1">
                                        <stop offset="0" stop-color="#22d3ee" stop-opacity="0"/>
                                        <stop offset="0.5" stop-color="#22d3ee"/>
                                        <stop offset="1" stop-color="#f59e0b" stop-opacity="0.8"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                        </span>
                    </motion.h1>

                    <motion.div
                        :initial="{ opacity: 0, y: 16 }"
                        :animate="{ opacity: 1, y: 0 }"
                        :transition="{ duration: 0.7, delay: 0.3, ease }"
                        class="mt-8 flex flex-wrap items-center gap-3 font-mono text-xs text-white/65"
                    >
                        <span>I ship infrastructure that stays up.</span>
                        <span class="rounded-md border border-amber-spark/30 bg-amber-spark/10 px-2.5 py-1 text-amber-200">AWS Certified</span>
                        <span class="rounded-md border border-cyan-300/30 bg-cyan-400/10 px-2.5 py-1 text-cyan-300">Azure Certified</span>
                    </motion.div>
                </div>

                <!-- Right: orbiting portrait -->
                <motion.div
                    :initial="{ opacity: 0, scale: 0.92 }"
                    :animate="{ opacity: 1, scale: 1 }"
                    :transition="{ duration: 0.9, delay: 0.25, ease }"
                    class="relative mx-auto aspect-square w-full max-w-[360px]"
                >
                    <div class="group relative h-full w-full">
                        <!-- Outer orbit -->
                        <div class="pointer-events-none absolute -inset-11 rounded-full border border-dashed border-cyan-300/25 animate-[orbit-spin_60s_linear_infinite]">
                            <span class="absolute -top-[3px] left-1/2 -ml-[3px] h-1.5 w-1.5 rounded-full bg-emerald-400 shadow-[0_0_14px_rgba(52,211,153,0.9)]"></span>
                        </div>
                        <!-- Middle broken orbit -->
                        <div class="pointer-events-none absolute -inset-[22px] rounded-full border border-amber-spark/25 border-t-transparent border-r-transparent animate-[orbit-spin_24s_linear_infinite_reverse]">
                            <span class="absolute -top-1 left-1/2 -ml-1 h-2 w-2 rounded-full bg-cyan-300 shadow-[0_0_14px_rgba(34,211,238,0.9)]"></span>
                        </div>
                        <!-- Inner dashed orbit -->
                        <div class="pointer-events-none absolute inset-0 rounded-full border border-dashed border-amber-spark/40 animate-[orbit-spin_40s_linear_infinite]">
                            <span class="absolute -top-[5px] left-1/2 -ml-[5px] h-2.5 w-2.5 rounded-full bg-amber-400 shadow-[0_0_14px_rgba(245,158,11,0.9)]"></span>
                            <span class="absolute -bottom-[5px] left-1/2 -ml-[5px] h-2.5 w-2.5 rounded-full bg-teal-400 shadow-[0_0_14px_rgba(45,212,191,0.9)] opacity-80"></span>
                        </div>

                        <!-- Portrait -->
                        <div
                            class="absolute inset-[10px] overflow-hidden rounded-full glass"
                            :class="isDark
                                ? 'shadow-[0_0_0_1px_rgba(34,211,238,0.14),0_30px_80px_-30px_rgba(34,211,238,0.35),0_20px_60px_-20px_rgba(0,0,0,0.7)]'
                                : 'shadow-[0_0_0_1px_rgba(79,70,229,0.18),0_30px_80px_-30px_rgba(79,70,229,0.4),0_20px_60px_-20px_rgba(15,23,42,0.25)]'"
                        >
                            <img
                                :src="profileImg"
                                alt="Ajay Upadhyay"
                                class="h-full w-full object-cover transition-transform duration-700 ease-[cubic-bezier(0.22,0.9,0.3,1)] group-hover:scale-105"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-full"
                                :style="isDark
                                    ? 'background: linear-gradient(145deg, rgba(34,211,238,0.18), transparent 40%, rgba(245,158,11,0.1))'
                                    : 'background: linear-gradient(145deg, rgba(99,102,241,0.2), transparent 40%, rgba(180,83,9,0.12))'"
                            ></div>
                        </div>

                        <!-- Badge -->
                        <div class="absolute -right-[4%] bottom-[4%] z-[2] inline-flex items-center gap-2 rounded-full glass-strong px-3 py-1.5 font-mono text-[10px] text-white/80">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 shadow-[0_0_10px_rgba(52,211,153,0.9)]"></span>
                            <span>Ajay · DevOps</span>
                        </div>
                    </div>
                </motion.div>
            </div>

            <!-- Bento grid -->
            <div class="mt-14 grid grid-cols-6 gap-4 md:grid-cols-12 md:auto-rows-[minmax(140px,auto)]">
                <!-- Intro -->
                <motion.div
                    :initial="{ opacity: 0, y: 24 }"
                    :whileInView="{ opacity: 1, y: 0 }"
                    :viewport="{ once: true, margin: '-60px' }"
                    :transition="{ duration: 0.6, ease }"
                    class="relative col-span-6 overflow-hidden rounded-2xl glass px-6 py-7 transition hover:border-white/15 md:col-span-7 md:row-span-2 md:px-8 md:py-8"
                >
                    <div class="font-mono text-[10px] uppercase tracking-[0.2em] text-cyan-300/70">— Intro</div>
                    <p class="mt-4 font-display text-[clamp(17px,2vw,26px)] leading-[1.35] tracking-tight text-white">
                        I'm <span class="text-gradient-cyan font-semibold">Ajay</span> — a DevOps &amp; Cloud Engineer shipping
                        multi-cloud infrastructure, CI/CD pipelines, and observability for
                        <span class="text-white/55">production systems that can't blink.</span>
                        Four years in, four certifications deep, and still genuinely enjoying it.
                    </p>
                    <div class="mt-6 flex items-center justify-between gap-2 border-t border-dashed border-white/10 pt-4 font-mono text-[11px] text-white/50">
                        <span>at · <b class="text-white/85">CloudBoson Technologies</b></span>
                        <span class="inline-flex items-center gap-1.5 text-emerald-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.9)]"></span>
                            live
                        </span>
                    </div>
                </motion.div>

                <!-- Uptime stat -->
                <motion.div
                    :initial="{ opacity: 0, y: 24 }"
                    :whileInView="{ opacity: 1, y: 0 }"
                    :viewport="{ once: true, margin: '-60px' }"
                    :transition="{ duration: 0.6, delay: 0.05, ease }"
                    class="col-span-6 grid content-between gap-4 rounded-2xl glass px-6 py-6 transition hover:border-white/15 md:col-span-5"
                >
                    <div class="font-mono text-[10px] uppercase tracking-[0.2em] text-cyan-300/70">— Uptime SLA</div>
                    <div class="font-display text-[clamp(44px,6vw,80px)] font-semibold leading-none tracking-tight text-white">
                        99.9<span class="text-gradient-cyan">%</span>
                    </div>
                    <div class="flex items-end justify-between font-mono text-[11px] text-white/55">
                        <span>maintained across 3 clouds</span>
                        <span class="text-emerald-400">↑ steady</span>
                    </div>
                </motion.div>

                <!-- Now -->
                <motion.div
                    :initial="{ opacity: 0, y: 24 }"
                    :whileInView="{ opacity: 1, y: 0 }"
                    :viewport="{ once: true, margin: '-60px' }"
                    :transition="{ duration: 0.6, delay: 0.1, ease }"
                    class="col-span-6 rounded-2xl glass px-6 py-6 transition hover:border-white/15 md:col-span-5"
                >
                    <div class="font-mono text-[10px] uppercase tracking-[0.2em] text-cyan-300/70">— Now</div>
                    <h3 class="mt-3 font-display text-xl font-semibold leading-snug tracking-tight text-white sm:text-2xl">
                        Azure CI/CD pipelines, zero-downtime multi-env deployments.
                    </h3>
                    <p class="mt-2.5 text-sm leading-relaxed text-white/60">
                        Architecting Elastic Beanstalk + Lambda + RDS stacks, wiring CloudWatch into Azure Monitor.
                    </p>
                    <div class="mt-5 flex gap-1.5">
                        <span class="h-1 flex-1 rounded-sm bg-cyan-400"></span>
                        <span class="h-1 flex-1 rounded-sm bg-cyan-400"></span>
                        <span class="h-1 flex-1 rounded-sm bg-cyan-400"></span>
                        <span class="h-1 flex-1 rounded-sm bg-cyan-400"></span>
                        <span class="h-1 flex-1 rounded-sm bg-white/10"></span>
                    </div>
                </motion.div>

                <!-- Mini stats -->
                <motion.div
                    v-for="(s, i) in heroStats"
                    :key="s.label"
                    :initial="{ opacity: 0, y: 24 }"
                    :whileInView="{ opacity: 1, y: 0 }"
                    :viewport="{ once: true, margin: '-60px' }"
                    :transition="{ duration: 0.5, delay: 0.1 + i * 0.06, ease }"
                    class="col-span-3 rounded-2xl glass px-5 py-5 transition hover:border-white/15 md:col-span-3"
                >
                    <div class="flex items-center gap-1.5">
                        <span class="h-1 w-1 rounded-full" :class="statAccents[s.accent].dot"></span>
                        <span class="font-mono text-[9px] uppercase tracking-[0.2em]" :class="statAccents[s.accent].text">{{ s.label }}</span>
                    </div>
                    <div class="mt-3 font-display text-3xl font-semibold tracking-tight text-white sm:text-4xl">
                        {{ s.value }}
                    </div>
                </motion.div>

                <!-- CTA -->
                <motion.a
                    href="#contact"
                    :initial="{ opacity: 0, y: 24 }"
                    :whileInView="{ opacity: 1, y: 0 }"
                    :viewport="{ once: true, margin: '-60px' }"
                    :transition="{ duration: 0.6, delay: 0.15, ease }"
                    class="group relative col-span-6 overflow-hidden rounded-2xl px-6 py-6 transition-transform hover:-translate-y-0.5 md:col-span-6"
                    :class="isDark
                        ? 'bg-gradient-to-br from-cyan-400/15 via-teal-400/10 to-amber-spark/15 border border-cyan-300/20'
                        : 'bg-gradient-to-br from-indigo-500/15 via-violet-500/10 to-cyan-500/15 border border-indigo-300/30'"
                >
                    <div class="flex items-center gap-2 font-mono text-[10px] font-semibold uppercase tracking-[0.15em] text-white/60">
                        <span class="h-1 w-1 rounded-full bg-cyan-300"></span>
                        <span>Start a project</span>
                    </div>
                    <h3 class="mt-3 font-display text-2xl font-semibold leading-tight tracking-tight text-white sm:text-[28px]">
                        Got infra that needs attention? Let's talk.
                    </h3>
                    <span
                        class="mt-5 inline-flex items-center gap-2 rounded-full px-4 py-2 font-mono text-[11px] font-semibold uppercase tracking-[0.12em] transition group-hover:translate-x-0.5"
                        :class="isDark ? 'bg-white text-ink-900' : 'bg-indigo-600 text-[#ffffff]'"
                    >
                        Send a message <span>→</span>
                    </span>
                    <span class="pointer-events-none absolute top-0 left-0 h-full w-1/3 animate-[cta-shimmer_4s_ease-in-out_infinite] bg-gradient-to-r from-transparent via-white/10 to-transparent"></span>
                </motion.a>

                <!-- Certifications summary -->
                <motion.div
                    :initial="{ opacity: 0, y: 24 }"
                    :whileInView="{ opacity: 1, y: 0 }"
                    :viewport="{ once: true, margin: '-60px' }"
                    :transition="{ duration: 0.6, delay: 0.2, ease }"
                    class="col-span-6 rounded-2xl glass px-6 py-6 transition hover:border-white/15 md:col-span-6"
                >
                    <div class="font-mono text-[10px] uppercase tracking-[0.2em] text-cyan-300/70">— Certifications</div>
                    <div class="mt-3 flex flex-wrap items-center gap-3">
                        <span class="font-display text-3xl font-semibold text-gradient-cyan">4×</span>
                        <div class="flex flex-col gap-1 font-mono text-xs text-white/65">
                            <span>SAA-C03 · DVA-C02</span>
                            <span>AZ-104 · AZ-900</span>
                        </div>
                        <a
                            href="#certs"
                            class="ml-auto rounded-full border border-white/10 px-3 py-1.5 font-mono text-[11px] text-white/60 transition hover:border-cyan-300/40 hover:text-cyan-300"
                        >
                            View all →
                        </a>
                    </div>
                </motion.div>
            </div>
        </div>
    </section>
</template>

<style scoped>
@keyframes orbit-spin {
    to { transform: rotate(360deg); }
}
@keyframes cta-shimmer {
    0%   { transform: translateX(-50%); }
    100% { transform: translateX(350%); }
}
</style>
