<script setup>
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post('/ajayupadhyay-secure-login', {
        onError: () => form.reset('password'),
    });
};

const inputCls = [
    'w-full rounded-xl px-4 py-3 font-sans text-sm text-white',
    'placeholder:text-white/30 outline-none transition-all',
    'focus:shadow-[0_0_0_2px_rgba(34,211,238,0.25)]',
].join(' ');
</script>

<template>
    <Head title="Admin Access" />

    <div
        class="relative flex min-h-screen items-center justify-center p-4 antialiased"
        style="background: #05070d;"
    >
        <!-- Background glows -->
        <div class="pointer-events-none fixed inset-0 overflow-hidden">
            <div class="absolute -top-40 left-1/2 h-[500px] w-[500px] -translate-x-1/2 rounded-full blur-[130px]"
                style="background: rgba(34,211,238,0.07);"></div>
            <div class="absolute bottom-0 right-0 h-[400px] w-[400px] rounded-full blur-[140px]"
                style="background: rgba(45,212,191,0.05);"></div>
        </div>

        <div class="relative w-full max-w-sm">
            <!-- Brand badge -->
            <div class="mb-6 flex justify-center">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1.5"
                    style="background: rgba(34,211,238,0.06); border: 1px solid rgba(34,211,238,0.14);">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]"></span>
                    <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-cyan-300/80">Secure Access</span>
                </div>
            </div>

            <!-- Card -->
            <div class="rounded-2xl p-7 sm:p-8"
                style="background: linear-gradient(135deg, rgba(255,255,255,0.07) 0%, rgba(255,255,255,0.02) 100%);
                       backdrop-filter: blur(24px);
                       border: 1px solid rgba(255,255,255,0.09);
                       box-shadow: 0 40px 80px -20px rgba(5,7,13,0.8), 0 0 0 1px rgba(34,211,238,0.06);">

                <h1 class="font-display text-2xl font-semibold tracking-tight text-white sm:text-3xl">
                    Admin <span style="background: linear-gradient(135deg, #e0f2fe 0%, #22d3ee 50%, #2dd4bf 100%);
                                       -webkit-background-clip: text; background-clip: text; color: transparent;">Panel</span>
                </h1>
                <p class="mt-1.5 font-mono text-[11px] text-white/35 tracking-wide">
                    ajayupadhyay.dev / restricted area
                </p>

                <div class="my-6 h-px" style="background: linear-gradient(90deg, transparent, rgba(255,255,255,0.07), transparent);"></div>

                <form @submit.prevent="submit" autocomplete="off" novalidate class="space-y-4">
                    <div>
                        <label class="mb-2 block font-mono text-[10px] font-semibold uppercase tracking-[0.14em] text-white/45">
                            Email
                        </label>
                        <input
                            v-model="form.email"
                            type="email"
                            required
                            placeholder="you@domain.com"
                            autofocus
                            :class="[inputCls, form.errors.email ? 'shadow-[0_0_0_2px_rgba(251,113,133,0.3)]' : '']"
                            style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);"
                        />
                        <p v-if="form.errors.email" class="mt-1.5 font-mono text-[10px] text-rose-400">
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <div>
                        <label class="mb-2 block font-mono text-[10px] font-semibold uppercase tracking-[0.14em] text-white/45">
                            Password
                        </label>
                        <input
                            v-model="form.password"
                            type="password"
                            required
                            placeholder="••••••••"
                            :class="[inputCls, form.errors.password ? 'shadow-[0_0_0_2px_rgba(251,113,133,0.3)]' : '']"
                            style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);"
                        />
                        <p v-if="form.errors.password" class="mt-1.5 font-mono text-[10px] text-rose-400">
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <div class="pt-1">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full rounded-xl py-3 font-mono text-[11px] font-semibold uppercase tracking-[0.14em] text-ink-900 transition disabled:opacity-60 disabled:cursor-not-allowed"
                            style="background: white; box-shadow: 0 8px 30px -8px rgba(34,211,238,0.4);"
                        >
                            {{ form.processing ? 'Authenticating...' : 'Access Panel →' }}
                        </button>
                    </div>
                </form>
            </div>

            <p class="mt-5 text-center font-mono text-[10px] text-white/20 tracking-widest">
                PRIVATE — UNAUTHORISED ACCESS PROHIBITED
            </p>
        </div>
    </div>
</template>
