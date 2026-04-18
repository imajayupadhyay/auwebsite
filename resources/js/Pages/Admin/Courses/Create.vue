<script setup>
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import CategoryMultiSelect from './components/CategoryMultiSelect.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    categories: { type: Array, default: () => [] },
    levels:     { type: Array, default: () => [] },
});

const form = useForm({
    code:       '',
    title:      '',
    subtitle:   '',
    level:      'Beginner',
    language:   'English',
    icon:       '',
    dot_color:  '#22d3ee',
    available:  false,
    categories: [],
});

const submit = () => {
    form.post('/admin/courses', { preserveScroll: true });
};

const inputCls = 'w-full rounded-xl px-4 py-2.5 font-sans text-sm text-white placeholder:text-white/25 outline-none transition-all';
const inputStyle = 'background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);';
const focusShadow = '0 0 0 2px rgba(34,211,238,0.18)';
</script>

<template>
    <Head title="New Course — Admin" />

    <div class="mx-auto max-w-2xl space-y-6">

        <!-- Page header -->
        <div class="flex items-center gap-4">
            <a href="/admin/courses"
                class="flex h-8 w-8 items-center justify-center rounded-lg transition hover:bg-white/10"
                style="border: 1px solid rgba(255,255,255,0.08); color: rgba(255,255,255,0.4);">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </a>
            <div>
                <div class="mb-1 inline-flex items-center gap-2 rounded-full px-2.5 py-1"
                    style="background: rgba(34,211,238,0.07); border: 1px solid rgba(34,211,238,0.15);">
                    <span class="h-1 w-1 rounded-full bg-cyan-400"></span>
                    <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-cyan-300/70">New Course</span>
                </div>
                <h1 class="font-display text-2xl font-semibold tracking-tight text-white">Add course</h1>
            </div>
        </div>

        <!-- Form card -->
        <div class="rounded-2xl p-6"
            style="background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%);
                   border: 1px solid rgba(255,255,255,0.08);">
            <form @submit.prevent="submit" novalidate class="space-y-5">

                <!-- Code + Title -->
                <div class="grid grid-cols-[110px_1fr] gap-4">
                    <div>
                        <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Code</label>
                        <input v-model="form.code" type="text" required placeholder="AZ-01"
                            :class="[inputCls, form.errors.code ? 'shadow-[0_0_0_2px_rgba(251,113,133,0.3)]' : '']"
                            :style="inputStyle"
                            @focus="$event.target.style.boxShadow = focusShadow"
                            @blur="$event.target.style.boxShadow = 'none'" />
                        <p v-if="form.errors.code" class="mt-1 font-mono text-[10px] text-rose-400">{{ form.errors.code }}</p>
                    </div>
                    <div>
                        <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Title</label>
                        <input v-model="form.title" type="text" required placeholder="Microsoft Azure"
                            :class="[inputCls, form.errors.title ? 'shadow-[0_0_0_2px_rgba(251,113,133,0.3)]' : '']"
                            :style="inputStyle"
                            @focus="$event.target.style.boxShadow = focusShadow"
                            @blur="$event.target.style.boxShadow = 'none'" />
                        <p v-if="form.errors.title" class="mt-1 font-mono text-[10px] text-rose-400">{{ form.errors.title }}</p>
                    </div>
                </div>

                <!-- Subtitle -->
                <div>
                    <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Subtitle</label>
                    <input v-model="form.subtitle" type="text" placeholder="Short tagline…"
                        :class="inputCls" :style="inputStyle"
                        @focus="$event.target.style.boxShadow = focusShadow"
                        @blur="$event.target.style.boxShadow = 'none'" />
                </div>

                <!-- Level + Language + Dot color -->
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Level</label>
                        <select v-model="form.level" :class="inputCls" :style="inputStyle"
                            @focus="$event.target.style.boxShadow = focusShadow"
                            @blur="$event.target.style.boxShadow = 'none'">
                            <option v-for="l in levels" :key="l" :value="l">{{ l }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Language</label>
                        <input v-model="form.language" type="text" placeholder="English"
                            :class="inputCls" :style="inputStyle"
                            @focus="$event.target.style.boxShadow = focusShadow"
                            @blur="$event.target.style.boxShadow = 'none'" />
                    </div>
                    <div>
                        <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Dot color</label>
                        <div class="flex items-center gap-2">
                            <input type="color" v-model="form.dot_color" class="h-10 w-10 flex-shrink-0 rounded-lg cursor-pointer"
                                style="background: transparent; border: 1px solid rgba(255,255,255,0.08); padding: 2px;" />
                            <input v-model="form.dot_color" type="text" placeholder="#22d3ee"
                                :class="inputCls" :style="inputStyle"
                                @focus="$event.target.style.boxShadow = focusShadow"
                                @blur="$event.target.style.boxShadow = 'none'" />
                        </div>
                    </div>
                </div>

                <!-- Icon -->
                <div>
                    <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">
                        Iconify icon name <span class="text-white/20">(e.g. logos:microsoft-azure)</span>
                    </label>
                    <input v-model="form.icon" type="text" placeholder="logos:microsoft-azure"
                        :class="inputCls" :style="inputStyle"
                        @focus="$event.target.style.boxShadow = focusShadow"
                        @blur="$event.target.style.boxShadow = 'none'" />
                </div>

                <!-- Categories -->
                <div>
                    <label class="mb-2 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Categories <span class="text-rose-400">*</span></label>
                    <CategoryMultiSelect
                        v-model="form.categories"
                        :categories="categories"
                        :error="form.errors.categories"
                    />
                </div>

                <!-- Available toggle -->
                <div class="flex items-center justify-between rounded-xl px-4 py-3"
                    style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07);">
                    <div>
                        <p class="text-sm font-medium text-white/70">Publish immediately</p>
                        <p class="font-mono text-[10px] text-white/30">Show this course on the public site</p>
                    </div>
                    <button type="button" @click="form.available = !form.available"
                        class="relative h-5 w-9 rounded-full transition-colors"
                        :style="form.available
                            ? 'background: rgba(34,211,238,0.25); border: 1px solid rgba(34,211,238,0.4);'
                            : 'background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);'">
                        <span class="absolute top-0.5 h-4 w-4 rounded-full transition-transform"
                            :style="form.available
                                ? 'transform: translateX(16px); background: #22d3ee;'
                                : 'transform: translateX(2px); background: rgba(255,255,255,0.4);'"></span>
                    </button>
                </div>

                <!-- Submit -->
                <div class="pt-1">
                    <button type="submit" :disabled="form.processing"
                        class="w-full rounded-xl py-3 font-mono text-[11px] font-semibold uppercase tracking-[0.14em] text-ink-900 transition disabled:opacity-60 disabled:cursor-not-allowed"
                        style="background: white; box-shadow: 0 8px 30px -8px rgba(34,211,238,0.35);">
                        {{ form.processing ? 'Creating…' : 'Create course & edit details →' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
