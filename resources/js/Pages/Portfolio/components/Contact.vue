<script setup>
import { ref, computed } from 'vue';
import { motion } from 'motion-v';
import { useTheme } from '@/composables/useTheme';
import { contactLinks } from '@/data/resume';

const { isDark } = useTheme();
const ease = [0.22, 1, 0.36, 1];

const form = ref({ name: '', email: '', phone: '', message: '' });
const status = ref('idle');

const btnLabel = computed(() => {
    if (status.value === 'sending') return 'Sending...';
    if (status.value === 'success') return 'Message sent ✓';
    return 'Send message';
});

const handleSubmit = () => {
    if (status.value === 'sending') return;
    status.value = 'sending';
    setTimeout(() => {
        status.value = 'success';
        form.value = { name: '', email: '', phone: '', message: '' };
        setTimeout(() => { status.value = 'idle'; }, 4000);
    }, 800);
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
                            </div>
                            <div>
                                <label class="mb-2 block font-mono text-[10px] font-semibold uppercase tracking-[0.12em] text-white/50">Email</label>
                                <input type="email" required maxlength="160" v-model="form.email" placeholder="you@domain.com" :class="inputCls" />
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
                        </div>

                        <button
                            type="submit"
                            :disabled="status === 'sending'"
                            class="inline-flex items-center gap-2 rounded-full px-5 py-3 font-mono text-[11px] font-semibold uppercase tracking-[0.12em] transition disabled:cursor-not-allowed disabled:opacity-60"
                            :class="isDark
                                ? 'bg-white text-ink-900 shadow-[0_15px_40px_-12px_rgba(34,211,238,0.45)] hover:shadow-[0_15px_50px_-12px_rgba(34,211,238,0.6)]'
                                : 'bg-indigo-600 text-[#ffffff] shadow-[0_15px_40px_-12px_rgba(99,102,241,0.45)] hover:bg-indigo-500'"
                        >
                            {{ btnLabel }} <span>→</span>
                        </button>

                        <div class="mt-3.5 min-h-[16px] font-mono text-[11px]">
                            <span v-if="status === 'success'" class="text-emerald-400">Thanks — I'll get back within 24h.</span>
                        </div>
                    </form>
                </motion.div>
            </div>
        </div>
    </section>
</template>
