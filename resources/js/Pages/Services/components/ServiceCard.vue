<script setup>
import { computed, h } from 'vue';
import { motion } from 'motion-v';

const props = defineProps({
    service: { type: Object, required: true },
    index:   { type: Number, default: 0 },
});

defineEmits(['inquire']);

const accent = computed(() => props.service.accent);

// Explicit class maps so Tailwind can statically extract them.
const glowMap = {
    amber:  'bg-amber-400/15',
    cyan:   'bg-cyan-400/15',
    teal:   'bg-teal-400/15',
    violet: 'bg-violet-400/15',
    rose:   'bg-rose-400/15',
};

const iconFrameMap = {
    amber:  'bg-amber-400/10 border-amber-400/25 group-hover:border-amber-400/50',
    cyan:   'bg-cyan-400/10 border-cyan-300/25 group-hover:border-cyan-300/50',
    teal:   'bg-teal-400/10 border-teal-300/25 group-hover:border-teal-300/50',
    violet: 'bg-violet-400/10 border-violet-400/25 group-hover:border-violet-400/50',
    rose:   'bg-rose-400/10 border-rose-400/25 group-hover:border-rose-400/50',
};

const iconTextMap = {
    amber:  'text-amber-300',
    cyan:   'text-cyan-300',
    teal:   'text-teal-300',
    violet: 'text-violet-300',
    rose:   'text-rose-300',
};

const categoryTagMap = {
    amber:  'border-amber-400/30 bg-amber-400/5 text-amber-300',
    cyan:   'border-cyan-300/30 bg-cyan-400/5 text-cyan-300',
    teal:   'border-teal-300/30 bg-teal-400/5 text-teal-300',
    violet: 'border-violet-400/30 bg-violet-400/5 text-violet-300',
    rose:   'border-rose-400/30 bg-rose-400/5 text-rose-300',
};

const arrowColorMap = {
    amber:  'text-amber-300',
    cyan:   'text-cyan-300',
    teal:   'text-teal-300',
    violet: 'text-violet-300',
    rose:   'text-rose-300',
};

const ctaHoverMap = {
    amber:  'hover:border-amber-400/50 hover:text-amber-300',
    cyan:   'hover:border-cyan-300/50 hover:text-cyan-300',
    teal:   'hover:border-teal-300/50 hover:text-teal-300',
    violet: 'hover:border-violet-400/50 hover:text-violet-300',
    rose:   'hover:border-rose-400/50 hover:text-rose-300',
};

const accentBarMap = {
    amber:  'bg-gradient-to-b from-amber-400 to-transparent',
    cyan:   'bg-gradient-to-b from-cyan-300 to-transparent',
    teal:   'bg-gradient-to-b from-teal-300 to-transparent',
    violet: 'bg-gradient-to-b from-violet-400 to-transparent',
    rose:   'bg-gradient-to-b from-rose-400 to-transparent',
};

const glowClass       = computed(() => glowMap[accent.value]       || glowMap.cyan);
const iconFrameClass  = computed(() => iconFrameMap[accent.value]  || iconFrameMap.cyan);
const iconTextClass   = computed(() => iconTextMap[accent.value]   || iconTextMap.cyan);
const categoryTagClass = computed(() => categoryTagMap[accent.value] || categoryTagMap.cyan);
const arrowColorClass = computed(() => arrowColorMap[accent.value] || arrowColorMap.cyan);
const ctaHoverClass   = computed(() => ctaHoverMap[accent.value]   || ctaHoverMap.cyan);
const accentBarClass  = computed(() => accentBarMap[accent.value]  || accentBarMap.cyan);

// Inline SVG icon registry — same set as original, rendered as functional components.
const svg = (children) =>
    h('svg',
        {
            viewBox: '0 0 24 24',
            fill: 'none',
            stroke: 'currentColor',
            'stroke-width': 1.6,
            'stroke-linecap': 'round',
            'stroke-linejoin': 'round',
        },
        children,
    );

const icons = {
    aws: () => svg([
        h('path', { d: 'M4 8l8-4 8 4-8 4-8-4z' }),
        h('path', { d: 'M4 12l8 4 8-4' }),
        h('path', { d: 'M4 16l8 4 8-4' }),
    ]),
    azure: () => svg([
        h('path', { d: 'M8 4l-6 14h6l3-6-3-8z' }),
        h('path', { d: 'M12 4l10 16H11l-2-4 3-12z' }),
    ]),
    lambda: () => svg([
        h('path', { d: 'M13 2L4 14h6l-2 8 11-14h-7l1-6z' }),
    ]),
    pipeline: () => svg([
        h('circle', { cx: 5, cy: 12, r: 2 }),
        h('rect', { x: 9, y: 9, width: 6, height: 6, rx: 1 }),
        h('circle', { cx: 19, cy: 12, r: 2 }),
        h('line', { x1: 7, y1: 12, x2: 9, y2: 12, 'stroke-dasharray': '1.5 2' }),
        h('line', { x1: 15, y1: 12, x2: 17, y2: 12, 'stroke-dasharray': '1.5 2' }),
    ]),
    k8s: () => svg([
        h('polygon', { points: '12,3 20,7 20,15 12,21 4,15 4,7' }),
        h('circle', { cx: 12, cy: 12, r: 2.5 }),
        h('line', { x1: 12, y1: 3, x2: 12, y2: 9.5 }),
        h('line', { x1: 20, y1: 7, x2: 14.5, y2: 11 }),
        h('line', { x1: 20, y1: 15, x2: 14.5, y2: 13 }),
        h('line', { x1: 12, y1: 21, x2: 12, y2: 14.5 }),
        h('line', { x1: 4,  y1: 15, x2: 9.5,  y2: 13 }),
        h('line', { x1: 4,  y1: 7,  x2: 9.5,  y2: 11 }),
    ]),
    container: () => svg([
        h('rect', { x: 3,    y: 8, width: 5, height: 5, rx: 0.5 }),
        h('rect', { x: 9.5,  y: 8, width: 5, height: 5, rx: 0.5 }),
        h('rect', { x: 16,   y: 8, width: 5, height: 5, rx: 0.5 }),
        h('rect', { x: 6,    y: 2, width: 5, height: 5, rx: 0.5 }),
        h('rect', { x: 12.5, y: 2, width: 5, height: 5, rx: 0.5 }),
        h('path', { d: 'M2 14c2 4 5 5 10 5s8-1 10-5' }),
    ]),
    iac: () => svg([
        h('path', { d: 'M8 6l-4 6 4 6' }),
        h('path', { d: 'M16 6l4 6-4 6' }),
        h('line', { x1: 14, y1: 4, x2: 10, y2: 20 }),
    ]),
    cicd: () => svg([
        h('path', { d: 'M21 12a9 9 0 01-15 6.7L3 16' }),
        h('path', { d: 'M3 12a9 9 0 0115-6.7L21 8' }),
        h('path', { d: 'M3 4v4h4M21 20v-4h-4' }),
    ]),
    observe: () => svg([
        h('path', { d: 'M3 16l4-6 4 4 4-8 6 10' }),
        h('line', { x1: 3, y1: 20, x2: 21, y2: 20 }),
    ]),
    monitor: () => svg([
        h('rect', { x: 3, y: 4, width: 18, height: 13, rx: 2 }),
        h('path', { d: 'M7 12l3-3 3 3 4-4' }),
        h('line', { x1: 8,  y1: 21, x2: 16, y2: 21 }),
        h('line', { x1: 12, y1: 17, x2: 12, y2: 21 }),
    ]),
    web: () => svg([
        h('circle', { cx: 12, cy: 12, r: 9 }),
        h('path', { d: 'M3 12h18' }),
        h('path', { d: 'M12 3c3 3 4.5 6 4.5 9s-1.5 6-4.5 9c-3-3-4.5-6-4.5-9s1.5-6 4.5-9z' }),
    ]),
    ai: () => svg([
        h('path', { d: 'M12 3l1.5 4.5L18 9l-4.5 1.5L12 15l-1.5-4.5L6 9l4.5-1.5L12 3z' }),
        h('path', { d: 'M19 15l.6 1.8L21 17.5l-1.4.7L19 20l-.6-1.8L17 17.5l1.4-.7L19 15z' }),
        h('path', { d: 'M5 17l.5 1.4L7 19l-1.5.6L5 21l-.5-1.4L3 19l1.5-.6L5 17z' }),
    ]),
};

const iconSvg = computed(() => icons[props.service.icon] || icons.azure);
</script>

<template>
    <motion.article
        :initial="{ opacity: 0, y: 24 }"
        :whileInView="{ opacity: 1, y: 0 }"
        :viewport="{ once: true, margin: '-60px' }"
        :transition="{ duration: 0.55, delay: (index % 3) * 0.07, ease: [0.22, 1, 0.36, 1] }"
        class="group relative flex flex-col overflow-hidden rounded-2xl glass px-6 pt-6 pb-6 transition hover:-translate-y-1 hover:border-white/15"
    >
        <!-- Top-right glow -->
        <div
            :class="['pointer-events-none absolute top-0 right-0 h-36 w-36 rounded-full opacity-0 blur-3xl transition-opacity duration-500 group-hover:opacity-100', glowClass]"
        ></div>

        <!-- Header row -->
        <div class="relative flex items-start justify-between">
            <div
                :class="['flex h-12 w-12 items-center justify-center rounded-xl border transition', iconFrameClass]"
            >
                <component :is="iconSvg" :class="['h-[22px] w-[22px]', iconTextClass]" />
            </div>
            <div class="flex flex-col items-end gap-1">
                <span class="font-mono text-[10px] font-semibold uppercase tracking-[0.14em] text-white/40">{{ service.num }}</span>
                <span :class="['rounded-md border px-2 py-0.5 font-mono text-[9px] uppercase tracking-[0.14em]', categoryTagClass]">
                    {{ service.categoryLabel }}
                </span>
            </div>
        </div>

        <!-- Title + tagline -->
        <h3 class="relative mt-5 font-display text-xl font-semibold leading-snug tracking-tight text-white sm:text-[22px]">
            {{ service.title }}
        </h3>
        <p class="relative mt-1.5 font-mono text-[11px] text-white/45">{{ service.tagline }}</p>

        <!-- Points -->
        <ul class="relative mt-5 flex-1 grid gap-2">
            <li
                v-for="p in service.points"
                :key="p"
                class="relative pl-5 text-[13px] leading-relaxed text-white/70"
            >
                <span :class="['absolute left-0 top-0 font-mono font-semibold', arrowColorClass]">→</span>
                <span>{{ p }}</span>
            </li>
        </ul>

        <!-- CTA -->
        <button
            type="button"
            @click="$emit('inquire', service)"
            :class="['relative mt-6 inline-flex items-center justify-between gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2.5 font-mono text-[11px] font-semibold uppercase tracking-[0.1em] text-white/75 transition group-hover:translate-x-0.5', ctaHoverClass]"
        >
            <span>Discuss service</span>
            <span class="transition group-hover:translate-x-0.5">→</span>
        </button>

        <!-- Left accent bar -->
        <span
            :class="['pointer-events-none absolute left-0 top-0 bottom-0 w-[2px] origin-top scale-y-0 transition-transform duration-500 group-hover:scale-y-100', accentBarClass]"
        ></span>
    </motion.article>
</template>
