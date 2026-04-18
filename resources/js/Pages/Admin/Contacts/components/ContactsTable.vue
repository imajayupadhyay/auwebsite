<script setup>
defineProps({
    contacts: { type: Object, required: true },
});

const emit = defineEmits(['view', 'delete', 'toggleRead']);

const formatDate = (iso) => {
    return new Date(iso).toLocaleDateString('en-US', {
        month: 'short', day: 'numeric', year: 'numeric',
    });
};

const truncate = (str, len = 60) =>
    str && str.length > len ? str.slice(0, len) + '…' : str;
</script>

<template>
    <div class="overflow-hidden rounded-2xl" style="border: 1px solid rgba(255,255,255,0.07);">
        <!-- Table header -->
        <div
            class="grid grid-cols-[24px_1fr_1fr_1fr_100px_96px] items-center gap-4 px-5 py-3"
            style="background: rgba(255,255,255,0.03); border-bottom: 1px solid rgba(255,255,255,0.06);"
        >
            <span></span>
            <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-white/30">Name</span>
            <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-white/30">Email</span>
            <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-white/30 hidden lg:block">Message</span>
            <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-white/30">Date</span>
            <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-white/30 text-right">Actions</span>
        </div>

        <!-- Empty state -->
        <div
            v-if="!contacts.data.length"
            class="flex flex-col items-center justify-center py-16"
            style="background: rgba(255,255,255,0.01);"
        >
            <svg class="mb-3 h-8 w-8 text-white/15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
            <p class="font-mono text-[11px] uppercase tracking-[0.2em] text-white/25">No messages yet</p>
        </div>

        <!-- Rows -->
        <div v-else>
            <div
                v-for="contact in contacts.data"
                :key="contact.id"
                class="group grid grid-cols-[24px_1fr_1fr_1fr_100px_96px] items-center gap-4 px-5 py-4 transition-colors"
                :style="contact.is_read
                    ? 'background: rgba(255,255,255,0.015); border-bottom: 1px solid rgba(255,255,255,0.04);'
                    : 'background: rgba(34,211,238,0.025); border-bottom: 1px solid rgba(255,255,255,0.04);'"
            >
                <!-- Read indicator -->
                <div class="flex items-center justify-center">
                    <span
                        class="h-2 w-2 rounded-full transition-all"
                        :style="contact.is_read
                            ? 'background: rgba(255,255,255,0.1);'
                            : 'background: #22d3ee; box-shadow: 0 0 6px rgba(34,211,238,0.6);'"
                    ></span>
                </div>

                <!-- Name -->
                <div>
                    <p class="truncate text-sm font-medium" :class="contact.is_read ? 'text-white/60' : 'text-white'">
                        {{ contact.name }}
                    </p>
                    <p v-if="contact.phone" class="mt-0.5 font-mono text-[10px] text-white/30">{{ contact.phone }}</p>
                </div>

                <!-- Email -->
                <p class="truncate font-mono text-xs text-white/50">{{ contact.email }}</p>

                <!-- Message preview -->
                <p class="hidden truncate text-xs text-white/40 lg:block">{{ truncate(contact.message) }}</p>

                <!-- Date -->
                <p class="font-mono text-[10px] text-white/35">{{ formatDate(contact.created_at) }}</p>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-1.5">
                    <!-- View -->
                    <button
                        @click="emit('view', contact)"
                        class="flex h-7 w-7 items-center justify-center rounded-lg transition hover:bg-white/10"
                        title="View message"
                    >
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>

                    <!-- Toggle read -->
                    <button
                        @click="emit('toggleRead', contact)"
                        class="flex h-7 w-7 items-center justify-center rounded-lg transition"
                        :style="contact.is_read
                            ? 'color: rgba(255,255,255,0.35);'
                            : 'color: #22d3ee;'"
                        :title="contact.is_read ? 'Mark unread' : 'Mark read'"
                    >
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path v-if="contact.is_read" d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/>
                            <path v-else d="M20 6L9 17l-5-5"/>
                        </svg>
                    </button>

                    <!-- Delete -->
                    <button
                        @click="emit('delete', contact)"
                        class="flex h-7 w-7 items-center justify-center rounded-lg transition hover:bg-rose-500/10"
                        title="Delete"
                    >
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="rgba(251,113,133,0.6)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                            <path d="M10 11v6"/><path d="M14 11v6"/>
                            <path d="M9 6V4h6v2"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
