<script setup>
import { motion } from 'motion-v';
import { skillCategories } from '@/data/resume';

const ease = [0.22, 1, 0.36, 1];

const accents = [
    { text: 'text-cyan-300',   dot: 'bg-cyan-400'   },
    { text: 'text-teal-300',   dot: 'bg-teal-400'   },
    { text: 'text-amber-200',  dot: 'bg-amber-400'  },
    { text: 'text-violet-300', dot: 'bg-violet-400' },
    { text: 'text-rose-300',   dot: 'bg-rose-400'   },
    { text: 'text-cyan-300',   dot: 'bg-cyan-400'   },
];
</script>

<template>
    <section id="stack" class="relative py-16 sm:py-20">
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
                        <span class="h-1 w-1 rounded-full bg-cyan-400"></span>
                        <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-cyan-300/80">§ Toolbox</span>
                    </div>
                    <h2 class="mt-4 font-display text-4xl font-semibold leading-[1.05] tracking-tight text-white sm:text-5xl md:text-6xl">
                        The <span class="text-white/50">stack.</span>
                    </h2>
                </div>
                <div class="hidden font-mono text-[10px] uppercase tracking-[0.15em] text-white/35 sm:block">
                    6 Stacks · 50+ Tools
                </div>
            </motion.div>

            <!-- Skill categories -->
            <div class="mt-10 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                <motion.div
                    v-for="(cat, i) in skillCategories"
                    :key="cat.name"
                    :initial="{ opacity: 0, y: 24 }"
                    :whileInView="{ opacity: 1, y: 0 }"
                    :viewport="{ once: true, margin: '-60px' }"
                    :transition="{ duration: 0.6, delay: i * 0.06, ease }"
                    class="group rounded-2xl glass px-6 py-6 transition hover:-translate-y-0.5 hover:border-white/15"
                >
                    <div class="mb-4 flex items-center justify-between border-b border-white/5 pb-3">
                        <h4 class="inline-flex items-center gap-2 font-display text-xl font-semibold tracking-tight">
                            <span class="h-1.5 w-1.5 rounded-full" :class="accents[i % accents.length].dot"></span>
                            <span :class="accents[i % accents.length].text">{{ cat.name }}</span>
                        </h4>
                        <span class="font-mono text-[10px] text-white/35">{{ String(cat.skills.length).padStart(2, '0') }}</span>
                    </div>
                    <div class="flex flex-wrap gap-1.5">
                        <span
                            v-for="skill in cat.skills"
                            :key="skill"
                            class="rounded-md border border-white/10 bg-white/5 px-2.5 py-1 font-mono text-[11px] text-white/70 transition hover:border-white/20 hover:bg-white/10 hover:text-white"
                        >{{ skill }}</span>
                    </div>
                </motion.div>
            </div>
        </div>
    </section>
</template>
