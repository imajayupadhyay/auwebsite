<script setup>
import { watch } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    lesson:   { type: Object, default: null }, // null = create
    moduleId: { type: Number, default: null },
});

const emit = defineEmits(['close']);

const form = useForm({
    title:       '',
    duration:    '',
    drive_input: '',
    is_preview:  false,
    sort_order:  0,
});

watch(
    () => props.lesson,
    (l) => {
        form.title       = l?.title         ?? '';
        form.duration    = l?.duration      ?? '';
        form.drive_input = l?.drive_file_id ?? '';
        form.is_preview  = l?.is_preview    ?? false;
        form.sort_order  = l?.sort_order    ?? 0;
        form.clearErrors();
    },
    { immediate: true },
);

const isEditing = () => !!props.lesson;

const submit = () => {
    if (isEditing()) {
        form.patch(`/admin/lessons/${props.lesson.id}`, {
            preserveScroll: true,
            onSuccess: () => emit('close'),
        });
    } else {
        form.post(`/admin/modules/${props.moduleId}/lessons`, {
            preserveScroll: true,
            onSuccess: () => { form.reset(); emit('close'); },
        });
    }
};

const inputCls = 'w-full rounded-xl px-4 py-2.5 font-sans text-sm text-white placeholder:text-white/25 outline-none transition-all';
const inputStyle = 'background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);';
const focusShadow = '0 0 0 2px rgba(34,211,238,0.18)';
</script>

<template>
    <Teleport to="body">
        <Transition enter-active-class="transition duration-200 ease-out" enter-from-class="opacity-0" enter-to-class="opacity-100"
                    leave-active-class="transition duration-150 ease-in" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="lesson !== undefined"
                class="fixed inset-0 z-50 flex items-center justify-center p-4"
                style="background: rgba(5,7,13,0.8); backdrop-filter: blur(8px);"
                @click.self="emit('close')"
            >
                <Transition enter-active-class="transition duration-200 ease-out" enter-from-class="opacity-0 scale-95 translate-y-2"
                            enter-to-class="opacity-100 scale-100 translate-y-0" leave-active-class="transition duration-150 ease-in"
                            leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                    <div class="relative w-full max-w-md rounded-2xl p-7"
                        style="background: linear-gradient(135deg, rgba(255,255,255,0.07) 0%, rgba(255,255,255,0.02) 100%);
                               backdrop-filter: blur(24px); border: 1px solid rgba(255,255,255,0.1);
                               box-shadow: 0 40px 80px -20px rgba(5,7,13,0.9), 0 0 0 1px rgba(34,211,238,0.07);">
                        <div class="pointer-events-none absolute inset-0 rounded-2xl"
                            style="background: radial-gradient(ellipse at 50% 0%, rgba(34,211,238,0.06) 0%, transparent 60%);"></div>

                        <div class="mb-5 flex items-center justify-between">
                            <h2 class="font-display text-lg font-semibold text-white">
                                {{ isEditing() ? 'Edit lesson' : 'Add lesson' }}
                            </h2>
                            <button @click="emit('close')"
                                class="flex h-8 w-8 items-center justify-center rounded-full transition hover:bg-white/10"
                                style="border: 1px solid rgba(255,255,255,0.08); color: rgba(255,255,255,0.4);">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                </svg>
                            </button>
                        </div>

                        <form @submit.prevent="submit" novalidate class="space-y-4">
                            <div>
                                <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Lesson title</label>
                                <input v-model="form.title" type="text" required placeholder="e.g. What is Cloud Computing?"
                                    :class="[inputCls, form.errors.title ? 'shadow-[0_0_0_2px_rgba(251,113,133,0.3)]' : '']"
                                    :style="inputStyle"
                                    @focus="$event.target.style.boxShadow = focusShadow"
                                    @blur="$event.target.style.boxShadow = 'none'" />
                                <p v-if="form.errors.title" class="mt-1 font-mono text-[10px] text-rose-400">{{ form.errors.title }}</p>
                            </div>

                            <div>
                                <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Duration <span class="text-white/20">(e.g. 12m)</span></label>
                                <input v-model="form.duration" type="text" placeholder="12m"
                                    :class="inputCls" :style="inputStyle"
                                    @focus="$event.target.style.boxShadow = focusShadow"
                                    @blur="$event.target.style.boxShadow = 'none'" />
                            </div>

                            <div>
                                <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">
                                    Google Drive URL or File ID
                                </label>
                                <input v-model="form.drive_input" type="text"
                                    placeholder="https://drive.google.com/file/d/… or bare file ID"
                                    :class="inputCls" :style="inputStyle"
                                    @focus="$event.target.style.boxShadow = focusShadow"
                                    @blur="$event.target.style.boxShadow = 'none'" />
                                <p class="mt-1 font-mono text-[9px] text-white/25">
                                    Make sure the file is shared as "Anyone with the link" on Google Drive.
                                </p>
                            </div>

                            <!-- Free preview toggle -->
                            <div class="flex items-center gap-3">
                                <button type="button" @click="form.is_preview = !form.is_preview"
                                    class="relative h-5 w-9 flex-shrink-0 rounded-full transition-colors"
                                    :style="form.is_preview
                                        ? 'background: rgba(34,211,238,0.25); border: 1px solid rgba(34,211,238,0.4);'
                                        : 'background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);'"
                                >
                                    <span class="absolute top-0.5 h-4 w-4 rounded-full transition-transform"
                                        :style="form.is_preview
                                            ? 'transform: translateX(16px); background: #22d3ee;'
                                            : 'transform: translateX(2px); background: rgba(255,255,255,0.4);'"
                                    ></span>
                                </button>
                                <span class="font-mono text-[10px] text-white/50">Free preview lesson</span>
                            </div>

                            <div class="pt-1">
                                <button type="submit" :disabled="form.processing"
                                    class="w-full rounded-xl py-2.5 font-mono text-[11px] font-semibold uppercase tracking-[0.14em] text-ink-900 transition disabled:opacity-60"
                                    style="background: white; box-shadow: 0 8px 30px -8px rgba(34,211,238,0.35);">
                                    {{ form.processing ? 'Saving…' : isEditing() ? 'Save changes' : 'Add lesson →' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
