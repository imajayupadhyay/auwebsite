<script setup>
import { watch } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    category: { type: Object, default: null }, // null = create
    flat:     { type: Array,  default: () => [] },
});

const emit = defineEmits(['close']);

const form = useForm({
    name:        '',
    slug:        '',
    parent_id:   null,
    description: '',
    sort_order:  0,
});

watch(
    () => props.category,
    (c) => {
        form.name        = c?.name        ?? '';
        form.slug        = c?.slug        ?? '';
        form.parent_id   = c?.parent_id   ?? null;
        form.description = c?.description ?? '';
        form.sort_order  = c?.sort_order  ?? 0;
        form.clearErrors();
    },
    { immediate: true },
);

const isEditing = () => !!props.category;

const submit = () => {
    if (isEditing()) {
        form.patch(`/admin/categories/${props.category.id}`, {
            preserveScroll: true,
            onSuccess: () => emit('close'),
        });
    } else {
        form.post('/admin/categories', {
            preserveScroll: true,
            onSuccess: () => { form.reset(); emit('close'); },
        });
    }
};

const inputCls = 'w-full rounded-xl px-4 py-2.5 font-sans text-sm text-white placeholder:text-white/25 outline-none transition-all';
const inputStyle = 'background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);';
const focusShadow = '0 0 0 2px rgba(34,211,238,0.18)';

// Exclude self + descendants from parent select
const availableParents = (id) => {
    if (!id) return props.flat;
    return props.flat.filter(c => c.id !== id);
};
</script>

<template>
    <Teleport to="body">
        <Transition enter-active-class="transition duration-200 ease-out" enter-from-class="opacity-0" enter-to-class="opacity-100"
                    leave-active-class="transition duration-150 ease-in" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="category !== undefined"
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

                        <!-- Header -->
                        <div class="mb-5 flex items-center justify-between">
                            <div>
                                <div class="mb-1 inline-flex items-center gap-2 rounded-full px-2.5 py-1"
                                    style="background: rgba(34,211,238,0.07); border: 1px solid rgba(34,211,238,0.15);">
                                    <span class="h-1 w-1 rounded-full bg-cyan-400"></span>
                                    <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-cyan-300/70">
                                        {{ isEditing() ? 'Edit Category' : 'New Category' }}
                                    </span>
                                </div>
                                <h2 class="font-display text-xl font-semibold text-white">
                                    {{ isEditing() ? 'Update category' : 'Add category' }}
                                </h2>
                            </div>
                            <button @click="emit('close')"
                                class="flex h-8 w-8 items-center justify-center rounded-full transition hover:bg-white/10"
                                style="border: 1px solid rgba(255,255,255,0.08); color: rgba(255,255,255,0.4);">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                </svg>
                            </button>
                        </div>

                        <div class="mb-5 h-px" style="background: linear-gradient(90deg, rgba(34,211,238,0.15), rgba(255,255,255,0.05), transparent);"></div>

                        <form @submit.prevent="submit" novalidate class="space-y-4">
                            <!-- Name -->
                            <div>
                                <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Name</label>
                                <input v-model="form.name" type="text" required placeholder="e.g. Cloud Computing"
                                    :class="[inputCls, form.errors.name ? 'shadow-[0_0_0_2px_rgba(251,113,133,0.3)]' : '']"
                                    :style="inputStyle"
                                    @focus="$event.target.style.boxShadow = focusShadow"
                                    @blur="$event.target.style.boxShadow = 'none'" />
                                <p v-if="form.errors.name" class="mt-1 font-mono text-[10px] text-rose-400">{{ form.errors.name }}</p>
                            </div>

                            <!-- Slug -->
                            <div>
                                <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Slug <span class="text-white/20">(auto-generated if blank)</span></label>
                                <input v-model="form.slug" type="text" placeholder="cloud-computing"
                                    :class="[inputCls, form.errors.slug ? 'shadow-[0_0_0_2px_rgba(251,113,133,0.3)]' : '']"
                                    :style="inputStyle"
                                    @focus="$event.target.style.boxShadow = focusShadow"
                                    @blur="$event.target.style.boxShadow = 'none'" />
                                <p v-if="form.errors.slug" class="mt-1 font-mono text-[10px] text-rose-400">{{ form.errors.slug }}</p>
                            </div>

                            <!-- Parent -->
                            <div>
                                <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Parent category <span class="text-white/20">(optional)</span></label>
                                <select v-model="form.parent_id"
                                    :class="inputCls" :style="inputStyle"
                                    @focus="$event.target.style.boxShadow = focusShadow"
                                    @blur="$event.target.style.boxShadow = 'none'"
                                    style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);"
                                >
                                    <option :value="null">— None (top-level) —</option>
                                    <option
                                        v-for="c in availableParents(category?.id)"
                                        :key="c.id"
                                        :value="c.id"
                                    >{{ c.parent_id ? '    ↳ ' : '' }}{{ c.name }}</option>
                                </select>
                                <p v-if="form.errors.parent_id" class="mt-1 font-mono text-[10px] text-rose-400">{{ form.errors.parent_id }}</p>
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Description <span class="text-white/20">(optional)</span></label>
                                <textarea v-model="form.description" rows="2" placeholder="Brief description…"
                                    :class="inputCls" :style="inputStyle"
                                    @focus="$event.target.style.boxShadow = focusShadow"
                                    @blur="$event.target.style.boxShadow = 'none'"
                                ></textarea>
                            </div>

                            <!-- Submit -->
                            <div class="pt-1">
                                <button type="submit" :disabled="form.processing"
                                    class="w-full rounded-xl py-2.5 font-mono text-[11px] font-semibold uppercase tracking-[0.14em] text-ink-900 transition disabled:opacity-60 disabled:cursor-not-allowed"
                                    style="background: white; box-shadow: 0 8px 30px -8px rgba(34,211,238,0.35);">
                                    {{ form.processing ? 'Saving…' : isEditing() ? 'Save changes' : 'Create category →' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
