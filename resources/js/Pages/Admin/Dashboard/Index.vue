<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineOptions({ layout: AdminLayout });

const page = usePage();
const user = page.props.auth?.user;

const now = new Date();
const hour = now.getHours();
const greeting = hour < 12 ? 'Good morning' : hour < 18 ? 'Good afternoon' : 'Good evening';
</script>

<template>
    <Head title="Dashboard — Admin" />

    <div class="mx-auto max-w-5xl">
        <!-- Welcome card -->
        <div
            class="relative overflow-hidden rounded-2xl p-7 sm:p-9"
            style="background: linear-gradient(135deg, rgba(255,255,255,0.06) 0%, rgba(255,255,255,0.02) 100%);
                   border: 1px solid rgba(255,255,255,0.08);
                   box-shadow: 0 0 0 1px rgba(34,211,238,0.06);"
        >
            <!-- Top glow accent -->
            <div class="pointer-events-none absolute inset-0 rounded-2xl"
                style="background: radial-gradient(ellipse at 50% 0%, rgba(34,211,238,0.07) 0%, transparent 60%);"></div>

            <!-- Status badge -->
            <div class="mb-5 inline-flex items-center gap-2 rounded-full px-3 py-1.5"
                style="background: rgba(34,211,238,0.06); border: 1px solid rgba(34,211,238,0.14);">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]"></span>
                <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-cyan-300/80">System Online</span>
            </div>

            <h2 class="font-display text-3xl font-semibold leading-snug tracking-tight text-white sm:text-4xl md:text-5xl">
                {{ greeting }},<br />
                <span style="background: linear-gradient(135deg, #e0f2fe 0%, #22d3ee 50%, #2dd4bf 100%);
                              -webkit-background-clip: text; background-clip: text; color: transparent;">
                    {{ user?.name ?? 'Admin' }}.
                </span>
            </h2>

            <p class="mt-3 max-w-[48ch] text-sm leading-relaxed text-white/50 sm:text-[15px]">
                Welcome to your admin panel. You're fully authenticated and in control.
                More sections are coming soon.
            </p>

            <!-- Divider -->
            <div class="my-6 h-px"
                style="background: linear-gradient(90deg, rgba(34,211,238,0.2), rgba(45,212,191,0.1), transparent);"></div>

            <!-- Meta row -->
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-2">
                    <span class="font-mono text-[10px] uppercase tracking-[0.15em] text-white/30">Logged in as</span>
                    <span class="font-mono text-[11px] text-white/60">{{ user?.email }}</span>
                </div>
                <div class="h-3 w-px" style="background: rgba(255,255,255,0.1);"></div>
                <div class="flex items-center gap-2">
                    <span class="font-mono text-[10px] uppercase tracking-[0.15em] text-white/30">Role</span>
                    <span class="font-mono text-[11px] text-cyan-300/70">Administrator</span>
                </div>
            </div>
        </div>

        <!-- Empty state placeholder -->
        <div class="mt-4 rounded-2xl p-8 text-center"
            style="background: rgba(255,255,255,0.02); border: 1px dashed rgba(255,255,255,0.07);">
            <p class="font-mono text-[11px] uppercase tracking-[0.2em] text-white/20">
                More panels coming soon
            </p>
        </div>
    </div>
</template>
