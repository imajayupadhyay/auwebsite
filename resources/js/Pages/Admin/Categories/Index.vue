<script setup>
import { ref, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import CategoryTree from './components/CategoryTree.vue';
import CategoryFormModal from './components/CategoryFormModal.vue';
import DeleteConfirmModal from './components/DeleteConfirmModal.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    tree:    { type: Array,  required: true },
    flat:    { type: Array,  required: true },
    filters: { type: Object, default: () => ({}) },
    stats:   { type: Object, default: () => ({}) },
});

// Search
const search = ref(props.filters.search ?? '');
let searchTimer = null;
watch(search, (val) => {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
        router.get('/admin/categories', { search: val }, { preserveState: true, replace: true });
    }, 350);
});

// Form modal
const formTarget = ref(undefined); // undefined=hidden, null=create, object=edit
const openCreate = () => { formTarget.value = null; };
const openEdit   = (cat) => { formTarget.value = cat; };
const closeForm  = () => { formTarget.value = undefined; };

// Delete modal
const toDelete  = ref(null);
const deleting  = ref(false);

const requestDelete = (cat) => { toDelete.value = cat; };
const cancelDelete  = () => { toDelete.value = null; };

const confirmDelete = () => {
    if (!toDelete.value) return;
    deleting.value = true;
    router.delete(`/admin/categories/${toDelete.value.id}`, {
        preserveScroll: true,
        onSuccess: () => { toDelete.value = null; },
        onFinish:  () => { deleting.value = false; },
    });
};
</script>

<template>
    <Head title="Categories — Admin" />

    <div class="mx-auto max-w-4xl space-y-5">

        <!-- Page header -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <div class="mb-1 inline-flex items-center gap-2 rounded-full px-3 py-1"
                    style="background: rgba(34,211,238,0.06); border: 1px solid rgba(34,211,238,0.12);">
                    <span class="h-1 w-1 rounded-full bg-emerald-400"></span>
                    <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-cyan-300/70">§ CMS</span>
                </div>
                <h1 class="font-display text-2xl font-semibold tracking-tight text-white sm:text-3xl">Categories</h1>
            </div>
            <button @click="openCreate"
                class="inline-flex items-center gap-2 rounded-full px-4 py-2 font-mono text-[10px] font-semibold uppercase tracking-[0.12em] text-ink-900 transition hover:opacity-90"
                style="background: white; box-shadow: 0 8px 24px -6px rgba(34,211,238,0.25);">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Add category
            </button>
        </div>

        <!-- Stats -->
        <div class="flex items-center gap-2">
            <div class="flex items-center gap-2 rounded-full px-3 py-1.5"
                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07);">
                <span class="font-mono text-[10px] uppercase tracking-wider text-white/35">Total</span>
                <span class="font-mono text-sm font-semibold text-white">{{ stats.total }}</span>
            </div>
            <div class="flex items-center gap-2 rounded-full px-3 py-1.5"
                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07);">
                <span class="font-mono text-[10px] uppercase tracking-wider text-white/35">Top-level</span>
                <span class="font-mono text-sm font-semibold text-white">{{ stats.parents }}</span>
            </div>
        </div>

        <!-- Search -->
        <div class="relative">
            <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-white/30"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input v-model="search" type="text" placeholder="Search categories…"
                class="w-full rounded-xl py-3 pl-11 pr-4 font-sans text-sm text-white placeholder:text-white/25 outline-none transition"
                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);"
                @focus="$event.target.style.boxShadow = '0 0 0 2px rgba(34,211,238,0.15)'"
                @blur="$event.target.style.boxShadow = 'none'" />
            <button v-if="search" @click="search = ''"
                class="absolute right-3 top-1/2 flex h-6 w-6 -translate-y-1/2 items-center justify-center rounded-full transition hover:bg-white/10"
                style="color: rgba(255,255,255,0.35);">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <!-- Tree -->
        <div class="rounded-2xl p-4" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.07);">
            <div v-if="!tree.length" class="flex flex-col items-center justify-center py-12">
                <svg class="mb-3 h-8 w-8 text-white/15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                </svg>
                <p class="font-mono text-[11px] uppercase tracking-[0.2em] text-white/25">No categories yet</p>
            </div>
            <CategoryTree v-else :nodes="tree" @edit="openEdit" @delete="requestDelete" />
        </div>
    </div>

    <!-- Modals -->
    <CategoryFormModal
        v-if="formTarget !== undefined"
        :category="formTarget"
        :flat="flat"
        @close="closeForm"
    />

    <DeleteConfirmModal
        :subject="toDelete?.name ?? null"
        label="category"
        :processing="deleting"
        @confirm="confirmDelete"
        @cancel="cancelDelete"
    />
</template>
