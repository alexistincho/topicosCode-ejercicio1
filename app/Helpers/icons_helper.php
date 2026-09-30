<?php

/**
 * Iconos SVG en linea, monocromaticos (heredan color del texto).
 * Mantiene la interfaz minimalista sin depender de librerias externas.
 */

if (! function_exists('mc_icon')) {
    function mc_icon(string $name): string
    {
        $icons = [
            'car' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M3 13l1.5-4.5A2 2 0 0 1 6.4 7h11.2a2 2 0 0 1 1.9 1.5L21 13"/><rect x="2.5" y="13" width="19" height="5.5" rx="1.5"/><circle cx="7" cy="18.5" r="1.5"/><circle cx="17" cy="18.5" r="1.5"/></svg>',
            'dashboard' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>',
            'plus' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 5v14M5 12h14"/></svg>',
            'list' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>',
            'users' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="9" cy="8" r="3.2"/><path d="M2.5 19c0-3 3-5.2 6.5-5.2s6.5 2.2 6.5 5.2"/><circle cx="17.3" cy="9" r="2.6"/><path d="M15.8 13.6c2.7.3 4.7 2.2 4.7 4.5"/></svg>',
            'key' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="8" cy="15.5" r="4"/><path d="M11 12.5 19 4.5M16 6.5l2.5 2.5M13.2 9.3l2.2 2.2"/></svg>',
            'logout' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5M21 12H9"/></svg>',
            'check' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 6 9 17l-5-5"/></svg>',
            'x' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 6 6 18M6 6l12 12"/></svg>',
            'arrow-left' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>',
            'calendar' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>',
            'edit' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 20h4L20 8l-4-4L4 16v4Z"/><path d="M13.5 6.5l4 4"/></svg>',
            'trash' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 7h16M9 7V4.5A1.5 1.5 0 0 1 10.5 3h3A1.5 1.5 0 0 1 15 4.5V7M6 7l1 13a1.5 1.5 0 0 0 1.5 1.4h7a1.5 1.5 0 0 0 1.5-1.4l1-13"/></svg>',
            'rotate' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M3 12a9 9 0 1 0 3-6.7"/><path d="M3 3v5h5"/></svg>',
            'inbox' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M3 12h4l2 3h6l2-3h4"/><path d="M5 5h14l2 7v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-6l2-7Z"/></svg>',
            'search' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>',
        ];

        return $icons[$name] ?? '';
    }
}
