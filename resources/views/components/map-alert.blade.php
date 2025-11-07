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
        let iconUrl = `${base}/logo.png`;

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

        const imageUrl = alert.image_path 
            ? `{{ asset('storage') }}/${alert.image_path}` 
            : `${base}/no-image.png`;

        const detailUrl = `/admin/alerts/${alert.id}`;
        new maplibregl.Marker({ element: el })
            .setLngLat([lng, lat])
            .setPopup(
                new maplibregl.Popup({ offset: 25 })
                    .setHTML(`
                        <div style="max-width: 250px;">
                            <h3 style="font-weight: 600; margin-bottom: 6px;">${alert.title}</h3>
                            <img src="${imageUrl}" alt="Alert Image" style="width: 100%; height: 130px; object-fit: cover; border-radius: 6px; margin-bottom: 6px;">
                            <p style="margin: 0;"><strong>Loại:</strong> ${alert.type}</p>
                            <p style="margin: 0;"><strong>Mức độ:</strong> ${alert.severity}</p>
                            <p style="margin: 0;"><strong>Bán kính:</strong> ${alert.radius ? alert.radius + ' m' : '500 m'}</p>
                            <p style="margin: 0;"><strong>Địa chỉ:</strong> ${alert.address.formatted_address}</p>
                            <div style="margin-top: 8px; text-align: center;">
                                <a href="${detailUrl}" 
                                    style="display: inline-block; background-color: #2563eb; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none;">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    `)
            )
            .addTo(map);

        // =============== Vẽ vùng cảnh báo ===============

        let radius = alert.radius ? parseFloat(alert.radius) : 500;

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
            default: return '#808080';         // xám
        }
    }

    // ==============================
    // Sau khi thêm tất cả markers
    // ==============================
    if (alerts.length > 0) {
        const bounds = new maplibregl.LngLatBounds();

        alerts.forEach(alert => {
            const lng = parseFloat(alert.address.longitude);
            const lat = parseFloat(alert.address.latitude);
            bounds.extend([lng, lat]);
        });

        map.fitBounds(bounds, {
            padding: 100,
            maxZoom: 13,
            duration: 1000
        });
    }

</script>
