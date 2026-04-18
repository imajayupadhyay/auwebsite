<script setup>
import { ref, watch } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { motion, AnimatePresence } from 'motion-v';
import { useTheme } from '@/composables/useTheme';
import { contactLinks } from '@/data/resume';

const { isDark } = useTheme();
const ease = [0.22, 1, 0.36, 1];

const page = usePage();
const showModal = ref(false);

const form = useForm({
    name: '',
    email: '',
    phone: '',
    message: '',
});

watch(
    () => page.props.flash?.contact_success,
    (val) => {
        if (val) showModal.value = true;
    },
);

const handleSubmit = () => {
    form.post('/contact', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};

const inputCls = 'w-full rounded-xl glass px-4 py-3 font-sans text-sm text-white placeholder:text-white/35 transition focus:border-cyan-300/40 focus:outline-none focus:shadow-[0_0_0_3px_rgba(34,211,238,0.08)]';
</script>

<template>
    <section id="contact" class="relative py-16 sm:py-20">
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
                        <span class="h-1 w-1 rounded-full bg-emerald-400"></span>
                        <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-cyan-300/80">§ Contact</span>
                    </div>
                    <h2 class="mt-4 font-display text-4xl font-semibold leading-[1.05] tracking-tight text-white sm:text-5xl md:text-6xl">
                        Open <span class="text-white/50">channel.</span>
                    </h2>
                </div>
                <div class="hidden font-mono text-[10px] uppercase tracking-[0.15em] text-white/35 sm:block">
                    Response &lt; 24h
                </div>
            </motion.div>

            <div class="mt-10 grid gap-4 lg:grid-cols-2">
                <!-- Left: info card -->
                <motion.div
                    :initial="{ opacity: 0, y: 24 }"
                    :whileInView="{ opacity: 1, y: 0 }"
                    :viewport="{ once: true, margin: '-60px' }"
                    :transition="{ duration: 0.6, ease }"
                    class="flex flex-col rounded-2xl glass px-6 py-7 sm:px-8 sm:py-9"
                >
                    <h3 class="font-display text-3xl font-semibold leading-[1.05] tracking-tight text-white sm:text-4xl md:text-5xl">
                        Let's build<br />
                        <span class="text-gradient-cyan">something reliable.</span>
                    </h3>
                    <p class="mt-4 max-w-[42ch] text-sm leading-relaxed text-white/60 sm:text-[15px]">
                        Open to DevOps, Cloud Engineering, and Infrastructure roles. Drop a line — I respond within 24 hours.
                    </p>

                    <div class="mt-auto grid gap-px overflow-hidden rounded-2xl border border-white/10 pt-8">
                        <a
                            v-for="l in contactLinks"
                            :key="l.key"
                            :href="l.href"
                            :target="l.external ? '_blank' : undefined"
                            :rel="l.external ? 'noopener noreferrer' : undefined"
                            class="group grid grid-cols-[72px_1fr_auto] items-center gap-3 border-b border-white/5 bg-white/5 px-4 py-3.5 transition last:border-b-0 hover:bg-white/10 sm:grid-cols-[88px_1fr_auto]"
                        >
                            <span class="font-mono text-[10px] uppercase tracking-[0.14em] text-white/40">{{ l.key }}</span>
                            <span class="truncate font-mono text-xs text-white/85 sm:text-[13px]">{{ l.val }}</span>
                            <span class="font-mono text-sm text-white/35 transition group-hover:translate-x-0.5 group-hover:text-cyan-300">→</span>
                        </a>
                    </div>
                </motion.div>

                <!-- Right: form -->
                <motion.div
                    :initial="{ opacity: 0, y: 24 }"
                    :whileInView="{ opacity: 1, y: 0 }"
                    :viewport="{ once: true, margin: '-60px' }"
                    :transition="{ duration: 0.6, delay: 0.05, ease }"
                    class="rounded-2xl glass p-6 sm:p-8"
                >
                    <div class="mb-5 flex items-center gap-2 font-mono text-[10px] font-semibold uppercase tracking-[0.14em] text-white/50">
                        <span class="h-1.5 w-1.5 rounded-full bg-cyan-300"></span>
                        <span>Send a message</span>
                    </div>

                    <form @submit.prevent="handleSubmit" autocomplete="off" novalidate>
                        <div class="mb-3.5 grid grid-cols-1 gap-3 sm:grid-cols-2">
                            <div>
                                <label class="mb-2 block font-mono text-[10px] font-semibold uppercase tracking-[0.12em] text-white/50">Name</label>
                                <input type="text" required maxlength="120" v-model="form.name" placeholder="Your name" :class="inputCls" />
                                <p v-if="form.errors.name" class="mt-1 font-mono text-[10px] text-rose-400">{{ form.errors.name }}</p>
                            </div>
                            <div>
                                <label class="mb-2 block font-mono text-[10px] font-semibold uppercase tracking-[0.12em] text-white/50">Email</label>
                                <input type="email" required maxlength="160" v-model="form.email" placeholder="you@domain.com" :class="inputCls" />
                                <p v-if="form.errors.email" class="mt-1 font-mono text-[10px] text-rose-400">{{ form.errors.email }}</p>
                            </div>
                        </div>

                        <div class="mb-3.5">
                            <label class="mb-2 block font-mono text-[10px] font-semibold uppercase tracking-[0.12em] text-white/50">
                                Phone <span class="normal-case tracking-normal text-white/35">(optional)</span>
                            </label>
                            <input type="tel" maxlength="40" v-model="form.phone" placeholder="+1 555 123 4567" :class="inputCls" />
                        </div>

                        <div class="mb-4">
                            <label class="mb-2 block font-mono text-[10px] font-semibold uppercase tracking-[0.12em] text-white/50">Message</label>
                            <textarea required maxlength="5000" rows="4" v-model="form.message" placeholder="Tell me about your project..." :class="[inputCls, 'min-h-[110px] resize-y leading-relaxed']"></textarea>
                            <p v-if="form.errors.message" class="mt-1 font-mono text-[10px] text-rose-400">{{ form.errors.message }}</p>
                        </div>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center gap-2 rounded-full px-5 py-3 font-mono text-[11px] font-semibold uppercase tracking-[0.12em] transition disabled:cursor-not-allowed disabled:opacity-60"
                            :class="isDark
                                ? 'bg-white text-ink-900 shadow-[0_15px_40px_-12px_rgba(34,211,238,0.45)] hover:shadow-[0_15px_50px_-12px_rgba(34,211,238,0.6)]'
                                : 'bg-indigo-600 text-[#ffffff] shadow-[0_15px_40px_-12px_rgba(99,102,241,0.45)] hover:bg-indigo-500'"
                        >
                            <span>{{ form.processing ? 'Sending...' : 'Send message' }}</span>
                            <span>→</span>
                        </button>
                    </form>
                </motion.div>
            </div>
        </div>
    </section>

    <!-- Success modal -->
    <Teleport to="body">
        <AnimatePresence>
            <template v-if="showModal">
                <!-- Backdrop -->
                <motion.div
                    :initial="{ opacity: 0 }"
                    :animate="{ opacity: 1 }"
                    :exit="{ opacity: 0 }"
                    :transition="{ duration: 0.25 }"
                    class="fixed inset-0 z-50 flex items-center justify-center p-4"
                    style="background: rgba(5,7,13,0.75); backdrop-filter: blur(8px);"
                    @click.self="showModal = false"
                >
                    <!-- Modal card -->
                    <motion.div
                        :initial="{ opacity: 0, scale: 0.92, y: 16 }"
                        :animate="{ opacity: 1, scale: 1, y: 0 }"
                        :exit="{ opacity: 0, scale: 0.94, y: 8 }"
                        :transition="{ duration: 0.35, ease: [0.22, 1, 0.36, 1] }"
                        class="relative w-full max-w-md rounded-2xl glass-strong p-8 text-center"
                        style="box-shadow: 0 0 0 1px rgba(34,211,238,0.12), 0 40px 80px -20px rgba(5,7,13,0.8);"
                    >
                        <!-- Glow ring -->
                        <div class="absolute inset-0 rounded-2xl" style="background: radial-gradient(ellipse at 50% 0%, rgba(34,211,238,0.08) 0%, transparent 65%); pointer-events: none;"></div>

                        <!-- Icon -->
                        <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-full" style="background: rgba(34,211,238,0.08); border: 1px solid rgba(34,211,238,0.2);">
                            <svg class="h-7 w-7 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>

                        <!-- Label -->
                        <div class="mb-2 inline-flex items-center gap-2 rounded-full px-3 py-1" style="background: rgba(34,211,238,0.06); border: 1px solid rgba(34,211,238,0.12);">
                            <span class="h-1 w-1 rounded-full bg-emerald-400"></span>
                            <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-cyan-300/80">Message received</span>
                        </div>

                        <h3 class="mt-3 font-display text-2xl font-semibold tracking-tight text-white sm:text-3xl">
                            Message <span class="text-gradient-cyan">sent.</span>
                        </h3>
                        <p class="mx-auto mt-3 max-w-[34ch] text-sm leading-relaxed text-white/55">
                            Thanks for reaching out — I'll get back to you within 24 hours.
                        </p>

                        <!-- Divider -->
                        <div class="my-6 h-px w-full" style="background: linear-gradient(90deg, transparent, rgba(255,255,255,0.06), transparent);"></div>

                        <button
                            @click="showModal = false"
                            class="inline-flex items-center gap-2 rounded-full bg-white px-6 py-2.5 font-mono text-[11px] font-semibold uppercase tracking-[0.12em] text-ink-900 transition hover:opacity-90"
                            style="box-shadow: 0 8px 24px -6px rgba(34,211,238,0.3);"
                        >
                            Close <span>✕</span>
                        </button>
                    </motion.div>
                </motion.div>
            </template>
        </AnimatePresence>
    </Teleport>
</template>
