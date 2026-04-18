<script setup>
import { ref, watch } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InquiryDetailModal from './components/InquiryDetailModal.vue';
import DeleteConfirmModal from './components/DeleteConfirmModal.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    inquiries: Object,
    filters:   Object,
    stats:     Object,
});

const search = ref(props.filters?.search ?? '');

let searchTimer = null;
watch(search, (val) => {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
        router.get('/admin/inquiries', { search: val }, { preserveState: true, replace: true });
    }, 350);
});

const detailItem   = ref(undefined);
const deleteTarget = ref(undefined);

const openDetail = (item) => { detailItem.value = item; };
const closeDetail = () => { detailItem.value = undefined; };

const confirmDelete = (item) => { deleteTarget.value = item; };
const cancelDelete  = () => { deleteTarget.value = undefined; };

const toggleRead = (item) => {
    router.patch(`/admin/inquiries/${item.id}/toggle-read`, {}, { preserveScroll: true });
};

const deleteForm = useForm({});
const doDelete = () => {
    if (!deleteTarget.value) return;
    deleteForm.delete(`/admin/inquiries/${deleteTarget.value.id}`, {
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
                <h1 class="font-display text-2xl font-semibold text-white sm:text-3xl">Service Inquiries</h1>
                <p class="mt-1 font-mono text-[11px] text-white/40">Project briefs submitted via the services page</p>
            </div>
            <div class="flex gap-3">
                <div class="rounded-xl px-4 py-2.5 text-center" style="background: rgba(34,211,238,0.06); border: 1px solid rgba(34,211,238,0.12);">
                    <p class="font-mono text-lg font-bold text-cyan-300">{{ stats.total }}</p>
                    <p class="font-mono text-[9px] uppercase tracking-[0.15em] text-white/40">Total</p>
                </div>
                <div class="rounded-xl px-4 py-2.5 text-center" style="background: rgba(251,113,133,0.06); border: 1px solid rgba(251,113,133,0.12);">
                    <p class="font-mono text-lg font-bold text-rose-400">{{ stats.unread }}</p>
                    <p class="font-mono text-[9px] uppercase tracking-[0.15em] text-white/40">Unread</p>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="mb-5 max-w-sm">
            <input
                v-model="search"
                type="search"
                placeholder="Search name, email, service..."
                class="w-full rounded-xl px-4 py-2.5 font-sans text-sm text-white placeholder:text-white/30 outline-none transition"
                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);"
            />
        </div>

        <!-- Table -->
        <div class="rounded-2xl overflow-hidden" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07);">
            <table class="w-full text-sm">
                <thead>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                        <th class="px-5 py-3.5 text-left font-mono text-[10px] uppercase tracking-[0.14em] text-white/35">Name</th>
                        <th class="hidden px-5 py-3.5 text-left font-mono text-[10px] uppercase tracking-[0.14em] text-white/35 sm:table-cell">Service</th>
                        <th class="hidden px-5 py-3.5 text-left font-mono text-[10px] uppercase tracking-[0.14em] text-white/35 lg:table-cell">Budget</th>
                        <th class="hidden px-5 py-3.5 text-left font-mono text-[10px] uppercase tracking-[0.14em] text-white/35 lg:table-cell">Date</th>
                        <th class="px-5 py-3.5 text-left font-mono text-[10px] uppercase tracking-[0.14em] text-white/35">Status</th>
                        <th class="px-5 py-3.5"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-if="inquiries.data.length === 0"
                    >
                        <td colspan="6" class="px-5 py-10 text-center font-mono text-[11px] text-white/30">No inquiries found.</td>
                    </tr>
                    <tr
                        v-for="item in inquiries.data"
                        :key="item.id"
                        class="cursor-pointer transition hover:bg-white/[0.02]"
                        :class="!item.is_read ? 'bg-cyan-400/[0.015]' : ''"
                        style="border-bottom: 1px solid rgba(255,255,255,0.04);"
                        @click="openDetail(item)"
                    >
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2.5">
                                <span v-if="!item.is_read" class="h-1.5 w-1.5 flex-shrink-0 rounded-full bg-cyan-400 shadow-[0_0_6px_rgba(34,211,238,0.7)]"></span>
                                <span v-else class="h-1.5 w-1.5 flex-shrink-0"></span>
                                <div>
                                    <p class="font-medium text-white/90">{{ item.name }}</p>
                                    <p class="font-mono text-[10px] text-white/40">{{ item.email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="hidden px-5 py-4 text-white/60 sm:table-cell">{{ item.service }}</td>
                        <td class="hidden px-5 py-4 lg:table-cell">
                            <span v-if="item.budget" class="rounded-full px-2.5 py-1 font-mono text-[10px] text-white/70" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">{{ item.budget }}</span>
                            <span v-else class="text-white/25">—</span>
                        </td>
                        <td class="hidden px-5 py-4 font-mono text-[11px] text-white/40 lg:table-cell">{{ formatDate(item.created_at) }}</td>
                        <td class="px-5 py-4">
                            <span
                                class="rounded-full px-2.5 py-1 font-mono text-[10px]"
                                :class="item.is_read
                                    ? 'text-white/40'
                                    : 'text-cyan-300'"
                                :style="item.is_read
                                    ? 'background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);'
                                    : 'background: rgba(34,211,238,0.08); border: 1px solid rgba(34,211,238,0.18);'"
                            >{{ item.is_read ? 'Read' : 'New' }}</span>
                        </td>
                        <td class="px-5 py-4" @click.stop>
                            <div class="flex items-center gap-1 justify-end">
                                <button
                                    type="button"
                                    @click="toggleRead(item)"
                                    class="flex h-7 w-7 items-center justify-center rounded-lg text-white/40 transition hover:bg-white/8 hover:text-white/70"
                                    :title="item.is_read ? 'Mark unread' : 'Mark read'"
                                >
                                    <svg v-if="item.is_read" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <svg v-else width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>
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
        <div v-if="inquiries.links?.length > 3" class="mt-5 flex flex-wrap gap-1.5">
            <component
                :is="link.url ? 'a' : 'span'"
                v-for="(link, i) in inquiries.links"
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

        <!-- Detail modal -->
        <InquiryDetailModal
            :item="detailItem"
            @close="closeDetail"
            @toggle-read="toggleRead"
            @delete="confirmDelete"
        />

        <!-- Delete confirm -->
        <DeleteConfirmModal
            :item="deleteTarget"
            :processing="deleteForm.processing"
            @confirm="doDelete"
            @cancel="cancelDelete"
        />
    </div>
</template>
