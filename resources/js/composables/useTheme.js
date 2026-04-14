import { ref, watch } from 'vue';

const isDark = ref(true);

function applyTheme(dark) {
    document.documentElement.classList.toggle('dark', dark);
    document.documentElement.classList.toggle('light', !dark);
}

try {
    const stored = localStorage.getItem('theme');
    isDark.value = stored
        ? stored === 'dark'
        : !window.matchMedia('(prefers-color-scheme: light)').matches;
} catch {}

applyTheme(isDark.value);

watch(isDark, (val) => {
    applyTheme(val);
    try { localStorage.setItem('theme', val ? 'dark' : 'light'); } catch {}
});

export function useTheme() {
    return {
        isDark,
        toggleTheme: () => { isDark.value = !isDark.value; },
    };
}
