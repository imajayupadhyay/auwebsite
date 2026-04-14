<script setup>
import { marqueeKeywords } from '@/data/resume';

const doubled = [...marqueeKeywords, ...marqueeKeywords];
</script>

<template>
    <div
        class="relative my-8 overflow-hidden border-y border-white/5 py-5 sm:my-12 sm:py-6"
        style="mask-image: linear-gradient(90deg, transparent, black 8%, black 92%, transparent);
               -webkit-mask-image: linear-gradient(90deg, transparent, black 8%, black 92%, transparent);"
        aria-hidden="true"
    >
        <div class="flex w-max animate-[marquee-scroll_40s_linear_infinite] gap-10 font-display text-[clamp(22px,3vw,40px)] font-semibold tracking-tight whitespace-nowrap text-white/30 hover:[animation-play-state:paused] sm:gap-16">
            <span
                v-for="(k, i) in doubled"
                :key="i"
                class="inline-flex items-center gap-10 transition-colors hover:text-cyan-300 sm:gap-16"
            >
                {{ k }}
                <span class="inline-block h-2 w-2 rounded-full bg-amber-spark opacity-60"></span>
            </span>
        </div>
    </div>
</template>

<style scoped>
@keyframes marquee-scroll {
    from { transform: translateX(0); }
    to   { transform: translateX(-50%); }
}
</style>
