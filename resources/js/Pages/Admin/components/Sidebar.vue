<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();

const navLinks = [
    {
        label: 'Dashboard',
        href: '/admin/dashboard',
        match: '/admin/dashboard',
        icon: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/>
            <rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>
        </svg>`,
    },
    {
        label: 'Contacts',
        href: '/admin/contacts',
        match: '/admin/contacts',
        icon: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
        </svg>`,
    },
    {
        label: 'Users',
        href: '/admin/users',
        match: '/admin/users',
        icon: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>`,
    },
    {
        label: 'Categories',
        href: '/admin/categories',
        match: '/admin/categories',
        icon: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
            <line x1="9" y1="14" x2="15" y2="14"/>
            <line x1="12" y1="11" x2="12" y2="17"/>
        </svg>`,
    },
    {
        label: 'Courses',
        href: '/admin/courses',
        match: '/admin/courses',
        icon: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
            <path d="M6 12v5c3 3 9 3 12 0v-5"/>
        </svg>`,
    },
];

const isActive = (href) => page.url.startsWith(href);
</script>

<template>
    <aside
        class="fixed inset-y-0 left-0 z-40 flex w-[240px] flex-col"
        style="background: #0a0e1a; border-right: 1px solid rgba(255,255,255,0.06);"
    >
        <!-- Brand -->
        <div class="flex h-16 items-center gap-3 px-5" style="border-bottom: 1px solid rgba(255,255,255,0.05);">
            <div class="flex h-7 w-7 items-center justify-center rounded-lg"
                style="background: rgba(34,211,238,0.1); border: 1px solid rgba(34,211,238,0.2);">
                <span class="font-mono text-[11px] font-bold text-cyan-300">A</span>
            </div>
            <div>
                <p class="font-display text-sm font-semibold leading-none text-white">ajayupadhyay</p>
                <p class="mt-0.5 font-mono text-[9px] uppercase tracking-[0.18em] text-white/30">/admin</p>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 overflow-y-auto px-3 py-4">
            <p class="mb-2 px-2 font-mono text-[9px] uppercase tracking-[0.2em] text-white/25">Menu</p>

            <Link
                v-for="link in navLinks"
                :key="link.href"
                :href="link.href"
                class="group mb-0.5 flex items-center gap-3 rounded-lg px-3 py-2.5 font-mono text-[11px] font-medium uppercase tracking-[0.1em] transition-all"
                :style="isActive(link.match)
                    ? 'background: rgba(34,211,238,0.08); color: #22d3ee; border: 1px solid rgba(34,211,238,0.15);'
                    : 'color: rgba(255,255,255,0.45); border: 1px solid transparent;'"
            >
                <span
                    class="flex-shrink-0 transition-colors"
                    :style="isActive(link.match) ? 'color: #22d3ee;' : 'color: rgba(255,255,255,0.3);'"
                    v-html="link.icon"
                ></span>
                {{ link.label }}
                <span v-if="isActive(link.match)" class="ml-auto h-1 w-1 rounded-full bg-cyan-400"></span>
            </Link>
        </nav>

        <!-- User footer -->
        <div class="px-3 py-4" style="border-top: 1px solid rgba(255,255,255,0.05);">
            <div class="rounded-xl px-3 py-3" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full"
                        style="background: rgba(34,211,238,0.1); border: 1px solid rgba(34,211,238,0.2);">
                        <span class="font-mono text-xs font-bold text-cyan-300">A</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate font-sans text-[12px] font-medium text-white/80">ajayupadhyay</p>
                        <p class="font-mono text-[9px] text-white/30">Administrator</p>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</template>
