<script setup>
import { ref, watch, computed, onMounted, onUnmounted } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { motion } from 'motion-v';
import { useTheme } from '@/composables/useTheme';
import { useCart } from '@/composables/useCart';
import CartDrawer from '@/Components/Global/CartDrawer.vue';

const { isDark, setDark, setLight } = useTheme();
const { count: cartCount, openCart } = useCart();

const searchQuery = ref('');

const submitSearch = () => {
    const q = searchQuery.value.trim();
    router.visit(q ? `/courses?search=${encodeURIComponent(q)}` : '/courses');
};

const page        = usePage();
const scrolled    = ref(false);
const mobileOpen  = ref(false);

const onScroll = () => { scrolled.value = window.scrollY > 12; };

onMounted(() => {
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
});

onUnmounted(() => {
    window.removeEventListener('scroll', onScroll);
});

// Lock body scroll while drawer is open
watch(mobileOpen, (val) => {
    document.body.style.overflow = val ? 'hidden' : '';
});

const close = () => { mobileOpen.value = false; };

const nav = [
    { label: 'Home',      href: '/',          type: 'route' },
    { label: 'Courses',   href: '/courses',   type: 'route' },
    { label: 'Portfolio', href: '/portfolio', type: 'route' },
    { label: 'Services',  href: '/services',  type: 'route' },
];

// Strip query/hash so "/courses?foo=1" still matches "/courses"
const currentPath = computed(() => (page.url || '/').split('?')[0].split('#')[0]);

const isActive = (item) => {
    if (item.type !== 'route') return false;
    if (item.href === '/') return currentPath.value === '/';
    return currentPath.value === item.href || currentPath.value.startsWith(item.href + '/');
};
</script>

<template>
    <!-- ─── Top bar ─────────────────────────────────────────────── -->
    <motion.header
        :initial="{ y: -24, opacity: 0 }"
        :animate="{ y: 0, opacity: 1 }"
        :transition="{ duration: 0.7, ease: [0.22, 1, 0.36, 1] }"
        class="fixed inset-x-0 top-0 z-50 transition-all duration-500"
        :class="scrolled
            ? (isDark
                ? 'glass-strong shadow-[0_10px_30px_-18px_rgba(34,211,238,0.35)]'
                : 'glass-strong shadow-[0_10px_30px_-18px_rgba(99,102,241,0.22)]')
            : 'glass'"
    >
        <div class="mx-auto w-full px-4 sm:px-6 lg:px-10">
            <div
                class="flex items-center justify-between gap-6 transition-all duration-500"
                :class="scrolled ? 'py-2.5 sm:py-3' : 'py-3.5 sm:py-4'"
            >
                <!-- Logo -->
                <Link href="/" class="group flex items-center gap-2.5">
                    <div class="relative">
                        <div class="absolute inset-0 rounded-lg bg-cyan-glow/30 blur-md opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
                        <svg viewBox="0 0 36 36" class="relative h-9 w-9" fill="none">
                            <rect x="1" y="1" width="34" height="34" rx="9" stroke="url(#logoStroke)" stroke-width="1.2"/>
                            <path d="M11 13 L8 18 L11 23"  stroke="#22d3ee" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M25 13 L28 18 L25 23" stroke="#2dd4bf" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M20 11 L16 25"         stroke="#f59e0b" stroke-width="1.8" stroke-linecap="round"/>
                            <defs>
                                <linearGradient id="logoStroke" x1="0" y1="0" x2="36" y2="36">
                                    <stop offset="0%"   stop-color="#22d3ee" stop-opacity="0.6"/>
                                    <stop offset="100%" stop-color="#f59e0b" stop-opacity="0.4"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <div class="flex flex-col leading-none">
                        <span class="font-display text-[15px] font-semibold tracking-tight text-white">Ajay Upadhyay</span>
                        <span class="mt-0.5 font-mono text-[10px] uppercase tracking-[0.18em] text-cyan-300/70">devops · cloud</span>
                    </div>
                </Link>

                <!-- Desktop nav -->
                <nav class="hidden items-center gap-1 lg:flex">
                    <component
                        v-for="item in nav"
                        :key="item.label"
                        :is="item.type === 'route' ? Link : 'a'"
                        :href="item.href"
                        :class="[
                            'group relative rounded-xl px-4 py-2 text-sm font-medium transition',
                            isActive(item) ? 'text-white' : 'text-white/70 hover:text-white',
                        ]"
                    >
                        <span class="relative z-10">{{ item.label }}</span>
                        <span
                            class="absolute inset-0 rounded-xl bg-white/5 transition"
                            :class="isActive(item) ? 'opacity-100' : 'opacity-0 group-hover:opacity-100'"
                        ></span>
                        <span
                            v-if="isActive(item)"
                            class="pointer-events-none absolute inset-x-3 -bottom-px h-px bg-gradient-to-r from-transparent via-cyan-300 to-transparent"
                        ></span>
                    </component>
                </nav>

                <!-- Actions -->
                <div class="flex items-center gap-2">
                    <!-- Theme switcher pill -->
                    <div class="relative flex items-center rounded-full glass p-0.5" role="group" aria-label="Theme">
                        <span
                            aria-hidden="true"
                            class="pointer-events-none absolute top-0.5 bottom-0.5 w-8 rounded-full transition-all duration-300 ease-[0.22,1,0.36,1]"
                            :class="isDark ? 'left-0.5 bg-white/10' : 'left-[calc(100%-2rem-2px)] bg-amber-400/15'"
                        />
                        <button @click="setDark" :aria-pressed="isDark" aria-label="Dark mode"
                            class="relative z-10 grid h-8 w-8 place-items-center rounded-full transition-colors duration-200"
                            :class="isDark ? 'text-cyan-300' : 'text-white/40 hover:text-white/65'">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                            </svg>
                        </button>
                        <button @click="setLight" :aria-pressed="!isDark" aria-label="Light mode"
                            class="relative z-10 grid h-8 w-8 place-items-center rounded-full transition-colors duration-200"
                            :class="!isDark ? 'text-amber-400' : 'text-white/40 hover:text-white/65'">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="5"/>
                                <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Cart -->
                    <button
                        @click="openCart"
                        class="relative grid h-9 w-9 place-items-center rounded-xl glass transition hover:border-white/20 text-white/80"
                        aria-label="Open cart"
                    >
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"/>
                            <circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                        <span
                            v-if="cartCount > 0"
                            class="absolute -right-1 -top-1 grid h-4 min-w-4 place-items-center rounded-full bg-cyan-400 px-1 font-mono text-[9px] font-bold shadow-[0_0_10px_rgba(34,211,238,0.6)]"
                            :class="isDark ? 'text-[#05070d]' : 'text-[#ffffff]'"
                            aria-live="polite"
                        >
                            {{ cartCount }}
                        </span>
                    </button>

                    <!-- Search (desktop) -->
                    <form
                        @submit.prevent="submitSearch"
                        class="group relative hidden items-center rounded-xl glass pl-3 pr-1.5 transition focus-within:border-cyan-300/30 focus-within:shadow-[0_0_0_3px_rgba(34,211,238,0.08)] sm:flex"
                        role="search"
                    >
                        <svg class="h-4 w-4 flex-none text-white/45 transition group-focus-within:text-cyan-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="7"/>
                            <path d="m21 21-4.3-4.3"/>
                        </svg>
                        <input
                            v-model="searchQuery"
                            type="search"
                            placeholder="Search courses…"
                            aria-label="Search courses"
                            class="w-24 bg-transparent px-2.5 py-2 text-sm text-white placeholder:text-white/35 focus:outline-none md:w-32 xl:w-40"
                        />
                        <button
                            type="submit"
                            class="grid h-7 w-7 flex-none place-items-center rounded-lg text-white/50 transition hover:bg-white/10 hover:text-cyan-300"
                            aria-label="Search"
                        >
                            <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="none">
                                <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </form>

                    <!-- Hamburger (mobile only) -->
                    <button
                        @click="mobileOpen = true"
                        class="lg:hidden grid h-9 w-9 place-items-center rounded-xl glass transition hover:border-white/20 text-white/80"
                        aria-label="Open menu"
                    >
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M4 7h16M4 12h10M4 17h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </motion.header>

    <!-- ─── Mobile drawer — teleported to <body> ────────────────── -->
    <Teleport to="body">
        <!-- Backdrop -->
        <Transition name="drawer-backdrop">
            <div
                v-if="mobileOpen"
                class="fixed inset-0 z-[60] lg:hidden"
                :class="isDark ? 'bg-ink-950/70' : 'bg-slate-900/40'"
                style="backdrop-filter: blur(4px);"
                @click="close"
                aria-hidden="true"
            />
        </Transition>

        <!-- Panel -->
        <Transition name="drawer-panel">
            <div
                v-if="mobileOpen"
                class="fixed right-0 top-0 z-[70] flex h-screen w-72 flex-col glass-strong lg:hidden overflow-hidden"
            >
                <!-- Header row -->
                <div class="flex items-center justify-between border-b border-white/5 px-5 py-4">
                    <span class="font-mono text-[10px] uppercase tracking-[0.25em] text-white/40">Menu</span>
                    <button
                        @click="close"
                        class="grid h-8 w-8 place-items-center rounded-xl glass transition hover:border-white/20 text-white/70"
                        aria-label="Close menu"
                    >
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M6 6l12 12M18 6L6 18"/>
                        </svg>
                    </button>
                </div>

                <!-- Nav links -->
                <nav class="flex flex-1 flex-col gap-1 overflow-y-auto p-4">
                    <component
                        v-for="(item, i) in nav"
                        :key="item.label"
                        :is="item.type === 'route' ? Link : 'a'"
                        :href="item.href"
                        @click="close"
                        :class="[
                            'group flex items-center justify-between rounded-xl px-4 py-3.5 text-[15px] font-medium transition',
                            isActive(item)
                                ? 'bg-white/10 text-white ring-1 ring-cyan-300/20'
                                : 'text-white/75 hover:bg-white/5 hover:text-white',
                        ]"
                        :style="{ transitionDelay: mobileOpen ? `${i * 40}ms` : '0ms' }"
                    >
                        <span class="flex items-center gap-2">
                            <span
                                v-if="isActive(item)"
                                class="h-1.5 w-1.5 rounded-full bg-cyan-300 shadow-[0_0_10px_rgba(34,211,238,0.8)]"
                            ></span>
                            {{ item.label }}
                        </span>
                        <svg
                            class="h-3.5 w-3.5 transition group-hover:translate-x-0.5"
                            :class="isActive(item) ? 'text-cyan-300' : 'text-white/25 group-hover:text-white/50'"
                            viewBox="0 0 20 20" fill="none"
                        >
                            <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </component>
                </nav>

                <!-- Footer CTA -->
                <div class="border-t border-white/5 p-4">
                    <a
                        href="#contact"
                        @click="close"
                        class="flex w-full items-center justify-center gap-2 rounded-xl border border-cyan-300/20 bg-cyan-400/10 px-4 py-3.5 text-sm font-semibold text-white transition hover:border-cyan-300/30 hover:bg-cyan-400/15"
                    >
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 shadow-[0_0_10px_rgba(52,211,153,0.9)]"></span>
                        Book a Call
                    </a>
                </div>
            </div>
        </Transition>
    </Teleport>

    <!-- ─── Cart drawer ────────────────────────────────────────── -->
    <CartDrawer />
</template>

<style scoped>
/* Backdrop fade */
.drawer-backdrop-enter-active,
.drawer-backdrop-leave-active {
    transition: opacity 0.3s ease;
}
.drawer-backdrop-enter-from,
.drawer-backdrop-leave-to {
    opacity: 0;
}

/* Panel slide right → left */
.drawer-panel-enter-active,
.drawer-panel-leave-active {
    transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1);
}
.drawer-panel-enter-from,
.drawer-panel-leave-to {
    transform: translateX(100%);
}
</style>
