<script setup>
defineProps({
    courses: { type: Object, required: true },
});

const emit = defineEmits(['delete']);

const formatPrice = (p) => p > 0 ? `₹${p.toLocaleString('en-IN')}` : 'Free';
</script>

<template>
    <div class="overflow-hidden rounded-2xl" style="border: 1px solid rgba(255,255,255,0.07);">
        <!-- Header -->
        <div class="grid grid-cols-[60px_1fr_140px_100px_80px_80px] items-center gap-3 px-5 py-3"
            style="background: rgba(255,255,255,0.03); border-bottom: 1px solid rgba(255,255,255,0.06);">
            <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-white/30">Code</span>
            <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-white/30">Title</span>
            <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-white/30">Categories</span>
            <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-white/30">Price</span>
            <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-white/30">Status</span>
            <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-white/30 text-right">Actions</span>
        </div>

        <!-- Empty -->
        <div v-if="!courses.data.length" class="flex flex-col items-center justify-center py-16"
            style="background: rgba(255,255,255,0.01);">
            <svg class="mb-3 h-8 w-8 text-white/15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>
            </svg>
            <p class="font-mono text-[11px] uppercase tracking-[0.2em] text-white/25">No courses found</p>
        </div>

        <!-- Rows -->
        <div v-else>
            <div v-for="course in courses.data" :key="course.id"
                class="group grid grid-cols-[60px_1fr_140px_100px_80px_80px] items-center gap-3 px-5 py-4 transition-colors"
                style="background: rgba(255,255,255,0.015); border-bottom: 1px solid rgba(255,255,255,0.04);">

                <!-- Code -->
                <span class="font-mono text-[10px] font-bold text-cyan-300/80">{{ course.code }}</span>

                <!-- Title + dot -->
                <div class="flex items-center gap-2.5 min-w-0">
                    <span class="h-2 w-2 flex-shrink-0 rounded-full" :style="`background: ${course.dot_color || '#22d3ee'};`"></span>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-medium text-white/85">{{ course.title }}</p>
                        <p class="font-mono text-[10px] text-white/30">{{ course.level }} · {{ course.hours }}h</p>
                    </div>
                </div>

                <!-- Categories -->
                <div class="flex flex-wrap gap-1">
                    <span v-for="cat in course.categories" :key="cat.id"
                        class="rounded-full px-2 py-0.5 font-mono text-[9px]"
                        style="background: rgba(34,211,238,0.07); border: 1px solid rgba(34,211,238,0.15); color: rgba(34,211,238,0.7);">
                        {{ cat.name }}
                    </span>
                </div>

                <!-- Price -->
                <span class="font-mono text-xs text-white/65">{{ formatPrice(course.price) }}</span>

                <!-- Status -->
                <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 font-mono text-[9px] uppercase"
                    :style="course.available
                        ? 'background: rgba(52,211,153,0.08); border: 1px solid rgba(52,211,153,0.2); color: rgba(52,211,153,0.9);'
                        : 'background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); color: rgba(255,255,255,0.35);'">
                    <span class="h-1 w-1 rounded-full" :style="course.available ? 'background: #34d399;' : 'background: rgba(255,255,255,0.3);'"></span>
                    {{ course.available ? 'Live' : 'Draft' }}
                </span>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-1.5">
                    <a :href="`/admin/courses/${course.id}/edit`"
                        class="flex h-7 w-7 items-center justify-center rounded-lg transition hover:bg-white/10"
                        title="Edit course">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.45)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </a>
                    <button @click="emit('delete', course)"
                        class="flex h-7 w-7 items-center justify-center rounded-lg transition hover:bg-rose-500/10"
                        title="Delete course">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="rgba(251,113,133,0.6)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                            <path d="M10 11v6"/><path d="M14 11v6"/>
                            <path d="M9 6V4h6v2"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
