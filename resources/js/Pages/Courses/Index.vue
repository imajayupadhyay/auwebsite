<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { motion } from 'motion-v';
import Header      from '@/Components/Global/Header.vue';
import Footer      from '@/Components/Global/Footer.vue';
import SearchFilters from './components/SearchFilters.vue';
import CourseCard    from './components/CourseCard.vue';
import { useTheme } from '@/composables/useTheme';
import { courses as allCourses } from '@/data/courses';

const props = defineProps({
    search: { type: String, default: '' },
});

const { isDark } = useTheme();

// ── Filter state ───────────────────────────────────────────
const search         = ref(props.search);
const activeCategory = ref('All');
const activeLevel    = ref('All');

const categories = ['All', 'Cloud', 'Containers', 'CI/CD', 'IaC'];
const levels     = ['All', 'Beginner', 'Intermediate', 'Advanced', 'All levels'];

const hasActiveFilter = computed(() =>
    search.value !== '' || activeCategory.value !== 'All' || activeLevel.value !== 'All',
);

const filteredCourses = computed(() =>
    allCourses.filter(c => {
        const q = search.value.toLowerCase();
        const matchesSearch = !q
            || c.title.toLowerCase().includes(q)
            || c.subtitle.toLowerCase().includes(q)
            || c.tags.some(t => t.toLowerCase().includes(q));

        const matchesCategory = activeCategory.value === 'All' || c.category === activeCategory.value;
        const matchesLevel    = activeLevel.value    === 'All' || c.level    === activeLevel.value;

        return matchesSearch && matchesCategory && matchesLevel;
    }),
);

const resetFilters = () => {
    search.value         = '';
    activeCategory.value = 'All';
    activeLevel.value    = 'All';
};

// ── Summary stats ──────────────────────────────────────────
const totalHours   = allCourses.reduce((s, c) => s + c.hours,   0);
const totalModules = allCourses.reduce((s, c) => s + c.modules, 0);
</script>

<template>
    <Head title="Courses — Ajay Upadhyay" />

    <div
        class="relative min-h-screen overflow-hidden text-white antialiased transition-colors duration-300"
        :class="isDark ? 'bg-ink-950' : 'bg-[#f5f7fa]'"
    >
        <!-- ── Background decorations ─────────────────────── -->
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div
                class="absolute inset-0 transition-all duration-500"
                :style="isDark
                    ? 'background: radial-gradient(ellipse at top left, rgba(34,211,238,0.07), transparent 55%)'
                    : 'background: radial-gradient(ellipse at top left, rgba(99,102,241,0.22), transparent 55%)'"
            />
            <div
                class="absolute inset-0 transition-all duration-500"
                :style="isDark
                    ? 'background: radial-gradient(ellipse at bottom right, rgba(139,92,246,0.06), transparent 60%)'
                    : 'background: radial-gradient(ellipse at bottom right, rgba(124,58,237,0.2), transparent 60%)'"
            />

            <!-- Grid -->
            <svg class="absolute inset-0 h-full w-full" :class="isDark ? 'opacity-[0.05]' : 'opacity-[0.18]'" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="cgrid" width="64" height="64" patternUnits="userSpaceOnUse">
                        <path d="M 64 0 L 0 0 0 64" fill="none" :stroke="isDark ? 'white' : '#4338ca'" stroke-width="1"/>
                    </pattern>
                    <radialGradient id="cfade" cx="50%" cy="30%" r="70%">
                        <stop offset="0%" stop-color="white" stop-opacity="1"/>
                        <stop offset="100%" stop-color="white" stop-opacity="0"/>
                    </radialGradient>
                    <mask id="cgridMask">
                        <rect width="100%" height="100%" fill="url(#cfade)"/>
                    </mask>
                </defs>
                <rect width="100%" height="100%" fill="url(#cgrid)" mask="url(#cgridMask)"/>
            </svg>

            <!-- Glow blobs -->
            <div class="absolute -top-32 -right-32 h-[500px] w-[500px] rounded-full blur-[130px] transition-all duration-500"
                :style="isDark
                    ? 'background: rgba(139,92,246,0.12);'
                    : 'background: rgba(99,102,241,0.38);'" />
            <div class="absolute top-[50%] -left-40 h-[420px] w-[420px] rounded-full blur-[140px] transition-all duration-500"
                :style="isDark
                    ? 'background: rgba(34,211,238,0.08);'
                    : 'background: rgba(6,182,212,0.28);'" />
            <div class="absolute top-[85%] right-[20%] h-[360px] w-[360px] rounded-full blur-[130px] transition-all duration-500"
                :style="isDark
                    ? 'background: rgba(245,158,11,0.06);'
                    : 'background: rgba(124,58,237,0.26);'" />

            <!-- Decorative SVG: crosshair ring (top right) -->
            <svg
                class="absolute right-[8%] top-[28%] h-48 w-48 transition-colors duration-300"
                viewBox="0 0 200 200" fill="none"
                :style="{ color: isDark ? 'rgba(34,211,238,0.18)' : 'rgba(67,56,202,0.38)' }"
            >
                <circle cx="100" cy="100" r="85" stroke="currentColor" stroke-width="1.2" stroke-dasharray="2 4"/>
                <circle cx="100" cy="100" r="52" stroke="currentColor" stroke-width="1.2"/>
                <circle cx="100" cy="100" r="22" stroke="currentColor" stroke-width="1.2"/>
                <path d="M100 5 L100 195 M5 100 L195 100" stroke="currentColor" stroke-width="0.8" stroke-dasharray="1 4"/>
            </svg>

            <!-- Decorative SVG: stack blocks (bottom left) -->
            <svg
                class="absolute left-[5%] bottom-[12%] h-52 w-52 transition-colors duration-300"
                viewBox="0 0 200 200" fill="none"
                :style="{ color: isDark ? 'rgba(45,212,191,0.14)' : 'rgba(124,58,237,0.32)' }"
            >
                <rect x="30" y="110" width="140" height="40" rx="4" stroke="currentColor" stroke-width="1.4"/>
                <rect x="40" y="70"  width="120" height="30" rx="4" stroke="currentColor" stroke-width="1.4"/>
                <rect x="55" y="35"  width="90"  height="25" rx="4" stroke="currentColor" stroke-width="1.4"/>
                <circle cx="40"  cy="130" r="2.5" :fill="isDark ? '#2dd4bf' : '#4338ca'"/>
                <circle cx="50"  cy="85"  r="2.5" :fill="isDark ? '#22d3ee' : '#7c3aed'"/>
                <circle cx="65"  cy="48"  r="2.5" :fill="isDark ? '#f59e0b' : '#0891b2'"/>
            </svg>
        </div>

        <Header />

        <main class="relative">

            <!-- ── Page hero ──────────────────────────────── -->
            <section class="relative pt-32 pb-10 sm:pt-36 sm:pb-12">
                <div class="mx-auto max-w-7xl px-6">

                    <!-- Breadcrumb -->
                    <motion.nav
                        :initial="{ opacity: 0, y: 8 }"
                        :animate="{ opacity: 1, y: 0 }"
                        :transition="{ duration: 0.5, ease: [0.22, 1, 0.36, 1] }"
                        class="flex items-center gap-2 text-xs text-white/35"
                        aria-label="Breadcrumb"
                    >
                        <Link href="/" class="transition hover:text-white/65">Home</Link>
                        <svg class="h-3 w-3 opacity-50" viewBox="0 0 20 20" fill="none">
                            <path d="M7 7l3 3-3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="text-white/60">Courses</span>
                    </motion.nav>

                    <div class="mt-6 flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                        <!-- Left: title block -->
                        <motion.div
                            :initial="{ opacity: 0, y: 20 }"
                            :animate="{ opacity: 1, y: 0 }"
                            :transition="{ duration: 0.7, delay: 0.05, ease: [0.22, 1, 0.36, 1] }"
                            class="max-w-2xl"
                        >
                            <div class="inline-flex items-center gap-2 rounded-full glass px-3 py-1">
                                <span class="h-1 w-1 rounded-full bg-cyan-400"></span>
                                <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-cyan-300/80">Course library</span>
                            </div>
                            <h1 class="mt-4 font-display text-4xl font-semibold leading-[1.05] tracking-tight text-white sm:text-5xl md:text-6xl">
                                Every course, <br class="hidden sm:block"/>
                                <span class="text-white/50">in one place.</span>
                            </h1>
                        </motion.div>

                        <!-- Right: summary stats -->
                        <motion.div
                            :initial="{ opacity: 0, y: 20 }"
                            :animate="{ opacity: 1, y: 0 }"
                            :transition="{ duration: 0.7, delay: 0.15, ease: [0.22, 1, 0.36, 1] }"
                            class="flex items-center gap-6 lg:pb-1"
                        >
                            <div class="text-center">
                                <div class="font-display text-3xl font-semibold text-white">{{ allCourses.length }}</div>
                                <div class="mt-1 font-mono text-[9px] uppercase tracking-[0.2em] text-white/45">Courses</div>
                            </div>
                            <div class="h-8 w-px bg-white/10"></div>
                            <div class="text-center">
                                <div class="font-display text-3xl font-semibold text-white">{{ totalHours }}+</div>
                                <div class="mt-1 font-mono text-[9px] uppercase tracking-[0.2em] text-white/45">Hours</div>
                            </div>
                            <div class="h-8 w-px bg-white/10"></div>
                            <div class="text-center">
                                <div class="font-display text-3xl font-semibold text-white">{{ totalModules }}</div>
                                <div class="mt-1 font-mono text-[9px] uppercase tracking-[0.2em] text-white/45">Modules</div>
                            </div>
                        </motion.div>
                    </div>
                </div>
            </section>

            <!-- ── Search + filters ───────────────────────── -->
            <section class="relative pb-6">
                <div class="mx-auto max-w-7xl px-6">
                    <motion.div
                        :initial="{ opacity: 0, y: 16 }"
                        :animate="{ opacity: 1, y: 0 }"
                        :transition="{ duration: 0.6, delay: 0.2, ease: [0.22, 1, 0.36, 1] }"
                    >
                        <SearchFilters
                            v-model:search="search"
                            v-model:activeCategory="activeCategory"
                            v-model:activeLevel="activeLevel"
                            :categories="categories"
                            :levels="levels"
                            :resultCount="filteredCourses.length"
                            :totalCount="allCourses.length"
                            :hasActiveFilter="hasActiveFilter"
                            @reset="resetFilters"
                        />
                    </motion.div>
                </div>
            </section>

            <!-- ── Course grid ────────────────────────────── -->
            <section class="relative pb-20 sm:pb-24">
                <div class="mx-auto max-w-7xl px-6">

                    <!-- Results -->
                    <div
                        v-if="filteredCourses.length > 0"
                        class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3"
                    >
                        <CourseCard
                            v-for="(course, i) in filteredCourses"
                            :key="course.code"
                            :course="course"
                            :index="i"
                        />
                    </div>

                    <!-- Empty state -->
                    <motion.div
                        v-else
                        :initial="{ opacity: 0, scale: 0.97 }"
                        :animate="{ opacity: 1, scale: 1 }"
                        :transition="{ duration: 0.4, ease: [0.22, 1, 0.36, 1] }"
                        class="flex flex-col items-center justify-center gap-5 py-28 text-center"
                    >
                        <div class="grid h-16 w-16 place-items-center rounded-2xl glass">
                            <svg class="h-7 w-7 text-white/30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"/>
                                <path d="m21 21-4.35-4.35M8 11h6"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-display text-lg font-semibold text-white">No courses found</p>
                            <p class="mt-1.5 text-sm text-white/50">Try a different keyword or clear the active filters.</p>
                        </div>
                        <button
                            @click="resetFilters"
                            class="rounded-xl glass px-5 py-2.5 text-sm font-medium text-white/70 transition hover:border-white/20 hover:text-white"
                        >
                            Clear filters
                        </button>
                    </motion.div>

                </div>
            </section>

        </main>

        <Footer />
    </div>
</template>
