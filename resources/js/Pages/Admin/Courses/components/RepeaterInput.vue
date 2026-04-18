<script setup>
import { ref } from 'vue';

const props = defineProps({
    modelValue: { type: Array,  default: () => [] },
    placeholder:{ type: String, default: 'Add item…' },
});

const emit = defineEmits(['update:modelValue']);

const draft = ref('');

const add = () => {
    const val = draft.value.trim();
    if (val) {
        emit('update:modelValue', [...props.modelValue, val]);
        draft.value = '';
    }
};

const remove = (i) => {
    emit('update:modelValue', props.modelValue.filter((_, idx) => idx !== i));
};

const move = (i, dir) => {
    const arr = [...props.modelValue];
    const to = i + dir;
    if (to < 0 || to >= arr.length) return;
    [arr[i], arr[to]] = [arr[to], arr[i]];
    emit('update:modelValue', arr);
};
</script>

<template>
    <div class="space-y-2">
        <div v-for="(item, i) in modelValue" :key="i"
            class="flex items-start gap-2 group">
            <span class="mt-2.5 font-mono text-[10px] text-white/20 w-5 text-right flex-shrink-0">{{ i + 1 }}.</span>
            <div class="flex-1 rounded-xl px-3 py-2 text-sm text-white/75"
                style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07);">
                {{ item }}
            </div>
            <div class="flex flex-col gap-0.5 opacity-0 group-hover:opacity-100 transition-opacity">
                <button type="button" @click="move(i, -1)" :disabled="i === 0"
                    class="flex h-5 w-5 items-center justify-center rounded hover:bg-white/10 transition disabled:opacity-20">
                    <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="2.5" stroke-linecap="round">
                        <polyline points="18 15 12 9 6 15"/>
                    </svg>
                </button>
                <button type="button" @click="move(i, 1)" :disabled="i === modelValue.length - 1"
                    class="flex h-5 w-5 items-center justify-center rounded hover:bg-white/10 transition disabled:opacity-20">
                    <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="2.5" stroke-linecap="round">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </button>
            </div>
            <button type="button" @click="remove(i)"
                class="mt-1.5 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-lg hover:bg-rose-500/10 transition opacity-0 group-hover:opacity-100">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="rgba(251,113,133,0.6)" stroke-width="2" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <!-- Add row -->
        <div class="flex gap-2">
            <input v-model="draft" type="text" :placeholder="placeholder"
                class="flex-1 rounded-xl px-3 py-2.5 font-sans text-sm text-white placeholder:text-white/20 outline-none transition"
                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);"
                @focus="$event.target.style.boxShadow = '0 0 0 2px rgba(34,211,238,0.15)'"
                @blur="$event.target.style.boxShadow = 'none'"
                @keydown.enter.prevent="add"
            />
            <button type="button" @click="add"
                class="flex-shrink-0 flex h-10 w-10 items-center justify-center rounded-xl transition hover:bg-white/10"
                style="border: 1px solid rgba(255,255,255,0.1);">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="2.5" stroke-linecap="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
            </button>
        </div>
    </div>
</template>
