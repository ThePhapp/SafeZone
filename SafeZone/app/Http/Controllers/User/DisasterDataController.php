<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class DisasterDataController extends Controller
{
    /**
     * Get disaster information from Gemini AI
     */
    public function getGeminiDisasterInfo(Request $request)
    {
        try {
            $location = $request->input('location', 'Vietnam');
            $disasterType = $request->input('type', 'all');
            
            // Cache key based on location and type
            $cacheKey = "gemini_disaster_{$location}_{$disasterType}";
            
            // Cache for 10 minutes
            $response = Cache::remember($cacheKey, 600, function () use ($location, $disasterType) {
                return $this->callGeminiAPI($location, $disasterType);
            });
            
            return response()->json([
                'success' => true,
                'data' => $response
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Call Gemini API for disaster analysis
     */
    private function callGeminiAPI($location, $disasterType)
    {
        $apiKey = env('GEMINI_API_KEY');
        
        if (!$apiKey) {
            throw new \Exception('Gemini API key not configured');
        }

        $prompt = $this->buildDisasterPrompt($location, $disasterType);
        
        $response = Http::withoutVerifying()
            ->timeout(30)
            ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

        if (!$response->successful()) {
            \Log::error('Gemini API error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            throw new \Exception('Failed to get response from Gemini AI: ' . $response->body());
        }

        $data = $response->json();
        
        // Extract text from response
        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
        
        return [
            'raw_text' => $text,
            'parsed_data' => $this->parseGeminiResponse($text),
            'location' => $location,
            'type' => $disasterType,
            'timestamp' => now()->toIso8601String()
        ];
    }

    /**
     * Build prompt for Gemini based on disaster type
     */
    private function buildDisasterPrompt($location, $disasterType)
    {
        $today = now()->format('Y-m-d');
        
        if ($disasterType === 'all') {
            return "You are a disaster monitoring expert. Analyze natural disasters and hazards for {$location} based on the following REAL DATA from USGS and NASA APIs.

I will provide you with:
1. Recent earthquakes from USGS (last 30 days)
2. Active natural events from NASA EONET (wildfires, storms, floods, volcanoes)

Your task:
- Analyze the provided data
- Identify patterns and trends
- Assess current risk level (low/medium/high)
- Provide safety recommendations

Please respond ONLY in valid JSON format:
{
  \"summary\": \"Brief overview of disaster situation in {$location}\",
  \"risk_assessment\": {
    \"overall_risk\": \"low/medium/high\",
    \"primary_threats\": [\"List of current threats\"],
    \"recommendations\": [\"Safety recommendations for residents\"]
  },
  \"earthquake_analysis\": {
    \"total_count\": 0,
    \"strongest_magnitude\": 0,
    \"trend\": \"increasing/stable/decreasing\",
    \"risk_areas\": [\"List of high-risk areas\"]
  },
  \"weather_analysis\": {
    \"active_events\": 0,
    \"event_types\": [\"List of event types\"],
    \"affected_areas\": [\"List of affected areas\"]
  },
  \"historical_context\": \"Brief comparison with historical data\",
  \"forecast\": \"Short-term forecast and warnings\"
}

Provide accurate, actionable information based on the data provided.";
        } else {
            return "Analyze {$disasterType} events in {$location} as of {$today}. Provide detailed information including locations, magnitudes/severity, dates, impacts, and safety recommendations. Format response as JSON.";
        }
    }

    /**
     * Get disaster data for specific location and pass to Gemini
     */
    public function analyzeLocationDisasters(Request $request)
    {
        try {
            $lat = $request->lat;
            $lng = $request->lng;
            $location = $request->location ?? 'Selected Location';
            $radius = $request->radius ?? 500; // km

            \Log::info('Location disaster analysis', ['lat' => $lat, 'lng' => $lng, 'location' => $location]);

            // Fetch real data from USGS
            $earthquakeData = $this->fetchUSGSData($lat, $lng, $radius);
            
            // Fetch real data from NASA
            $nasaData = $this->fetchNASAData($lat, $lng, $radius);

            // Build enhanced prompt with real data
            $prompt = $this->buildEnhancedPrompt($location, $earthquakeData, $nasaData);

            // Get Gemini analysis
            $apiKey = env('GEMINI_API_KEY');
            
            if (!$apiKey) {
                throw new \Exception('Gemini API key not configured');
            }

            $response = Http::withoutVerifying()
                ->timeout(30)
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ]
                ]);

            if (!$response->successful()) {
                \Log::error('Gemini API error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new \Exception('Failed to get analysis from Gemini AI');
            }

            $data = $response->json();
            $analysisText = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

            return response()->json([
                'success' => true,
                'location' => [
                    'name' => $location,
                    'lat' => $lat,
                    'lng' => $lng,
                    'radius' => $radius
                ],
                'raw_data' => [
                    'earthquakes' => $earthquakeData,
                    'nasa_events' => $nasaData
                ],
                'ai_analysis' => [
                    'raw_text' => $analysisText,
                    'parsed_data' => $this->parseGeminiResponse($analysisText)
                ],
                'timestamp' => now()->toIso8601String()
            ]);

        } catch (\Exception $e) {
            \Log::error('Location analysis error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fetch earthquake data from USGS for specific location
     */
    private function fetchUSGSData($lat, $lng, $radius)
    {
        try {
            $response = Http::timeout(15)->get('https://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/all_month.geojson');
            
            if (!$response->successful()) {
                return [];
            }

            $data = $response->json();
            $features = $data['features'] ?? [];

            // Filter by distance
            $nearby = array_filter($features, function($eq) use ($lat, $lng, $radius) {
                $eqLng = $eq['geometry']['coordinates'][0];
                $eqLat = $eq['geometry']['coordinates'][1];
                $distance = $this->haversineDistance($lat, $lng, $eqLat, $eqLng);
                return $distance <= $radius;
            });

            return array_values($nearby);
        } catch (\Exception $e) {
            \Log::error('USGS fetch error', ['error' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * Fetch NASA EONET data for specific location
     */
    private function fetchNASAData($lat, $lng, $radius)
    {
        try {
            $response = Http::timeout(15)->get('https://eonet.gsfc.nasa.gov/api/v3/events', [
                'status' => 'open',
                'limit' => 100
            ]);
            
            if (!$response->successful()) {
                return [];
            }

            $events = $response->json()['events'] ?? [];

            // Filter by distance (approximate)
            $nearby = array_filter($events, function($event) use ($lat, $lng, $radius) {
                if (empty($event['geometry'])) {
                    return false;
                }
                
                $geo = $event['geometry'][0];
                if (empty($geo['coordinates'])) {
                    return false;
                }

                $coords = $geo['coordinates'];
                $distance = $this->haversineDistance($lat, $lng, $coords[1], $coords[0]);
                return $distance <= $radius;
            });

            return array_values($nearby);
        } catch (\Exception $e) {
            \Log::error('NASA fetch error', ['error' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * Build enhanced prompt with real API data
     */
    private function buildEnhancedPrompt($location, $earthquakeData, $nasaData)
    {
        $earthquakeSummary = [];
        foreach ($earthquakeData as $eq) {
            $props = $eq['properties'];
            $coords = $eq['geometry']['coordinates'];
            $earthquakeSummary[] = [
                'magnitude' => $props['mag'],
                'location' => $props['place'],
                'depth' => $coords[2] . 'km',
                'time' => date('Y-m-d H:i', $props['time'] / 1000)
            ];
        }

        $nasaSummary = [];
        foreach ($nasaData as $event) {
            $nasaSummary[] = [
                'title' => $event['title'],
                'category' => $event['categories'][0]['title'] ?? 'Unknown',
                'date' => $event['geometry'][0]['date'] ?? 'Unknown'
            ];
        }

        return "Analyze natural disaster risk for {$location} based on this REAL DATA:

EARTHQUAKE DATA (Last 30 days, USGS):
" . json_encode($earthquakeSummary, JSON_PRETTY_PRINT) . "

NASA EONET EVENTS (Active disasters):
" . json_encode($nasaSummary, JSON_PRETTY_PRINT) . "

Provide analysis in this EXACT JSON format (no markdown, no code blocks):
{
  \"summary\": \"Overview of disaster situation\",
  \"risk_assessment\": {
    \"overall_risk\": \"low/medium/high\",
    \"primary_threats\": [\"threat1\", \"threat2\"],
    \"recommendations\": [\"recommendation1\", \"recommendation2\"]
  },
  \"earthquake_analysis\": {
    \"total_count\": " . count($earthquakeSummary) . ",
    \"strongest_magnitude\": \"X.X\",
    \"trend\": \"increasing/stable/decreasing\",
    \"risk_areas\": [\"area1\", \"area2\"]
  },
  \"weather_analysis\": {
    \"active_events\": " . count($nasaSummary) . ",
    \"event_types\": [\"type1\", \"type2\"],
    \"affected_areas\": [\"area1\", \"area2\"]
  },
  \"historical_context\": \"Brief historical comparison\",
  \"forecast\": \"Short-term forecast and warnings\"
}";
    }    /**
     * Parse Gemini response into structured data
     */
    private function parseGeminiResponse($text)
    {
        // Try to extract JSON from response
        preg_match('/\{[\s\S]*\}/', $text, $matches);
        
        if (!empty($matches)) {
            try {
                return json_decode($matches[0], true);
            } catch (\Exception $e) {
                // If JSON parsing fails, return raw text
                return ['raw' => $text];
            }
        }
        
        return ['raw' => $text];
    }

    /**
     * Get real-time earthquake data from USGS
     */
    public function getEarthquakes(Request $request)
    {
        try {
            // Cache for 5 minutes to reduce API calls
            $earthquakes = Cache::remember('usgs_earthquakes', 300, function () {
                // USGS Earthquake API - Last 24 hours, magnitude 2.5+
                $response = Http::timeout(10)->get('https://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_day.geojson');
                
                if ($response->successful()) {
                    $data = $response->json();
                    return $data['features'] ?? [];
                }
                
                return [];
            });

            // Filter by region if provided
            if ($request->has('lat') && $request->has('lng') && $request->has('radius')) {
                $userLat = $request->lat;
                $userLng = $request->lng;
                $radiusKm = $request->radius ?? 500; // Default 500km

                $earthquakes = array_filter($earthquakes, function($eq) use ($userLat, $userLng, $radiusKm) {
                    $eqLng = $eq['geometry']['coordinates'][0];
                    $eqLat = $eq['geometry']['coordinates'][1];
                    
                    $distance = $this->haversineDistance($userLat, $userLng, $eqLat, $eqLng);
                    return $distance <= $radiusKm;
                });
            }

            return response()->json([
                'success' => true,
                'count' => count($earthquakes),
                'earthquakes' => array_values($earthquakes)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get NASA EONET (Earth Observatory Natural Event Tracker) events
     */
    public function getNASAEvents(Request $request)
    {
        try {
            // Cache for 10 minutes
            $events = Cache::remember('nasa_eonet_events', 600, function () {
                // NASA EONET API - Natural events
                $response = Http::timeout(10)->get('https://eonet.gsfc.nasa.gov/api/v3/events', [
                    'status' => 'open', // Only active events
                    'limit' => 100
                ]);
                
                if ($response->successful()) {
                    $data = $response->json();
                    return $data['events'] ?? [];
                }
                
                return [];
            });

            // Filter by category if provided
            if ($request->has('categories')) {
                $categories = explode(',', $request->categories);
                $events = array_filter($events, function($event) use ($categories) {
                    foreach ($event['categories'] as $cat) {
                        if (in_array($cat['id'], $categories)) {
                            return true;
                        }
                    }
                    return false;
                });
            }

            return response()->json([
                'success' => true,
                'count' => count($events),
                'events' => array_values($events)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get combined disaster dashboard data using Gemini AI
     */
    public function getDashboardData(Request $request)
    {
        try {
            $lat = $request->lat ?? 21.0285; // Default Hanoi
            $lng = $request->lng ?? 105.8542;
            $location = $request->location ?? 'Vietnam';

            \Log::info('Disaster dashboard request', ['lat' => $lat, 'lng' => $lng, 'location' => $location]);

            // Get AI-powered disaster analysis
            $geminiData = Cache::remember("gemini_dashboard_{$location}", 600, function () use ($location) {
                return $this->callGeminiAPI($location, 'all');
            });

            return response()->json([
                'success' => true,
                'location' => [
                    'name' => $location,
                    'lat' => $lat,
                    'lng' => $lng
                ],
                'ai_analysis' => $geminiData,
                'timestamp' => now()->toIso8601String()
            ]);

        } catch (\Exception $e) {
            \Log::error('Dashboard data error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate distance between two coordinates using Haversine formula
     */
    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
