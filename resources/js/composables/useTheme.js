import { ref, watch } from 'vue';

const isDark = ref(true);

function applyTheme(dark) {
    document.documentElement.classList.toggle('dark', dark);
    document.documentElement.classList.toggle('light', !dark);
}

// Always default to dark; only respect a user's saved preference
try {
    const stored = localStorage.getItem('theme');
    isDark.value = stored ? stored === 'dark' : true;
} catch {}

applyTheme(isDark.value);

watch(isDark, (val) => {
    applyTheme(val);
    try { localStorage.setItem('theme', val ? 'dark' : 'light'); } catch {}
});

export function useTheme() {
    return {
        isDark,
        setDark:  () => { isDark.value = true; },
        setLight: () => { isDark.value = false; },
    };
}
