<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import ModuleFormModal from './ModuleFormModal.vue';
import LessonFormModal from './LessonFormModal.vue';
import DeleteConfirmModal from './DeleteConfirmModal.vue';

const props = defineProps({
    course: { type: Object, required: true },
});

// Expanded modules
const expanded = ref(new Set());
const toggle = (id) => {
    expanded.value.has(id) ? expanded.value.delete(id) : expanded.value.add(id);
};

// Module modal
const moduleTarget = ref(undefined); // undefined=hidden, null=create, obj=edit
const openAddModule   = () => { moduleTarget.value = null; };
const openEditModule  = (m) => { moduleTarget.value = m; };
const closeModuleModal = () => { moduleTarget.value = undefined; };

// Lesson modal
const lessonTarget   = ref(undefined);
const lessonModuleId = ref(null);
const openAddLesson   = (moduleId) => { lessonModuleId.value = moduleId; lessonTarget.value = null; };
const openEditLesson  = (lesson, moduleId) => { lessonModuleId.value = moduleId; lessonTarget.value = lesson; };
const closeLessonModal = () => { lessonTarget.value = undefined; };

// Delete
const toDelete  = ref({ subject: null, label: '', id: null, type: null });
const deleting  = ref(false);

const requestDeleteModule = (m) => { toDelete.value = { subject: m.title, label: 'module', id: m.id, type: 'module' }; };
const requestDeleteLesson = (l) => { toDelete.value = { subject: l.title, label: 'lesson', id: l.id, type: 'lesson' }; };
const cancelDelete = () => { toDelete.value = { subject: null, label: '', id: null, type: null }; };

const confirmDelete = () => {
    if (!toDelete.value.id) return;
    deleting.value = true;
    const url = toDelete.value.type === 'module'
        ? `/admin/modules/${toDelete.value.id}`
        : `/admin/lessons/${toDelete.value.id}`;
    router.delete(url, {
        preserveScroll: true,
        onSuccess: () => cancelDelete(),
        onFinish:  () => { deleting.value = false; },
    });
};
</script>

<template>
    <div class="space-y-2">
        <!-- Module rows -->
        <div v-for="mod in course.modules" :key="mod.id"
            class="overflow-hidden rounded-xl"
            style="border: 1px solid rgba(255,255,255,0.07);">

            <!-- Module header row -->
            <div class="flex items-center gap-3 px-4 py-3 cursor-pointer select-none"
                style="background: rgba(255,255,255,0.03);"
                @click="toggle(mod.id)"
            >
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.3)" stroke-width="2.5" stroke-linecap="round"
                    class="flex-shrink-0 transition-transform"
                    :style="expanded.has(mod.id) ? 'transform: rotate(90deg);' : ''">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>

                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white/80 truncate">{{ mod.title }}</p>
                    <p class="font-mono text-[10px] text-white/30">
                        {{ mod.lessons?.length ?? 0 }} lessons{{ mod.duration ? ' · ' + mod.duration : '' }}
                    </p>
                </div>

                <!-- Module actions -->
                <div class="flex items-center gap-1" @click.stop>
                    <button @click="openAddLesson(mod.id)"
                        class="flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 font-mono text-[9px] transition hover:bg-white/10"
                        style="border: 1px solid rgba(34,211,238,0.15); color: rgba(34,211,238,0.7);"
                        title="Add lesson">
                        <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Lesson
                    </button>
                    <button @click="openEditModule(mod)"
                        class="flex h-7 w-7 items-center justify-center rounded-lg hover:bg-white/10 transition">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>
                    <button @click="requestDeleteModule(mod)"
                        class="flex h-7 w-7 items-center justify-center rounded-lg hover:bg-rose-500/10 transition">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="rgba(251,113,133,0.6)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Lessons list (collapsed by default, expand on click) -->
            <div v-show="expanded.has(mod.id)" class="border-t border-white/5">
                <div v-if="!mod.lessons?.length" class="px-10 py-3 font-mono text-[10px] text-white/25">
                    No lessons yet — click "+ Lesson" to add one.
                </div>
                <div v-for="lesson in mod.lessons" :key="lesson.id"
                    class="group flex items-center gap-3 px-10 py-2.5 border-b border-white/[0.03] last:border-0"
                    style="background: rgba(255,255,255,0.01);">

                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/>
                    </svg>

                    <p class="flex-1 text-[13px] text-white/65 truncate">{{ lesson.title }}</p>

                    <div class="flex items-center gap-1.5 flex-shrink-0">
                        <span v-if="lesson.duration" class="font-mono text-[9px] text-white/30">{{ lesson.duration }}</span>
                        <span v-if="lesson.is_preview"
                            class="rounded-full px-1.5 py-0.5 font-mono text-[8px] uppercase"
                            style="background: rgba(52,211,153,0.07); border: 1px solid rgba(52,211,153,0.2); color: rgba(52,211,153,0.7);">
                            Preview
                        </span>
                        <span v-if="lesson.drive_file_id"
                            class="rounded-full px-1.5 py-0.5 font-mono text-[8px] uppercase"
                            style="background: rgba(34,211,238,0.07); border: 1px solid rgba(34,211,238,0.15); color: rgba(34,211,238,0.6);">
                            Drive
                        </span>
                    </div>

                    <!-- Lesson actions (hover) -->
                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button @click="openEditLesson(lesson, mod.id)"
                            class="flex h-6 w-6 items-center justify-center rounded hover:bg-white/10 transition">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </button>
                        <button @click="requestDeleteLesson(lesson)"
                            class="flex h-6 w-6 items-center justify-center rounded hover:bg-rose-500/10 transition">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="rgba(251,113,133,0.6)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty state -->
        <div v-if="!course.modules?.length"
            class="flex flex-col items-center justify-center py-10 rounded-xl"
            style="background: rgba(255,255,255,0.02); border: 1px dashed rgba(255,255,255,0.08);">
            <p class="font-mono text-[11px] uppercase tracking-[0.2em] text-white/25">No modules yet</p>
        </div>

        <!-- Add module button -->
        <button @click="openAddModule"
            type="button"
            class="w-full flex items-center justify-center gap-2 rounded-xl py-2.5 font-mono text-[10px] uppercase tracking-[0.12em] transition hover:bg-white/5"
            style="border: 1px dashed rgba(34,211,238,0.2); color: rgba(34,211,238,0.5);">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Add module
        </button>
    </div>

    <!-- Modals -->
    <ModuleFormModal
        v-if="moduleTarget !== undefined"
        :module="moduleTarget"
        :course-id="course.id"
        @close="closeModuleModal"
    />

    <LessonFormModal
        v-if="lessonTarget !== undefined"
        :lesson="lessonTarget"
        :module-id="lessonModuleId"
        @close="closeLessonModal"
    />

    <DeleteConfirmModal
        :subject="toDelete.subject"
        :label="toDelete.label"
        :processing="deleting"
        @confirm="confirmDelete"
        @cancel="cancelDelete"
    />
</template>
