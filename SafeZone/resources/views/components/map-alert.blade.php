    <style>
        /* Remove default MapLibre popup styling */
        .maplibregl-popup-content {
            background: transparent !important;
            padding: 0 !important;
            box-shadow: none !important;
            border-radius: 0 !important;
        }
        
        .maplibregl-popup-tip {
            display: none !important;
        }
        
        .custom-popup .maplibregl-popup-content {
            max-width: none !important;
        }
        
        .maplibregl-popup-close-button {
            color: #fff !important;
            font-size: 20px !important;
            padding: 4px 8px !important;
            right: 4px !important;
            top: 4px !important;
            z-index: 10 !important;
            background: rgba(0, 0, 0, 0.5) !important;
            border-radius: 4px !important;
            width: 24px !important;
            height: 24px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        .maplibregl-popup-close-button:hover {
            background: rgba(0, 0, 0, 0.7) !important;
        }
    </style>

    <div class="relative w-full h-full">
        <div id="map" class="w-full h-full rounded-lg overflow-hidden shadow"></div>
    </div>

    <script>
    let alerts = @json($alerts->resolve());
    console.log(alerts);
    let userAddresses = @json($userAddresses);

    const center = alerts.length > 0 
        ? [alerts[0].address.longitude, alerts[0].address.latitude]
        : [105.8342, 21.0278];

    // ==============================
    // Initialize map
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
    // Display markers
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
            : `{{ asset('images') }}/${alert.image_path}`;

        const detailUrl = {{ $isAdmin ? '`/admin/alerts/${alert.id}`' : '`/alerts/${alert.id}`' }};
        new maplibregl.Marker({ element: el })
            .setLngLat([lng, lat])
            .setPopup(
                new maplibregl.Popup({ offset: 25, className: 'custom-popup' })
                    .setHTML(`
                        <div style="max-width: 280px; background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-radius: 12px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
                            <!-- Image -->
                            <div style="position: relative; width: 100%; height: 140px; overflow: hidden;">
                                <img src="${imageUrl}" alt="Alert Image" style="width: 100%; height: 100%; object-fit: cover;">
                                <div style="position: absolute; top: 8px; right: 8px; padding: 4px 10px; border-radius: 6px; font-size: 10px; font-weight: 700; text-transform: uppercase; backdrop-filter: blur(8px);
                                    ${alert.severity === 'critical' ? 'background: rgba(239, 68, 68, 0.9); color: #fff;' : 
                                      alert.severity === 'high' ? 'background: rgba(249, 115, 22, 0.9); color: #fff;' : 
                                      alert.severity === 'medium' ? 'background: rgba(234, 179, 8, 0.9); color: #fff;' : 
                                      'background: rgba(6, 182, 212, 0.9); color: #fff;'}">
                                    ${alert.severity}
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div style="padding: 12px;">
                                <h3 style="font-size: 15px; font-weight: 700; color: #f1f5f9; margin: 0 0 8px 0; line-height: 1.3;">${alert.title}</h3>
                                
                                <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 8px;">
                                    <span style="display: inline-flex; align-items: center; gap: 4px; font-size: 11px; color: #94a3b8; background: rgba(51, 65, 85, 0.5); padding: 3px 8px; border-radius: 4px;">
                                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                        ${alert.type}
                                    </span>
                                    <span style="display: inline-flex; align-items: center; gap: 4px; font-size: 11px; color: #94a3b8; background: rgba(51, 65, 85, 0.5); padding: 3px 8px; border-radius: 4px;">
                                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                        ${alert.radius || '500'} m
                                    </span>
                                </div>
                                
                                <p style="font-size: 11px; color: #cbd5e1; margin: 0 0 10px 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    ${alert.address.formatted_address}
                                </p>
                                
                                <a href="${detailUrl}" 
                                    style="display: block; text-align: center; background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 600; transition: all 0.2s; box-shadow: 0 2px 8px rgba(6, 182, 212, 0.3);">
                                    View Details →
                                </a>
                            </div>
                        </div>
                    `)
            )
            .addTo(map);

        // =============== Draw alert zone ===============

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

    // ==============================
    // Display user location
    // ==============================
    if (userAddresses && userAddresses.length > 0) {
        userAddresses.forEach(addr => {
            let markerColor = '#e63946';
            let markerPopup = `<strong>${addr.formatted_address}</strong>`;

            const marker = new maplibregl.Marker({ color: markerColor })
                .setLngLat([addr.longitude, addr.latitude])
                .setPopup(new maplibregl.Popup({ offset: 25 }).setHTML(markerPopup))
                .addTo(map);
        });
    }


    function getColorBySeverity(severity) {
        switch (severity) {
            case 'low': return '#00BFFF';      // light blue
            case 'medium': return '#FFD700';   // yellow
            case 'high': return '#FFA500';     // orange
            case 'critical': return '#FF0000'; // red
            default: return '#808080';         // gray
        }
    }

    // ==============================
    // After adding all markers
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

    // ==============================
    // Function to add new alert to map (Realtime)
    // ==============================
    function addAlertToMap(alert) {
        console.log("🗺️ Adding new alert to map:", alert);
        if (!alert.address) return;

        const lng = parseFloat(alert.address.longitude);
        const lat = parseFloat(alert.address.latitude);
        const base = '{{ asset("images") }}';

        // === Select icon similar to old logic ===
        let iconUrl = `${base}/logo.png`;

        if (alert.type === 'flood') {
            if (alert.severity === 'high') iconUrl = `${base}/flood-orange.png`;
            else if (alert.severity === 'medium') iconUrl = `${base}/flood-yellow.png`;
            else if (alert.severity === 'low') iconUrl = `${base}/flood-blue.png`;
            else if (alert.severity === 'critical') iconUrl = `${base}/flood-red.png`;
        } else if (alert.type === 'fire') {
            if (alert.severity === 'high') iconUrl = `${base}/fire-orange.png`;
            else if (alert.severity === 'medium') iconUrl = `${base}/fire-yellow.png`;
            else if (alert.severity === 'low') iconUrl = `${base}/fire-blue.png`;
            else if (alert.severity === 'critical') iconUrl = `${base}/fire-red.png`;
        } else if (alert.type === 'storm') {
            if (alert.severity === 'high') iconUrl = `${base}/storm-orange.png`;
            else if (alert.severity === 'medium') iconUrl = `${base}/storm-yellow.png`;
            else if (alert.severity === 'low') iconUrl = `${base}/storm-blue.png`;
            else if (alert.severity === 'critical') iconUrl = `${base}/storm-red.png`;
        } else if (alert.type === 'earthquake') {
            if (alert.severity === 'high') iconUrl = `${base}/earthquake-orange.png`;
            else if (alert.severity === 'medium') iconUrl = `${base}/earthquake-yellow.png`;
            else if (alert.severity === 'low') iconUrl = `${base}/earthquake-blue.png`;
            else if (alert.severity === 'critical') iconUrl = `${base}/earthquake-red.png`;
        }

        const el = document.createElement('div');
        el.style.width = '60px';
        el.style.height = '60px';
        el.style.backgroundImage = `url(${iconUrl})`;
        el.style.backgroundSize = 'contain';
        el.style.backgroundRepeat = 'no-repeat';
        el.style.backgroundPosition = 'center';
        el.style.cursor = 'pointer';

        const imageUrl = alert.image_path 
            ? `{{ asset('storage') }}/${alert.image_path}` 
            : `{{ asset('images') }}/${alert.image_path}`;

        const detailUrl = {{ $isAdmin ? '`/admin/alerts/${alert.id}`' : '`/alerts/${alert.id}`' }};

        // === Create new marker ===
        new maplibregl.Marker({ element: el })
            .setLngLat([lng, lat])
            .setPopup(
                new maplibregl.Popup({ offset: 25, className: 'custom-popup' })
                    .setHTML(`
                        <div style="max-width: 280px; background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-radius: 12px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
                            <!-- Image -->
                            <div style="position: relative; width: 100%; height: 140px; overflow: hidden;">
                                <img src="${imageUrl}" alt="Alert Image" style="width: 100%; height: 100%; object-fit: cover;">
                                <div style="position: absolute; top: 8px; right: 8px; padding: 4px 10px; border-radius: 6px; font-size: 10px; font-weight: 700; text-transform: uppercase; backdrop-filter: blur(8px);
                                    ${alert.severity === 'critical' ? 'background: rgba(239, 68, 68, 0.9); color: #fff;' : 
                                      alert.severity === 'high' ? 'background: rgba(249, 115, 22, 0.9); color: #fff;' : 
                                      alert.severity === 'medium' ? 'background: rgba(234, 179, 8, 0.9); color: #fff;' : 
                                      'background: rgba(6, 182, 212, 0.9); color: #fff;'}">
                                    ${alert.severity}
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div style="padding: 12px;">
                                <h3 style="font-size: 15px; font-weight: 700; color: #f1f5f9; margin: 0 0 8px 0; line-height: 1.3;">${alert.title}</h3>
                                
                                <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 8px;">
                                    <span style="display: inline-flex; align-items: center; gap: 4px; font-size: 11px; color: #94a3b8; background: rgba(51, 65, 85, 0.5); padding: 3px 8px; border-radius: 4px;">
                                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                        ${alert.type}
                                    </span>
                                    <span style="display: inline-flex; align-items: center; gap: 4px; font-size: 11px; color: #94a3b8; background: rgba(51, 65, 85, 0.5); padding: 3px 8px; border-radius: 4px;">
                                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                        ${alert.radius || '500'} m
                                    </span>
                                </div>
                                
                                <p style="font-size: 11px; color: #cbd5e1; margin: 0 0 10px 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    ${alert.address.formatted_address}
                                </p>
                                
                                <a href="${detailUrl}" 
                                    style="display: block; text-align: center; background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 600; transition: all 0.2s; box-shadow: 0 2px 8px rgba(6, 182, 212, 0.3);">
                                    View Details →
                                </a>
                            </div>
                        </div>
                    `)
            )
            .addTo(map);

        // === Draw radius circle zone ===
        const radius = alert.radius ? parseFloat(alert.radius) : 500;
        const circle = turf.circle([lng, lat], radius / 1000, { steps: 64, units: 'kilometers' });

        const sourceId = `alert-circle-${alert.id}`;
        const layerId = `alert-circle-layer-${alert.id}`;

        // If map already loaded, add zone immediately
        if (map.loaded()) {
            if (!map.getSource(sourceId)) {
                map.addSource(sourceId, { type: 'geojson', data: circle });
                map.addLayer({
                    id: layerId,
                    type: 'fill',
                    source: sourceId,
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
        } else {
            map.on('load', () => {
                if (!map.getSource(sourceId)) {
                    map.addSource(sourceId, { type: 'geojson', data: circle });
                    map.addLayer({
                        id: layerId,
                        type: 'fill',
                        source: sourceId,
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
        }
    }
    window.addAlertToMap = addAlertToMap;
</script>
