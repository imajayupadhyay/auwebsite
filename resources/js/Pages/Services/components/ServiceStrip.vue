<script setup>
import { motion } from 'motion-v';
import { serviceStats } from '@/data/services';

const ease = [0.22, 1, 0.36, 1];

const accentMap = {
    amber:  'text-gradient-cyan',
    teal:   'text-gradient-cyan',
    cyan:   'text-gradient-cyan',
    violet: 'text-gradient-cyan',
};
</script>

<template>
    <section class="relative py-8 sm:py-12">
        <div class="mx-auto max-w-7xl px-6">
            <motion.div
                :initial="{ opacity: 0, y: 16 }"
                :whileInView="{ opacity: 1, y: 0 }"
                :viewport="{ once: true, margin: '-80px' }"
                :transition="{ duration: 0.6, ease }"
                class="grid grid-cols-2 gap-4 border-y border-white/5 py-6 sm:grid-cols-4 sm:py-8"
            >
                <motion.div
                    v-for="(s, i) in serviceStats"
                    :key="s.label"
                    :initial="{ opacity: 0, y: 12 }"
                    :whileInView="{ opacity: 1, y: 0 }"
                    :viewport="{ once: true, margin: '-60px' }"
                    :transition="{ duration: 0.5, delay: i * 0.06, ease }"
                    class="flex items-baseline gap-3 sm:gap-4"
                >
                    <div class="font-display text-3xl font-semibold leading-none tracking-tight sm:text-4xl" :class="accentMap[s.accent] || 'text-white'">
                        {{ s.value }}
                    </div>
                    <div class="font-mono text-[9px] uppercase leading-snug tracking-[0.14em] text-white/45 sm:text-[10px]">
                        {{ s.label }}
                    </div>
                </motion.div>
            </motion.div>
        </div>
    </section>
</template>
