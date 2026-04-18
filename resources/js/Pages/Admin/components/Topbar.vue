<script setup>
import { router, usePage } from '@inertiajs/vue3';

defineProps({
    title: { type: String, default: 'Dashboard' },
});

const page = usePage();

const logout = () => {
    router.post('/admin/logout');
};
</script>

<template>
    <header
        class="sticky top-0 z-30 flex h-16 items-center justify-between px-6"
        style="background: rgba(10,14,26,0.85); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.05);"
    >
        <!-- Page title -->
        <div class="flex items-center gap-3">
            <div class="h-px w-4" style="background: rgba(34,211,238,0.4);"></div>
            <h1 class="font-display text-sm font-semibold tracking-tight text-white sm:text-base">{{ title }}</h1>
        </div>

        <!-- Right side -->
        <div class="flex items-center gap-3">
            <!-- Date badge -->
            <div class="hidden items-center gap-2 rounded-full px-3 py-1.5 sm:flex"
                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07);">
                <span class="h-1 w-1 rounded-full bg-emerald-400 shadow-[0_0_4px_rgba(52,211,153,0.8)]"></span>
                <span class="font-mono text-[10px] text-white/40">
                    {{ new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) }}
                </span>
            </div>

            <!-- User chip -->
            <div class="flex items-center gap-2 rounded-full px-3 py-1.5"
                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07);">
                <div class="flex h-5 w-5 items-center justify-center rounded-full"
                    style="background: rgba(34,211,238,0.15);">
                    <span class="font-mono text-[9px] font-bold text-cyan-300">A</span>
                </div>
                <span class="font-mono text-[11px] text-white/60">{{ page.props.auth?.user?.name ?? 'Admin' }}</span>
            </div>

            <!-- Logout -->
            <button
                @click="logout"
                class="flex items-center gap-1.5 rounded-full px-3 py-1.5 font-mono text-[10px] uppercase tracking-[0.12em] text-white/40 transition hover:text-rose-400"
                style="border: 1px solid rgba(255,255,255,0.06);"
                title="Logout"
            >
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                Logout
            </button>
        </div>
    </header>
</template>
