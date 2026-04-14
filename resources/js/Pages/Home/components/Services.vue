<script setup>
import { motion } from 'motion-v';
import { useTheme } from '@/composables/useTheme';
const { isDark } = useTheme();

const services = [
    {
        num: '01',
        title: '1:1 Mentorship',
        desc: 'Weekly sessions tailored to your role and stack. Career guidance, architecture reviews, and hands-on debugging — one engineer at a time.',
        bullets: ['Weekly 1-hour calls', 'Async Slack access', 'Custom learning path'],
        tag: 'Most booked',
    },
    {
        num: '02',
        title: 'Corporate Training',
        desc: 'Hands-on workshops for engineering teams — from AWS fundamentals to advanced Kubernetes operations. On-site or remote.',
        bullets: ['Custom curriculum', '4–40 engineers', 'Private Slack channel'],
        tag: null,
    },
    {
        num: '03',
        title: 'Cloud Consulting',
        desc: 'Architecture reviews, migration strategy, and infrastructure audits. I plug in with your team for 2 to 8 weeks.',
        bullets: ['Architecture reviews', 'Migration planning', 'Cost optimization'],
        tag: null,
    },
    {
        num: '04',
        title: 'Interview Prep',
        desc: 'Crack DevOps, SRE, and Platform interviews with mock system-design sessions and real feedback from an interviewer.',
        bullets: ['Mock interviews', 'System design drills', 'Offer negotiation'],
        tag: null,
    },
];
</script>

<template>
    <section id="services" class="relative py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-6">
            <motion.div
                :initial="{ opacity: 0, y: 30 }"
                :whileInView="{ opacity: 1, y: 0 }"
                :viewport="{ once: true, margin: '-80px' }"
                :transition="{ duration: 0.8, ease: [0.22, 1, 0.36, 1] }"
                class="mx-auto max-w-3xl text-center"
            >
                <div class="inline-flex items-center gap-2 rounded-full glass px-3 py-1">
                    <span class="h-1 w-1 rounded-full bg-amber-spark"></span>
                    <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-amber-200/80">02 · engagements</span>
                </div>
                <h2 class="mt-5 font-display text-4xl font-semibold leading-[1.05] tracking-tight text-white sm:text-5xl md:text-6xl">
                    Work with me, <span class="text-white/50">directly.</span>
                </h2>
                <p class="mx-auto mt-6 max-w-xl text-base leading-relaxed text-white/60">
                    Four ways to level up — whether you're an individual engineer, a team lead,
                    or a company in the middle of a cloud migration.
                </p>
            </motion.div>

            <div class="mt-16 grid gap-5 md:grid-cols-2">
                <motion.div
                    v-for="(s, i) in services"
                    :key="s.num"
                    :initial="{ opacity: 0, y: 30 }"
                    :whileInView="{ opacity: 1, y: 0 }"
                    :viewport="{ once: true, margin: '-60px' }"
                    :transition="{ duration: 0.7, delay: i * 0.1, ease: [0.22, 1, 0.36, 1] }"
                    class="group relative overflow-hidden rounded-2xl glass p-8 transition hover:border-white/15"
                >
                    <div
                        class="pointer-events-none absolute right-0 top-0 h-40 w-40 rounded-full blur-2xl transition-opacity duration-500 opacity-0 group-hover:opacity-100"
                        :class="isDark ? 'bg-gradient-to-br from-cyan-400/10 to-transparent' : 'bg-gradient-to-br from-indigo-400/12 to-transparent'"
                    ></div>

                    <div class="flex items-start justify-between">
                        <div class="font-mono text-[10px] uppercase tracking-[0.25em] text-cyan-300/70">
                            — {{ s.num }}
                        </div>
                        <span
                            v-if="s.tag"
                            class="rounded-full border border-amber-spark/30 bg-amber-spark/10 px-2.5 py-0.5 font-mono text-[9px] uppercase tracking-[0.18em] text-amber-200"
                        >
                            {{ s.tag }}
                        </span>
                    </div>

                    <h3 class="mt-6 font-display text-3xl font-semibold tracking-tight text-white">
                        {{ s.title }}
                    </h3>
                    <p class="mt-3 text-[15px] leading-relaxed text-white/60">
                        {{ s.desc }}
                    </p>

                    <ul class="mt-6 space-y-2.5">
                        <li
                            v-for="b in s.bullets"
                            :key="b"
                            class="flex items-center gap-2.5 text-sm text-white/75"
                        >
                            <svg class="h-3.5 w-3.5 flex-shrink-0 text-cyan-300" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m3 8 3.5 3.5L13 5"/>
                            </svg>
                            {{ b }}
                        </li>
                    </ul>

                    <div class="mt-8 flex items-center justify-between border-t border-white/5 pt-6">
                        <span class="font-mono text-[10px] uppercase tracking-[0.18em] text-white/40">
                            Custom scope
                        </span>
                        <a href="#contact" class="group/btn inline-flex items-center gap-1.5 font-mono text-[11px] uppercase tracking-[0.15em] text-white/80 transition hover:text-cyan-300">
                            Enquire
                            <svg class="h-3 w-3 transition group-hover/btn:translate-x-0.5" viewBox="0 0 20 20" fill="none">
                                <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                </motion.div>
            </div>
        </div>
    </section>
</template>
