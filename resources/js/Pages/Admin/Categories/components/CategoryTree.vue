<script setup>
defineProps({
    nodes:  { type: Array, required: true },
    depth:  { type: Number, default: 0 },
});

const emit = defineEmits(['edit', 'delete']);
</script>

<template>
    <div :class="depth > 0 ? 'ml-6 border-l border-white/5 pl-4 mt-1 space-y-1' : 'space-y-1'">
        <div
            v-for="node in nodes"
            :key="node.id"
        >
            <div
                class="group flex items-center gap-3 rounded-xl px-3 py-2.5 transition-colors"
                style="background: rgba(255,255,255,0.025); border: 1px solid rgba(255,255,255,0.05);"
            >
                <!-- Icon -->
                <div class="flex-shrink-0 flex h-6 w-6 items-center justify-center rounded-lg"
                    :style="depth === 0
                        ? 'background: rgba(34,211,238,0.08); border: 1px solid rgba(34,211,238,0.18);'
                        : 'background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);'"
                >
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        :style="depth === 0 ? 'color: #22d3ee;' : 'color: rgba(255,255,255,0.35);'"
                    >
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                    </svg>
                </div>

                <!-- Name + badge -->
                <div class="flex flex-1 items-center gap-2 min-w-0">
                    <span class="text-sm font-medium text-white/80 truncate">{{ node.name }}</span>
                    <span v-if="depth === 0 && node.children?.length"
                        class="flex-shrink-0 rounded-full px-1.5 py-0.5 font-mono text-[9px]"
                        style="background: rgba(34,211,238,0.07); color: rgba(34,211,238,0.7); border: 1px solid rgba(34,211,238,0.15);"
                    >{{ node.children.length }} sub</span>
                    <span class="flex-shrink-0 font-mono text-[9px] text-white/25">{{ node.slug }}</span>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button @click="emit('edit', node)"
                        class="flex h-6 w-6 items-center justify-center rounded-lg hover:bg-white/10 transition"
                        title="Edit"
                    >
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.45)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>
                    <button @click="emit('delete', node)"
                        class="flex h-6 w-6 items-center justify-center rounded-lg hover:bg-rose-500/10 transition"
                        title="Delete"
                    >
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="rgba(251,113,133,0.6)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                            <path d="M10 11v6"/><path d="M14 11v6"/>
                            <path d="M9 6V4h6v2"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Recursive children -->
            <CategoryTree
                v-if="node.children?.length"
                :nodes="node.children"
                :depth="depth + 1"
                @edit="emit('edit', $event)"
                @delete="emit('delete', $event)"
            />
        </div>
    </div>
</template>
