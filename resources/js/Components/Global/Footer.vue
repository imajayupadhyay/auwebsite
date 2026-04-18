<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useTheme } from '@/composables/useTheme';

const year = new Date().getFullYear();
const { isDark } = useTheme();

const form = useForm({ email: '' });
const subscribed = ref(false);

const subscribe = () => {
    if (form.processing) return;
    form.post('/newsletter', {
        preserveScroll: true,
        onSuccess: () => {
            subscribed.value = true;
            form.reset();
        },
    });
};

const columns = [
    {
        title: 'Courses',
        links: ['AWS Cloud', 'Microsoft Azure', 'Google Cloud', 'Jenkins CI/CD', 'Docker & Kubernetes', 'Terraform'],
    },
    {
        title: 'Services',
        links: ['1:1 Mentorship', 'Corporate Training', 'Cloud Consulting', 'Interview Prep'],
    },
    {
        title: 'Company',
        links: ['About', 'Blog', 'Testimonials', 'Contact'],
    },
];

const socials = [
    { label: 'GitHub', path: 'M12 .5C5.6.5.5 5.6.5 12c0 5.1 3.3 9.4 7.9 10.9.6.1.8-.3.8-.6v-2c-3.2.7-3.9-1.5-3.9-1.5-.5-1.3-1.3-1.7-1.3-1.7-1-.7.1-.7.1-.7 1.2.1 1.8 1.2 1.8 1.2 1 1.8 2.7 1.3 3.4 1 .1-.8.4-1.3.8-1.6-2.6-.3-5.3-1.3-5.3-5.8 0-1.3.5-2.3 1.2-3.2-.1-.3-.5-1.5.1-3.1 0 0 1-.3 3.3 1.2 1-.3 2-.4 3-.4s2 .1 3 .4c2.3-1.5 3.3-1.2 3.3-1.2.7 1.6.2 2.8.1 3.1.8.9 1.2 1.9 1.2 3.2 0 4.5-2.7 5.5-5.3 5.8.4.4.8 1.1.8 2.3v3.3c0 .3.2.7.8.6 4.6-1.5 7.9-5.8 7.9-10.9C23.5 5.6 18.4.5 12 .5z' },
    { label: 'LinkedIn', path: 'M20.5 2h-17A1.5 1.5 0 0 0 2 3.5v17A1.5 1.5 0 0 0 3.5 22h17a1.5 1.5 0 0 0 1.5-1.5v-17A1.5 1.5 0 0 0 20.5 2zM8 19H5v-9h3v9zM6.5 8.25A1.75 1.75 0 1 1 8.3 6.5a1.75 1.75 0 0 1-1.8 1.75zM19 19h-3v-4.74c0-1.42-.6-1.93-1.37-1.93A1.74 1.74 0 0 0 13 14.19V19h-3v-9h2.9v1.3a3.1 3.1 0 0 1 2.7-1.4c1.55 0 3.36.86 3.36 3.66z' },
    { label: 'YouTube', path: 'M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6A3 3 0 0 0 .5 6.2C0 8.1 0 12 0 12s0 3.9.5 5.8a3 3 0 0 0 2.1 2.1c1.9.6 9.4.6 9.4.6s7.5 0 9.4-.6a3 3 0 0 0 2.1-2.1c.5-1.9.5-5.8.5-5.8s0-3.9-.5-5.8zM9.6 15.6V8.4l6.2 3.6-6.2 3.6z' },
    { label: 'Twitter/X', path: 'M17.53 2H20.8l-7.14 8.16L22 22h-6.56l-5.14-6.72L4.42 22H1.15l7.64-8.73L1 2h6.72l4.65 6.15L17.53 2zm-1.15 18h1.82L7.72 3.9H5.77L16.38 20z' },
];
</script>

<template>
    <footer id="contact" class="relative mt-16 overflow-hidden border-t border-white/5">
        <svg class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-[1px] w-full">
            <defs>
                <linearGradient id="footerLine" x1="0" x2="1">
                    <stop offset="0" :stop-color="isDark ? '#22d3ee' : '#6366f1'" stop-opacity="0"/>
                    <stop offset="0.5" :stop-color="isDark ? '#22d3ee' : '#6366f1'" stop-opacity="0.6"/>
                    <stop offset="1" :stop-color="isDark ? '#22d3ee' : '#6366f1'" stop-opacity="0"/>
                </linearGradient>
            </defs>
            <rect width="100%" height="1" fill="url(#footerLine)"/>
        </svg>

        <div
            class="pointer-events-none absolute -top-32 left-1/2 h-[400px] w-[600px] -translate-x-1/2 rounded-full blur-[120px] transition-all duration-500"
            :class="isDark ? 'bg-cyan-500/10' : 'bg-indigo-400/12'"
        ></div>

        <div class="relative mx-auto max-w-7xl px-6 pb-10 pt-20">
            <div class="grid gap-12 lg:grid-cols-12">
                <div class="lg:col-span-5">
                    <div class="flex items-center gap-3">
                        <svg viewBox="0 0 36 36" class="h-10 w-10" fill="none">
                            <rect x="1" y="1" width="34" height="34" rx="9" stroke="#22d3ee" stroke-opacity="0.5" stroke-width="1.2"/>
                            <path d="M11 13 L8 18 L11 23" stroke="#22d3ee" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M25 13 L28 18 L25 23" stroke="#2dd4bf" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M20 11 L16 25" stroke="#f59e0b" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                        <div>
                            <div class="font-display text-lg font-semibold text-white">Ajay Upadhyay</div>
                            <div class="font-mono text-[10px] uppercase tracking-[0.2em] text-cyan-300/70">devops · cloud · mentorship</div>
                        </div>
                    </div>
                    <p class="mt-6 max-w-md text-sm leading-relaxed text-white/60">
                        Practical DevOps courses and hands-on mentorship — taught by an engineer who's shipped to production across every major cloud.
                    </p>

                    <!-- Success state -->
                    <div v-if="subscribed" class="mt-8 flex max-w-md items-center gap-3 rounded-xl p-4" style="background: rgba(52,211,153,0.08); border: 1px solid rgba(52,211,153,0.2);">
                        <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-emerald-400/15 text-emerald-400">✓</span>
                        <div>
                            <p class="text-sm font-medium text-emerald-400">You're on the list!</p>
                            <p class="font-mono text-[10px] text-white/45">I'll notify you when new courses drop.</p>
                        </div>
                    </div>

                    <!-- Subscribe form -->
                    <form v-else @submit.prevent="subscribe" class="mt-8 max-w-md">
                        <div class="flex items-center gap-2 rounded-xl glass p-1.5 pl-4" :class="form.errors.email ? 'ring-1 ring-rose-400/40' : ''">
                            <svg class="h-4 w-4 flex-shrink-0 text-cyan-300/80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16v10H4z"/><path d="m4 7 8 6 8-6"/></svg>
                            <input
                                v-model="form.email"
                                type="email"
                                placeholder="you@engineer.dev"
                                required
                                :disabled="form.processing"
                                class="flex-1 bg-transparent text-sm text-white placeholder:text-white/40 focus:outline-none disabled:opacity-60"
                            />
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="rounded-lg bg-cyan-400/90 px-3.5 py-2 text-xs font-semibold text-ink-900 transition hover:bg-cyan-300 disabled:opacity-60 disabled:cursor-not-allowed"
                            >
                                {{ form.processing ? '...' : 'Notify me' }}
                            </button>
                        </div>
                        <p v-if="form.errors.email" class="mt-2 font-mono text-[10px] text-rose-400">{{ form.errors.email }}</p>
                    </form>

                    <div class="mt-8 flex items-center gap-2">
                        <a
                            v-for="s in socials"
                            :key="s.label"
                            href="#"
                            :aria-label="s.label"
                            class="group grid h-10 w-10 place-items-center rounded-xl glass transition hover:border-cyan-300/30"
                        >
                            <svg class="h-[18px] w-[18px] text-white/70 transition group-hover:text-cyan-300" viewBox="0 0 24 24" fill="currentColor">
                                <path :d="s.path"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8 sm:grid-cols-3 lg:col-span-7">
                    <div v-for="col in columns" :key="col.title">
                        <div class="font-mono text-[10px] uppercase tracking-[0.2em] text-cyan-300/70">
                            {{ col.title }}
                        </div>
                        <ul class="mt-5 space-y-3">
                            <li v-for="link in col.links" :key="link">
                                <a href="#" class="text-sm text-white/70 transition hover:text-white">{{ link }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mt-16 flex flex-col items-start justify-between gap-4 border-t border-white/5 pt-6 text-xs text-white/40 sm:flex-row sm:items-center">
                <div class="font-mono tracking-wide">
                    © {{ year }} AJAY UPADHYAY · ALL RIGHTS RESERVED
                </div>
                <div class="flex items-center gap-2 font-mono">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 shadow-[0_0_10px_rgba(52,211,153,0.9)]"></span>
                    <span>Currently accepting 1:1 students</span>
                </div>
            </div>
        </div>
    </footer>
</template>
