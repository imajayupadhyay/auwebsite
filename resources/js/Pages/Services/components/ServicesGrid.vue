<script setup>
import { ref, computed } from 'vue';
import { motion } from 'motion-v';
import { services, categories } from '@/data/services';
import ServiceCard from './ServiceCard.vue';

defineEmits(['inquire']);

const ease = [0.22, 1, 0.36, 1];
const activeCategory = ref('all');

const filteredServices = computed(() => {
    if (activeCategory.value === 'all') return services;
    return services.filter((s) => s.category === activeCategory.value);
});

const dotMap = {
    white:  'bg-white',
    amber:  'bg-amber-400',
    cyan:   'bg-cyan-400',
    teal:   'bg-teal-400',
    violet: 'bg-violet-400',
    rose:   'bg-rose-400',
};

const activeMap = {
    white:  'border-white/30 bg-white/10 text-white',
    amber:  'border-amber-400/60 bg-amber-400/10 text-amber-300',
    cyan:   'border-cyan-300/60 bg-cyan-400/10 text-cyan-300',
    teal:   'border-teal-300/60 bg-teal-400/10 text-teal-300',
    violet: 'border-violet-400/60 bg-violet-400/10 text-violet-300',
    rose:   'border-rose-400/60 bg-rose-400/10 text-rose-300',
};
</script>

<template>
    <section id="offerings" class="relative py-16 sm:py-20">
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
                        <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-cyan-300/80">§ Offerings</span>
                    </div>
                    <h2 class="mt-4 max-w-[22ch] font-display text-4xl font-semibold leading-[1.05] tracking-tight text-white sm:text-5xl md:text-6xl">
                        Twelve ways to <span class="text-white/50">ship safer.</span>
                    </h2>
                </div>
                <div class="hidden font-mono text-[10px] uppercase tracking-[0.15em] text-white/35 sm:block">
                    {{ filteredServices.length }} {{ filteredServices.length === 1 ? 'Service' : 'Services' }} · Fixed Price
                </div>
            </motion.div>

            <!-- Filter bar -->
            <motion.div
                :initial="{ opacity: 0, y: 14 }"
                :whileInView="{ opacity: 1, y: 0 }"
                :viewport="{ once: true, margin: '-60px' }"
                :transition="{ duration: 0.5, ease }"
                class="mt-8"
            >
                <div class="mb-3 flex items-center gap-2">
                    <span class="font-mono text-[10px] font-semibold uppercase tracking-[0.14em] text-white/40">// filter by</span>
                    <span class="h-px flex-1 bg-white/5"></span>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <button
                        v-for="c in categories"
                        :key="c.id"
                        type="button"
                        @click="activeCategory = c.id"
                        :class="[
                            'inline-flex items-center gap-2 rounded-full border px-3.5 py-2 font-mono text-[11px] transition',
                            activeCategory === c.id
                                ? activeMap[c.accent]
                                : 'border-white/10 bg-white/5 text-white/65 hover:border-white/20 hover:bg-white/10 hover:text-white',
                        ]"
                    >
                        <span :class="['h-1.5 w-1.5 rounded-full', dotMap[c.accent]]"></span>
                        <span>{{ c.name }}</span>
                        <span
                            :class="[
                                'ml-0.5 font-mono text-[10px]',
                                activeCategory === c.id ? 'opacity-80' : 'text-white/40',
                            ]"
                        >{{ c.count }}</span>
                    </button>
                </div>
            </motion.div>

            <!-- Services grid -->
            <div
                :key="activeCategory"
                class="mt-10 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3"
            >
                <ServiceCard
                    v-for="(s, i) in filteredServices"
                    :key="s.id"
                    :service="s"
                    :index="i"
                    @inquire="$emit('inquire', $event)"
                />
            </div>

            <!-- Empty state -->
            <div
                v-if="filteredServices.length === 0"
                class="py-16 text-center font-mono text-xs text-white/45"
            >
                No services in this category.
            </div>
        </div>
    </section>
</template>
