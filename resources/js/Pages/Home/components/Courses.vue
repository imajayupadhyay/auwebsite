<script setup>
import { motion } from 'motion-v';
import { Link } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';

const courses = [
    {
        code: 'AZ-01',
        title: 'Microsoft Azure',
        subtitle: 'Resilient systems on Azure ecosystem',
        level: 'Intermediate',
        modules: 12,
        hours: 32,
        dot: '#0078D4',
        icon: 'logos:microsoft-azure',
        available: true,
        slug: 'microsoft-azure',
    },
    {
        code: 'AWS-01',
        title: 'AWS Cloud',
        subtitle: 'From EC2 to EKS — production patterns',
        level: 'Intermediate',
        modules: 14,
        hours: 38,
        dot: '#FF9900',
        icon: 'logos:aws',
        available: false,
        slug: 'aws-cloud',
    },
    {
        code: 'GCP-01',
        title: 'Google Cloud',
        subtitle: 'GCP for engineers who want to ship',
        level: 'Beginner',
        modules: 10,
        hours: 26,
        dot: '#4285F4',
        icon: 'logos:google-cloud',
        available: false,
        slug: 'google-cloud',
    },
    {
        code: 'K8S-01',
        title: 'Docker · Kubernetes',
        subtitle: 'Container orchestration at scale',
        level: 'Advanced',
        modules: 16,
        hours: 44,
        dot: '#326CE5',
        icon: 'logos:kubernetes',
        available: false,
        slug: 'docker-kubernetes',
    },
    {
        code: 'JNK-01',
        title: 'Jenkins CI/CD',
        subtitle: 'Pipelines that stay green at 2 AM',
        level: 'All levels',
        modules: 9,
        hours: 22,
        dot: '#D33833',
        icon: 'logos:jenkins',
        available: false,
        slug: 'jenkins-cicd',
    },
    {
        code: 'TF-01',
        title: 'Terraform',
        subtitle: 'Infrastructure as code, done right',
        level: 'Intermediate',
        modules: 11,
        hours: 28,
        dot: '#7B42BC',
        icon: 'logos:terraform-icon',
        available: false,
        slug: 'terraform',
    },
];
</script>

<template>
    <section id="courses" class="relative py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-6">
            <motion.div
                :initial="{ opacity: 0, y: 30 }"
                :whileInView="{ opacity: 1, y: 0 }"
                :viewport="{ once: true, margin: '-80px' }"
                :transition="{ duration: 0.8, ease: [0.22, 1, 0.36, 1] }"
                class="flex flex-col items-start justify-between gap-8 lg:flex-row lg:items-end"
            >
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 rounded-full glass px-3 py-1">
                        <span class="h-1 w-1 rounded-full bg-cyan-400"></span>
                        <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-cyan-300/80">01 · the library</span>
                    </div>
                    <h2 class="mt-5 font-display text-4xl font-semibold leading-[1.05] tracking-tight text-white sm:text-5xl md:text-6xl">
                        Learn the stack, <br class="hidden sm:block"/>
                        <span class="text-white/50">not the trend.</span>
                    </h2>
                </div>
                <p class="max-w-md text-base leading-relaxed text-white/60">
                    Each course is built around real production scenarios — the kind of
                    problems that break at 3 AM on a Tuesday. No tutorials. No toy apps.
                </p>
            </motion.div>

            <div class="mt-16 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <motion.div
                    v-for="(c, i) in courses"
                    :key="c.code"
                    :initial="{ opacity: 0, y: 24 }"
                    :whileInView="{ opacity: 1, y: 0 }"
                    :viewport="{ once: true, margin: '-60px' }"
                    :transition="{ duration: 0.6, delay: i * 0.08, ease: [0.22, 1, 0.36, 1] }"
                    :class="[
                        'group relative overflow-hidden rounded-2xl glass p-6 transition duration-500',
                        c.available
                            ? 'cursor-pointer hover:border-white/20 hover:-translate-y-1'
                            : 'cursor-default opacity-55',
                    ]"
                >
                    <div
                        v-if="c.available"
                        class="pointer-events-none absolute -inset-px rounded-2xl opacity-0 transition duration-500 group-hover:opacity-100"
                        :style="{ background: `radial-gradient(400px circle at var(--mx, 50%) var(--my, 0%), ${c.dot}22, transparent 60%)` }"
                    ></div>

                    <Link
                        v-if="c.available"
                        :href="`/courses/${c.slug}`"
                        class="absolute inset-0 z-10 rounded-2xl focus:outline-none focus:ring-2 focus:ring-cyan-300/40"
                        :aria-label="`View ${c.title} course`"
                    />

                    <div class="relative flex items-start justify-between">
                        <div class="grid h-12 w-12 place-items-center rounded-xl border border-white/10 bg-white/5">
                            <Icon :icon="c.icon" class="h-7 w-7" />
                        </div>
                        <span
                            v-if="c.available"
                            class="font-mono text-[10px] uppercase tracking-[0.18em] text-white/40"
                        >{{ c.code }}</span>
                        <span
                            v-else
                            class="inline-flex items-center gap-1.5 rounded-full border border-white/10 bg-white/5 px-2.5 py-1 backdrop-blur-sm"
                        >
                            <svg class="h-2.5 w-2.5 text-white/40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <span class="font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Coming Soon</span>
                        </span>
                    </div>

                    <div class="relative mt-8">
                        <h3 class="font-display text-2xl font-semibold tracking-tight text-white">
                            {{ c.title }}
                        </h3>
                        <p class="mt-2 text-sm leading-relaxed text-white/60">
                            {{ c.subtitle }}
                        </p>
                    </div>

                    <div class="relative mt-7 flex items-center justify-between border-t border-white/5 pt-5">
                        <div class="flex items-center gap-3 font-mono text-[10px] uppercase tracking-[0.15em] text-white/50">
                            <span class="flex items-center gap-1.5">
                                <span class="h-1 w-1 rounded-full" :style="{ backgroundColor: c.dot }"></span>
                                {{ c.level }}
                            </span>
                            <span>·</span>
                            <span>{{ c.modules }} mods</span>
                            <span>·</span>
                            <span>{{ c.hours }}h</span>
                        </div>
                        <span
                            v-if="c.available"
                            class="grid h-7 w-7 place-items-center rounded-full border border-white/10 transition group-hover:border-cyan-300/40 group-hover:bg-cyan-400/10"
                        >
                            <svg class="h-3 w-3 text-white/70 transition group-hover:text-cyan-300 group-hover:translate-x-0.5" viewBox="0 0 20 20" fill="none">
                                <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                </motion.div>
            </div>
        </div>
    </section>
</template>
