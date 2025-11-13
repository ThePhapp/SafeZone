<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Emergency Evacuation Routes') }}
        </h2>
    </x-slot>

<div class="max-w-7xl mx-auto py-8 px-4">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-red-900 to-red-700 rounded-2xl shadow-lg p-6 mb-6">
        <div class="flex items-center gap-3 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            <div>
                <h3 class="text-2xl font-bold text-white">Find Nearest Shelter</h3>
                <p class="text-red-200 text-sm">Locate emergency shelters during disasters</p>
            </div>
        </div>
        <button id="find-nearest-btn" class="bg-white text-red-700 px-6 py-3 rounded-lg font-bold shadow-lg hover:bg-red-50 transition-all transform hover:scale-105">
            <span class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                Find Nearest Shelters
            </span>
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Map Section -->
        <div class="lg:col-span-2">
            <div class="bg-gray-900 rounded-2xl shadow-lg p-4">
                <h4 class="text-lg font-bold text-gray-100 mb-4">Shelter Locations</h4>
                <div class="rounded-xl overflow-hidden border border-gray-700 shadow-lg" style="height: 600px;">
                    <div id="emergency-map"></div>
                </div>
            </div>
        </div>

        <!-- Shelter List Section -->
        <div class="lg:col-span-1">
            <div class="bg-gray-900 rounded-2xl shadow-lg p-6">
                <h4 class="text-lg font-bold text-gray-100 mb-4">Nearest Shelters</h4>
                <div id="shelter-list" class="space-y-4">
                    <p class="text-gray-400 text-sm italic">Click "Find Nearest Shelters" to see available shelters</p>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    #emergency-map {
        width: 100%;
        height: 100%;
        min-height: 600px;
    }
    
    /* Animated route */
    @keyframes dash {
        to {
            stroke-dashoffset: -20;
        }
    }
    
    /* Route info card */
    .route-info {
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    let emergencyMap;
    let userMarker;
    let shelterMarkers = [];
    let routePolyline;

    document.addEventListener('DOMContentLoaded', function () {
        // Initialize map
        emergencyMap = L.map('emergency-map').setView([21.0285, 105.8542], 13); // Hanoi default
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(emergencyMap);

        // Force map to refresh after initialization
        setTimeout(() => {
            emergencyMap.invalidateSize();
        }, 100);

        // Add all shelters to map
        const allShelters = @json($shelters);
        console.log('All shelters:', allShelters); // Debug
        
        if (allShelters && allShelters.length > 0) {
            allShelters.forEach(shelter => {
                if (shelter.latitude && shelter.longitude) {
                    const marker = L.marker([parseFloat(shelter.latitude), parseFloat(shelter.longitude)])
                        .bindPopup(`
                            <div class="p-2">
                                <h5 class="font-bold text-gray-900">${shelter.name || 'Unnamed'}</h5>
                                <p class="text-sm text-gray-600">${shelter.address || 'No address'}</p>
                                <div class="mt-2">
                                    <span class="px-2 py-1 text-xs rounded ${
                                        shelter.status === 'active' ? 'bg-green-100 text-green-800' :
                                        shelter.status === 'full' ? 'bg-orange-100 text-orange-800' :
                                        'bg-red-100 text-red-800'
                                    }">${shelter.status ? shelter.status.toUpperCase() : 'UNKNOWN'}</span>
                                    <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800 ml-1">${shelter.type || 'general'}</span>
                                </div>
                                <p class="text-sm mt-2"><strong>Capacity:</strong> ${shelter.capacity || 0}</p>
                                ${shelter.contact_phone ? `<p class="text-sm"><strong>Phone:</strong> ${shelter.contact_phone}</p>` : ''}
                            </div>
                        `)
                        .addTo(emergencyMap);
                    shelterMarkers.push({ marker, shelter });
                }
            });
            
            // Fit bounds to show all markers
            if (shelterMarkers.length > 0) {
                const group = L.featureGroup(shelterMarkers.map(sm => sm.marker));
                emergencyMap.fitBounds(group.getBounds().pad(0.1));
            }
        } else {
            console.warn('No shelters found in database');
        }

        // Find nearest shelters
        document.getElementById('find-nearest-btn').addEventListener('click', function () {
            if (!navigator.geolocation) {
                alert('Your browser does not support geolocation.');
                return;
            }

            this.disabled = true;
            this.innerHTML = '<span class="flex items-center gap-2">Finding...</span>';

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    // Add/update user marker
                    if (userMarker) {
                        emergencyMap.removeLayer(userMarker);
                    }
                    userMarker = L.marker([lat, lng], {
                        icon: L.icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
                            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                            shadowSize: [41, 41]
                        })
                    }).addTo(emergencyMap).bindPopup('Your Location').openPopup();

                    emergencyMap.setView([lat, lng], 13);

                    // Fetch nearest shelters
                    fetch('{{ route("emergency-routes.find-nearest") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ latitude: lat, longitude: lng })
                    })
                    .then(res => res.json())
                    .then(data => {
                        displayShelterList(data.shelters, lat, lng);
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Error finding shelters');
                    })
                    .finally(() => {
                        this.disabled = false;
                        this.innerHTML = '<span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>Find Nearest Shelters</span>';
                    });
                },
                (error) => {
                    alert('Unable to retrieve your location');
                    this.disabled = false;
                    this.innerHTML = '<span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>Find Nearest Shelters</span>';
                }
            );
        });

        function displayShelterList(shelters, userLat, userLng) {
            const listContainer = document.getElementById('shelter-list');
            if (shelters.length === 0) {
                listContainer.innerHTML = '<p class="text-gray-400 text-sm italic">No shelters found nearby</p>';
                return;
            }

            listContainer.innerHTML = shelters.map((shelter, index) => `
                <div class="bg-gray-800 rounded-lg p-4 border border-gray-700 hover:border-emerald-500 transition cursor-pointer shelter-card" data-lat="${shelter.latitude}" data-lng="${shelter.longitude}" data-index="${index}">
                    <div class="flex items-start gap-3">
                        <div class="bg-emerald-600 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold flex-shrink-0">
                            ${index + 1}
                        </div>
                        <div class="flex-1">
                            <h5 class="font-bold text-gray-100">${shelter.name}</h5>
                            <p class="text-xs text-gray-400 mt-1">${shelter.address}</p>
                            <div class="flex gap-2 mt-2">
                                <span class="px-2 py-1 text-xs rounded ${
                                    shelter.status === 'active' ? 'bg-green-900 text-green-300' :
                                    shelter.status === 'full' ? 'bg-orange-900 text-orange-300' :
                                    'bg-red-900 text-red-300'
                                }">${shelter.status}</span>
                                <span class="px-2 py-1 text-xs rounded bg-blue-900 text-blue-300">${shelter.type}</span>
                            </div>
                            <p class="text-sm text-gray-300 mt-2"><strong>Distance:</strong> ${shelter.distance.toFixed(2)} km</p>
                            ${shelter.contact_phone ? `<p class="text-sm text-gray-300"><strong>Phone:</strong> ${shelter.contact_phone}</p>` : ''}
                            <button class="mt-2 bg-emerald-600 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-emerald-700 show-route-btn" data-lat="${shelter.latitude}" data-lng="${shelter.longitude}" data-name="${shelter.name}">
                                Show Route
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');

            // Add click handlers
            document.querySelectorAll('.shelter-card').forEach(card => {
                card.addEventListener('click', function(e) {
                    if (!e.target.classList.contains('show-route-btn')) {
                        const lat = parseFloat(this.dataset.lat);
                        const lng = parseFloat(this.dataset.lng);
                        emergencyMap.setView([lat, lng], 15);
                        const marker = shelterMarkers.find(m => m.shelter.latitude === lat && m.shelter.longitude === lng);
                        if (marker) marker.marker.openPopup();
                    }
                });
            });

            document.querySelectorAll('.show-route-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const destLat = parseFloat(this.dataset.lat);
                    const destLng = parseFloat(this.dataset.lng);
                    const name = this.dataset.name;
                    drawRoute(userLat, userLng, destLat, destLng, name);
                });
            });
        }

        function drawRoute(startLat, startLng, endLat, endLng, shelterName) {
            // Remove existing route
            if (routePolyline) {
                emergencyMap.removeLayer(routePolyline);
            }

            // Use OSRM routing API for real road routes
            const osrmUrl = `https://router.project-osrm.org/route/v1/driving/${startLng},${startLat};${endLng},${endLat}?overview=full&geometries=geojson`;
            
            fetch(osrmUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.code === 'Ok' && data.routes && data.routes.length > 0) {
                        const route = data.routes[0];
                        const coordinates = route.geometry.coordinates;
                        
                        // Convert coordinates from [lng, lat] to [lat, lng] for Leaflet
                        const latlngs = coordinates.map(coord => [coord[1], coord[0]]);
                        
                        // Draw the route with gradient effect
                        routePolyline = L.polyline(latlngs, {
                            color: '#ef4444',
                            weight: 5,
                            opacity: 0.8,
                            lineJoin: 'round',
                            className: 'route-animated'
                        }).addTo(emergencyMap);

                        // Add start marker (green)
                        L.marker([startLat, startLng], {
                            icon: L.divIcon({
                                className: 'custom-div-icon',
                                html: `<div style="background-color: #10b981; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"><span style="color: white; font-size: 16px;">🚶</span></div>`,
                                iconSize: [30, 30],
                                iconAnchor: [15, 15]
                            })
                        }).addTo(emergencyMap).bindPopup('Start: Your Location');

                        // Add end marker (red)
                        L.marker([endLat, endLng], {
                            icon: L.divIcon({
                                className: 'custom-div-icon',
                                html: `<div style="background-color: #ef4444; width: 35px; height: 35px; border-radius: 50%; border: 3px solid white; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"><span style="color: white; font-size: 18px;">🏠</span></div>`,
                                iconSize: [35, 35],
                                iconAnchor: [17, 17]
                            })
                        }).addTo(emergencyMap).bindPopup(`Destination: ${shelterName}`);

                        // Fit bounds to show entire route
                        emergencyMap.fitBounds(routePolyline.getBounds(), { padding: [50, 50] });

                        // Get distance and duration
                        const distanceKm = (route.distance / 1000).toFixed(2);
                        const durationMin = Math.round(route.duration / 60);
                        const durationHours = durationMin >= 60 ? `${Math.floor(durationMin / 60)}h ${durationMin % 60}m` : `${durationMin} min`;
                        
                        // Show route info in a custom control
                        const routeInfo = L.control({ position: 'topright' });
                        routeInfo.onAdd = function() {
                            const div = L.DomUtil.create('div', 'route-info');
                            div.style.cssText = `
                                background: white;
                                padding: 15px;
                                border-radius: 10px;
                                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                                min-width: 200px;
                                font-family: system-ui;
                            `;
                            div.innerHTML = `
                                <div style="border-bottom: 2px solid #ef4444; padding-bottom: 8px; margin-bottom: 10px;">
                                    <strong style="color: #1f2937; font-size: 16px;">📍 Route to ${shelterName}</strong>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span style="font-size: 20px;">🚗</span>
                                        <div>
                                            <div style="color: #6b7280; font-size: 12px;">Distance</div>
                                            <div style="color: #1f2937; font-weight: 600; font-size: 18px;">${distanceKm} km</div>
                                        </div>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span style="font-size: 20px;">⏱️</span>
                                        <div>
                                            <div style="color: #6b7280; font-size: 12px;">Duration</div>
                                            <div style="color: #1f2937; font-weight: 600; font-size: 18px;">${durationHours}</div>
                                        </div>
                                    </div>
                                </div>
                                <button onclick="this.parentElement.parentElement.remove()" style="
                                    position: absolute;
                                    top: 8px;
                                    right: 8px;
                                    background: #f3f4f6;
                                    border: none;
                                    border-radius: 50%;
                                    width: 24px;
                                    height: 24px;
                                    cursor: pointer;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-size: 16px;
                                ">×</button>
                            `;
                            return div;
                        };
                        routeInfo.addTo(emergencyMap);
                        
                        // Also show popup at destination
                        L.popup()
                            .setLatLng([endLat, endLng])
                            .setContent(`
                                <div class="p-2">
                                    <strong class="text-base">${shelterName}</strong><br>
                                    <p class="text-sm mt-1">Click route markers for details</p>
                                </div>
                            `)
                            .openOn(emergencyMap);
                    } else {
                        // Fallback to straight line if routing fails
                        routePolyline = L.polyline([
                            [startLat, startLng],
                            [endLat, endLng]
                        ], {
                            color: '#ef4444',
                            weight: 4,
                            opacity: 0.7,
                            dashArray: '10, 10'
                        }).addTo(emergencyMap);

                        const bounds = L.latLngBounds([[startLat, startLng], [endLat, endLng]]);
                        emergencyMap.fitBounds(bounds, { padding: [50, 50] });

                        const distance = emergencyMap.distance([startLat, startLng], [endLat, endLng]) / 1000;
                        
                        L.popup()
                            .setLatLng([endLat, endLng])
                            .setContent(`<strong>Route to ${shelterName}</strong><br>Distance: ~${distance.toFixed(2)} km (straight line)`)
                            .openOn(emergencyMap);
                    }
                })
                .catch(error => {
                    console.error('Routing error:', error);
                    // Fallback to straight line
                    routePolyline = L.polyline([
                        [startLat, startLng],
                        [endLat, endLng]
                    ], {
                        color: '#ef4444',
                        weight: 4,
                        opacity: 0.7,
                        dashArray: '10, 10'
                    }).addTo(emergencyMap);

                    const bounds = L.latLngBounds([[startLat, startLng], [endLat, endLng]]);
                    emergencyMap.fitBounds(bounds, { padding: [50, 50] });
                });
        }
    });
</script>
</x-app-layout>
