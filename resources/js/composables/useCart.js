import { ref, computed, watch } from 'vue';

const STORAGE_KEY = 'cart:v1';

const items = ref([]);
const isOpen = ref(false);

try {
    const stored = localStorage.getItem(STORAGE_KEY);
    if (stored) items.value = JSON.parse(stored);
} catch {}

watch(
    items,
    (val) => {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(val));
        } catch {}
    },
    { deep: true },
);

const count = computed(() => items.value.reduce((s, i) => s + i.quantity, 0));
const subtotal = computed(() => items.value.reduce((s, i) => s + i.price * i.quantity, 0));
const originalTotal = computed(() =>
    items.value.reduce((s, i) => s + (i.originalPrice ?? i.price) * i.quantity, 0),
);
const savings = computed(() => Math.max(0, originalTotal.value - subtotal.value));

const has = (slug) => items.value.some((i) => i.slug === slug);

const addItem = (course) => {
    if (!course?.slug) return;
    const existing = items.value.find((i) => i.slug === course.slug);
    if (existing) {
        existing.quantity += 1;
    } else {
        items.value.push({
            slug: course.slug,
            code: course.code,
            title: course.title,
            subtitle: course.subtitle,
            icon: course.icon,
            dot: course.dot,
            price: course.price,
            originalPrice: course.originalPrice,
            quantity: 1,
        });
    }
    isOpen.value = true;
};

const removeItem = (slug) => {
    items.value = items.value.filter((i) => i.slug !== slug);
};

const updateQuantity = (slug, qty) => {
    const it = items.value.find((i) => i.slug === slug);
    if (!it) return;
    if (qty <= 0) return removeItem(slug);
    it.quantity = qty;
};

const clearCart = () => {
    items.value = [];
};

const openCart = () => {
    isOpen.value = true;
};
const closeCart = () => {
    isOpen.value = false;
};

export function useCart() {
    return {
        items,
        isOpen,
        count,
        subtotal,
        originalTotal,
        savings,
        has,
        addItem,
        removeItem,
        updateQuantity,
        clearCart,
        openCart,
        closeCart,
    };
}
