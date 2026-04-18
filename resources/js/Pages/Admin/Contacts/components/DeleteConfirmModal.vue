<script setup>
defineProps({
    contact: { type: Object, default: null },
    processing: { type: Boolean, default: false },
});

const emit = defineEmits(['confirm', 'cancel']);
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition duration-150 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-100 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="contact"
                class="fixed inset-0 z-[60] flex items-center justify-center p-4"
                style="background: rgba(5,7,13,0.85); backdrop-filter: blur(10px);"
                @click.self="emit('cancel')"
            >
                <Transition
                    enter-active-class="transition duration-150 ease-out"
                    enter-from-class="opacity-0 scale-95"
                    enter-to-class="opacity-100 scale-100"
                    leave-active-class="transition duration-100 ease-in"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-95"
                >
                    <div
                        v-if="contact"
                        class="relative w-full max-w-sm rounded-2xl p-7 text-center"
                        style="background: linear-gradient(135deg, rgba(255,255,255,0.07) 0%, rgba(255,255,255,0.02) 100%);
                               backdrop-filter: blur(24px);
                               border: 1px solid rgba(251,113,133,0.15);
                               box-shadow: 0 40px 80px -20px rgba(5,7,13,0.9);"
                    >
                        <!-- Rose glow top -->
                        <div class="pointer-events-none absolute inset-0 rounded-2xl"
                            style="background: radial-gradient(ellipse at 50% 0%, rgba(251,113,133,0.06) 0%, transparent 60%);"></div>

                        <!-- Icon -->
                        <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full"
                            style="background: rgba(251,113,133,0.08); border: 1px solid rgba(251,113,133,0.2);">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="rgba(251,113,133,0.8)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                <path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                            </svg>
                        </div>

                        <h3 class="font-display text-lg font-semibold text-white">Delete message?</h3>
                        <p class="mx-auto mt-2 max-w-[28ch] text-sm leading-relaxed text-white/45">
                            Message from <span class="text-white/70">{{ contact.name }}</span> will be permanently removed.
                        </p>

                        <div class="my-5 h-px" style="background: linear-gradient(90deg, transparent, rgba(255,255,255,0.06), transparent);"></div>

                        <div class="flex gap-2">
                            <button
                                @click="emit('cancel')"
                                class="flex-1 rounded-xl py-2.5 font-mono text-[10px] uppercase tracking-[0.12em] text-white/50 transition hover:text-white/70"
                                style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);"
                            >
                                Cancel
                            </button>
                            <button
                                @click="emit('confirm')"
                                :disabled="processing"
                                class="flex-1 rounded-xl py-2.5 font-mono text-[10px] uppercase tracking-[0.12em] transition disabled:opacity-60"
                                style="background: rgba(251,113,133,0.12); border: 1px solid rgba(251,113,133,0.25); color: rgba(251,113,133,0.9);"
                            >
                                {{ processing ? 'Deleting…' : 'Delete' }}
                            </button>
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
