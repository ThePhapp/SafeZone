<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                        AI Disaster Monitoring & Analysis
                    </h2>

                    <!-- Location Selection Section -->
                    <div class="mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-lg border border-blue-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            📍 Select Location for Analysis
                        </h3>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Map Container -->
                            <div>
                                <div id="map" class="h-96 rounded-lg border-2 border-blue-300 shadow-lg"></div>
                                <p class="text-sm text-gray-600 mt-2">
                                    🖱️ Click on map to select location or use current position
                                </p>
                            </div>

                            <!-- Location Info & Controls -->
                            <div class="space-y-4">
                                <div class="bg-white p-4 rounded-lg shadow">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Selected Location
                                    </label>
                                    <div id="selected-location" class="text-gray-900 font-semibold">
                                        No location selected
                                    </div>
                                    <div id="selected-coords" class="text-sm text-gray-600 mt-1">
                                        Coordinates: --
                                    </div>
                                </div>

                                <div class="bg-white p-4 rounded-lg shadow">
                                    <label for="radius" class="block text-sm font-medium text-gray-700 mb-2">
                                        Search Radius (km)
                                    </label>
                                    <input type="range" id="radius" name="radius" min="50" max="1000" value="500" 
                                           class="w-full h-2 bg-blue-200 rounded-lg appearance-none cursor-pointer">
                                    <div class="text-center mt-2">
                                        <span id="radius-value" class="text-lg font-bold text-blue-600">500 km</span>
                                    </div>
                                </div>

                                <button id="analyze-btn" 
                                        class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-4 rounded-lg font-semibold hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                        disabled>
                                    🔍 Analyze Disasters in This Area
                                </button>

                                <button id="current-location-btn" 
                                        class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-green-600 hover:to-emerald-700 transition-all duration-200 shadow">
                                    📍 Use Current Location
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div id="loading" class="hidden text-center py-12">
                        <div class="inline-block animate-spin rounded-full h-16 w-16 border-4 border-blue-500 border-t-transparent"></div>
                        <p class="mt-4 text-gray-600 font-medium">Analyzing disaster data...</p>
                    </div>

                    <!-- Results Container -->
                    <div id="results" class="hidden">
                        <!-- Location Summary -->
                        <div id="location-summary" class="mb-6 bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-lg border border-purple-200">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">📊 Analysis Summary</h3>
                            <div id="summary-content" class="text-gray-700"></div>
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
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <button id="toggle-raw-data" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                🔽 Show Raw API Data
                            </button>
                            <div id="raw-data" class="hidden mt-4 bg-white p-4 rounded border text-xs font-mono overflow-x-auto"></div>
                        </div>
                    </div>

                    <!-- Error Display -->
                    <div id="error" class="hidden bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p id="error-message" class="text-sm text-red-700"></p>
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
                    btn.textContent = '🔼 Hide Raw API Data';
                } else {
                    rawData.classList.add('hidden');
                    btn.textContent = '🔽 Show Raw API Data';
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
                    'low': 'bg-green-100 border-green-500 text-green-800',
                    'medium': 'bg-yellow-100 border-yellow-500 text-yellow-800',
                    'high': 'bg-red-100 border-red-500 text-red-800'
                };
                const riskColor = riskColors[risk.overall_risk] || riskColors['medium'];

                document.getElementById('risk-assessment').innerHTML = `
                    <div class="${riskColor} p-6 rounded-lg border-l-4">
                        <h3 class="text-xl font-bold mb-3">⚠️ Risk Assessment</h3>
                        <div class="mb-3">
                            <span class="font-semibold">Overall Risk: </span>
                            <span class="text-2xl font-bold uppercase">${risk.overall_risk}</span>
                        </div>
                        <div class="mb-3">
                            <strong>Primary Threats:</strong>
                            <ul class="list-disc list-inside mt-2">
                                ${(risk.primary_threats || []).map(t => `<li>${t}</li>`).join('')}
                            </ul>
                        </div>
                        <div>
                            <strong>Recommendations:</strong>
                            <ul class="list-disc list-inside mt-2">
                                ${(risk.recommendations || []).map(r => `<li>${r}</li>`).join('')}
                            </ul>
                        </div>
                    </div>
                `;
            }

            // Earthquake Analysis
            if (analysis.earthquake_analysis) {
                const eq = analysis.earthquake_analysis;
                document.getElementById('earthquake-section').innerHTML = `
                    <div class="bg-orange-50 p-6 rounded-lg border border-orange-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">🌋 Earthquake Analysis</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-3">
                            <div class="bg-white p-3 rounded shadow text-center">
                                <div class="text-2xl font-bold text-orange-600">${eq.total_count || 0}</div>
                                <div class="text-sm text-gray-600">Total Events</div>
                            </div>
                            <div class="bg-white p-3 rounded shadow text-center">
                                <div class="text-2xl font-bold text-red-600">${eq.strongest_magnitude || 'N/A'}</div>
                                <div class="text-sm text-gray-600">Strongest</div>
                            </div>
                            <div class="bg-white p-3 rounded shadow text-center">
                                <div class="text-lg font-semibold text-blue-600">${eq.trend || 'N/A'}</div>
                                <div class="text-sm text-gray-600">Trend</div>
                            </div>
                            <div class="bg-white p-3 rounded shadow text-center">
                                <div class="text-lg font-semibold text-purple-600">${(eq.risk_areas || []).length}</div>
                                <div class="text-sm text-gray-600">Risk Areas</div>
                            </div>
                        </div>
                        ${eq.risk_areas && eq.risk_areas.length > 0 ? `
                            <div class="mt-3">
                                <strong>High-Risk Areas:</strong>
                                <ul class="list-disc list-inside mt-2 text-gray-700">
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
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">🌪️ Active Weather Events</h3>
                        <div class="grid grid-cols-2 gap-4 mb-3">
                            <div class="bg-white p-3 rounded shadow text-center">
                                <div class="text-2xl font-bold text-blue-600">${weather.active_events || 0}</div>
                                <div class="text-sm text-gray-600">Active Events</div>
                            </div>
                            <div class="bg-white p-3 rounded shadow text-center">
                                <div class="text-lg font-semibold text-indigo-600">${(weather.event_types || []).length}</div>
                                <div class="text-sm text-gray-600">Event Types</div>
                            </div>
                        </div>
                        ${weather.event_types && weather.event_types.length > 0 ? `
                            <div class="mb-3">
                                <strong>Event Types:</strong>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    ${weather.event_types.map(type => 
                                        `<span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">${type}</span>`
                                    ).join('')}
                                </div>
                            </div>
                        ` : ''}
                        ${weather.affected_areas && weather.affected_areas.length > 0 ? `
                            <div>
                                <strong>Affected Areas:</strong>
                                <ul class="list-disc list-inside mt-2 text-gray-700">
                                    ${weather.affected_areas.map(area => `<li>${area}</li>`).join('')}
                                </ul>
                            </div>
                        ` : ''}
                    </div>
                `;
            }

            // Historical Context
            document.getElementById('historical-section').innerHTML = `
                <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                    <h4 class="font-bold text-gray-900 mb-2">📜 Historical Context</h4>
                    <p class="text-gray-700 text-sm">${analysis.historical_context || 'No historical data available'}</p>
                </div>
            `;

            // Forecast
            document.getElementById('forecast-section').innerHTML = `
                <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-200">
                    <h4 class="font-bold text-gray-900 mb-2">🔮 Forecast & Warnings</h4>
                    <p class="text-gray-700 text-sm">${analysis.forecast || 'No forecast available'}</p>
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
