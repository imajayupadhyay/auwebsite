<script setup>
import { watch } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    user: { type: Object, default: null }, // null = create mode
});

const emit = defineEmits(['close']);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

// Sync form when user prop changes (switching between create / edit)
watch(
    () => props.user,
    (u) => {
        form.name = u?.name ?? '';
        form.email = u?.email ?? '';
        form.password = '';
        form.password_confirmation = '';
        form.clearErrors();
    },
    { immediate: true },
);

const isEditing = () => !!props.user;

const submit = () => {
    if (isEditing()) {
        form.patch(`/admin/users/${props.user.id}`, {
            preserveScroll: true,
            onSuccess: () => emit('close'),
        });
    } else {
        form.post('/admin/users', {
            preserveScroll: true,
            onSuccess: () => { form.reset(); emit('close'); },
        });
    }
};

const inputCls = [
    'w-full rounded-xl px-4 py-2.5 font-sans text-sm text-white placeholder:text-white/25 outline-none transition-all',
].join(' ');

const inputStyle = 'background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);';
const inputFocusStyle = '0 0 0 2px rgba(34,211,238,0.18)';
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <!-- Backdrop -->
            <div
                v-if="user !== undefined"
                class="fixed inset-0 z-50 flex items-center justify-center p-4"
                style="background: rgba(5,7,13,0.8); backdrop-filter: blur(8px);"
                @click.self="emit('close')"
            >
                <Transition
                    enter-active-class="transition duration-200 ease-out"
                    enter-from-class="opacity-0 scale-95 translate-y-2"
                    enter-to-class="opacity-100 scale-100 translate-y-0"
                    leave-active-class="transition duration-150 ease-in"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-95"
                >
                    <div
                        class="relative w-full max-w-md rounded-2xl p-7"
                        style="background: linear-gradient(135deg, rgba(255,255,255,0.07) 0%, rgba(255,255,255,0.02) 100%);
                               backdrop-filter: blur(24px);
                               border: 1px solid rgba(255,255,255,0.1);
                               box-shadow: 0 40px 80px -20px rgba(5,7,13,0.9), 0 0 0 1px rgba(34,211,238,0.07);"
                    >
                        <!-- Top glow -->
                        <div class="pointer-events-none absolute inset-0 rounded-2xl"
                            style="background: radial-gradient(ellipse at 50% 0%, rgba(34,211,238,0.06) 0%, transparent 60%);"></div>

                        <!-- Header -->
                        <div class="mb-5 flex items-center justify-between">
                            <div>
                                <div class="mb-1 inline-flex items-center gap-2 rounded-full px-2.5 py-1"
                                    style="background: rgba(34,211,238,0.07); border: 1px solid rgba(34,211,238,0.15);">
                                    <span class="h-1 w-1 rounded-full bg-cyan-400"></span>
                                    <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-cyan-300/70">
                                        {{ isEditing() ? 'Edit Admin' : 'New Admin' }}
                                    </span>
                                </div>
                                <h2 class="font-display text-xl font-semibold text-white">
                                    {{ isEditing() ? 'Update account' : 'Add administrator' }}
                                </h2>
                            </div>
                            <button
                                @click="emit('close')"
                                class="flex h-8 w-8 items-center justify-center rounded-full transition hover:bg-white/10"
                                style="border: 1px solid rgba(255,255,255,0.08); color: rgba(255,255,255,0.4);"
                            >
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                </svg>
                            </button>
                        </div>

                        <div class="mb-5 h-px" style="background: linear-gradient(90deg, rgba(34,211,238,0.15), rgba(255,255,255,0.05), transparent);"></div>

                        <form @submit.prevent="submit" autocomplete="off" novalidate class="space-y-4">
                            <!-- Name -->
                            <div>
                                <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Name</label>
                                <input
                                    v-model="form.name"
                                    type="text"
                                    required
                                    placeholder="Full name"
                                    :class="[inputCls, form.errors.name ? 'shadow-[0_0_0_2px_rgba(251,113,133,0.3)]' : '']"
                                    :style="inputStyle"
                                    @focus="$event.target.style.boxShadow = inputFocusStyle"
                                    @blur="$event.target.style.boxShadow = 'none'"
                                />
                                <p v-if="form.errors.name" class="mt-1 font-mono text-[10px] text-rose-400">{{ form.errors.name }}</p>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Email</label>
                                <input
                                    v-model="form.email"
                                    type="email"
                                    required
                                    placeholder="admin@domain.com"
                                    :class="[inputCls, form.errors.email ? 'shadow-[0_0_0_2px_rgba(251,113,133,0.3)]' : '']"
                                    :style="inputStyle"
                                    @focus="$event.target.style.boxShadow = inputFocusStyle"
                                    @blur="$event.target.style.boxShadow = 'none'"
                                />
                                <p v-if="form.errors.email" class="mt-1 font-mono text-[10px] text-rose-400">{{ form.errors.email }}</p>
                            </div>

                            <!-- Divider for password section -->
                            <div class="relative">
                                <div class="h-px" style="background: rgba(255,255,255,0.06);"></div>
                                <span class="absolute left-0 top-1/2 -translate-y-1/2 font-mono text-[9px] uppercase tracking-[0.18em] text-white/25 bg-transparent pr-2">
                                    {{ isEditing() ? 'Change password (optional)' : 'Password' }}
                                </span>
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Password</label>
                                <input
                                    v-model="form.password"
                                    type="password"
                                    :required="!isEditing()"
                                    :placeholder="isEditing() ? 'Leave blank to keep current' : 'Min 8 characters'"
                                    :class="[inputCls, form.errors.password ? 'shadow-[0_0_0_2px_rgba(251,113,133,0.3)]' : '']"
                                    :style="inputStyle"
                                    @focus="$event.target.style.boxShadow = inputFocusStyle"
                                    @blur="$event.target.style.boxShadow = 'none'"
                                />
                                <p v-if="form.errors.password" class="mt-1 font-mono text-[10px] text-rose-400">{{ form.errors.password }}</p>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label class="mb-1.5 block font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">Confirm Password</label>
                                <input
                                    v-model="form.password_confirmation"
                                    type="password"
                                    :required="!isEditing() || !!form.password"
                                    placeholder="Repeat password"
                                    :class="inputCls"
                                    :style="inputStyle"
                                    @focus="$event.target.style.boxShadow = inputFocusStyle"
                                    @blur="$event.target.style.boxShadow = 'none'"
                                />
                            </div>

                            <!-- Submit -->
                            <div class="pt-1">
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="w-full rounded-xl py-2.5 font-mono text-[11px] font-semibold uppercase tracking-[0.14em] text-ink-900 transition disabled:opacity-60 disabled:cursor-not-allowed"
                                    style="background: white; box-shadow: 0 8px 30px -8px rgba(34,211,238,0.35);"
                                >
                                    {{ form.processing ? 'Saving…' : isEditing() ? 'Save changes' : 'Create admin →' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
