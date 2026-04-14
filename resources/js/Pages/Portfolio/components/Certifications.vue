<script setup>
import { motion } from 'motion-v';
import { certifications } from '@/data/resume';

const ease = [0.22, 1, 0.36, 1];
</script>

<template>
    <section id="certs" class="relative py-16 sm:py-20">
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
                        <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-amber-200/80">§ Credentials</span>
                    </div>
                    <h2 class="mt-4 font-display text-4xl font-semibold leading-[1.05] tracking-tight text-white sm:text-5xl md:text-6xl">
                        Paper <span class="text-white/50">trail.</span>
                    </h2>
                </div>
                <div class="hidden font-mono text-[10px] uppercase tracking-[0.15em] text-white/35 sm:block">
                    4 Active · AWS + Azure
                </div>
            </motion.div>

            <!-- Cert cards -->
            <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <motion.div
                    v-for="(cert, i) in certifications"
                    :key="cert.code"
                    :initial="{ opacity: 0, y: 24 }"
                    :whileInView="{ opacity: 1, y: 0 }"
                    :viewport="{ once: true, margin: '-60px' }"
                    :transition="{ duration: 0.6, delay: i * 0.07, ease }"
                    class="group relative rounded-2xl glass px-5 pt-6 pb-5 text-center transition hover:-translate-y-1 hover:border-cyan-300/30"
                >
                    <!-- Badge image -->
                    <div class="mx-auto mb-4 h-24 w-24 drop-shadow-[0_10px_20px_rgba(0,0,0,0.35)]">
                        <img :src="cert.badge" :alt="cert.name" class="h-full w-full object-contain" />
                    </div>

                    <h5 class="font-display text-[15px] font-semibold leading-snug tracking-tight text-white">
                        {{ cert.name }}
                    </h5>

                    <div class="mt-3 border-b border-dashed border-white/10 pb-3 font-mono text-[10px] uppercase tracking-[0.15em] text-white/45">
                        <template v-if="cert.level">
                            <span class="font-semibold text-cyan-300">{{ cert.level }}</span>
                            <span> · </span>
                        </template>
                        <span>{{ cert.code }}</span>
                    </div>

                    <a
                        :href="cert.verifyUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-4 inline-flex items-center gap-1.5 rounded-full border border-white/10 px-3 py-1.5 font-mono text-[11px] text-white/65 transition hover:border-cyan-300/40 hover:text-cyan-300"
                    >
                        Verify <span>↗</span>
                    </a>
                </motion.div>
            </div>
        </div>
    </section>
</template>
