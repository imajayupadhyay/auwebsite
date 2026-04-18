<script setup>
import { motion } from 'motion-v';
import { Link } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';

defineProps({
    course: { type: Object, required: true },
    index:  { type: Number, default: 0 },
});
</script>

<template>
    <motion.div
        :initial="{ opacity: 0, y: 24 }"
        :whileInView="{ opacity: 1, y: 0 }"
        :viewport="{ once: true, margin: '-50px' }"
        :transition="{ duration: 0.55, delay: index * 0.06, ease: [0.22, 1, 0.36, 1] }"
        :class="[
            'group relative flex flex-col overflow-hidden rounded-2xl glass p-6 transition duration-500',
            course.available
                ? 'cursor-pointer hover:border-white/20 hover:-translate-y-1'
                : 'cursor-default opacity-55',
        ]"
    >
        <!-- Hover radial glow -->
        <div
            v-if="course.available"
            class="pointer-events-none absolute -inset-px rounded-2xl opacity-0 transition duration-500 group-hover:opacity-100"
            :style="{ background: `radial-gradient(380px circle at 50% 0%, ${course.dot_color}20, transparent 65%)` }"
        />

        <!-- Stretched link for available courses -->
        <Link
            v-if="course.available"
            :href="`/courses/${course.slug}`"
            class="absolute inset-0 z-10 rounded-2xl focus:outline-none focus:ring-2 focus:ring-cyan-300/40"
            :aria-label="`View ${course.title} course`"
        />

        <!-- Top row -->
        <div class="relative flex items-start justify-between">
            <div class="grid h-12 w-12 place-items-center rounded-xl border border-white/10 bg-white/5">
                <Icon :icon="course.icon" class="h-7 w-7" />
            </div>

            <!-- Course code (available) or Coming Soon badge -->
            <span v-if="course.available"
                class="font-mono text-[10px] uppercase tracking-[0.18em] text-white/40">
                {{ course.code }}
            </span>
            <span v-else
                class="inline-flex items-center gap-1.5 rounded-full border border-white/10 bg-white/5 px-2.5 py-1">
                <svg class="h-2.5 w-2.5 text-white/40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <span class="font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Coming Soon</span>
            </span>
        </div>

        <!-- Title + subtitle -->
        <div class="relative mt-6">
            <h3 class="font-display text-xl font-semibold tracking-tight text-white leading-snug">
                {{ course.title }}
            </h3>
            <p class="mt-2 text-sm leading-relaxed text-white/60">
                {{ course.subtitle }}
            </p>
        </div>

        <!-- Tags -->
        <div class="relative mt-4 flex flex-wrap gap-1.5">
            <span
                v-for="tag in course.tags"
                :key="tag"
                class="rounded-full border border-white/8 bg-white/5 px-2.5 py-0.5 font-mono text-[10px] tracking-wide text-white/45"
            >
                {{ tag }}
            </span>
        </div>

        <!-- Spacer pushes footer to bottom -->
        <div class="flex-1" />

        <!-- Footer meta -->
        <div class="relative mt-6 flex items-center justify-between border-t border-white/5 pt-5">
            <div class="flex items-center gap-3 font-mono text-[10px] uppercase tracking-[0.15em] text-white/50">
                <span class="flex items-center gap-1.5">
                    <span class="h-1 w-1 rounded-full" :style="{ backgroundColor: course.dot_color }"></span>
                    {{ course.level }}
                </span>
                <span>·</span>
                <span>{{ course.modules_count }} mods</span>
                <span>·</span>
                <span>{{ course.hours }}h</span>
            </div>
            <span
                v-if="course.available"
                class="grid h-7 w-7 place-items-center rounded-full border border-white/10 transition group-hover:border-cyan-300/40 group-hover:bg-cyan-400/10"
            >
                <svg class="h-3 w-3 text-white/60 transition group-hover:text-cyan-300 group-hover:translate-x-0.5" viewBox="0 0 20 20" fill="none">
                    <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
        </div>
    </motion.div>
</template>
