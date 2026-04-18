<script setup>
import { usePage } from '@inertiajs/vue3';

defineProps({
    users: { type: Object, required: true },
});

const emit = defineEmits(['edit', 'delete']);
const page = usePage();

const isSelf = (user) => user.email === page.props.auth?.user?.email;

const initials = (name) =>
    name
        .split(' ')
        .map((n) => n[0])
        .slice(0, 2)
        .join('')
        .toUpperCase();

const formatDate = (iso) =>
    new Date(iso).toLocaleDateString('en-US', {
        month: 'short', day: 'numeric', year: 'numeric',
    });
</script>

<template>
    <div class="overflow-hidden rounded-2xl" style="border: 1px solid rgba(255,255,255,0.07);">
        <!-- Header -->
        <div
            class="grid grid-cols-[40px_1fr_1fr_120px_96px] items-center gap-4 px-5 py-3"
            style="background: rgba(255,255,255,0.03); border-bottom: 1px solid rgba(255,255,255,0.06);"
        >
            <span></span>
            <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-white/30">Name</span>
            <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-white/30">Email</span>
            <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-white/30">Joined</span>
            <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-white/30 text-right">Actions</span>
        </div>

        <!-- Empty state -->
        <div
            v-if="!users.data.length"
            class="flex flex-col items-center justify-center py-16"
            style="background: rgba(255,255,255,0.01);"
        >
            <svg class="mb-3 h-8 w-8 text-white/15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
            </svg>
            <p class="font-mono text-[11px] uppercase tracking-[0.2em] text-white/25">No admins found</p>
        </div>

        <!-- Rows -->
        <div v-else>
            <div
                v-for="user in users.data"
                :key="user.id"
                class="group grid grid-cols-[40px_1fr_1fr_120px_96px] items-center gap-4 px-5 py-4 transition-colors"
                style="background: rgba(255,255,255,0.015); border-bottom: 1px solid rgba(255,255,255,0.04);"
            >
                <!-- Avatar -->
                <div
                    class="flex h-8 w-8 items-center justify-center rounded-full flex-shrink-0"
                    :style="isSelf(user)
                        ? 'background: rgba(34,211,238,0.12); border: 1px solid rgba(34,211,238,0.25);'
                        : 'background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);'"
                >
                    <span
                        class="font-mono text-[10px] font-bold"
                        :style="isSelf(user) ? 'color: #22d3ee;' : 'color: rgba(255,255,255,0.5);'"
                    >{{ initials(user.name) }}</span>
                </div>

                <!-- Name + badge -->
                <div class="flex items-center gap-2 min-w-0">
                    <p class="truncate text-sm font-medium text-white/85">{{ user.name }}</p>
                    <span
                        v-if="isSelf(user)"
                        class="flex-shrink-0 rounded-full px-2 py-0.5 font-mono text-[9px] uppercase tracking-wider"
                        style="background: rgba(34,211,238,0.08); border: 1px solid rgba(34,211,238,0.2); color: #22d3ee;"
                    >You</span>
                </div>

                <!-- Email -->
                <p class="truncate font-mono text-xs text-white/45">{{ user.email }}</p>

                <!-- Joined -->
                <p class="font-mono text-[10px] text-white/35">{{ formatDate(user.created_at) }}</p>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-1.5">
                    <!-- Edit -->
                    <button
                        @click="emit('edit', user)"
                        class="flex h-7 w-7 items-center justify-center rounded-lg transition hover:bg-white/10"
                        title="Edit user"
                    >
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.45)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>

                    <!-- Delete (disabled for self) -->
                    <button
                        @click="!isSelf(user) && emit('delete', user)"
                        class="flex h-7 w-7 items-center justify-center rounded-lg transition"
                        :class="isSelf(user) ? 'cursor-not-allowed opacity-25' : 'hover:bg-rose-500/10'"
                        :title="isSelf(user) ? 'Cannot delete your own account' : 'Delete user'"
                        :disabled="isSelf(user)"
                    >
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                            :stroke="isSelf(user) ? 'rgba(255,255,255,0.3)' : 'rgba(251,113,133,0.6)'"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                            <path d="M10 11v6"/><path d="M14 11v6"/>
                            <path d="M9 6V4h6v2"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
