<script setup>
defineProps({
    item:       { type: Object,  default: undefined },
    processing: { type: Boolean, default: false },
});

const emit = defineEmits(['confirm', 'cancel']);
</script>

<template>
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
                v-if="item !== undefined"
                class="fixed inset-0 z-[60] flex items-center justify-center p-4"
                style="background: rgba(5,7,13,0.75); backdrop-filter: blur(6px);"
                @click.self="emit('cancel')"
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
                    <h3 class="font-display text-lg font-semibold text-white">Delete inquiry?</h3>
                    <p class="mt-2 text-sm text-white/55">
                        Permanently delete the inquiry from <strong class="text-white/80">{{ item?.name }}</strong>. This cannot be undone.
                    </p>
                    <div class="mt-6 flex gap-3">
                        <button
                            type="button"
                            @click="emit('cancel')"
                            class="flex-1 rounded-xl py-2.5 font-mono text-[11px] font-semibold uppercase tracking-[0.12em] text-white/60 transition hover:bg-white/6"
                            style="border: 1px solid rgba(255,255,255,0.08);"
                        >Cancel</button>
                        <button
                            type="button"
                            @click="emit('confirm')"
                            :disabled="processing"
                            class="flex-1 rounded-xl py-2.5 font-mono text-[11px] font-semibold uppercase tracking-[0.12em] text-white transition disabled:opacity-60"
                            style="background: rgba(239,68,68,0.9); border: 1px solid rgba(239,68,68,0.4);"
                        >{{ processing ? 'Deleting...' : 'Delete' }}</button>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
