<script setup>
import { router } from '@inertiajs/vue3';

const props = defineProps({
    contact: { type: Object, default: null },
});

const emit = defineEmits(['close', 'delete']);

const formatDate = (iso) =>
    new Date(iso).toLocaleDateString('en-US', {
        weekday: 'long', month: 'long', day: 'numeric', year: 'numeric',
        hour: '2-digit', minute: '2-digit',
    });

const markRead = () => {
    router.patch(`/admin/contacts/${props.contact.id}/toggle-read`, {}, { preserveScroll: true });
};
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="contact"
                class="fixed inset-0 z-50 flex items-center justify-center p-4"
                style="background: rgba(5,7,13,0.8); backdrop-filter: blur(8px);"
                @click.self="emit('close')"
            >
                <Transition
                    enter-active-class="transition duration-200 ease-out"
                    enter-from-class="opacity-0 scale-95 translate-y-2"
                    enter-to-class="opacity-100 scale-100 translate-y-0"
                    leave-active-class="transition duration-150 ease-in"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-95"
                >
                    <div
                        v-if="contact"
                        class="relative w-full max-w-lg rounded-2xl p-7"
                        style="background: linear-gradient(135deg, rgba(255,255,255,0.07) 0%, rgba(255,255,255,0.02) 100%);
                               backdrop-filter: blur(24px);
                               border: 1px solid rgba(255,255,255,0.1);
                               box-shadow: 0 40px 80px -20px rgba(5,7,13,0.9), 0 0 0 1px rgba(34,211,238,0.07);"
                    >
                        <!-- Top accent -->
                        <div class="pointer-events-none absolute inset-0 rounded-2xl"
                            style="background: radial-gradient(ellipse at 50% 0%, rgba(34,211,238,0.06) 0%, transparent 60%);"></div>

                        <!-- Header -->
                        <div class="mb-5 flex items-start justify-between gap-4">
                            <div>
                                <div class="mb-1.5 inline-flex items-center gap-2 rounded-full px-2.5 py-1"
                                    style="background: rgba(34,211,238,0.07); border: 1px solid rgba(34,211,238,0.15);">
                                    <span
                                        class="h-1.5 w-1.5 rounded-full"
                                        :style="contact.is_read
                                            ? 'background: rgba(255,255,255,0.2);'
                                            : 'background: #22d3ee; box-shadow: 0 0 5px rgba(34,211,238,0.7);'"
                                    ></span>
                                    <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-cyan-300/70">
                                        {{ contact.is_read ? 'Read' : 'Unread' }}
                                    </span>
                                </div>
                                <h2 class="font-display text-xl font-semibold text-white">{{ contact.name }}</h2>
                                <p class="font-mono text-[11px] text-white/40">{{ contact.email }}</p>
                            </div>
                            <button
                                @click="emit('close')"
                                class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full transition hover:bg-white/10"
                                style="border: 1px solid rgba(255,255,255,0.08); color: rgba(255,255,255,0.4);"
                            >
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Divider -->
                        <div class="mb-5 h-px" style="background: linear-gradient(90deg, rgba(34,211,238,0.15), rgba(255,255,255,0.05), transparent);"></div>

                        <!-- Meta grid -->
                        <div class="mb-4 grid grid-cols-2 gap-3">
                            <div class="rounded-xl px-3 py-2.5" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                                <p class="mb-0.5 font-mono text-[9px] uppercase tracking-[0.18em] text-white/30">Email</p>
                                <p class="truncate font-mono text-xs text-white/70">{{ contact.email }}</p>
                            </div>
                            <div class="rounded-xl px-3 py-2.5" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                                <p class="mb-0.5 font-mono text-[9px] uppercase tracking-[0.18em] text-white/30">Phone</p>
                                <p class="font-mono text-xs text-white/70">{{ contact.phone || '—' }}</p>
                            </div>
                            <div class="col-span-2 rounded-xl px-3 py-2.5" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                                <p class="mb-0.5 font-mono text-[9px] uppercase tracking-[0.18em] text-white/30">Received</p>
                                <p class="font-mono text-xs text-white/70">{{ formatDate(contact.created_at) }}</p>
                            </div>
                        </div>

                        <!-- Message -->
                        <div class="mb-5 rounded-xl px-4 py-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                            <p class="mb-2 font-mono text-[9px] uppercase tracking-[0.18em] text-white/30">Message</p>
                            <p class="text-sm leading-relaxed text-white/75 whitespace-pre-wrap">{{ contact.message }}</p>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-2">
                            <button
                                @click="markRead"
                                class="flex flex-1 items-center justify-center gap-2 rounded-xl py-2.5 font-mono text-[10px] uppercase tracking-[0.12em] transition"
                                :style="contact.is_read
                                    ? 'background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); color: rgba(255,255,255,0.45);'
                                    : 'background: rgba(34,211,238,0.08); border: 1px solid rgba(34,211,238,0.2); color: #22d3ee;'"
                            >
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 6L9 17l-5-5"/>
                                </svg>
                                {{ contact.is_read ? 'Mark unread' : 'Mark read' }}
                            </button>
                            <button
                                @click="emit('delete', contact); emit('close')"
                                class="flex flex-1 items-center justify-center gap-2 rounded-xl py-2.5 font-mono text-[10px] uppercase tracking-[0.12em] transition"
                                style="background: rgba(251,113,133,0.07); border: 1px solid rgba(251,113,133,0.2); color: rgba(251,113,133,0.8);"
                            >
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                </svg>
                                Delete
                            </button>
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
