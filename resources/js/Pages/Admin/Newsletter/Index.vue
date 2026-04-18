<script setup>
import { ref, watch } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    subscribers: Object,
    filters:     Object,
    stats:       Object,
});

const search = ref(props.filters?.search ?? '');

let searchTimer = null;
watch(search, (val) => {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
        router.get('/admin/newsletter', { search: val }, { preserveState: true, replace: true });
    }, 350);
});

const deleteTarget = ref(undefined);
const confirmDelete = (item) => { deleteTarget.value = item; };
const cancelDelete  = () => { deleteTarget.value = undefined; };

const toggleActive = (item) => {
    router.patch(`/admin/newsletter/${item.id}/toggle-active`, {}, { preserveScroll: true });
};

const deleteForm = useForm({});
const doDelete = () => {
    if (!deleteTarget.value) return;
    deleteForm.delete(`/admin/newsletter/${deleteTarget.value.id}`, {
        preserveScroll: true,
        onSuccess: () => { deleteTarget.value = undefined; },
    });
};

const formatDate = (d) => new Date(d).toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' });
</script>

<template>
    <div>
        <!-- Page header -->
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="font-display text-2xl font-semibold text-white sm:text-3xl">Newsletter</h1>
                <p class="mt-1 font-mono text-[11px] text-white/40">Subscribers collected from the footer form</p>
            </div>
            <div class="flex gap-3">
                <div class="rounded-xl px-4 py-2.5 text-center" style="background: rgba(34,211,238,0.06); border: 1px solid rgba(34,211,238,0.12);">
                    <p class="font-mono text-lg font-bold text-cyan-300">{{ stats.total }}</p>
                    <p class="font-mono text-[9px] uppercase tracking-[0.15em] text-white/40">Total</p>
                </div>
                <div class="rounded-xl px-4 py-2.5 text-center" style="background: rgba(52,211,153,0.06); border: 1px solid rgba(52,211,153,0.12);">
                    <p class="font-mono text-lg font-bold text-emerald-400">{{ stats.active }}</p>
                    <p class="font-mono text-[9px] uppercase tracking-[0.15em] text-white/40">Active</p>
                </div>
                <div class="rounded-xl px-4 py-2.5 text-center" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08);">
                    <p class="font-mono text-lg font-bold text-white/40">{{ stats.inactive }}</p>
                    <p class="font-mono text-[9px] uppercase tracking-[0.15em] text-white/40">Inactive</p>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="mb-5 max-w-sm">
            <input
                v-model="search"
                type="search"
                placeholder="Search email..."
                class="w-full rounded-xl px-4 py-2.5 font-sans text-sm text-white placeholder:text-white/30 outline-none transition"
                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);"
            />
        </div>

        <!-- Table -->
        <div class="rounded-2xl overflow-hidden" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07);">
            <table class="w-full text-sm">
                <thead>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                        <th class="px-5 py-3.5 text-left font-mono text-[10px] uppercase tracking-[0.14em] text-white/35">Email</th>
                        <th class="hidden px-5 py-3.5 text-left font-mono text-[10px] uppercase tracking-[0.14em] text-white/35 sm:table-cell">Status</th>
                        <th class="hidden px-5 py-3.5 text-left font-mono text-[10px] uppercase tracking-[0.14em] text-white/35 lg:table-cell">Subscribed</th>
                        <th class="px-5 py-3.5"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="subscribers.data.length === 0">
                        <td colspan="4" class="px-5 py-10 text-center font-mono text-[11px] text-white/30">No subscribers yet.</td>
                    </tr>
                    <tr
                        v-for="item in subscribers.data"
                        :key="item.id"
                        class="transition"
                        style="border-bottom: 1px solid rgba(255,255,255,0.04);"
                    >
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2.5">
                                <span
                                    class="h-1.5 w-1.5 flex-shrink-0 rounded-full"
                                    :class="item.is_active ? 'bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.7)]' : 'bg-white/20'"
                                ></span>
                                <span class="font-mono text-sm text-white/80">{{ item.email }}</span>
                            </div>
                        </td>
                        <td class="hidden px-5 py-4 sm:table-cell">
                            <span
                                class="rounded-full px-2.5 py-1 font-mono text-[10px]"
                                :class="item.is_active ? 'text-emerald-400' : 'text-white/35'"
                                :style="item.is_active
                                    ? 'background: rgba(52,211,153,0.08); border: 1px solid rgba(52,211,153,0.18);'
                                    : 'background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);'"
                            >{{ item.is_active ? 'Active' : 'Inactive' }}</span>
                        </td>
                        <td class="hidden px-5 py-4 font-mono text-[11px] text-white/40 lg:table-cell">{{ formatDate(item.created_at) }}</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-1 justify-end">
                                <button
                                    type="button"
                                    @click="toggleActive(item)"
                                    class="flex h-7 w-7 items-center justify-center rounded-lg text-white/40 transition hover:bg-white/8 hover:text-white/70"
                                    :title="item.is_active ? 'Deactivate' : 'Activate'"
                                >
                                    <svg v-if="item.is_active" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                        <circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                                    </svg>
                                    <svg v-else width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                </button>
                                <button
                                    type="button"
                                    @click="confirmDelete(item)"
                                    class="flex h-7 w-7 items-center justify-center rounded-lg text-white/40 transition hover:bg-rose-500/10 hover:text-rose-400"
                                    title="Delete"
                                >
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                        <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div v-if="subscribers.links?.length > 3" class="mt-5 flex flex-wrap gap-1.5">
            <component
                :is="link.url ? 'a' : 'span'"
                v-for="(link, i) in subscribers.links"
                :key="i"
                :href="link.url ?? undefined"
                v-html="link.label"
                class="rounded-lg px-3 py-1.5 font-mono text-[11px] transition"
                :class="link.active
                    ? 'text-cyan-300'
                    : link.url
                        ? 'text-white/40 hover:text-white/70'
                        : 'cursor-default text-white/20'"
                :style="link.active ? 'background: rgba(34,211,238,0.08); border: 1px solid rgba(34,211,238,0.18);' : 'border: 1px solid transparent;'"
            />
        </div>

        <!-- Delete confirm modal -->
        <Teleport to="body">
            <Transition
                enter-active-class="transition-opacity duration-150 ease-out"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-opacity duration-100 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="deleteTarget !== undefined"
                    class="fixed inset-0 z-50 flex items-center justify-center p-4"
                    style="background: rgba(5,7,13,0.75); backdrop-filter: blur(6px);"
                    @click.self="cancelDelete"
                >
                    <div
                        class="w-full max-w-sm rounded-2xl p-7"
                        style="background: #0a0e1a; border: 1px solid rgba(251,113,133,0.15); box-shadow: 0 30px 60px -15px rgba(0,0,0,0.9);"
                        @click.stop
                    >
                        <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-xl" style="background: rgba(251,113,133,0.1); border: 1px solid rgba(251,113,133,0.2);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="text-rose-400">
                                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                            </svg>
                        </div>
                        <h3 class="font-display text-lg font-semibold text-white">Remove subscriber?</h3>
                        <p class="mt-2 text-sm text-white/55">
                            Permanently remove <strong class="font-mono text-white/80">{{ deleteTarget?.email }}</strong> from the list. This cannot be undone.
                        </p>
                        <div class="mt-6 flex gap-3">
                            <button
                                type="button"
                                @click="cancelDelete"
                                class="flex-1 rounded-xl py-2.5 font-mono text-[11px] font-semibold uppercase tracking-[0.12em] text-white/60 transition hover:bg-white/6"
                                style="border: 1px solid rgba(255,255,255,0.08);"
                            >Cancel</button>
                            <button
                                type="button"
                                @click="doDelete"
                                :disabled="deleteForm.processing"
                                class="flex-1 rounded-xl py-2.5 font-mono text-[11px] font-semibold uppercase tracking-[0.12em] text-white transition disabled:opacity-60"
                                style="background: rgba(239,68,68,0.9); border: 1px solid rgba(239,68,68,0.4);"
                            >{{ deleteForm.processing ? 'Removing...' : 'Remove' }}</button>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>
