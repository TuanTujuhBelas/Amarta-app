<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

@fonts

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance

{{--
    CSS fallback untuk utility Tailwind yang mungkin tidak ter-compile oleh JIT (karena class
    baru ditambahkan setelah build terakhir). HAPUS blok ini setelah `npm run build`
    berhasil dijalankan (Node >= 20) — JIT akan generate otomatis dari scan template.
--}}
<style>
    /* ===== Text wrapping & truncation ===== */
    .break-words { overflow-wrap: break-word; word-wrap: break-word; }
    .break-all { word-break: break-all; }
    .line-clamp-2 { display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden; }
    .line-clamp-none { -webkit-line-clamp: unset; }

    /* ===== Focus / state rings ===== */
    .ring-4 { box-shadow: 0 0 0 4px var(--tw-ring-color, rgba(255,255,255,0.25)); }

    /* ===== Group state variants for <details> ===== */
    details.group[open] > summary .group-open\:rotate-180 { transform: rotate(180deg); }
    details.group[open] > summary .group-open\:line-clamp-none,
    details.group[open] .group-open\:line-clamp-none { -webkit-line-clamp: unset; }

    /* ===== Responsive display utilities (md & lg) ===== */
    @media (min-width: 48rem) {
        .md\:block { display: block; }
        .md\:inline-block { display: inline-block; }
        .md\:inline-flex { display: inline-flex; }
        .md\:flex { display: flex; }
        .md\:grid { display: grid; }
        .md\:hidden { display: none; }
        .md\:items-center { align-items: center; }
    }
    @media (min-width: 64rem) {
        .lg\:block { display: block; }
        .lg\:inline-block { display: inline-block; }
        .lg\:inline-flex { display: inline-flex; }
        .lg\:flex { display: flex; }
        .lg\:grid { display: grid; }
        .lg\:hidden { display: none; }
    }

    /* ===== Responsive text sizes di breakpoint sm ===== */
    @media (min-width: 40rem) {
        .sm\:text-xs { font-size: .75rem; line-height: 1rem; }
        .sm\:text-sm { font-size: .875rem; line-height: 1.25rem; }
        .sm\:text-base { font-size: 1rem; line-height: 1.5rem; }
        .sm\:text-lg { font-size: 1.125rem; line-height: 1.75rem; }
        .sm\:text-xl { font-size: 1.25rem; line-height: 1.75rem; }
        .sm\:text-2xl { font-size: 1.5rem; line-height: 2rem; }
        .sm\:text-\[11px\] { font-size: 11px; }
        .sm\:text-\[10px\] { font-size: 10px; }

        .sm\:inline { display: inline; }
        .sm\:inline-flex { display: inline-flex; }
        .sm\:flex { display: flex; }
        .sm\:flex-row { flex-direction: row; }
        .sm\:items-start { align-items: flex-start; }
        .sm\:items-center { align-items: center; }

        .sm\:p-5 { padding: 1.25rem; }
        .sm\:p-6 { padding: 1.5rem; }
        .sm\:p-8 { padding: 2rem; }
        .sm\:px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }

        .sm\:gap-4 { gap: 1rem; }
        .sm\:gap-6 { gap: 1.5rem; }

        .sm\:size-16 { width: 4rem; height: 4rem; }
        .sm\:w-32 { width: 8rem; }
        .sm\:h-44 { height: 11rem; }
        .sm\:w-72 { width: 18rem; }
        .sm\:order-first { order: -9999; }
    }
</style>
