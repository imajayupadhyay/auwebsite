<script setup>
import { computed } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import CategoryMultiSelect from './components/CategoryMultiSelect.vue';
import TagChipInput from './components/TagChipInput.vue';
import RepeaterInput from './components/RepeaterInput.vue';
import CurriculumSection from './components/CurriculumSection.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    course:         { type: Object, required: true },
    allCategories:  { type: Array,  default: () => [] },
    levels:         { type: Array,  default: () => [] },
});

const page = usePage();
const flash = computed(() => page.props.flash ?? {});

const form = useForm({
    code:             props.course.code,
    slug:             props.course.slug,
    title:            props.course.title,
    subtitle:         props.course.subtitle         ?? '',
    icon:             props.course.icon             ?? '',
    dot_color:        props.course.dot_color        ?? '#22d3ee',
    level:            props.course.level,
    language:         props.course.language,
    hours:            props.course.hours,
    price:            props.course.price,
    original_price:   props.course.original_price   ?? '',
    rating:           props.course.rating           ?? '',
    students:         props.course.students,
    available:        props.course.available,
    last_updated_text:props.course.last_updated_text ?? '',
    description:      props.course.description      ?? '',
    tags:             props.course.tags             ?? [],
    outcomes:         props.course.outcomes         ?? [],
    requirements:     props.course.requirements     ?? [],
    sort_order:       props.course.sort_order       ?? 0,
    categories:       props.course.categories?.map(c => c.id) ?? [],
});

const submit = () => {
    form.patch(`/admin/courses/${props.course.id}`, { preserveScroll: true });
};

const inputCls = 'w-full rounded-xl px-4 py-2.5 font-sans text-sm text-white placeholder:text-white/25 outline-none transition-all';
const inputStyle = 'background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);';
const focusShadow = '0 0 0 2px rgba(34,211,238,0.18)';

const section = (title) => ({ title });
</script>

<template>
    <Head :title="`Edit: ${course.title} — Admin`" />

    <div class="mx-auto max-w-3xl space-y-6">

        <!-- Sticky top bar -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="/admin/courses"
                    class="flex h-8 w-8 items-center justify-center rounded-lg transition hover:bg-white/10"
                    style="border: 1px solid rgba(255,255,255,0.08); color: rgba(255,255,255,0.4);">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                </a>
                <div>
                    <span class="font-mono text-[10px] uppercase tracking-wider text-cyan-300/60">{{ course.code }}</span>
                    <h1 class="font-display text-xl font-semibold text-white leading-tight">{{ course.title }}</h1>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <!-- Flash success -->
                <Transition enter-active-class="transition duration-300" enter-from-class="opacity-0 translate-x-2" enter-to-class="opacity-100 translate-x-0"
                            leave-active-class="transition duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
                    <span v-if="flash.success" class="font-mono text-[10px] text-emerald-400">
                        ✓ {{ flash.success }}
                    </span>
                </Transition>

                <button @click="submit" :disabled="form.processing"
                    class="inline-flex items-center gap-2 rounded-xl px-5 py-2.5 font-mono text-[11px] font-semibold uppercase tracking-[0.12em] text-ink-900 transition disabled:opacity-60"
                    style="background: white; box-shadow: 0 8px 24px -6px rgba(34,211,238,0.3);">
                    {{ form.processing ? 'Saving…' : 'Save changes' }}
                </button>
            </div>
        </div>

        <!-- Section card helper -->
        <template v-for="s in ['basic']" :key="s"><!-- noop, sections are inline --></template>

        <!-- ── BASIC INFO ── -->
        <div class="rounded-2xl p-6 space-y-5" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07);">
            <h2 class="font-mono text-[10px] uppercase tracking-[0.2em] text-white/40">Basic Info</h2>

            <div class="grid grid-cols-[110px_1fr] gap-4">
                <div>
                    <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Code</label>
                    <input v-model="form.code" type="text" required
                        :class="[inputCls, form.errors.code ? 'shadow-[0_0_0_2px_rgba(251,113,133,0.3)]' : '']"
                        :style="inputStyle"
                        @focus="$event.target.style.boxShadow = focusShadow"
                        @blur="$event.target.style.boxShadow = 'none'" />
                    <p v-if="form.errors.code" class="mt-1 font-mono text-[10px] text-rose-400">{{ form.errors.code }}</p>
                </div>
                <div>
                    <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Title</label>
                    <input v-model="form.title" type="text" required
                        :class="[inputCls, form.errors.title ? 'shadow-[0_0_0_2px_rgba(251,113,133,0.3)]' : '']"
                        :style="inputStyle"
                        @focus="$event.target.style.boxShadow = focusShadow"
                        @blur="$event.target.style.boxShadow = 'none'" />
                    <p v-if="form.errors.title" class="mt-1 font-mono text-[10px] text-rose-400">{{ form.errors.title }}</p>
                </div>
            </div>

            <div>
                <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Subtitle</label>
                <input v-model="form.subtitle" type="text" placeholder="Short tagline…"
                    :class="inputCls" :style="inputStyle"
                    @focus="$event.target.style.boxShadow = focusShadow"
                    @blur="$event.target.style.boxShadow = 'none'" />
            </div>

            <div>
                <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Slug</label>
                <input v-model="form.slug" type="text"
                    :class="[inputCls, form.errors.slug ? 'shadow-[0_0_0_2px_rgba(251,113,133,0.3)]' : '']"
                    :style="inputStyle"
                    @focus="$event.target.style.boxShadow = focusShadow"
                    @blur="$event.target.style.boxShadow = 'none'" />
                <p v-if="form.errors.slug" class="mt-1 font-mono text-[10px] text-rose-400">{{ form.errors.slug }}</p>
            </div>

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
                    <input v-model="form.language" type="text"
                        :class="inputCls" :style="inputStyle"
                        @focus="$event.target.style.boxShadow = focusShadow"
                        @blur="$event.target.style.boxShadow = 'none'" />
                </div>
                <div>
                    <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Last updated text</label>
                    <input v-model="form.last_updated_text" type="text" placeholder="Apr 2026"
                        :class="inputCls" :style="inputStyle"
                        @focus="$event.target.style.boxShadow = focusShadow"
                        @blur="$event.target.style.boxShadow = 'none'" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Icon (Iconify)</label>
                    <input v-model="form.icon" type="text" placeholder="logos:microsoft-azure"
                        :class="inputCls" :style="inputStyle"
                        @focus="$event.target.style.boxShadow = focusShadow"
                        @blur="$event.target.style.boxShadow = 'none'" />
                </div>
                <div>
                    <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Dot color</label>
                    <div class="flex items-center gap-2">
                        <input type="color" v-model="form.dot_color" class="h-10 w-10 flex-shrink-0 rounded-lg cursor-pointer"
                            style="background: transparent; border: 1px solid rgba(255,255,255,0.08); padding: 2px;" />
                        <input v-model="form.dot_color" type="text"
                            :class="inputCls" :style="inputStyle"
                            @focus="$event.target.style.boxShadow = focusShadow"
                            @blur="$event.target.style.boxShadow = 'none'" />
                    </div>
                </div>
            </div>

            <!-- Available toggle -->
            <div class="flex items-center justify-between rounded-xl px-4 py-3"
                style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07);">
                <div>
                    <p class="text-sm font-medium text-white/70">Published</p>
                    <p class="font-mono text-[10px] text-white/30">Show on public site</p>
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
        </div>

        <!-- ── CATEGORIES ── -->
        <div class="rounded-2xl p-6 space-y-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07);">
            <h2 class="font-mono text-[10px] uppercase tracking-[0.2em] text-white/40">Categories</h2>
            <CategoryMultiSelect v-model="form.categories" :categories="allCategories" :error="form.errors.categories" />
        </div>

        <!-- ── PRICING & STATS ── -->
        <div class="rounded-2xl p-6 space-y-5" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07);">
            <h2 class="font-mono text-[10px] uppercase tracking-[0.2em] text-white/40">Pricing & Stats</h2>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Price (INR)</label>
                    <input v-model="form.price" type="number" min="0"
                        :class="inputCls" :style="inputStyle"
                        @focus="$event.target.style.boxShadow = focusShadow"
                        @blur="$event.target.style.boxShadow = 'none'" />
                </div>
                <div>
                    <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Original price</label>
                    <input v-model="form.original_price" type="number" min="0" placeholder="0"
                        :class="inputCls" :style="inputStyle"
                        @focus="$event.target.style.boxShadow = focusShadow"
                        @blur="$event.target.style.boxShadow = 'none'" />
                </div>
                <div>
                    <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Rating (0–5)</label>
                    <input v-model="form.rating" type="number" min="0" max="5" step="0.1" placeholder="4.9"
                        :class="inputCls" :style="inputStyle"
                        @focus="$event.target.style.boxShadow = focusShadow"
                        @blur="$event.target.style.boxShadow = 'none'" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Students enrolled</label>
                    <input v-model="form.students" type="number" min="0"
                        :class="inputCls" :style="inputStyle"
                        @focus="$event.target.style.boxShadow = focusShadow"
                        @blur="$event.target.style.boxShadow = 'none'" />
                </div>
                <div>
                    <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Total hours</label>
                    <input v-model="form.hours" type="number" min="0"
                        :class="inputCls" :style="inputStyle"
                        @focus="$event.target.style.boxShadow = focusShadow"
                        @blur="$event.target.style.boxShadow = 'none'" />
                </div>
            </div>
        </div>

        <!-- ── DESCRIPTION ── -->
        <div class="rounded-2xl p-6 space-y-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07);">
            <h2 class="font-mono text-[10px] uppercase tracking-[0.2em] text-white/40">Description</h2>
            <textarea v-model="form.description" rows="5" placeholder="Course overview…"
                :class="inputCls" :style="inputStyle"
                @focus="$event.target.style.boxShadow = focusShadow"
                @blur="$event.target.style.boxShadow = 'none'"
            ></textarea>
        </div>

        <!-- ── TAGS ── -->
        <div class="rounded-2xl p-6 space-y-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07);">
            <h2 class="font-mono text-[10px] uppercase tracking-[0.2em] text-white/40">Tags</h2>
            <TagChipInput v-model="form.tags" />
        </div>

        <!-- ── OUTCOMES ── -->
        <div class="rounded-2xl p-6 space-y-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07);">
            <h2 class="font-mono text-[10px] uppercase tracking-[0.2em] text-white/40">Learning Outcomes</h2>
            <RepeaterInput v-model="form.outcomes" placeholder="What students will learn…" />
        </div>

        <!-- ── REQUIREMENTS ── -->
        <div class="rounded-2xl p-6 space-y-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07);">
            <h2 class="font-mono text-[10px] uppercase tracking-[0.2em] text-white/40">Requirements</h2>
            <RepeaterInput v-model="form.requirements" placeholder="What students need to know…" />
        </div>

        <!-- Save button (bottom) -->
        <div class="flex justify-end pb-4">
            <button @click="submit" :disabled="form.processing"
                class="inline-flex items-center gap-2 rounded-xl px-6 py-3 font-mono text-[11px] font-semibold uppercase tracking-[0.12em] text-ink-900 transition disabled:opacity-60"
                style="background: white; box-shadow: 0 8px 24px -6px rgba(34,211,238,0.3);">
                {{ form.processing ? 'Saving…' : 'Save changes' }}
            </button>
        </div>

        <!-- ── CURRICULUM ── -->
        <div class="rounded-2xl p-6 space-y-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07);">
            <h2 class="font-mono text-[10px] uppercase tracking-[0.2em] text-white/40">Curriculum</h2>
            <CurriculumSection :course="course" />
        </div>

    </div>
</template>
