<script setup>
defineProps({
    item: { type: Object, default: undefined },
});

const emit = defineEmits(['close', 'toggle-read', 'delete']);

const formatDate = (d) => new Date(d).toLocaleString('en-IN', {
    day: 'numeric', month: 'short', year: 'numeric',
    hour: '2-digit', minute: '2-digit',
});
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition-opacity duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="item !== undefined"
                class="fixed inset-0 z-50 flex items-center justify-center p-4"
                style="background: rgba(5,7,13,0.8); backdrop-filter: blur(8px);"
                @click.self="emit('close')"
            >
                <Transition
                    enter-active-class="transition duration-200 ease-out"
                    enter-from-class="opacity-0 scale-[0.97]"
                    enter-to-class="opacity-100 scale-100"
                    leave-active-class="transition duration-150 ease-in"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-[0.97]"
                >
                    <div
                        v-if="item !== undefined"
                        class="relative w-full max-w-lg max-h-[90vh] overflow-y-auto rounded-2xl"
                        style="background: #0a0e1a; border: 1px solid rgba(255,255,255,0.09); box-shadow: 0 40px 80px -20px rgba(0,0,0,0.9);"
                        @click.stop
                    >
                        <!-- Header -->
                        <div class="sticky top-0 flex items-center justify-between gap-4 px-6 py-4" style="background: #0a0e1a; border-bottom: 1px solid rgba(255,255,255,0.06);">
                            <div>
                                <p class="font-mono text-[10px] uppercase tracking-[0.14em] text-white/35">Service Inquiry</p>
                                <p class="mt-0.5 font-medium text-white">{{ item?.name }}</p>
                            </div>
                            <button type="button" @click="emit('close')" class="flex h-8 w-8 items-center justify-center rounded-full text-white/40 transition hover:bg-white/8 hover:text-white">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg>
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="p-6 space-y-5">
                            <!-- Meta grid -->
                            <div class="grid grid-cols-2 gap-3">
                                <div class="rounded-xl p-3.5" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                                    <p class="font-mono text-[9px] uppercase tracking-[0.14em] text-white/35">Email</p>
                                    <p class="mt-1 break-all text-sm text-white/80">{{ item?.email }}</p>
                                </div>
                                <div class="rounded-xl p-3.5" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                                    <p class="font-mono text-[9px] uppercase tracking-[0.14em] text-white/35">Phone</p>
                                    <p class="mt-1 text-sm text-white/80">{{ item?.phone || '—' }}</p>
                                </div>
                                <div class="rounded-xl p-3.5" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                                    <p class="font-mono text-[9px] uppercase tracking-[0.14em] text-white/35">Company</p>
                                    <p class="mt-1 text-sm text-white/80">{{ item?.company || '—' }}</p>
                                </div>
                                <div class="rounded-xl p-3.5" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                                    <p class="font-mono text-[9px] uppercase tracking-[0.14em] text-white/35">Submitted</p>
                                    <p class="mt-1 text-sm text-white/80">{{ item ? formatDate(item.created_at) : '' }}</p>
                                </div>
                            </div>

                            <!-- Service + Budget + Timeline -->
                            <div class="flex flex-wrap gap-2">
                                <span class="rounded-full px-3 py-1.5 font-mono text-[11px] text-cyan-300" style="background: rgba(34,211,238,0.08); border: 1px solid rgba(34,211,238,0.18);">
                                    {{ item?.service }}
                                </span>
                                <span v-if="item?.budget" class="rounded-full px-3 py-1.5 font-mono text-[11px] text-white/70" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                                    {{ item.budget }}
                                </span>
                                <span v-if="item?.timeline" class="rounded-full px-3 py-1.5 font-mono text-[11px] text-teal-300" style="background: rgba(45,212,191,0.08); border: 1px solid rgba(45,212,191,0.18);">
                                    {{ item.timeline }}
                                </span>
                            </div>

                            <!-- Details -->
                            <div>
                                <p class="mb-2 font-mono text-[10px] uppercase tracking-[0.14em] text-white/35">Project Details</p>
                                <div class="whitespace-pre-wrap rounded-xl p-4 text-sm leading-relaxed text-white/75" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">{{ item?.details }}</div>
                            </div>
                        </div>

                        <!-- Footer actions -->
                        <div class="sticky bottom-0 flex items-center justify-between gap-3 px-6 py-4" style="background: #0a0e1a; border-top: 1px solid rgba(255,255,255,0.06);">
                            <button
                                type="button"
                                @click="emit('toggle-read', item)"
                                class="flex items-center gap-2 rounded-lg px-3 py-2 font-mono text-[10px] font-semibold uppercase tracking-[0.12em] text-white/50 transition hover:bg-white/6 hover:text-white/80"
                            >
                                {{ item?.is_read ? 'Mark as Unread' : 'Mark as Read' }}
                            </button>
                            <button
                                type="button"
                                @click="emit('delete', item)"
                                class="flex items-center gap-2 rounded-lg px-3 py-2 font-mono text-[10px] font-semibold uppercase tracking-[0.12em] text-rose-400 transition hover:bg-rose-500/10"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
