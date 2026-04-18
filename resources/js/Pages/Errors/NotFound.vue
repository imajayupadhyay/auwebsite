<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { motion } from 'motion-v';
import { useTheme } from '@/composables/useTheme';
import Header from '@/Components/Global/Header.vue';
import Footer from '@/Components/Global/Footer.vue';

const { isDark } = useTheme();

const ease = [0.22, 1, 0.36, 1];

// Terminal typewriter — lines revealed one by one
const lines = [
    { prompt: '$', cmd: ' kubectl get pod /routes/this-page', delay: 400 },
    { prompt: '',  cmd: 'Error from server (NotFound): pod "/routes/this-page" not found', isErr: true, delay: 900 },
    { prompt: '$', cmd: ' ping ajayupadhyay.dev/this-page', delay: 1600 },
    { prompt: '',  cmd: 'Request timeout for icmp_seq 404 — no route to host', isErr: true, delay: 2100 },
    { prompt: '$', cmd: ' echo "Drifting in the cloud..."', delay: 2900 },
    { prompt: '',  cmd: 'Drifting in the cloud...', isOut: true, delay: 3300 },
    { prompt: '$', cmd: ' _', isCursor: true, delay: 3700 },
];

const visibleLines = ref(0);

onMounted(() => {
    lines.forEach((line, i) => {
        setTimeout(() => { visibleLines.value = i + 1; }, line.delay);
    });
});
</script>

<template>
    <Head title="404 — Page Not Found">
        <meta head-key="description" name="description" content="The page you're looking for doesn't exist." />
    </Head>

    <div
        class="relative min-h-screen overflow-hidden text-white antialiased"
        :class="isDark ? 'bg-ink-950' : 'bg-[#f5f7fa]'"
    >
        <!-- ── Background layer ── -->
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div
                class="absolute inset-0"
                :style="isDark
                    ? 'background: radial-gradient(ellipse at top, rgba(34,211,238,0.07), transparent 50%)'
                    : 'background: radial-gradient(ellipse at top, rgba(99,102,241,0.18), transparent 55%)'"
            ></div>
            <div
                class="absolute inset-0"
                :style="isDark
                    ? 'background: radial-gradient(ellipse at bottom right, rgba(45,212,191,0.05), transparent 60%)'
                    : 'background: radial-gradient(ellipse at bottom right, rgba(14,165,233,0.15), transparent 60%)'"
            ></div>

            <!-- Grid -->
            <svg class="absolute inset-0 h-full w-full" :class="isDark ? 'opacity-[0.06]' : 'opacity-[0.14]'" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid404" width="64" height="64" patternUnits="userSpaceOnUse">
                        <path d="M 64 0 L 0 0 0 64" fill="none" :stroke="isDark ? 'white' : '#4338ca'" stroke-width="1"/>
                    </pattern>
                    <radialGradient id="fade404" cx="50%" cy="40%" r="60%">
                        <stop offset="0%" stop-color="white" stop-opacity="1"/>
                        <stop offset="100%" stop-color="white" stop-opacity="0"/>
                    </radialGradient>
                    <mask id="gridMask404">
                        <rect width="100%" height="100%" fill="url(#fade404)"/>
                    </mask>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid404)" mask="url(#gridMask404)"/>
            </svg>

            <!-- Glow blobs -->
            <div class="absolute -top-40 -left-32 h-[600px] w-[600px] rounded-full blur-[140px]"
                :style="isDark ? 'background: rgba(34,211,238,0.12)' : 'background: rgba(99,102,241,0.32)'"></div>
            <div class="absolute top-[30%] -right-40 h-[500px] w-[500px] rounded-full blur-[130px]"
                :style="isDark ? 'background: rgba(45,212,191,0.09)' : 'background: rgba(139,92,246,0.28)'"></div>
            <div class="absolute top-[65%] left-[15%] h-[420px] w-[420px] rounded-full blur-[140px]"
                :style="isDark ? 'background: rgba(245,158,11,0.06)' : 'background: rgba(6,182,212,0.22)'"></div>

            <!-- Decorative orbital rings (top-right) -->
            <svg class="absolute right-[4%] top-[18%] h-64 w-64 opacity-40" viewBox="0 0 200 200" fill="none"
                :style="{ color: isDark ? 'rgba(34,211,238,0.35)' : 'rgba(67,56,202,0.4)' }">
                <circle cx="100" cy="100" r="90" stroke="currentColor" stroke-width="1" stroke-dasharray="3 6" class="animate-spin-slow"/>
                <circle cx="100" cy="100" r="60" stroke="currentColor" stroke-width="1.2"/>
                <circle cx="100" cy="100" r="30" stroke="currentColor" stroke-width="1" stroke-dasharray="2 4" class="animate-spin-slower-rev"/>
                <circle cx="100" cy="10" r="4" :fill="isDark ? '#22d3ee' : '#4338ca'"/>
                <circle cx="190" cy="100" r="3" :fill="isDark ? '#2dd4bf' : '#7c3aed'"/>
                <circle cx="100" cy="190" r="3" :fill="isDark ? '#f59e0b' : '#0891b2'"/>
                <circle cx="10"  cy="100" r="3" :fill="isDark ? '#22d3ee' : '#4338ca'"/>
            </svg>

            <!-- Hex prism (bottom-left) -->
            <svg class="absolute left-[3%] bottom-[18%] h-56 w-56 opacity-30" viewBox="0 0 200 200" fill="none"
                :style="{ color: isDark ? 'rgba(45,212,191,0.4)' : 'rgba(124,58,237,0.4)' }">
                <path d="M30 50 L100 20 L170 50 L170 150 L100 180 L30 150 Z" stroke="currentColor" stroke-width="1.4"/>
                <path d="M30 50 L100 80 M170 50 L100 80 M100 80 L100 180" stroke="currentColor" stroke-width="1" stroke-dasharray="3 4"/>
                <circle cx="100" cy="80" r="4" :fill="isDark ? '#22d3ee' : '#4338ca'" fill-opacity="0.9"/>
            </svg>
        </div>

        <Header />

        <main class="relative flex flex-col items-center justify-center px-6 py-32 sm:py-40">
            <div class="mx-auto w-full max-w-3xl text-center">

                <!-- Status badge -->
                <motion.div
                    :initial="{ opacity: 0, y: 10 }"
                    :animate="{ opacity: 1, y: 0 }"
                    :transition="{ duration: 0.6, delay: 0.05, ease }"
                    class="inline-flex items-center gap-2.5 rounded-full glass px-4 py-1.5"
                >
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-rose-400 opacity-70"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-rose-400"></span>
                    </span>
                    <span class="font-mono text-[11px] uppercase tracking-[0.18em] text-rose-400/90">exit code · 404</span>
                </motion.div>

                <!-- Glitchy 404 number -->
                <motion.div
                    :initial="{ opacity: 0, scale: 0.88 }"
                    :animate="{ opacity: 1, scale: 1 }"
                    :transition="{ duration: 0.8, delay: 0.15, ease }"
                    class="relative mt-6 select-none"
                >
                    <span class="glitch-404 font-display font-bold leading-none tracking-tighter text-white"
                        style="font-size: clamp(7rem, 22vw, 16rem);"
                        data-text="404"
                    >404</span>
                    <!-- Glow behind the number -->
                    <div class="pointer-events-none absolute inset-0 -z-10 mx-auto blur-[80px] rounded-full"
                        style="background: rgba(34,211,238,0.12); width: 60%; height: 100%; left: 20%;"></div>
                </motion.div>

                <!-- Headline -->
                <motion.h1
                    :initial="{ opacity: 0, y: 18 }"
                    :animate="{ opacity: 1, y: 0 }"
                    :transition="{ duration: 0.8, delay: 0.28, ease }"
                    class="mt-4 font-display text-3xl font-semibold tracking-tight text-white sm:text-4xl"
                >
                    Pod not found<span class="text-gradient-cyan">.</span>
                </motion.h1>

                <motion.p
                    :initial="{ opacity: 0, y: 16 }"
                    :animate="{ opacity: 1, y: 0 }"
                    :transition="{ duration: 0.8, delay: 0.38, ease }"
                    class="mx-auto mt-4 max-w-md text-sm leading-relaxed"
                    :class="isDark ? 'text-white/55' : 'text-slate-500'"
                >
                    The route you requested doesn't exist, got taken offline, or was never deployed.
                    Let's get you back on solid infrastructure.
                </motion.p>

                <!-- Terminal window -->
                <motion.div
                    :initial="{ opacity: 0, y: 24 }"
                    :animate="{ opacity: 1, y: 0 }"
                    :transition="{ duration: 0.85, delay: 0.5, ease }"
                    class="mx-auto mt-10 max-w-xl overflow-hidden rounded-2xl text-left"
                    style="background: rgba(10,14,26,0.9); border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 30px 60px -15px rgba(0,0,0,0.7), 0 0 0 1px rgba(34,211,238,0.05);"
                >
                    <!-- Terminal titlebar -->
                    <div class="flex items-center gap-2 px-4 py-3" style="border-bottom: 1px solid rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);">
                        <span class="h-3 w-3 rounded-full bg-rose-500/80"></span>
                        <span class="h-3 w-3 rounded-full bg-amber-400/80"></span>
                        <span class="h-3 w-3 rounded-full bg-emerald-400/80"></span>
                        <span class="ml-3 font-mono text-[10px] uppercase tracking-[0.15em] text-white/30">bash — ajayupadhyay.dev</span>
                    </div>

                    <!-- Terminal body -->
                    <div class="p-5 font-mono text-[12px] leading-relaxed sm:text-[13px]">
                        <div
                            v-for="(line, i) in lines"
                            :key="i"
                            v-show="visibleLines > i"
                            class="flex gap-2"
                            :class="[
                                i > 0 ? 'mt-1' : '',
                                line.isErr ? 'text-rose-400' : line.isOut ? 'text-emerald-400' : 'text-white/80',
                            ]"
                        >
                            <span v-if="line.prompt" class="flex-shrink-0 text-cyan-400">{{ line.prompt }}</span>
                            <span :class="line.isCursor ? 'terminal-cursor' : ''">{{ line.isCursor ? '' : line.cmd }}</span>
                        </div>
                    </div>
                </motion.div>

                <!-- CTA buttons -->
                <motion.div
                    :initial="{ opacity: 0, y: 14 }"
                    :animate="{ opacity: 1, y: 0 }"
                    :transition="{ duration: 0.8, delay: 0.65, ease }"
                    class="mt-10 flex flex-col items-center justify-center gap-3 sm:flex-row"
                >
                    <Link
                        href="/"
                        class="inline-flex items-center gap-2 rounded-full px-7 py-3 font-mono text-[11px] font-semibold uppercase tracking-[0.14em] text-ink-900 transition"
                        style="background: white; box-shadow: 0 12px 40px -10px rgba(34,211,238,0.4);"
                    >
                        ← Back to home
                    </Link>
                    <Link
                        href="/courses"
                        class="inline-flex items-center gap-2 rounded-full px-7 py-3 font-mono text-[11px] font-semibold uppercase tracking-[0.14em] transition"
                        :class="isDark ? 'glass text-white/80 hover:text-white' : 'bg-white/70 text-slate-700 hover:bg-white'"
                    >
                        Browse courses →
                    </Link>
                </motion.div>

            </div>
        </main>

        <Footer />
    </div>
</template>

<style scoped>
/* ── Glitch animation on "404" ───────────────────────────── */
.glitch-404 {
    position: relative;
    color: white;
}

.glitch-404::before,
.glitch-404::after {
    content: attr(data-text);
    position: absolute;
    inset: 0;
    font: inherit;
    line-height: inherit;
    letter-spacing: inherit;
}

.glitch-404::before {
    color: #22d3ee;
    clip-path: polygon(0 20%, 100% 20%, 100% 40%, 0 40%);
    animation: glitch-top 3.5s infinite linear;
    opacity: 0.7;
}

.glitch-404::after {
    color: #f59e0b;
    clip-path: polygon(0 60%, 100% 60%, 100% 80%, 0 80%);
    animation: glitch-bot 4s infinite linear;
    opacity: 0.6;
}

@keyframes glitch-top {
    0%, 88%   { transform: translate(0, 0);       opacity: 0; }
    90%        { transform: translate(-4px, -2px);  opacity: 0.7; }
    92%        { transform: translate(3px, 0);      opacity: 0.7; }
    94%        { transform: translate(-2px, 1px);   opacity: 0.7; }
    96%        { transform: translate(0, 0);        opacity: 0.7; }
    98%        { transform: translate(4px, -1px);   opacity: 0.7; }
    100%       { transform: translate(0, 0);        opacity: 0; }
}

@keyframes glitch-bot {
    0%, 82%   { transform: translate(0, 0);      opacity: 0; }
    85%        { transform: translate(5px, 2px);  opacity: 0.6; }
    87%        { transform: translate(-3px, 0);   opacity: 0.6; }
    90%        { transform: translate(2px, -1px); opacity: 0.6; }
    93%        { transform: translate(-4px, 1px); opacity: 0.6; }
    96%        { transform: translate(0, 0);      opacity: 0.6; }
    100%       { transform: translate(0, 0);      opacity: 0; }
}

/* ── Blinking terminal cursor ─────────────────────────── */
.terminal-cursor::after {
    content: '█';
    color: #22d3ee;
    animation: blink 1.1s step-end infinite;
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50%      { opacity: 0; }
}

/* ── Slow orbital spin ────────────────────────────────── */
.animate-spin-slow {
    animation: spin 24s linear infinite;
    transform-origin: 100px 100px;
}

.animate-spin-slower-rev {
    animation: spin-rev 18s linear infinite;
    transform-origin: 100px 100px;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
}

@keyframes spin-rev {
    from { transform: rotate(0deg); }
    to   { transform: rotate(-360deg); }
}
</style>
