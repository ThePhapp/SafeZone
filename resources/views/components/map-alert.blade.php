<div class="relative w-full h-full">
    <div id="map" class="w-full h-full rounded-lg overflow-hidden shadow"></div>
</div>

<script>
    let alerts = @json($alerts->resolve());
    console.log(alerts);

    const center = alerts.length > 0 
        ? [alerts[0].address.longitude, alerts[0].address.latitude]
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

    let base = '{{ asset("images") }}';

    // ==============================
    // Hiển thị các markers
    // ==============================
    alerts.forEach(alert => {
        let iconUrl = `${base}/marker-default.png`;

        if (alert.type === 'flood') {
            if (alert.severity === 'high') iconUrl = `${base}/flood-orange.png`;
            else if (alert.severity === 'medium') iconUrl = `${base}/flood-yellow.png`;
            else if (alert.severity === 'low') iconUrl = `${base}/flood-blue.png`;
            else if (alert.severity === 'critical') iconUrl = `${base}/flood-red.png`;
        }

        if (alert.type === 'fire') {
            if (alert.severity === 'high') iconUrl = `${base}/fire-orange.png`;
            else if (alert.severity === 'medium') iconUrl = `${base}/fire-yellow.png`;
            else if (alert.severity === 'low') iconUrl = `${base}/fire-blue.png`;
            else if (alert.severity === 'critical') iconUrl = `${base}/fire-red.png`;
        }

        if (alert.type === 'earthquake') {
            if (alert.severity === 'high') iconUrl = `${base}/earthquake-orange.png`;
            else if (alert.severity === 'medium') iconUrl = `${base}/earthquake-yellow.png`;
            else if (alert.severity === 'low') iconUrl = `${base}/earthquake-blue.png`;
            else if (alert.severity === 'critical') iconUrl = `${base}/earthquake-red.png`;
        }

        if (alert.type === 'storm') {
            if (alert.severity === 'high') iconUrl = `${base}/storm-orange.png`;
            else if (alert.severity === 'medium') iconUrl = `${base}/storm-yellow.png`;
            else if (alert.severity === 'low') iconUrl = `${base}/storm-blue.png`;
            else if (alert.severity === 'critical') iconUrl = `${base}/storm-red.png`;
        }

        const el = document.createElement('div');
    el.style.width = '60px';
    el.style.height = '60px';
    el.style.backgroundImage = `url(${iconUrl})`;
    el.style.backgroundSize = 'contain';
    el.style.backgroundRepeat = 'no-repeat';
    el.style.backgroundPosition = 'center';
    el.style.display = 'block';
    el.style.cursor = 'pointer';

    const lng = parseFloat(alert.address.longitude);
    const lat = parseFloat(alert.address.latitude);

    new maplibregl.Marker({ element: el })
        .setLngLat([lng, lat])
        .setPopup(
            new maplibregl.Popup({ offset: 25 })
                .setHTML(`<strong>${alert.title}</strong><br>${alert.address.formatted_address}`)
        )
        .addTo(map);

    // =============== Vẽ vùng cảnh báo ===============

    let radius = 500;
    if (alert.severity === 'medium') radius = 800;
    else if (alert.severity === 'high') radius = 1500;
    else if (alert.severity === 'critical') radius = 2500;

    const circle = turf.circle([lng, lat], radius / 1000, { steps: 64, units: 'kilometers' });

    const sourceId = `alert-circle-${alert.id}`;
    const layerId = `alert-circle-layer-${alert.id}`;

    map.on('load', () => {
        if (!map.getSource(sourceId)) {
            map.addSource(sourceId, {
                type: 'geojson',
                data: circle
            });

            map.addLayer({
                id: layerId,
                type: 'fill',
                source: sourceId,
                layout: {},
                paint: {
                    'fill-color': getColorBySeverity(alert.severity),
                    'fill-opacity': 0.25
                }
            });

            map.addLayer({
                id: `${layerId}-outline`,
                type: 'line',
                source: sourceId,
                paint: {
                    'line-color': getColorBySeverity(alert.severity),
                    'line-width': 2,
                    'line-opacity': 0.6
                }
            });
        }
    });
});


function getColorBySeverity(severity) {
    switch (severity) {
        case 'low': return '#00BFFF';      // xanh dương nhạt
        case 'medium': return '#FFD700';   // vàng
        case 'high': return '#FFA500';     // cam
        case 'critical': return '#FF0000'; // đỏ
        default: return '#808080';
    }
}
</script>
