
@props([
    'locations' => [],
    'zoom' => 10,
    'markerType' => 'default',
])

<div class="relative w-full h-full">
    <div id="map" class="w-full h-full rounded-lg overflow-hidden shadow"></div>
</div>

<script>
    // ==============================
    // DỮ LIỆU MARKER
    // ==============================
    const mapLocationsData = @json($locations);
    const markerType = @json($markerType);
    const center = mapLocationsData.length > 0 
        ? [mapLocationsData[0].longitude, mapLocationsData[0].latitude]
        : [105.8342, 21.0278]; 

    // ==============================
    // KHỞI TẠO BẢN ĐỒ
    // ==============================
    const map = new maplibregl.Map({
        container: 'map',
        style: `https://api.maptiler.com/maps/streets/style.json?key=${MAPTILER_KEY}`,
        center: center,
        zoom: {{ $zoom }}
    });

    map.addControl(new maplibregl.NavigationControl(), 'top-right');

    // ==============================
    // HIỂN THỊ MARKERS
    // ==============================
    mapLocationsData.forEach(location => {
        let markerColor = '#e63946';
        let markerPopup = `<strong>${location.formatted_address}</strong>`;

        const marker = new maplibregl.Marker({ color: markerColor })
            .setLngLat([location.longitude, location.latitude])
            .setPopup(new maplibregl.Popup({ offset: 25 }).setHTML(markerPopup))
            .addTo(map);
    });

    // ==============================
    // FIT BẢN ĐỒ CHO TẤT CẢ ĐIỂM
    // ==============================
    if (mapLocationsData.length > 1) {
        const bounds = new maplibregl.LngLatBounds();
        mapLocationsData.forEach(loc => bounds.extend([loc.longitude, loc.latitude]));
        map.fitBounds(bounds, { padding: 80 });
    }

    map.dragPan.enable();
    map.scrollZoom.enable();
    map.boxZoom.enable();
    map.keyboard.enable();


</script>

