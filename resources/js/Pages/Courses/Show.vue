<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { motion } from 'motion-v';
import { Icon } from '@iconify/vue';
import Header from '@/Components/Global/Header.vue';
import Footer from '@/Components/Global/Footer.vue';
import { useTheme } from '@/composables/useTheme';
import { useCart } from '@/composables/useCart';
import { getCourseBySlug } from '@/data/courses';

const props = defineProps({
    slug: { type: String, required: true },
});

const { isDark } = useTheme();
const { addItem, has, openCart } = useCart();

const course = computed(() => getCourseBySlug(props.slug));

const openModule = ref(0);
const toggleModule = (i) => {
    openModule.value = openModule.value === i ? -1 : i;
};

const inCart = computed(() => (course.value ? has(course.value.slug) : false));

const discountPct = computed(() => {
    if (!course.value?.originalPrice) return 0;
    return Math.round(((course.value.originalPrice - course.value.price) / course.value.originalPrice) * 100);
});

const totalLessons = computed(() =>
    (course.value?.curriculum || []).reduce((s, m) => s + (m.lessons?.length || 0), 0),
);

const inr = (n) => `₹${(n ?? 0).toLocaleString('en-IN')}`;

const onAddToCart = () => {
    if (!course.value || !course.value.available) return;
    addItem(course.value);
};

const onEnrollNow = () => {
    if (!course.value || !course.value.available) return;
    if (!inCart.value) addItem(course.value);
    openCart();
};

const ease = [0.22, 1, 0.36, 1];
</script>

<template>
    <Head :title="course ? `${course.title} — Ajay Upadhyay` : 'Course not found'" />

    <div
        class="relative min-h-screen overflow-hidden text-white antialiased transition-colors duration-300"
        :class="isDark ? 'bg-ink-950' : 'bg-[#f5f7fa]'"
    >
        <!-- ── Background decorations ─────────────────────── -->
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div
                class="absolute inset-0 transition-all duration-500"
                :style="isDark
                    ? 'background: radial-gradient(ellipse at top, rgba(34,211,238,0.08), transparent 50%)'
                    : 'background: radial-gradient(ellipse at top, rgba(99,102,241,0.22), transparent 55%)'"
            ></div>
            <div
                class="absolute inset-0 transition-all duration-500"
                :style="isDark
                    ? 'background: radial-gradient(ellipse at bottom right, rgba(45,212,191,0.05), transparent 60%)'
                    : 'background: radial-gradient(ellipse at bottom right, rgba(14,165,233,0.18), transparent 60%)'"
            ></div>

            <svg class="absolute inset-0 h-full w-full" :class="isDark ? 'opacity-[0.06]' : 'opacity-[0.16]'" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="sgrid" width="64" height="64" patternUnits="userSpaceOnUse">
                        <path d="M 64 0 L 0 0 0 64" fill="none" :stroke="isDark ? 'white' : '#4338ca'" stroke-width="1"/>
                    </pattern>
                    <radialGradient id="sfade" cx="50%" cy="30%" r="70%">
                        <stop offset="0%" stop-color="white" stop-opacity="1"/>
                        <stop offset="100%" stop-color="white" stop-opacity="0"/>
                    </radialGradient>
                    <mask id="sgridMask">
                        <rect width="100%" height="100%" fill="url(#sfade)"/>
                    </mask>
                </defs>
                <rect width="100%" height="100%" fill="url(#sgrid)" mask="url(#sgridMask)"/>
            </svg>

            <div class="absolute -top-32 -left-32 h-[500px] w-[500px] rounded-full blur-[140px] transition-all duration-500"
                :style="isDark ? 'background: rgba(34,211,238,0.13);' : 'background: rgba(99,102,241,0.34);'" />
            <div class="absolute top-[40%] -right-40 h-[480px] w-[480px] rounded-full blur-[130px] transition-all duration-500"
                :style="isDark ? 'background: rgba(45,212,191,0.1);' : 'background: rgba(124,58,237,0.3);'" />
        </div>

        <Header />

        <main class="relative">
            <!-- ── Not found state ─────────────────────────── -->
            <section v-if="!course" class="pt-36 pb-24">
                <div class="mx-auto max-w-xl px-6 text-center">
                    <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl glass">
                        <svg class="h-7 w-7 text-white/30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 8v4M12 16h.01"/>
                        </svg>
                    </div>
                    <h1 class="mt-6 font-display text-3xl font-semibold tracking-tight text-white">
                        Course not found
                    </h1>
                    <p class="mt-3 text-white/55">
                        The course you're looking for doesn't exist or has been moved.
                    </p>
                    <Link
                        href="/courses"
                        class="mt-8 inline-flex items-center gap-2 rounded-xl glass px-5 py-2.5 text-sm font-medium text-white/75 transition hover:border-white/20 hover:text-white"
                    >
                        <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="none">
                            <path d="M16 10H4m0 0 4-4m-4 4 4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Back to courses
                    </Link>
                </div>
            </section>

            <!-- ── Course detail ───────────────────────────── -->
            <template v-else>
                <!-- ── Hero ──────────────────────────────── -->
                <section class="relative pt-32 pb-12 sm:pt-36">
                    <div class="mx-auto max-w-7xl px-6">
                        <!-- Breadcrumb -->
                        <motion.nav
                            :initial="{ opacity: 0, y: 8 }"
                            :animate="{ opacity: 1, y: 0 }"
                            :transition="{ duration: 0.5, ease }"
                            class="flex items-center gap-2 text-xs text-white/35"
                            aria-label="Breadcrumb"
                        >
                            <Link href="/" class="transition hover:text-white/65">Home</Link>
                            <svg class="h-3 w-3 opacity-50" viewBox="0 0 20 20" fill="none">
                                <path d="M7 7l3 3-3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <Link href="/courses" class="transition hover:text-white/65">Courses</Link>
                            <svg class="h-3 w-3 opacity-50" viewBox="0 0 20 20" fill="none">
                                <path d="M7 7l3 3-3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="truncate text-white/60">{{ course.title }}</span>
                        </motion.nav>

                        <motion.div
                            :initial="{ opacity: 0, y: 16 }"
                            :animate="{ opacity: 1, y: 0 }"
                            :transition="{ duration: 0.7, delay: 0.08, ease }"
                            class="mt-8 flex items-start gap-5"
                        >
                            <div class="hidden h-16 w-16 flex-none place-items-center rounded-2xl border border-white/10 bg-white/5 sm:grid">
                                <Icon :icon="course.icon" class="h-10 w-10" />
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="inline-flex items-center gap-1.5 rounded-full glass px-2.5 py-1 font-mono text-[10px] uppercase tracking-[0.18em] text-cyan-300/80">
                                        <span class="h-1 w-1 rounded-full" :style="{ backgroundColor: course.dot }"></span>
                                        {{ course.code }} · {{ course.category }}
                                    </span>
                                    <span
                                        v-if="!course.available"
                                        class="inline-flex items-center gap-1.5 rounded-full border border-amber-spark/30 bg-amber-spark/10 px-2.5 py-1 font-mono text-[10px] uppercase tracking-[0.18em] text-amber-200/80"
                                    >
                                        Coming soon
                                    </span>
                                </div>

                                <h1 class="mt-4 font-display text-4xl font-semibold leading-[1.05] tracking-tight text-white sm:text-5xl md:text-6xl">
                                    {{ course.title }}
                                </h1>
                                <p class="mt-4 max-w-2xl text-lg leading-relaxed text-white/65">
                                    {{ course.subtitle }}
                                </p>

                                <!-- Meta bar -->
                                <div class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-3 font-mono text-[11px] uppercase tracking-[0.14em] text-white/50">
                                    <span class="flex items-center gap-1.5">
                                        <svg class="h-3.5 w-3.5 text-amber-300" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <span class="text-white/80">{{ course.rating }}</span>
                                        <span v-if="course.students > 0" class="text-white/40 normal-case tracking-normal">({{ course.students.toLocaleString('en-IN') }} students)</span>
                                    </span>
                                    <span class="hidden sm:block">·</span>
                                    <span>{{ course.level }}</span>
                                    <span class="hidden sm:block">·</span>
                                    <span>{{ course.modules }} modules</span>
                                    <span class="hidden sm:block">·</span>
                                    <span>{{ course.hours }}h total</span>
                                    <span class="hidden sm:block">·</span>
                                    <span>{{ course.language }}</span>
                                </div>

                                <!-- Tags -->
                                <div class="mt-5 flex flex-wrap gap-1.5">
                                    <span
                                        v-for="tag in course.tags"
                                        :key="tag"
                                        class="rounded-full border border-white/10 bg-white/5 px-2.5 py-1 font-mono text-[10px] tracking-wide text-white/60"
                                    >
                                        {{ tag }}
                                    </span>
                                </div>
                            </div>
                        </motion.div>
                    </div>
                </section>

                <!-- ── Content + sidebar ─────────────────── -->
                <section class="relative pb-24">
                    <div class="mx-auto max-w-7xl px-6">
                        <div class="grid gap-8 lg:grid-cols-3">
                            <!-- LEFT: Description, outcomes, curriculum, requirements -->
                            <div class="space-y-10 lg:col-span-2">
                                <!-- Description -->
                                <motion.section
                                    :initial="{ opacity: 0, y: 16 }"
                                    :whileInView="{ opacity: 1, y: 0 }"
                                    :viewport="{ once: true, margin: '-50px' }"
                                    :transition="{ duration: 0.6, ease }"
                                >
                                    <div class="flex items-center gap-2">
                                        <span class="h-px w-6 bg-cyan-300/50"></span>
                                        <h2 class="font-mono text-[11px] uppercase tracking-[0.2em] text-cyan-300/80">About this course</h2>
                                    </div>
                                    <p class="mt-4 text-[15px] leading-relaxed text-white/70">
                                        {{ course.description }}
                                    </p>
                                </motion.section>

                                <!-- What you'll learn -->
                                <motion.section
                                    v-if="course.outcomes?.length"
                                    :initial="{ opacity: 0, y: 16 }"
                                    :whileInView="{ opacity: 1, y: 0 }"
                                    :viewport="{ once: true, margin: '-50px' }"
                                    :transition="{ duration: 0.6, ease }"
                                    class="rounded-2xl glass p-6 sm:p-7"
                                >
                                    <div class="flex items-center gap-2">
                                        <span class="h-px w-6 bg-cyan-300/50"></span>
                                        <h2 class="font-mono text-[11px] uppercase tracking-[0.2em] text-cyan-300/80">What you'll learn</h2>
                                    </div>
                                    <ul class="mt-5 grid gap-3 sm:grid-cols-2">
                                        <li
                                            v-for="item in course.outcomes"
                                            :key="item"
                                            class="flex items-start gap-3 text-sm leading-relaxed text-white/75"
                                        >
                                            <svg class="mt-0.5 h-4 w-4 flex-none text-cyan-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M20 6 9 17l-5-5"/>
                                            </svg>
                                            <span>{{ item }}</span>
                                        </li>
                                    </ul>
                                </motion.section>

                                <!-- Curriculum -->
                                <motion.section
                                    v-if="course.curriculum?.length"
                                    :initial="{ opacity: 0, y: 16 }"
                                    :whileInView="{ opacity: 1, y: 0 }"
                                    :viewport="{ once: true, margin: '-50px' }"
                                    :transition="{ duration: 0.6, ease }"
                                >
                                    <div class="flex items-end justify-between gap-4">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="h-px w-6 bg-cyan-300/50"></span>
                                                <h2 class="font-mono text-[11px] uppercase tracking-[0.2em] text-cyan-300/80">Curriculum</h2>
                                            </div>
                                            <p class="mt-3 font-display text-2xl font-semibold tracking-tight text-white sm:text-3xl">
                                                {{ course.curriculum.length }} modules · {{ totalLessons }} lessons
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-6 overflow-hidden rounded-2xl glass divide-y divide-white/5">
                                        <div
                                            v-for="(mod, i) in course.curriculum"
                                            :key="mod.title"
                                        >
                                            <button
                                                type="button"
                                                @click="toggleModule(i)"
                                                class="group flex w-full items-center justify-between gap-4 px-5 py-4 text-left transition hover:bg-white/5 sm:px-6"
                                                :aria-expanded="openModule === i"
                                            >
                                                <div class="flex min-w-0 items-center gap-4">
                                                    <span class="grid h-8 w-8 flex-none place-items-center rounded-lg border border-white/10 bg-white/5 font-mono text-[11px] text-cyan-300">
                                                        {{ String(i + 1).padStart(2, '0') }}
                                                    </span>
                                                    <div class="min-w-0">
                                                        <div class="truncate font-display text-[15px] font-semibold text-white">
                                                            {{ mod.title }}
                                                        </div>
                                                        <div class="mt-0.5 font-mono text-[10px] uppercase tracking-[0.15em] text-white/40">
                                                            {{ mod.lessons?.length || 0 }} lessons · {{ mod.duration }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <svg
                                                    class="h-4 w-4 flex-none text-white/40 transition-transform duration-300"
                                                    :class="openModule === i ? 'rotate-180 text-cyan-300' : 'group-hover:text-white/70'"
                                                    viewBox="0 0 20 20" fill="none"
                                                >
                                                    <path d="M5 8l5 5 5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </button>

                                            <Transition name="accordion">
                                                <div v-if="openModule === i" class="px-5 pb-5 sm:px-6">
                                                    <ul class="ml-12 space-y-2.5 border-l border-white/10 pl-5">
                                                        <li
                                                            v-for="lesson in mod.lessons"
                                                            :key="lesson"
                                                            class="relative text-sm text-white/65"
                                                        >
                                                            <span class="absolute -left-[1.4rem] top-[0.55rem] h-1.5 w-1.5 rounded-full bg-cyan-300/60"></span>
                                                            {{ lesson }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </Transition>
                                        </div>
                                    </div>
                                </motion.section>

                                <!-- Requirements -->
                                <motion.section
                                    v-if="course.requirements?.length"
                                    :initial="{ opacity: 0, y: 16 }"
                                    :whileInView="{ opacity: 1, y: 0 }"
                                    :viewport="{ once: true, margin: '-50px' }"
                                    :transition="{ duration: 0.6, ease }"
                                >
                                    <div class="flex items-center gap-2">
                                        <span class="h-px w-6 bg-cyan-300/50"></span>
                                        <h2 class="font-mono text-[11px] uppercase tracking-[0.2em] text-cyan-300/80">Requirements</h2>
                                    </div>
                                    <ul class="mt-4 space-y-2.5">
                                        <li
                                            v-for="req in course.requirements"
                                            :key="req"
                                            class="flex items-start gap-3 text-sm leading-relaxed text-white/70"
                                        >
                                            <span class="mt-[0.55rem] h-1 w-1 flex-none rounded-full bg-white/35"></span>
                                            {{ req }}
                                        </li>
                                    </ul>
                                </motion.section>
                            </div>

                            <!-- RIGHT: sticky pricing card -->
                            <aside class="lg:col-span-1">
                                <motion.div
                                    :initial="{ opacity: 0, y: 16 }"
                                    :animate="{ opacity: 1, y: 0 }"
                                    :transition="{ duration: 0.7, delay: 0.15, ease }"
                                    class="sticky top-28 rounded-2xl glass p-6 sm:p-7"
                                >
                                    <!-- Price -->
                                    <div class="flex items-end gap-3">
                                        <span class="font-display text-4xl font-semibold tracking-tight text-white">
                                            {{ inr(course.price) }}
                                        </span>
                                        <span
                                            v-if="course.originalPrice && course.originalPrice > course.price"
                                            class="mb-1 font-mono text-sm text-white/35 line-through"
                                        >
                                            {{ inr(course.originalPrice) }}
                                        </span>
                                    </div>
                                    <div
                                        v-if="discountPct > 0"
                                        class="mt-2 inline-flex items-center gap-1.5 rounded-full border border-emerald-400/30 bg-emerald-400/10 px-2.5 py-1 font-mono text-[10px] uppercase tracking-[0.15em] text-emerald-300"
                                    >
                                        <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2l2.39 4.84L18 8l-4 3.9L15 18l-5-2.63L5 18l1-6.1L2 8l5.61-1.16L10 2z"/></svg>
                                        {{ discountPct }}% off · limited time
                                    </div>

                                    <!-- Actions -->
                                    <div class="mt-6 space-y-2.5">
                                        <button
                                            @click="onEnrollNow"
                                            :disabled="!course.available"
                                            class="group relative flex w-full items-center justify-center gap-2 overflow-hidden rounded-xl px-5 py-3.5 text-sm font-semibold transition disabled:cursor-not-allowed disabled:opacity-50"
                                            :class="isDark
                                                ? 'bg-white text-ink-900 shadow-[0_20px_50px_-12px_rgba(34,211,238,0.45)] hover:shadow-[0_20px_60px_-12px_rgba(34,211,238,0.65)]'
                                                : 'bg-indigo-600 text-[#ffffff] shadow-[0_20px_50px_-12px_rgba(99,102,241,0.45)] hover:bg-indigo-500'"
                                        >
                                            <span>Enroll Now</span>
                                            <svg class="h-4 w-4 transition group-hover:translate-x-0.5" viewBox="0 0 20 20" fill="none">
                                                <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>

                                        <button
                                            @click="onAddToCart"
                                            :disabled="!course.available"
                                            class="flex w-full items-center justify-center gap-2 rounded-xl glass px-5 py-3.5 text-sm font-semibold text-white transition hover:border-white/20 disabled:cursor-not-allowed disabled:opacity-50"
                                            :class="inCart ? 'ring-1 ring-cyan-300/30' : ''"
                                        >
                                            <template v-if="inCart">
                                                <svg class="h-4 w-4 text-cyan-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M20 6 9 17l-5-5"/>
                                                </svg>
                                                <span>Added to cart</span>
                                            </template>
                                            <template v-else>
                                                <svg class="h-4 w-4 text-cyan-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="9" cy="21" r="1"/>
                                                    <circle cx="20" cy="21" r="1"/>
                                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                                </svg>
                                                <span>Add to Cart</span>
                                            </template>
                                        </button>
                                    </div>

                                    <p
                                        v-if="!course.available"
                                        class="mt-3 text-center font-mono text-[10px] uppercase tracking-[0.18em] text-amber-200/80"
                                    >
                                        This course is not yet available
                                    </p>

                                    <!-- Divider -->
                                    <div class="my-6 h-px bg-white/10"></div>

                                    <!-- Meta list -->
                                    <dl class="space-y-3 text-sm">
                                        <div class="flex items-center justify-between">
                                            <dt class="flex items-center gap-2 text-white/55">
                                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10"/>
                                                    <path d="M12 6v6l4 2"/>
                                                </svg>
                                                Duration
                                            </dt>
                                            <dd class="font-mono text-white/80">{{ course.hours }}h</dd>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <dt class="flex items-center gap-2 text-white/55">
                                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                                </svg>
                                                Modules
                                            </dt>
                                            <dd class="font-mono text-white/80">{{ course.modules }}</dd>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <dt class="flex items-center gap-2 text-white/55">
                                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="m12 14 4-4"/>
                                                    <path d="M3.34 19a10 10 0 1 1 17.32 0"/>
                                                </svg>
                                                Level
                                            </dt>
                                            <dd class="text-white/80">{{ course.level }}</dd>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <dt class="flex items-center gap-2 text-white/55">
                                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                                    <path d="M16 2v4M8 2v4M3 10h18"/>
                                                </svg>
                                                Updated
                                            </dt>
                                            <dd class="text-white/80">{{ course.lastUpdated }}</dd>
                                        </div>
                                    </dl>

                                    <!-- Guarantee -->
                                    <div class="mt-6 flex items-start gap-3 rounded-xl border border-white/8 bg-white/5 p-3.5">
                                        <svg class="h-4 w-4 flex-none text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                        </svg>
                                        <p class="text-[12px] leading-relaxed text-white/60">
                                            30-day money-back guarantee. Cancel any time.
                                        </p>
                                    </div>
                                </motion.div>
                            </aside>
                        </div>
                    </div>
                </section>
            </template>
        </main>

        <Footer />
    </div>
</template>

<style scoped>
.accordion-enter-active,
.accordion-leave-active {
    transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
    overflow: hidden;
}
.accordion-enter-from,
.accordion-leave-to {
    opacity: 0;
    max-height: 0;
    padding-top: 0;
    padding-bottom: 0;
}
.accordion-enter-to,
.accordion-leave-from {
    opacity: 1;
    max-height: 600px;
}
</style>
