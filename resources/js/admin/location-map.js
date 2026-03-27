/**
 * Admin — Location Map Module
 * Nominatim geocoding autocomplete + Leaflet interactive map
 * Rules: no alert/confirm, CSRF on all POST, XSS-safe DOM, debounced input,
 *        aria-busy loading state, icon-in-input with proper padding gap.
 */
(function () {
    'use strict';

    // ── Configuration ────────────────────────────────────────────────────────
    const NOMINATIM_URL  = 'https://nominatim.openstreetmap.org/search';
    const DEBOUNCE_MS    = 350;
    const MIN_QUERY_LEN  = 3;
    const RESULT_LIMIT   = 6;
    const DEFAULT_ZOOM   = 10;
    const DEFAULT_LAT    = 40.4093;   // Azerbaijan centre
    const DEFAULT_LNG    = 49.8671;

    // ── DOM refs ─────────────────────────────────────────────────────────────
    const searchInput   = document.getElementById('mapSearchInput');
    const suggestBox    = document.getElementById('mapSuggestions');
    const latInput      = document.getElementById('lat_input');
    const lngInput      = document.getElementById('lng_input');
    const mapContainer  = document.getElementById('locationMapContainer');
    const mapHint       = document.getElementById('mapHint');

    // Guard: only run on location pages
    if (!searchInput || !suggestBox || !latInput || !lngInput || !mapContainer) return;

    // ── State ────────────────────────────────────────────────────────────────
    let debounceTimer = null;
    let leafletMap    = null;
    let marker        = null;

    // ── Helpers ──────────────────────────────────────────────────────────────

    /** XSS-safe: create element with textContent */
    function el(tag, attrs, text) {
        const node = document.createElement(tag);
        Object.entries(attrs || {}).forEach(([k, v]) => {
            if (k === 'class') node.className = v;
            else node.setAttribute(k, v);
        });
        if (text !== undefined) node.textContent = text;
        return node;
    }

    function setLoading(active) {
        searchInput.setAttribute('aria-busy', active ? 'true' : 'false');
        searchInput.style.opacity = active ? '0.7' : '1';
    }

    function closeSuggestions() {
        suggestBox.innerHTML = '';
        suggestBox.classList.add('hidden');
    }

    function showHint() {
        if (mapHint) mapHint.classList.remove('hidden');
    }

    // ── Leaflet map ──────────────────────────────────────────────────────────

    function initMap(lat, lng) {
        if (typeof L === 'undefined') return;

        mapContainer.classList.remove('hidden');

        if (leafletMap) {
            leafletMap.setView([lat, lng], DEFAULT_ZOOM);
            moveMarker(lat, lng);
            return;
        }

        leafletMap = L.map(mapContainer, { zoomControl: true }).setView([lat, lng], DEFAULT_ZOOM);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            maxZoom: 19,
        }).addTo(leafletMap);

        marker = L.marker([lat, lng], { draggable: true }).addTo(leafletMap);

        // Drag end → update inputs
        marker.on('dragend', function () {
            const pos = marker.getLatLng();
            fillCoords(pos.lat.toFixed(6), pos.lng.toFixed(6), false);
        });

        // Map click → move marker + update inputs
        leafletMap.on('click', function (e) {
            const pos = e.latlng;
            moveMarker(pos.lat, pos.lng);
            fillCoords(pos.lat.toFixed(6), pos.lng.toFixed(6), false);
        });

        showHint();
    }

    function moveMarker(lat, lng) {
        if (!marker) return;
        marker.setLatLng([lat, lng]);
    }

    // ── Fill coordinates ─────────────────────────────────────────────────────

    function fillCoords(lat, lng, flyTo) {
        latInput.value = lat;
        lngInput.value = lng;

        // Visual feedback: brief green ring on inputs
        [latInput, lngInput].forEach(function (inp) {
            inp.classList.add('ring-2', 'ring-green-400');
            setTimeout(function () {
                inp.classList.remove('ring-2', 'ring-green-400');
            }, 1800);
        });

        if (flyTo && leafletMap) {
            leafletMap.flyTo([lat, lng], DEFAULT_ZOOM, { animate: true, duration: 0.8 });
            moveMarker(lat, lng);
        }
    }

    // ── Suggestions dropdown ─────────────────────────────────────────────────

    function renderSuggestions(results) {
        closeSuggestions();

        if (!results.length) {
            const empty = el('div', { class: 'px-3 py-2.5 text-xs text-gray-400 italic' },
                window.__t?.['message.no_results'] ?? 'No results');
            suggestBox.appendChild(empty);
            suggestBox.classList.remove('hidden');
            return;
        }

        results.forEach(function (place) {
            const item = el('div', {
                class: 'flex items-start gap-2 px-3 py-2 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-0 transition',
                role: 'option',
                tabindex: '0',
            });

            // Icon
            const icon = el('i', { class: 'fas fa-map-marker-alt text-green-500 mt-0.5 shrink-0 text-xs' });

            // Text column
            const textCol = el('div', { class: 'flex-1 min-w-0' });
            const name    = el('p', { class: 'text-xs text-gray-800 font-medium truncate' },
                place.display_name.split(',').slice(0, 2).join(', '));
            const coords  = el('p', { class: 'text-xs text-gray-400 mt-0.5' },
                parseFloat(place.lat).toFixed(4) + ', ' + parseFloat(place.lon).toFixed(4));
            textCol.appendChild(name);
            textCol.appendChild(coords);

            item.appendChild(icon);
            item.appendChild(textCol);

            // Click or keyboard
            function select() {
                const lat = parseFloat(place.lat).toFixed(6);
                const lng = parseFloat(place.lon).toFixed(6);
                initMap(parseFloat(lat), parseFloat(lng));
                fillCoords(lat, lng, true);
                searchInput.value = place.display_name.split(',').slice(0, 2).join(', ');
                closeSuggestions();
            }

            item.addEventListener('click', select);
            item.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); select(); }
            });

            suggestBox.appendChild(item);
        });

        suggestBox.classList.remove('hidden');
    }

    // ── Nominatim fetch ──────────────────────────────────────────────────────

    async function fetchSuggestions(query) {
        setLoading(true);
        try {
            const url = NOMINATIM_URL
                + '?format=json'
                + '&q=' + encodeURIComponent(query)
                + '&limit=' + RESULT_LIMIT
                + '&addressdetails=1';

            const res = await fetch(url, {
                headers: { 'Accept-Language': document.documentElement.lang || 'az,en' },
            });

            if (!res.ok) throw new Error('HTTP ' + res.status);
            const data = await res.json();
            renderSuggestions(data);
        } catch (_) {
            closeSuggestions();
        } finally {
            setLoading(false);
        }
    }

    // ── Input event ──────────────────────────────────────────────────────────

    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        const query = this.value.trim();

        if (query.length < MIN_QUERY_LEN) { closeSuggestions(); return; }

        debounceTimer = setTimeout(function () {
            fetchSuggestions(query);
        }, DEBOUNCE_MS);
    });

    // Close on outside click
    document.addEventListener('click', function (e) {
        if (!e.target.closest('#mapSearchWrapper')) closeSuggestions();
    });

    // Keyboard: Escape closes
    searchInput.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeSuggestions();
    });

    // ── Init with existing coordinates (edit page) ───────────────────────────

    const existingLat = parseFloat(latInput.value);
    const existingLng = parseFloat(lngInput.value);

    if (!isNaN(existingLat) && !isNaN(existingLng) && existingLat !== 0 && existingLng !== 0) {
        // Defer so Leaflet CSS is ready
        setTimeout(function () {
            initMap(existingLat, existingLng);
        }, 100);
    }

})();
