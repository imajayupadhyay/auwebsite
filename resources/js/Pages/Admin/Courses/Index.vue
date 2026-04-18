<script setup>
import { ref, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import CoursesTable from './components/CoursesTable.vue';
import DeleteConfirmModal from './components/DeleteConfirmModal.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    courses:    { type: Object, required: true },
    categories: { type: Array,  default: () => [] },
    filters:    { type: Object, default: () => ({}) },
    stats:      { type: Object, default: () => ({}) },
});

const search     = ref(props.filters.search   ?? '');
const categoryId = ref(props.filters.category ?? '');
let searchTimer  = null;

const reload = () => {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
        router.get('/admin/courses', { search: search.value, category: categoryId.value }, { preserveState: true, replace: true });
    }, 350);
};

watch(search, reload);
watch(categoryId, () => {
    router.get('/admin/courses', { search: search.value, category: categoryId.value }, { preserveState: true, replace: true });
});

// Delete
const toDelete = ref(null);
const deleting = ref(false);

const requestDelete = (course) => { toDelete.value = course; };
const cancelDelete  = () => { toDelete.value = null; };

const confirmDelete = () => {
    if (!toDelete.value) return;
    deleting.value = true;
    router.delete(`/admin/courses/${toDelete.value.id}`, {
        preserveScroll: true,
        onSuccess: () => { toDelete.value = null; },
        onFinish:  () => { deleting.value = false; },
    });
};

const goToPage = (url) => { if (url) router.visit(url, { preserveState: true }); };
</script>

<template>
    <Head title="Courses — Admin" />

    <div class="mx-auto max-w-6xl space-y-5">

        <!-- Page header -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <div class="mb-1 inline-flex items-center gap-2 rounded-full px-3 py-1"
                    style="background: rgba(34,211,238,0.06); border: 1px solid rgba(34,211,238,0.12);">
                    <span class="h-1 w-1 rounded-full bg-emerald-400"></span>
                    <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-cyan-300/70">§ CMS</span>
                </div>
                <h1 class="font-display text-2xl font-semibold tracking-tight text-white sm:text-3xl">Courses</h1>
            </div>
            <a href="/admin/courses/create"
                class="inline-flex items-center gap-2 rounded-full px-4 py-2 font-mono text-[10px] font-semibold uppercase tracking-[0.12em] text-ink-900 transition hover:opacity-90"
                style="background: white; box-shadow: 0 8px 24px -6px rgba(34,211,238,0.25);">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Add course
            </a>
        </div>

        <!-- Stats -->
        <div class="flex items-center gap-2 flex-wrap">
            <div class="flex items-center gap-2 rounded-full px-3 py-1.5"
                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07);">
                <span class="font-mono text-[10px] uppercase tracking-wider text-white/35">Total</span>
                <span class="font-mono text-sm font-semibold text-white">{{ stats.total }}</span>
            </div>
            <div class="flex items-center gap-2 rounded-full px-3 py-1.5"
                style="background: rgba(52,211,153,0.06); border: 1px solid rgba(52,211,153,0.12);">
                <span class="h-1 w-1 rounded-full bg-emerald-400"></span>
                <span class="font-mono text-[10px] uppercase tracking-wider text-emerald-400/60">Live</span>
                <span class="font-mono text-sm font-semibold text-emerald-300">{{ stats.available }}</span>
            </div>
            <div class="flex items-center gap-2 rounded-full px-3 py-1.5"
                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07);">
                <span class="font-mono text-[10px] uppercase tracking-wider text-white/35">Drafts</span>
                <span class="font-mono text-sm font-semibold text-white">{{ stats.drafts }}</span>
            </div>
        </div>

        <!-- Filters row -->
        <div class="flex gap-3 flex-wrap">
            <div class="relative flex-1 min-w-[200px]">
                <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-white/30"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input v-model="search" type="text" placeholder="Search by title or code…"
                    class="w-full rounded-xl py-3 pl-11 pr-4 font-sans text-sm text-white placeholder:text-white/25 outline-none transition"
                    style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);"
                    @focus="$event.target.style.boxShadow = '0 0 0 2px rgba(34,211,238,0.15)'"
                    @blur="$event.target.style.boxShadow = 'none'" />
                <button v-if="search" @click="search = ''"
                    class="absolute right-3 top-1/2 flex h-6 w-6 -translate-y-1/2 items-center justify-center rounded-full hover:bg-white/10"
                    style="color: rgba(255,255,255,0.35);">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>

            <select v-model="categoryId"
                class="rounded-xl px-4 py-3 font-mono text-[11px] text-white outline-none transition"
                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                <option value="">All categories</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                    {{ cat.parent_id ? '  ↳ ' : '' }}{{ cat.name }}
                </option>
            </select>
        </div>

        <!-- Table -->
        <CoursesTable :courses="courses" @delete="requestDelete" />

        <!-- Pagination -->
        <div v-if="courses.last_page > 1" class="flex items-center justify-between">
            <p class="font-mono text-[10px] text-white/30">{{ courses.from }}–{{ courses.to }} of {{ courses.total }}</p>
            <div class="flex items-center gap-1.5">
                <button v-for="link in courses.links" :key="link.label"
                    @click="goToPage(link.url)"
                    :disabled="!link.url || link.active"
                    class="flex min-w-[32px] items-center justify-center rounded-lg px-2.5 py-1.5 font-mono text-[10px] transition disabled:cursor-not-allowed"
                    :style="link.active
                        ? 'background: rgba(34,211,238,0.1); border: 1px solid rgba(34,211,238,0.2); color: #22d3ee;'
                        : link.url
                            ? 'background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07); color: rgba(255,255,255,0.45);'
                            : 'opacity: 0.3; border: 1px solid rgba(255,255,255,0.05); color: rgba(255,255,255,0.2);'"
                    v-html="link.label"
                ></button>
            </div>
        </div>
    </div>

    <DeleteConfirmModal
        :subject="toDelete?.title ?? null"
        label="course"
        :processing="deleting"
        @confirm="confirmDelete"
        @cancel="cancelDelete"
    />
</template>
