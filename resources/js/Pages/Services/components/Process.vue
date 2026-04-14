<script setup>
import { motion } from 'motion-v';
import { processSteps } from '@/data/services';

const ease = [0.22, 1, 0.36, 1];
</script>

<template>
    <section id="process" class="relative py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-6">
            <!-- Section header -->
            <motion.div
                :initial="{ opacity: 0, y: 24 }"
                :whileInView="{ opacity: 1, y: 0 }"
                :viewport="{ once: true, margin: '-80px' }"
                :transition="{ duration: 0.7, ease }"
                class="flex items-end justify-between gap-6 border-b border-white/5 pb-5"
            >
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full glass px-3 py-1">
                        <span class="h-1 w-1 rounded-full bg-amber-spark"></span>
                        <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-amber-200/80">§ Process</span>
                    </div>
                    <h2 class="mt-4 max-w-[22ch] font-display text-4xl font-semibold leading-[1.05] tracking-tight text-white sm:text-5xl md:text-6xl">
                        Four checkpoints, <span class="text-white/50">no surprises.</span>
                    </h2>
                </div>
                <div class="hidden font-mono text-[10px] uppercase tracking-[0.15em] text-white/35 sm:block">
                    Discovery → Handover
                </div>
            </motion.div>

            <!-- Steps -->
            <div class="relative mt-10 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Connecting dashed line (desktop) -->
                <svg
                    class="pointer-events-none absolute left-[10%] right-[10%] top-[44px] hidden h-px w-[80%] text-white/15 lg:block"
                    viewBox="0 0 100 1"
                    preserveAspectRatio="none"
                    fill="none"
                >
                    <line x1="0" y1="0.5" x2="100" y2="0.5" stroke="currentColor" stroke-dasharray="1 2"/>
                </svg>

                <motion.div
                    v-for="(step, i) in processSteps"
                    :key="step.n"
                    :initial="{ opacity: 0, y: 24 }"
                    :whileInView="{ opacity: 1, y: 0 }"
                    :viewport="{ once: true, margin: '-60px' }"
                    :transition="{ duration: 0.55, delay: i * 0.08, ease }"
                    class="group relative rounded-2xl glass px-6 py-6 transition hover:-translate-y-0.5 hover:border-white/15"
                >
                    <!-- Step number -->
                    <div class="relative z-[1] mb-5 flex h-10 w-10 items-center justify-center rounded-full border border-white/15 bg-white/5 font-display text-sm font-bold text-cyan-300">
                        {{ step.n }}
                    </div>
                    <h4 class="font-display text-lg font-semibold tracking-tight text-white sm:text-xl">{{ step.label }}</h4>
                    <p class="mt-2 text-[13px] leading-relaxed text-white/65">{{ step.desc }}</p>

                    <!-- Arrow between cards (desktop) -->
                    <span
                        v-if="i < processSteps.length - 1"
                        class="absolute -right-[22px] top-[36px] hidden font-mono text-sm text-white/30 transition group-hover:text-cyan-300 lg:block"
                    >→</span>
                </motion.div>
            </div>
        </div>
    </section>
</template>
