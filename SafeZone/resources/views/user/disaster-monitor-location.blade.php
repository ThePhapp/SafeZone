<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            AI Disaster Monitoring & Analysis
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800/40 border border-slate-600/30 overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6">
                    <!-- Location Selection Section -->
                    <div class="mb-8 bg-slate-900/50 border border-slate-700 p-6 rounded-xl">
                        <h3 class="text-lg font-semibold text-slate-100 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Select Location for Analysis
                        </h3>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Map Container -->
                            <div>
                                <div id="map" class="h-96 rounded-lg border border-slate-700 shadow-lg"></div>
                                <p class="text-sm text-slate-400 mt-3 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                                    </svg>
                                    Click on map to select location or use current position
                                </p>
                            </div>

                            <!-- Location Info & Controls -->
                            <div class="space-y-4">
                                <div class="bg-slate-950/50 border border-slate-700 p-4 rounded-lg">
                                    <label class="block text-sm font-semibold text-slate-300 mb-2 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        Selected Location
                                    </label>
                                    <div id="selected-location" class="text-slate-100 font-semibold">
                                        No location selected
                                    </div>
                                    <div id="selected-coords" class="text-sm text-slate-400 mt-1">
                                        Coordinates: --
                                    </div>
                                </div>

                                <div class="bg-slate-950/50 border border-slate-700 p-4 rounded-lg">
                                    <label for="radius" class="block text-sm font-semibold text-slate-300 mb-3 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                        </svg>
                                        Search Radius (km)
                                    </label>
                                    <input type="range" id="radius" name="radius" min="50" max="1000" value="500" 
                                           class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-cyan-500">
                                    <div class="text-center mt-3">
                                        <span id="radius-value" class="text-lg font-bold text-cyan-400">500 km</span>
                                    </div>
                                </div>

                                <button id="analyze-btn" 
                                        class="w-full bg-cyan-600 hover:bg-cyan-500 text-white px-6 py-4 rounded-lg font-semibold transition-all duration-200 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                                        disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Analyze Disasters in This Area
                                </button>

                                <button id="current-location-btn" 
                                        class="w-full bg-slate-700 hover:bg-slate-600 text-slate-200 px-6 py-3 rounded-lg font-semibold transition-all duration-200 shadow flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                    Use Current Location
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div id="loading" class="hidden text-center py-12">
                        <div class="inline-block animate-spin rounded-full h-16 w-16 border-4 border-cyan-500 border-t-transparent"></div>
                        <p class="mt-4 text-slate-300 font-medium">Analyzing disaster data...</p>
                    </div>

                    <!-- Results Container -->
                    <div id="results" class="hidden">
                        <!-- Location Summary -->
                        <div id="location-summary" class="mb-6 bg-slate-900/50 border border-slate-700 p-6 rounded-xl">
                            <h3 class="text-xl font-bold text-slate-100 mb-3 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Analysis Summary
                            </h3>
                            <div id="summary-content" class="text-slate-300"></div>
                        </div>

                        <!-- Risk Assessment -->
                        <div id="risk-assessment" class="mb-6"></div>

                        <!-- Earthquake Analysis -->
                        <div id="earthquake-section" class="mb-6"></div>

                        <!-- Weather Events -->
                        <div id="weather-section" class="mb-6"></div>

                        <!-- Historical Context & Forecast -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div id="historical-section"></div>
                            <div id="forecast-section"></div>
                        </div>

                        <!-- Raw Data (Collapsible) -->
                        <div class="bg-slate-900/50 border border-slate-700 p-4 rounded-lg">
                            <button id="toggle-raw-data" class="text-sm font-medium text-cyan-400 hover:text-cyan-300 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                Show Raw API Data
                            </button>
                            <div id="raw-data" class="hidden mt-4 bg-slate-950/50 border border-slate-700 p-4 rounded text-xs font-mono overflow-x-auto text-slate-300"></div>
                        </div>
                    </div>

                    <!-- Error Display -->
                    <div id="error" class="hidden bg-red-500/20 border border-red-500/30 p-4 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p id="error-message" class="text-sm text-red-300"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        let map;
        let selectedMarker;
        let selectedLat, selectedLng, selectedLocation;
        let radiusCircle;

        // Initialize Map
        document.addEventListener('DOMContentLoaded', function() {
            map = L.map('map').setView([16.0544, 108.2022], 8); // Vietnam central

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Handle map clicks
            map.on('click', function(e) {
                selectLocation(e.latlng.lat, e.latlng.lng);
            });

            // Radius slider
            document.getElementById('radius').addEventListener('input', function(e) {
                const radius = e.target.value;
                document.getElementById('radius-value').textContent = radius + ' km';
                
                if (radiusCircle) {
                    radiusCircle.setRadius(radius * 1000); // Convert to meters
                }
            });

            // Current location button
            document.getElementById('current-location-btn').addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        map.setView([lat, lng], 10);
                        selectLocation(lat, lng);
                    }, function(error) {
                        alert('Unable to get your location: ' + error.message);
                    });
                } else {
                    alert('Geolocation is not supported by your browser');
                }
            });

            // Analyze button
            document.getElementById('analyze-btn').addEventListener('click', analyzeDisasters);

            // Toggle raw data
            document.getElementById('toggle-raw-data').addEventListener('click', function() {
                const rawData = document.getElementById('raw-data');
                const btn = document.getElementById('toggle-raw-data');
                if (rawData.classList.contains('hidden')) {
                    rawData.classList.remove('hidden');
                    btn.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 15l7-7 7 7" />
                        </svg>
                        Hide Raw API Data
                    `;
                } else {
                    rawData.classList.add('hidden');
                    btn.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                        Show Raw API Data
                    `;
                }
            });
        });

        function selectLocation(lat, lng) {
            selectedLat = lat;
            selectedLng = lng;

            // Remove existing marker
            if (selectedMarker) {
                map.removeLayer(selectedMarker);
            }
            if (radiusCircle) {
                map.removeLayer(radiusCircle);
            }

            // Add new marker
            selectedMarker = L.marker([lat, lng]).addTo(map);
            
            // Add radius circle
            const radius = document.getElementById('radius').value;
            radiusCircle = L.circle([lat, lng], {
                color: 'blue',
                fillColor: '#3b82f6',
                fillOpacity: 0.1,
                radius: radius * 1000 // Convert km to meters
            }).addTo(map);

            // Reverse geocode to get location name
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    selectedLocation = data.display_name || `${lat.toFixed(4)}, ${lng.toFixed(4)}`;
                    document.getElementById('selected-location').textContent = selectedLocation;
                    document.getElementById('selected-coords').textContent = 
                        `Coordinates: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                    
                    // Enable analyze button
                    document.getElementById('analyze-btn').disabled = false;
                })
                .catch(() => {
                    selectedLocation = `${lat.toFixed(4)}, ${lng.toFixed(4)}`;
                    document.getElementById('selected-location').textContent = selectedLocation;
                    document.getElementById('selected-coords').textContent = 
                        `Coordinates: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                    document.getElementById('analyze-btn').disabled = false;
                });
        }

        async function analyzeDisasters() {
            if (!selectedLat || !selectedLng) {
                alert('Please select a location first');
                return;
            }

            // Hide previous results and errors
            document.getElementById('results').classList.add('hidden');
            document.getElementById('error').classList.add('hidden');
            
            // Show loading
            document.getElementById('loading').classList.remove('hidden');

            try {
                const radius = document.getElementById('radius').value;
                const response = await fetch('/api/disasters/analyze-location', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        lat: selectedLat,
                        lng: selectedLng,
                        location: selectedLocation,
                        radius: radius
                    })
                });

                const data = await response.json();

                // Hide loading
                document.getElementById('loading').classList.add('hidden');

                if (data.success) {
                    displayResults(data);
                } else {
                    showError(data.error || 'Failed to analyze location');
                }
            } catch (error) {
                document.getElementById('loading').classList.add('hidden');
                showError('Error: ' + error.message);
            }
        }

        function displayResults(data) {
            // Show results container
            document.getElementById('results').classList.remove('hidden');

            const analysis = data.ai_analysis.parsed_data;

            // Summary
            document.getElementById('summary-content').innerHTML = `
                <p class="text-lg">${analysis.summary || 'No summary available'}</p>
                <p class="text-sm text-gray-600 mt-2">
                    Analysis for: <strong>${data.location.name}</strong> 
                    (Radius: ${data.location.radius} km)
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    Generated: ${new Date(data.timestamp).toLocaleString()}
                </p>
            `;

            // Risk Assessment
            if (analysis.risk_assessment) {
                const risk = analysis.risk_assessment;
                const riskColors = {
                    'low': 'bg-cyan-500/20 border-cyan-500/30 text-cyan-300',
                    'medium': 'bg-yellow-500/20 border-yellow-500/30 text-yellow-300',
                    'high': 'bg-red-500/20 border-red-500/30 text-red-300'
                };
                const riskColor = riskColors[risk.overall_risk] || riskColors['medium'];

                document.getElementById('risk-assessment').innerHTML = `
                    <div class="${riskColor} p-6 rounded-xl border-l-4">
                        <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Risk Assessment
                        </h3>
                        <div class="mb-4 bg-slate-950/50 p-4 rounded-lg border border-slate-700">
                            <span class="font-semibold text-slate-300">Overall Risk: </span>
                            <span class="text-2xl font-bold uppercase">${risk.overall_risk}</span>
                        </div>
                        <div class="mb-4">
                            <strong class="text-slate-200">Primary Threats:</strong>
                            <ul class="list-disc list-inside mt-2 space-y-1">
                                ${(risk.primary_threats || []).map(t => `<li class="text-slate-300">${t}</li>`).join('')}
                            </ul>
                        </div>
                        <div>
                            <strong class="text-slate-200">Recommendations:</strong>
                            <ul class="list-disc list-inside mt-2 space-y-1">
                                ${(risk.recommendations || []).map(r => `<li class="text-slate-300">${r}</li>`).join('')}
                            </ul>
                        </div>
                    </div>
                `;
            }

            // Earthquake Analysis
            if (analysis.earthquake_analysis) {
                const eq = analysis.earthquake_analysis;
                document.getElementById('earthquake-section').innerHTML = `
                    <div class="bg-slate-900/50 border border-slate-700 p-6 rounded-xl">
                        <h3 class="text-xl font-bold text-slate-100 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Earthquake Analysis
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <div class="bg-slate-950/50 border border-slate-700 p-3 rounded-lg text-center">
                                <div class="text-2xl font-bold text-orange-400">${eq.total_count || 0}</div>
                                <div class="text-sm text-slate-400">Total Events</div>
                            </div>
                            <div class="bg-slate-950/50 border border-slate-700 p-3 rounded-lg text-center">
                                <div class="text-2xl font-bold text-red-400">${eq.strongest_magnitude || 'N/A'}</div>
                                <div class="text-sm text-slate-400">Strongest</div>
                            </div>
                            <div class="bg-slate-950/50 border border-slate-700 p-3 rounded-lg text-center">
                                <div class="text-lg font-semibold text-cyan-400">${eq.trend || 'N/A'}</div>
                                <div class="text-sm text-slate-400">Trend</div>
                            </div>
                            <div class="bg-slate-950/50 border border-slate-700 p-3 rounded-lg text-center">
                                <div class="text-lg font-semibold text-purple-400">${(eq.risk_areas || []).length}</div>
                                <div class="text-sm text-slate-400">Risk Areas</div>
                            </div>
                        </div>
                        ${eq.risk_areas && eq.risk_areas.length > 0 ? `
                            <div class="mt-4 bg-slate-950/50 border border-slate-700 p-4 rounded-lg">
                                <strong class="text-slate-200">High-Risk Areas:</strong>
                                <ul class="list-disc list-inside mt-2 text-slate-300 space-y-1">
                                    ${eq.risk_areas.map(area => `<li>${area}</li>`).join('')}
                                </ul>
                            </div>
                        ` : ''}
                    </div>
                `;
            }

            // Weather Analysis
            if (analysis.weather_analysis) {
                const weather = analysis.weather_analysis;
                document.getElementById('weather-section').innerHTML = `
                    <div class="bg-slate-900/50 border border-slate-700 p-6 rounded-xl">
                        <h3 class="text-xl font-bold text-slate-100 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                            </svg>
                            Active Weather Events
                        </h3>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="bg-slate-950/50 border border-slate-700 p-3 rounded-lg text-center">
                                <div class="text-2xl font-bold text-cyan-400">${weather.active_events || 0}</div>
                                <div class="text-sm text-slate-400">Active Events</div>
                            </div>
                            <div class="bg-slate-950/50 border border-slate-700 p-3 rounded-lg text-center">
                                <div class="text-lg font-semibold text-cyan-400">${(weather.event_types || []).length}</div>
                                <div class="text-sm text-slate-400">Event Types</div>
                            </div>
                        </div>
                        ${weather.event_types && weather.event_types.length > 0 ? `
                            <div class="mb-4">
                                <strong class="text-slate-200">Event Types:</strong>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    ${weather.event_types.map(type => 
                                        `<span class="bg-cyan-500/20 text-cyan-300 border border-cyan-500/30 px-3 py-1 rounded-full text-sm">${type}</span>`
                                    ).join('')}
                                </div>
                            </div>
                        ` : ''}
                        ${weather.affected_areas && weather.affected_areas.length > 0 ? `
                            <div class="bg-slate-950/50 border border-slate-700 p-4 rounded-lg">
                                <strong class="text-slate-200">Affected Areas:</strong>
                                <ul class="list-disc list-inside mt-2 text-slate-300 space-y-1">
                                    ${weather.affected_areas.map(area => `<li>${area}</li>`).join('')}
                                </ul>
                            </div>
                        ` : ''}
                    </div>
                `;
            }

            // Historical Context
            document.getElementById('historical-section').innerHTML = `
                <div class="bg-slate-900/50 border border-slate-700 p-5 rounded-xl">
                    <h4 class="font-bold text-slate-100 mb-3 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Historical Context
                    </h4>
                    <p class="text-slate-300 text-sm leading-relaxed">${analysis.historical_context || 'No historical data available'}</p>
                </div>
            `;

            // Forecast
            document.getElementById('forecast-section').innerHTML = `
                <div class="bg-slate-900/50 border border-slate-700 p-5 rounded-xl">
                    <h4 class="font-bold text-slate-100 mb-3 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Forecast & Warnings
                    </h4>
                    <p class="text-slate-300 text-sm leading-relaxed">${analysis.forecast || 'No forecast available'}</p>
                </div>
            `;

            // Raw Data
            document.getElementById('raw-data').innerHTML = `
                <pre class="whitespace-pre-wrap">${JSON.stringify(data, null, 2)}</pre>
            `;
        }

        function showError(message) {
            document.getElementById('error').classList.remove('hidden');
            document.getElementById('error-message').textContent = message;
        }
    </script>
</x-app-layout>
