<script setup>
const props = defineProps({
    modelValue:  { type: Array,  default: () => [] }, // array of category IDs
    categories:  { type: Array,  default: () => [] },
    error:       { type: String, default: '' },
});

const emit = defineEmits(['update:modelValue']);

const isSelected = (id) => props.modelValue.includes(id);

const toggle = (id) => {
    const next = isSelected(id)
        ? props.modelValue.filter(x => x !== id)
        : [...props.modelValue, id];
    emit('update:modelValue', next);
};

const catName = (id) => props.categories.find(c => c.id === id)?.name ?? id;
</script>

<template>
    <div>
        <!-- Selected chips -->
        <div v-if="modelValue.length" class="mb-2 flex flex-wrap gap-1.5">
            <span v-for="id in modelValue" :key="id"
                class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 font-mono text-[9px]"
                style="background: rgba(34,211,238,0.08); border: 1px solid rgba(34,211,238,0.2); color: #22d3ee;">
                {{ catName(id) }}
                <button type="button" @click="toggle(id)" class="hover:opacity-70 transition">
                    <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </span>
        </div>

        <!-- Options grid -->
        <div class="flex flex-wrap gap-2">
            <button
                v-for="cat in categories"
                :key="cat.id"
                type="button"
                @click="toggle(cat.id)"
                class="rounded-xl px-3 py-1.5 font-mono text-[10px] transition"
                :style="isSelected(cat.id)
                    ? 'background: rgba(34,211,238,0.1); border: 1px solid rgba(34,211,238,0.25); color: #22d3ee;'
                    : 'background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); color: rgba(255,255,255,0.5);'"
            >
                <span v-if="cat.parent_id" class="text-white/25 mr-0.5">↳ </span>{{ cat.name }}
            </button>
        </div>

        <p v-if="error" class="mt-1.5 font-mono text-[10px] text-rose-400">{{ error }}</p>
    </div>
</template>
