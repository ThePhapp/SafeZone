@props([
    'locations' => [],
    'zoom' => 10,
    'markerType' => 'default',
])


<div class="relative w-full h-full">
    <div id="map" class="w-full h-full rounded-lg overflow-hidden shadow"></div>
</div>

    
<script>


    let mapLocationsData = @json($locations);
    const markerType = @json($markerType);
    const center = mapLocationsData.length > 0 
        ? [mapLocationsData[0].longitude, mapLocationsData[0].latitude]
        : [105.8342, 21.0278]; 

    // ==============================
    // Khởi tạo bản đồ
    // ==============================
    const map = new maplibregl.Map({
        container: 'map',
        style: `https://api.maptiler.com/maps/streets/style.json?key=${MAPTILER_KEY}`,
        center: center,
        zoom: {{ $zoom }}
    });

    map.addControl(new maplibregl.NavigationControl(), 'top-right');

    // ==============================
    // Hiển thị các markers
    // ==============================
    mapLocationsData.forEach(location => {

        let markerColor = '#e63946';
        let markerPopup = `<strong>${location.formatted_address}</strong>`;

        switch (markerType) {
            // case 'warehouse':
            //     markerColor = '#1d4ed8'; // xanh dương
            //     markerPopup = `<strong>Warehouse:</strong> ${location.formatted_address}`;
            //     break;
            // case 'user':
            //     markerColor = '#22c55e'; // xanh lá
            //     markerPopup = `<strong>User Address:</strong> ${location.formatted_address}`;
            //     break;
            // case 'address':
            //     markerColor = '#f59e0b'; // vàng
            //     markerPopup = `<strong>Delivery Point:</strong> ${location.formatted_address}`;
            //     break;
            default:
                markerColor = '#e63946';
        }

        const marker = new maplibregl.Marker({ color: markerColor })
            .setLngLat([location.longitude, location.latitude])
            .setPopup(new maplibregl.Popup({ offset: 25 }).setHTML(markerPopup))
            .addTo(map);
    });


    // ==============================
    // Tự động fit bản đồ để hiển thị tất cả các điểm
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
