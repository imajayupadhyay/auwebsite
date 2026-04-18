<script setup>
import { ref } from 'vue';

const props = defineProps({
    modelValue: { type: Array, default: () => [] },
});

const emit = defineEmits(['update:modelValue']);

const input = ref('');

const add = () => {
    const tag = input.value.trim();
    if (tag && !props.modelValue.includes(tag)) {
        emit('update:modelValue', [...props.modelValue, tag]);
    }
    input.value = '';
};

const remove = (tag) => {
    emit('update:modelValue', props.modelValue.filter(t => t !== tag));
};

const onKeydown = (e) => {
    if (e.key === 'Enter' || e.key === ',') {
        e.preventDefault();
        add();
    }
    if (e.key === 'Backspace' && !input.value && props.modelValue.length) {
        remove(props.modelValue[props.modelValue.length - 1]);
    }
};
</script>

<template>
    <div class="rounded-xl px-3 py-2.5 flex flex-wrap gap-1.5 min-h-[44px]"
        style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
        <span v-for="tag in modelValue" :key="tag"
            class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 font-mono text-[10px]"
            style="background: rgba(34,211,238,0.07); border: 1px solid rgba(34,211,238,0.15); color: rgba(34,211,238,0.8);">
            {{ tag }}
            <button type="button" @click="remove(tag)" class="hover:opacity-70 transition">
                <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </span>
        <input
            v-model="input"
            type="text"
            placeholder="Type and press Enter…"
            class="flex-1 min-w-[120px] bg-transparent outline-none font-mono text-xs text-white placeholder:text-white/20"
            @keydown="onKeydown"
            @blur="add"
        />
    </div>
</template>
