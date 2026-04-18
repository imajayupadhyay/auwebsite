<script setup>
import { ref, computed, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useTheme } from '@/composables/useTheme';
import { services, budgetOptions, timelineOptions } from '@/data/services';

const { isDark } = useTheme();

const props = defineProps({
    show:    { type: Boolean, default: false },
    service: { type: Object,  default: null  },
});

const emit = defineEmits(['close']);

const form = useForm({
    service:  '',
    name:     '',
    email:    '',
    phone:    '',
    company:  '',
    budget:   '',
    timeline: '',
    details:  '',
});

const sent = ref(false);

const btnLabel = computed(() => (form.processing ? 'Sending brief...' : 'Send brief'));

const inputCls = 'w-full rounded-xl glass px-4 py-3 font-sans text-sm text-white placeholder:text-white/35 outline-none transition focus:border-cyan-300/40 focus:shadow-[0_0_0_3px_rgba(34,211,238,0.08)]';
const selectCls = inputCls + ' appearance-none pr-10 cursor-pointer';

// Lock body scroll while modal is open
watch(
    () => props.show,
    (open) => {
        document.body.style.overflow = open ? 'hidden' : '';
        if (open) {
            sent.value = false;
            if (props.service?.title) {
                form.service = props.service.title;
            } else if (!form.service) {
                form.service = '';
            }
        }
    },
);

const close = () => {
    emit('close');
    setTimeout(() => {
        if (sent.value) {
            form.reset();
            sent.value = false;
        }
    }, 300);
};

const handleSubmit = () => {
    if (form.processing) return;
    form.post('/service-inquiry', {
        preserveScroll: true,
        onSuccess: () => {
            sent.value = true;
        },
    });
};
</script>

<template>
    <Teleport to="body">
        <!-- Backdrop -->
        <Transition
            enter-active-class="transition-opacity duration-300 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-200 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="show"
                class="fixed inset-0 z-[80]"
                :class="isDark ? 'bg-ink-950/75' : 'bg-slate-900/45'"
                style="backdrop-filter: blur(8px);"
                @click="close"
                aria-hidden="true"
            />
        </Transition>

        <!-- Panel -->
        <Transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="opacity-0 translate-y-6 sm:translate-y-2 sm:scale-[0.97]"
            enter-to-class="opacity-100 translate-y-0 sm:scale-100"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100 translate-y-0 sm:scale-100"
            leave-to-class="opacity-0 translate-y-6 sm:translate-y-2 sm:scale-[0.97]"
        >
            <div
                v-if="show"
                class="fixed inset-x-0 bottom-0 z-[90] flex justify-center sm:inset-0 sm:items-center sm:px-4 sm:py-6"
                role="dialog"
                aria-modal="true"
                aria-labelledby="inquiry-title"
            >
                <div
                    class="relative max-h-[92vh] w-full overflow-y-auto rounded-t-3xl glass-strong sm:max-w-[640px] sm:rounded-3xl"
                    :class="isDark
                        ? 'shadow-[0_-30px_80px_-30px_rgba(34,211,238,0.25),0_30px_80px_-20px_rgba(0,0,0,0.85)]'
                        : 'shadow-[0_-30px_80px_-30px_rgba(79,70,229,0.3),0_30px_80px_-20px_rgba(15,23,42,0.25)]'"
                    @click.stop
                >
                    <!-- Success state -->
                    <div v-if="sent" class="p-8 text-center sm:p-10">
                        <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-2xl border border-emerald-400/30 bg-emerald-400/10">
                            <span class="text-2xl text-emerald-400">✓</span>
                        </div>
                        <h3 class="font-display text-2xl font-semibold leading-tight tracking-tight text-white">
                            Brief received<span class="text-gradient-cyan">.</span>
                        </h3>
                        <p class="mx-auto mt-3 max-w-[44ch] text-sm leading-relaxed text-white/65">
                            Thanks for the details. I'll review and reply within 24 hours with scope, timeline, and a fixed quote.
                        </p>
                        <button
                            type="button"
                            @click="close"
                            class="mt-6 inline-flex items-center gap-2 rounded-full px-5 py-3 font-mono text-[11px] font-semibold uppercase tracking-[0.12em] transition"
                            :class="isDark
                                ? 'bg-white text-ink-900 hover:shadow-[0_15px_40px_-12px_rgba(34,211,238,0.55)]'
                                : 'bg-indigo-600 text-[#ffffff] hover:bg-indigo-500'"
                        >
                            Close <span>→</span>
                        </button>
                    </div>

                    <!-- Form state -->
                    <form v-else @submit.prevent="handleSubmit" autocomplete="off" novalidate class="space-y-0">
                        <!-- Header -->
                        <div
                            class="sticky top-0 z-10 flex items-center justify-between gap-4 border-b border-white/5 px-5 py-4 sm:px-8 sm:py-5"
                            :class="isDark ? 'bg-ink-950/60' : 'bg-white/60'"
                            style="backdrop-filter: blur(12px);"
                        >
                            <div class="flex items-center gap-2.5 font-mono text-[10px] font-semibold uppercase tracking-[0.14em] text-white/50">
                                <span class="relative flex h-1.5 w-1.5">
                                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-cyan-400 opacity-70"></span>
                                    <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-cyan-400"></span>
                                </span>
                                <span>Project Brief</span>
                            </div>
                            <button
                                type="button"
                                @click="close"
                                class="flex h-8 w-8 items-center justify-center rounded-full text-white/60 transition hover:bg-white/10 hover:text-white"
                                aria-label="Close"
                            >
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                    <path d="M6 6l12 12M18 6L6 18"/>
                                </svg>
                            </button>
                        </div>

                        <div class="p-5 sm:p-8">
                            <h3 id="inquiry-title" class="font-display text-2xl font-semibold leading-tight tracking-tight text-white sm:text-3xl">
                                Let's scope it out<span class="text-gradient-cyan">.</span>
                            </h3>
                            <p class="mt-2 text-sm leading-relaxed text-white/60">
                                Fill out what you know — I'll reply within 24 hours with next steps.
                            </p>

                            <!-- Service -->
                            <div class="mt-6">
                                <label class="mb-2 block font-mono text-[10px] font-semibold uppercase tracking-[0.12em] text-white/50">Service</label>
                                <div class="relative">
                                    <select v-model="form.service" required :class="selectCls">
                                        <option value="" disabled>Pick a service...</option>
                                        <option v-for="s in services" :key="s.id" :value="s.title">{{ s.num }} · {{ s.title }}</option>
                                        <option value="Other / Not sure yet">Other / Not sure yet</option>
                                    </select>
                                    <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 font-mono text-[11px] text-white/40">▾</span>
                                </div>
                            </div>

                            <!-- Name + Email -->
                            <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                <div>
                                    <label class="mb-2 block font-mono text-[10px] font-semibold uppercase tracking-[0.12em] text-white/50">Name *</label>
                                    <input type="text" required maxlength="120" v-model="form.name" placeholder="Your name" :class="inputCls" />
                                </div>
                                <div>
                                    <label class="mb-2 block font-mono text-[10px] font-semibold uppercase tracking-[0.12em] text-white/50">Email *</label>
                                    <input type="email" required maxlength="160" v-model="form.email" placeholder="you@domain.com" :class="inputCls" />
                                </div>
                            </div>

                            <!-- Phone + Company -->
                            <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                <div>
                                    <label class="mb-2 block font-mono text-[10px] font-semibold uppercase tracking-[0.12em] text-white/50">
                                        Phone <span class="normal-case tracking-normal text-white/35">(optional)</span>
                                    </label>
                                    <input type="tel" maxlength="40" v-model="form.phone" placeholder="+1 555 123 4567" :class="inputCls" />
                                </div>
                                <div>
                                    <label class="mb-2 block font-mono text-[10px] font-semibold uppercase tracking-[0.12em] text-white/50">
                                        Company <span class="normal-case tracking-normal text-white/35">(optional)</span>
                                    </label>
                                    <input type="text" maxlength="160" v-model="form.company" placeholder="Acme Inc." :class="inputCls" />
                                </div>
                            </div>

                            <!-- Budget chips -->
                            <div class="mt-4">
                                <label class="mb-2 block font-mono text-[10px] font-semibold uppercase tracking-[0.12em] text-white/50">Budget range</label>
                                <div class="flex flex-wrap gap-2">
                                    <button
                                        v-for="b in budgetOptions"
                                        :key="b"
                                        type="button"
                                        @click="form.budget = form.budget === b ? '' : b"
                                        :class="[
                                            'rounded-full border px-3 py-1.5 font-mono text-[11px] transition',
                                            form.budget === b
                                                ? 'border-cyan-300/60 bg-cyan-400/10 text-cyan-300'
                                                : 'border-white/10 bg-white/5 text-white/65 hover:border-white/20 hover:text-white',
                                        ]"
                                    >{{ b }}</button>
                                </div>
                            </div>

                            <!-- Timeline chips -->
                            <div class="mt-4">
                                <label class="mb-2 block font-mono text-[10px] font-semibold uppercase tracking-[0.12em] text-white/50">Timeline</label>
                                <div class="flex flex-wrap gap-2">
                                    <button
                                        v-for="t in timelineOptions"
                                        :key="t"
                                        type="button"
                                        @click="form.timeline = form.timeline === t ? '' : t"
                                        :class="[
                                            'rounded-full border px-3 py-1.5 font-mono text-[11px] transition',
                                            form.timeline === t
                                                ? 'border-teal-300/60 bg-teal-400/10 text-teal-300'
                                                : 'border-white/10 bg-white/5 text-white/65 hover:border-white/20 hover:text-white',
                                        ]"
                                    >{{ t }}</button>
                                </div>
                            </div>

                            <!-- Details -->
                            <div class="mt-4">
                                <label class="mb-2 block font-mono text-[10px] font-semibold uppercase tracking-[0.12em] text-white/50">Project details *</label>
                                <textarea
                                    required
                                    maxlength="5000"
                                    rows="5"
                                    v-model="form.details"
                                    placeholder="Current stack, challenges, what success looks like..."
                                    :class="[inputCls, 'min-h-[130px] resize-y leading-relaxed']"
                                ></textarea>
                                <div class="mt-2 flex justify-between font-mono text-[10px] text-white/40">
                                    <span>Pro tip: include stack + pain points.</span>
                                    <span>{{ form.details.length }}/5000</span>
                                </div>
                            </div>

                            <!-- Submit -->
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="group mt-6 inline-flex w-full items-center justify-between gap-2 rounded-full px-5 py-3.5 font-mono text-[11px] font-semibold uppercase tracking-[0.12em] transition disabled:cursor-not-allowed disabled:opacity-60"
                                :class="isDark
                                    ? 'bg-white text-ink-900 shadow-[0_15px_40px_-12px_rgba(34,211,238,0.45)] hover:shadow-[0_15px_50px_-12px_rgba(34,211,238,0.65)]'
                                    : 'bg-indigo-600 text-[#ffffff] shadow-[0_15px_40px_-12px_rgba(99,102,241,0.45)] hover:bg-indigo-500'"
                            >
                                <span>{{ btnLabel }}</span>
                                <span class="transition group-hover:translate-x-0.5">→</span>
                            </button>

                            <p class="mt-4 text-center font-mono text-[10px] text-white/40">
                                Response within 24h · Your info is never shared.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
