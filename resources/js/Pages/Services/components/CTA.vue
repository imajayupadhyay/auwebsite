<script setup>
import { motion } from 'motion-v';
import { useTheme } from '@/composables/useTheme';

const { isDark } = useTheme();
const ease = [0.22, 1, 0.36, 1];

defineEmits(['open-inquiry']);
</script>

<template>
    <section class="relative py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-6">
            <motion.div
                :initial="{ opacity: 0, y: 24 }"
                :whileInView="{ opacity: 1, y: 0 }"
                :viewport="{ once: true, margin: '-80px' }"
                :transition="{ duration: 0.75, ease }"
                class="relative overflow-hidden rounded-3xl px-6 py-12 sm:px-12 sm:py-16"
                :class="isDark
                    ? 'bg-gradient-to-br from-cyan-400/15 via-teal-400/10 to-amber-spark/15 border border-cyan-300/25'
                    : 'bg-gradient-to-br from-indigo-500/15 via-violet-500/10 to-cyan-500/15 border border-indigo-300/30'"
            >
                <!-- Shimmer -->
                <span class="pointer-events-none absolute top-0 left-0 h-full w-1/3 animate-[cta-shimmer_4s_ease-in-out_infinite] bg-gradient-to-r from-transparent via-white/10 to-transparent"></span>

                <!-- Grid overlay -->
                <svg class="pointer-events-none absolute inset-0 h-full w-full opacity-[0.08]" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="ctaGrid" width="32" height="32" patternUnits="userSpaceOnUse">
                            <path d="M 32 0 L 0 0 0 32" fill="none" stroke="currentColor" stroke-width="0.6"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#ctaGrid)" class="text-white"/>
                </svg>

                <div class="relative grid items-center gap-10 lg:grid-cols-[1.5fr_1fr]">
                    <div>
                        <div class="mb-4 flex items-center gap-2 font-mono text-[10px] font-semibold uppercase tracking-[0.14em] text-white/60">
                            <span class="h-1.5 w-1.5 rounded-full bg-cyan-300 shadow-[0_0_10px_rgba(34,211,238,0.9)]"></span>
                            <span>§ Start a project</span>
                        </div>
                        <h3 class="max-w-[18ch] font-display text-3xl font-semibold leading-[1.02] tracking-tight text-white sm:text-4xl md:text-5xl">
                            Got infra that needs attention?
                        </h3>
                        <p class="mt-5 max-w-[52ch] font-mono text-[13px] leading-relaxed text-white/60 sm:text-sm">
                            Send a brief. I'll reply within 24 hours with scope, timeline, and a fixed quote — no calls required to get started.
                        </p>
                    </div>

                    <div class="flex flex-col gap-3">
                        <button
                            type="button"
                            @click="$emit('open-inquiry')"
                            class="group inline-flex items-center justify-between gap-2 rounded-full px-5 py-3.5 font-mono text-[11px] font-semibold uppercase tracking-[0.12em] transition"
                            :class="isDark
                                ? 'bg-white text-ink-900 shadow-[0_15px_40px_-12px_rgba(34,211,238,0.5)] hover:shadow-[0_15px_50px_-12px_rgba(34,211,238,0.7)]'
                                : 'bg-indigo-600 text-[#ffffff] shadow-[0_15px_40px_-12px_rgba(99,102,241,0.5)] hover:bg-indigo-500'"
                        >
                            <span>Send a brief</span>
                            <span class="transition group-hover:translate-x-0.5">→</span>
                        </button>
                        <a
                            href="mailto:ajayupadhyaydevops@gmail.com"
                            class="group inline-flex items-center justify-between gap-2 rounded-full glass px-5 py-3.5 font-mono text-[11px] font-semibold uppercase tracking-[0.12em] text-white/80 transition hover:border-white/20 hover:text-white"
                        >
                            <span>Email directly</span>
                            <span class="transition group-hover:translate-x-0.5">↗</span>
                        </a>
                    </div>
                </div>
            </motion.div>
        </div>
    </section>
</template>

<style scoped>
@keyframes cta-shimmer {
    0%   { transform: translateX(-50%); }
    100% { transform: translateX(350%); }
}
</style>
