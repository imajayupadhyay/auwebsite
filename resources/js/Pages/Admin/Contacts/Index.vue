<script setup>
import { ref, watch } from 'vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ContactsTable from './components/ContactsTable.vue';
import ContactDetailModal from './components/ContactDetailModal.vue';
import DeleteConfirmModal from './components/DeleteConfirmModal.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    contacts: { type: Object, required: true },
    filters:  { type: Object, default: () => ({}) },
    stats:    { type: Object, default: () => ({ total: 0, unread: 0 }) },
});

// Search
const search = ref(props.filters.search ?? '');
let searchTimer = null;
watch(search, (val) => {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
        router.get('/admin/contacts', { search: val }, { preserveState: true, replace: true });
    }, 350);
});

// Detail modal
const viewing = ref(null);
const openDetail = (contact) => { viewing.value = contact; };
const closeDetail = () => { viewing.value = null; };

// Delete modal
const toDelete = ref(null);
const deleting = ref(false);

const requestDelete = (contact) => { toDelete.value = contact; };
const cancelDelete  = () => { toDelete.value = null; };

const confirmDelete = () => {
    if (!toDelete.value) return;
    deleting.value = true;
    router.delete(`/admin/contacts/${toDelete.value.id}`, {
        preserveScroll: true,
        onSuccess: () => { toDelete.value = null; },
        onFinish:  () => { deleting.value = false; },
    });
};

// Toggle read
const toggleRead = (contact) => {
    router.patch(`/admin/contacts/${contact.id}/toggle-read`, {}, { preserveScroll: true });
};

// Pagination
const goToPage = (url) => {
    if (url) router.visit(url, { preserveState: true });
};
</script>

<template>
    <Head title="Contacts — Admin" />

    <div class="mx-auto max-w-6xl space-y-5">

        <!-- Page header -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <div class="mb-1 inline-flex items-center gap-2 rounded-full px-3 py-1"
                    style="background: rgba(34,211,238,0.06); border: 1px solid rgba(34,211,238,0.12);">
                    <span class="h-1 w-1 rounded-full bg-emerald-400"></span>
                    <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-cyan-300/70">§ Inbox</span>
                </div>
                <h1 class="font-display text-2xl font-semibold tracking-tight text-white sm:text-3xl">Contacts</h1>
            </div>

            <!-- Stats chips -->
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-2 rounded-full px-3 py-1.5"
                    style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07);">
                    <span class="font-mono text-[10px] text-white/35 uppercase tracking-wider">Total</span>
                    <span class="font-mono text-sm font-semibold text-white">{{ stats.total }}</span>
                </div>
                <div class="flex items-center gap-2 rounded-full px-3 py-1.5"
                    :style="stats.unread > 0
                        ? 'background: rgba(34,211,238,0.07); border: 1px solid rgba(34,211,238,0.18);'
                        : 'background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07);'">
                    <span
                        class="h-1.5 w-1.5 rounded-full"
                        :style="stats.unread > 0
                            ? 'background: #22d3ee; box-shadow: 0 0 5px rgba(34,211,238,0.6);'
                            : 'background: rgba(255,255,255,0.2);'"
                    ></span>
                    <span class="font-mono text-[10px] uppercase tracking-wider"
                        :style="stats.unread > 0 ? 'color: #22d3ee;' : 'color: rgba(255,255,255,0.35);'">
                        Unread
                    </span>
                    <span class="font-mono text-sm font-semibold"
                        :style="stats.unread > 0 ? 'color: #22d3ee;' : 'color: rgba(255,255,255,0.6);'">
                        {{ stats.unread }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Search bar -->
        <div class="relative">
            <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-white/30"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input
                v-model="search"
                type="text"
                placeholder="Search by name or email…"
                class="w-full rounded-xl py-3 pl-11 pr-4 font-sans text-sm text-white placeholder:text-white/25 outline-none transition"
                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
                       focus:box-shadow: 0 0 0 2px rgba(34,211,238,0.2);"
                @focus="$event.target.style.boxShadow = '0 0 0 2px rgba(34,211,238,0.15)'"
                @blur="$event.target.style.boxShadow = 'none'"
            />
            <button
                v-if="search"
                @click="search = ''"
                class="absolute right-3 top-1/2 flex h-6 w-6 -translate-y-1/2 items-center justify-center rounded-full transition hover:bg-white/10"
                style="color: rgba(255,255,255,0.35);"
            >
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <!-- Table -->
        <ContactsTable
            :contacts="contacts"
            @view="openDetail"
            @delete="requestDelete"
            @toggle-read="toggleRead"
        />

        <!-- Pagination -->
        <div v-if="contacts.last_page > 1" class="flex items-center justify-between">
            <p class="font-mono text-[10px] text-white/30">
                {{ contacts.from }}–{{ contacts.to }} of {{ contacts.total }}
            </p>
            <div class="flex items-center gap-1.5">
                <button
                    v-for="link in contacts.links"
                    :key="link.label"
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

    <!-- Modals -->
    <ContactDetailModal
        :contact="viewing"
        @close="closeDetail"
        @delete="requestDelete"
    />

    <DeleteConfirmModal
        :contact="toDelete"
        :processing="deleting"
        @confirm="confirmDelete"
        @cancel="cancelDelete"
    />
</template>
