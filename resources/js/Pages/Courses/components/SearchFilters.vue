<script setup>
defineProps({
    search:         { type: String,  required: true },
    activeCategory: { type: String,  required: true },
    activeLevel:    { type: String,  required: true },
    categories:     { type: Array,   required: true },
    levels:         { type: Array,   required: true },
    resultCount:    { type: Number,  required: true },
    totalCount:     { type: Number,  required: true },
    hasActiveFilter:{ type: Boolean, required: true },
});

const emit = defineEmits([
    'update:search',
    'update:activeCategory',
    'update:activeLevel',
    'reset',
]);
</script>

<template>
    <div class="flex flex-col gap-3">

        <!-- Search bar -->
        <div class="relative">
            <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-white/35"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input
                :value="search"
                @input="emit('update:search', $event.target.value)"
                type="search"
                placeholder="Search by name, tag or keyword…"
                class="w-full glass rounded-xl py-3 pl-10 pr-10 text-sm text-white placeholder:text-white/35 focus:outline-none focus:border-cyan-300/40 transition"
            />
            <button
                v-if="search"
                @click="emit('update:search', '')"
                class="absolute right-3 top-1/2 -translate-y-1/2 grid h-5 w-5 place-items-center rounded-full bg-white/10 text-white/50 transition hover:bg-white/20 hover:text-white"
                aria-label="Clear search"
            >
                <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <path d="M6 6l12 12M18 6L6 18"/>
                </svg>
            </button>
        </div>

        <!-- Filter row -->
        <div class="flex flex-wrap items-center gap-2">

            <!-- Category pills -->
            <div class="flex items-center gap-0.5 rounded-xl glass p-1">
                <button
                    v-for="cat in categories"
                    :key="cat"
                    @click="emit('update:activeCategory', cat)"
                    class="rounded-lg px-3 py-1.5 font-mono text-[10px] uppercase tracking-[0.14em] transition-all duration-200"
                    :class="activeCategory === cat
                        ? 'bg-cyan-400/20 text-cyan-300'
                        : 'text-white/45 hover:text-white/75'"
                >
                    {{ cat }}
                </button>
            </div>

            <!-- Level pills -->
            <div class="flex items-center gap-0.5 rounded-xl glass p-1">
                <button
                    v-for="lvl in levels"
                    :key="lvl"
                    @click="emit('update:activeLevel', lvl)"
                    class="rounded-lg px-3 py-1.5 font-mono text-[10px] uppercase tracking-[0.14em] transition-all duration-200"
                    :class="activeLevel === lvl
                        ? 'bg-amber-400/20 text-amber-300'
                        : 'text-white/45 hover:text-white/75'"
                >
                    {{ lvl }}
                </button>
            </div>

            <!-- Result count + reset -->
            <div class="ml-auto flex items-center gap-3">
                <button
                    v-if="hasActiveFilter"
                    @click="emit('reset')"
                    class="font-mono text-[10px] uppercase tracking-[0.15em] text-white/40 transition hover:text-white/70 underline underline-offset-2"
                >
                    Clear
                </button>
                <span class="font-mono text-[10px] uppercase tracking-[0.18em] text-white/35">
                    {{ resultCount }}<span class="text-white/20"> / {{ totalCount }}</span>
                </span>
            </div>
        </div>

    </div>
</template>
