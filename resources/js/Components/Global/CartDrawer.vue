<script setup>
import { watch } from 'vue';
import { Icon } from '@iconify/vue';
import { useCart } from '@/composables/useCart';
import { useTheme } from '@/composables/useTheme';

const { isDark } = useTheme();
const {
    items,
    isOpen,
    count,
    subtotal,
    savings,
    removeItem,
    updateQuantity,
    clearCart,
    closeCart,
} = useCart();

watch(isOpen, (val) => {
    document.body.style.overflow = val ? 'hidden' : '';
});

const inr = (n) => `₹${(n ?? 0).toLocaleString('en-IN')}`;
</script>

<template>
    <Teleport to="body">
        <Transition name="cart-backdrop">
            <div
                v-if="isOpen"
                class="fixed inset-0 z-[80]"
                :class="isDark ? 'bg-ink-950/70' : 'bg-slate-900/40'"
                style="backdrop-filter: blur(4px);"
                @click="closeCart"
                aria-hidden="true"
            />
        </Transition>

        <Transition name="cart-panel">
            <aside
                v-if="isOpen"
                class="fixed right-0 top-0 z-[90] flex h-screen w-full max-w-md flex-col glass-strong overflow-hidden"
                role="dialog"
                aria-label="Shopping cart"
            >
                <!-- Header -->
                <div class="flex items-center justify-between border-b border-white/5 px-6 py-5">
                    <div class="flex items-center gap-3">
                        <div class="grid h-9 w-9 place-items-center rounded-xl border border-white/10 bg-white/5">
                            <svg class="h-4 w-4 text-cyan-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"/>
                                <circle cx="20" cy="21" r="1"/>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-display text-base font-semibold text-white">Your cart</div>
                            <div class="font-mono text-[10px] uppercase tracking-[0.18em] text-white/45">
                                {{ count }} {{ count === 1 ? 'item' : 'items' }}
                            </div>
                        </div>
                    </div>
                    <button
                        @click="closeCart"
                        class="grid h-8 w-8 place-items-center rounded-xl glass transition hover:border-white/20 text-white/70"
                        aria-label="Close cart"
                    >
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M6 6l12 12M18 6L6 18"/>
                        </svg>
                    </button>
                </div>

                <!-- Items -->
                <div v-if="items.length > 0" class="flex flex-1 flex-col gap-3 overflow-y-auto px-6 py-5">
                    <div
                        v-for="item in items"
                        :key="item.slug"
                        class="group relative rounded-2xl glass p-4"
                    >
                        <div class="flex gap-4">
                            <div class="grid h-14 w-14 flex-none place-items-center rounded-xl border border-white/10 bg-white/5">
                                <Icon :icon="item.icon" class="h-8 w-8" />
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <div class="font-mono text-[9px] uppercase tracking-[0.18em] text-white/40">
                                            {{ item.code }}
                                        </div>
                                        <div class="mt-1 truncate font-display text-sm font-semibold text-white">
                                            {{ item.title }}
                                        </div>
                                        <div class="mt-0.5 truncate text-[11px] text-white/55">
                                            {{ item.subtitle }}
                                        </div>
                                    </div>
                                    <button
                                        @click="removeItem(item.slug)"
                                        class="grid h-7 w-7 flex-none place-items-center rounded-lg text-white/35 transition hover:bg-white/5 hover:text-white/80"
                                        aria-label="Remove"
                                    >
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                            <path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/>
                                        </svg>
                                    </button>
                                </div>

                                <div class="mt-3 flex items-center justify-between">
                                    <!-- Quantity -->
                                    <div class="inline-flex items-center gap-1 rounded-lg border border-white/10 bg-white/5 p-0.5">
                                        <button
                                            @click="updateQuantity(item.slug, item.quantity - 1)"
                                            class="grid h-6 w-6 place-items-center rounded text-white/60 transition hover:bg-white/10 hover:text-white"
                                            aria-label="Decrease quantity"
                                        >
                                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14"/></svg>
                                        </button>
                                        <span class="grid h-6 w-7 place-items-center font-mono text-[11px] text-white">{{ item.quantity }}</span>
                                        <button
                                            @click="updateQuantity(item.slug, item.quantity + 1)"
                                            class="grid h-6 w-6 place-items-center rounded text-white/60 transition hover:bg-white/10 hover:text-white"
                                            aria-label="Increase quantity"
                                        >
                                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                                        </button>
                                    </div>

                                    <div class="text-right">
                                        <div class="font-display text-sm font-semibold text-white">
                                            ₹{{ (item.price * item.quantity).toLocaleString('en-IN') }}
                                        </div>
                                        <div
                                            v-if="item.originalPrice && item.originalPrice > item.price"
                                            class="font-mono text-[10px] text-white/35 line-through"
                                        >
                                            ₹{{ (item.originalPrice * item.quantity).toLocaleString('en-IN') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty state -->
                <div
                    v-else
                    class="flex flex-1 flex-col items-center justify-center gap-4 px-6 text-center"
                >
                    <div class="grid h-16 w-16 place-items-center rounded-2xl glass">
                        <svg class="h-7 w-7 text-white/30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"/>
                            <circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-display text-base font-semibold text-white">Your cart is empty</p>
                        <p class="mt-1 text-sm text-white/50">Browse the course library and pick one to get started.</p>
                    </div>
                    <button
                        @click="closeCart"
                        class="rounded-xl glass px-5 py-2.5 text-sm font-medium text-white/75 transition hover:border-white/20 hover:text-white"
                    >
                        Keep browsing
                    </button>
                </div>

                <!-- Footer: totals + actions -->
                <div
                    v-if="items.length > 0"
                    class="border-t border-white/5 px-6 py-5"
                >
                    <div v-if="savings > 0" class="mb-3 flex items-center justify-between text-xs">
                        <span class="text-white/55">You save</span>
                        <span class="font-mono text-emerald-400">− {{ inr(savings) }}</span>
                    </div>
                    <div class="mb-4 flex items-end justify-between">
                        <div>
                            <div class="font-mono text-[10px] uppercase tracking-[0.2em] text-white/45">Subtotal</div>
                            <div class="mt-0.5 text-[11px] text-white/45">Taxes calculated at checkout</div>
                        </div>
                        <div class="font-display text-2xl font-semibold text-white">{{ inr(subtotal) }}</div>
                    </div>

                    <button
                        class="group relative flex w-full items-center justify-center gap-2 overflow-hidden rounded-xl px-5 py-3.5 text-sm font-semibold transition"
                        :class="isDark
                            ? 'bg-white text-ink-900 shadow-[0_20px_50px_-12px_rgba(34,211,238,0.45)] hover:shadow-[0_20px_60px_-12px_rgba(34,211,238,0.65)]'
                            : 'bg-indigo-600 text-[#ffffff] shadow-[0_20px_50px_-12px_rgba(99,102,241,0.45)] hover:bg-indigo-500'"
                    >
                        Checkout
                        <svg class="h-4 w-4 transition group-hover:translate-x-0.5" viewBox="0 0 20 20" fill="none">
                            <path d="M4 10h12m0 0-4-4m4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                    <button
                        @click="clearCart"
                        class="mt-2 w-full rounded-xl px-5 py-2.5 text-xs font-medium text-white/50 transition hover:bg-white/5 hover:text-white/80"
                    >
                        Clear cart
                    </button>
                </div>
            </aside>
        </Transition>
    </Teleport>
</template>

<style scoped>
.cart-backdrop-enter-active,
.cart-backdrop-leave-active {
    transition: opacity 0.3s ease;
}
.cart-backdrop-enter-from,
.cart-backdrop-leave-to {
    opacity: 0;
}

.cart-panel-enter-active,
.cart-panel-leave-active {
    transition: transform 0.38s cubic-bezier(0.22, 1, 0.36, 1);
}
.cart-panel-enter-from,
.cart-panel-leave-to {
    transform: translateX(100%);
}
</style>
