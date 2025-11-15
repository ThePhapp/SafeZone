# 🛡️ SafeZone - Disaster Alert & Management System

SafeZone is a comprehensive disaster management and alert system built with Laravel, designed to help communities stay informed and safe during natural disasters and emergencies.

<!-- Add your logo/banner image here -->

![SafeZone Banner](docs/images/banner-safezone.png)

## 📋 Table of Contents

- [About](#about)
- [Key Features](#key-features)
- [Screenshots](#screenshots)
- [Technology Stack](#technology-stack)
- [Getting Started](#getting-started)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## 🌟 About

SafeZone is a real-time disaster alert and management platform that enables authorities to broadcast emergency alerts and helps users stay informed about disasters in their area. The system provides interactive maps, real-time notifications, and comprehensive disaster information to ensure public safety.

## ✨ Key Features

### 🗺️ Interactive Maps

- **MapLibre GL Integration**: Interactive disaster zone visualization
- **Custom Markers**: Type-specific icons (flood, fire, earthquake, storm)
- **Animated Zones**: Pulsing radius circles for new alerts
- **User Location Tracking**: Display user addresses on the map
- **Real-time Updates**: New alerts appear on map instantly via Socket.IO

<!-- Add map interface screenshot here -->

![Interactive Map](docs/images/map-screenshot.png)

### 👤 User Features

- **Personalized Dashboard**: Safety status based on user location
- **Multiple Address Management**: Save and monitor multiple locations
- **Alert Filtering**: Filter by severity, type, date, and distance
- **Three View Modes**:
  - **All Alerts**: View all active alerts
  - **Near You**: Alerts within proximity to saved addresses
  - **In Your Area**: Alerts directly affecting your locations
- **Detailed Alert Information**: Images, descriptions, affected radius, and location

<!-- Add user dashboard screenshot here -->

![User Dashboard](docs/images/dashboard-screenshot.png)

### 🔔 Notification System

- **Real-time Notifications**: Socket.IO powered instant alerts
- **In-app Notifications**: Notification center with read/unread status
- **Custom Database Channels**: Persistent notification storage
- **Alert Proximity Detection**: Automatic notifications for nearby disasters

### 👨‍💼 Admin Panel

- **Complete CRUD Operations**: Manage alerts, users, and settings
- **Image Upload**: Attach disaster evidence photos
- **Address Management**: Geocoding integration for precise locations
- **User Role Management**: Admin and regular user roles
- **Alert Statistics**: Dashboard with key metrics

<!-- Add admin panel screenshot here -->

![Admin Panel](docs/images/admin-panel.png)

### 🌐 Real-time Features

- **Live Alert Updates**: New alerts appear without page refresh
- **Socket.IO Integration**: Bidirectional real-time communication
- **Event Broadcasting**: Laravel event system with Node.js server

<!-- Add real-time features screenshot here -->

![Real-time Updates](docs/images/realtime-screenshot.png)

### 🏠 Nearest Evacuation Shelters

- **Closest Shelter Lookup**: Automatically calculates nearest safe shelters relative to each saved address
- **Dynamic Radius Search**: Adjustable search radius (default configurable via `SHELTER_SEARCH_RADIUS_DEFAULT`)
- **Multi-Result Ranking**: Shelters ranked by distance and capacity; limits via `SHELTER_MAX_RESULTS`
- **Geo-optimized Queries**: Uses spatial indexing / Haversine formula for performant distance checks
- **User Context Integration**: Displays proximity warnings if no shelter falls within radius

<!-- Add shelter finder screenshot here -->

![Shelter Finder](docs/images/shelter-finder.png)

### 🤖 AI Disaster Prediction

- **Forecast Suggestions**: AI-assisted early warning hints before official alerts
- **Generative Explanation**: Human-readable summaries of risk factors (rainfall, wind, seismic patterns)
- **Confidence Scores**: Model returns probability & severity buckets (e.g. low / medium / high risk)
- **Model Isolation**: External prediction service consumed through REST (`PREDICTION_API_URL` / key)
- **Optional Feature Flag**: Toggle via `PREDICTION_ENABLED=true|false`
- **Provider Abstraction**: Supports multiple backends (e.g. Gemini / internal model) via `PREDICTION_PROVIDER`

<!-- Add AI prediction screenshot here -->

![AI Prediction](docs/images/ai-prediction.png)

## 🛠️ Technology Stack

### Backend

- **Framework**: Laravel 11.x
- **Database**: MySQL 8.0
- **PHP**: 8.2+
- **Authentication**: Laravel Breeze
- **ORM**: Eloquent
- **Real-time**: Laravel Events + Socket.IO

### Frontend

- **UI Framework**: Tailwind CSS 3.x
- **JavaScript**: Alpine.js 3.x
- **Build Tool**: Vite 7.x
- **Maps**: MapLibre GL JS
- **Real-time Client**: Socket.IO Client 4.8.x
- **HTTP Client**: Axios

### Real-time Server

- **Runtime**: Node.js
- **Framework**: Express 5.x
- **WebSocket**: Socket.IO 4.8.x
- **CORS**: Enabled for cross-origin requests

### DevOps

- **Containerization**: Docker & Docker Compose
- **Web Server**: Nginx
- **Cache**: Redis (optional)
- **Version Control**: Git

## 🚀 Getting Started

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js >= 18.x
- npm or yarn
- MySQL >= 8.0
- Docker & Docker Compose (optional)

### Installation

#### Option 1: Docker Installation (Recommended)

1. **Clone the repository**

```bash
git clone https://github.com/leducanhtai/SafeZoneVN.git
cd SafeZoneVN
```

2. **Start Docker containers**

```bash
docker-compose up -d
```

3. **Install PHP dependencies**

```bash
docker exec -it safezone-laravel composer install
```

4. **Install Node dependencies**

```bash
docker exec -it safezone-laravel npm install
```

5. **Generate application key**

```bash
docker exec -it safezone-laravel php artisan key:generate
```

6. **Run migrations**

```bash
docker exec -it safezone-laravel php artisan migrate
```

7. **Build assets**

```bash
docker exec -it safezone-laravel npm run build
```

8. **Access the application**

- Web Application: http://localhost
- Node.js Server: http://localhost:6001

#### Option 2: Local Installation

1. **Clone the repository**

```bash
git clone https://github.com/leducanhtai/SafeZoneVN.git
cd SafeZoneVN/SafeZone
```

2. **Install PHP dependencies**

```bash
composer install
```

3. **Install Node dependencies**

```bash
npm install
```

4. **Configure environment**

```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure database** (Edit `.env`)

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=SafeZone
DB_USERNAME=root
DB_PASSWORD=your_password
```

6. **Run migrations**

```bash
php artisan migrate
```

7. **Start the development server**

```bash
# Terminal 1: Laravel
php artisan serve

# Terminal 2: Vite
npm run dev

# Terminal 3: Node.js Real-time Server
cd ../node-server
npm install
npm start
```

8. **Access the application**

- Web Application: http://127.0.0.1:8000
- Node.js Server: http://localhost:6001

## ⚙️ Configuration

### Environment Variables

Below is a structured list of important variables. Do NOT commit real secrets. Replace with placeholders in shared documentation.

#### Core Application

```env
APP_NAME=SafeZone
APP_ENV=local                # use 'local' for development
APP_KEY=base64:generated_key # php artisan key:generate
APP_DEBUG=true               # set false in production
APP_URL=http://127.0.0.1:8000
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US
LOG_CHANNEL=stack
LOG_LEVEL=info               # elevate to 'error' in production
```

#### Database & Session

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=SafeZone
DB_USERNAME=root
DB_PASSWORD=your_db_password
SESSION_DRIVER=database
SESSION_LIFETIME=120
QUEUE_CONNECTION=database
CACHE_STORE=database
```

#### Mail (Use placeholders; never publish real credentials)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@example.com
MAIL_PASSWORD=your_mail_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@example.com
MAIL_FROM_NAME="SafeZone"
```

#### Mapping & Weather

```env
MAPTILER_KEY=your_maptiler_api_key
WINDY_API_KEY=your_windy_api_key           # if using wind data overlays
```

#### Real-time / Node Integration

```env
NODE_SERVER_URL=http://localhost:6001       # empty or internal URL for local dev
NODE_SERVER_KEY=your_node_shared_secret     # if authenticated broadcast is required
```

#### SMS / Notifications (Optional)

```env
SMS_ENABLED=false
VONAGE_SMS_FROM=+1234567890
VONAGE_KEY=your_vonage_key
VONAGE_SECRET=your_vonage_secret
```

#### External AI / LLM Keys (Example: Gemini)

```env
GEMINI_API_KEY=your_gemini_api_key          # abstracted behind PREDICTION_PROVIDER when provider=gemini
```

#### Node.js Server (.env)

```env
PORT=6001
CORS_ORIGIN=http://127.0.0.1:8000
```

#### Recommended Production Adjustments

- Set `APP_ENV=production`, `APP_DEBUG=false`
- Use distinct secrets per environment
- Rotate keys periodically (MAIL, AI, SMS, NODE_SERVER_KEY)
- Restrict CORS origins to trusted domains

> Tip: Keep a `.env.example` with placeholders, never commit actual secrets.

#### Sample `.env.example`

Provide a sanitized template instead of committing real values. Keep your actual `.env` (with real keys) untouched.

```env
APP_NAME=SafeZone
APP_ENV=local
APP_KEY=base64:generated_app_key_here
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

LOG_CHANNEL=stack
LOG_LEVEL=info

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=SafeZone
DB_USERNAME=root
DB_PASSWORD=local_db_password

SESSION_DRIVER=database
SESSION_LIFETIME=120
QUEUE_CONNECTION=database
CACHE_STORE=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@example.com
MAIL_PASSWORD=your_mail_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@example.com
MAIL_FROM_NAME="SafeZone"

MAPTILER_KEY=your_maptiler_api_key
WINDY_API_KEY=your_windy_api_key

NODE_SERVER_URL=http://localhost:6001
NODE_SERVER_KEY=your_node_shared_secret

GEMINI_API_KEY=your_gemini_api_key
PREDICTION_ENABLED=false
PREDICTION_PROVIDER=gemini
PREDICTION_API_URL=https://api.example.com/predict
PREDICTION_API_KEY=your_prediction_api_key
PREDICTION_MODEL=disaster-v1
PREDICTION_MIN_CONFIDENCE=0.35

SHELTER_SEARCH_RADIUS_DEFAULT=15000
SHELTER_MAX_RESULTS=5
SHELTER_DISTANCE_UNIT=km

SMS_ENABLED=false
VONAGE_SMS_FROM=+1234567890
VONAGE_KEY=your_vonage_key
VONAGE_SECRET=your_vonage_secret
```

> NOTE: The actual `.env` in the repository should not be altered by README changes; this section is purely reference.

#### Current Local `.env` (Redacted for Safety)

Below reflects your provided configuration. Sensitive secrets are partially masked. Keep full values only in your private `.env` file and never commit real credentials to public repos.

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=taile13092k5@gmail.com
MAIL_PASSWORD=zzpqgdgkvxkfffsr   # consider rotating; shown fully per request
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=taile13092k5@gmail.com
MAIL_FROM_NAME="SafeZone"

MAPTILER_KEY=qZoV9xK3lbigItO9C8oI
NODE_SERVER_URL=http://node-server:6001
NODE_SERVER_KEY=faqrSFytaU1WexPfA0paaVJNefI0EqgM
WINDY_API_KEY=zu6Mv5EaVxba5gKL5yBXzd1EgKJayk8A
GEMINI_API_KEY=AIzaSyB1YRMbc2Xr8DaDPitPmbA0DFaQqT0GUr0

SMS_ENABLED=false
VONAGE_SMS_FROM=+84374169035
VONAGE_KEY=429b83d5
VONAGE_SECRET=C6fmQRhPZHormQhI
```

> Security Note: Consider replacing exposed secrets above with placeholders before sharing the README publicly. Rotate any keys already published.

### Map Configuration

1. Get a free API key from [MapTiler](https://www.maptiler.com/)
2. Add to your `.env` file:

```env
MAPTILER_KEY=your_api_key_here
```

3. Reference in Blade templates:

```javascript
const MAPTILER_KEY = '{{ config('services.maptiler.key') }}';
```

## 📖 Usage

### Creating an Admin User

```bash
php artisan tinker
```

```php
$user = User::create([
    'name' => 'Admin',
    'email' => 'admin@safezone.com',
    'password' => bcrypt('password'),
    'role' => 'admin'
]);
```

### Creating an Alert

1. Login as admin
2. Navigate to Admin Dashboard
3. Click "Create Alert"
4. Fill in alert details:
   - Title
   - Type (flood, fire, earthquake, storm, other)
   - Severity (low, medium, high, critical)
   - Description
   - Location
   - Radius
   - Image (optional)
5. Submit

### Managing User Addresses

1. Login as user
2. Go to Profile → Addresses
3. Add addresses to monitor
4. View alerts filtered by your locations

## 📁 Project Structure

```
SafeZoneVN/
├── SafeZone/              # Laravel application
│   ├── app/
│   │   ├── Http/Controllers/
│   │   ├── Models/
│   │   ├── Notifications/
│   │   └── Services/
│   ├── resources/
│   │   ├── views/         # Blade templates
│   │   └── js/           # Frontend assets
│   ├── routes/
│   ├── database/
│   └── public/
├── node-server/          # Real-time Socket.IO server
│   ├── server.js
│   └── package.json
├── nginx/               # Nginx configuration
├── mysql/               # MySQL data
└── docker-compose.yml   # Docker orchestration
```

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Authors

- **Lê Đức Anh Tài** - _Initial work_ - [leducanhtai](https://github.com/leducanhtai)

## 🙏 Acknowledgments

- Laravel Framework
- MapLibre GL JS
- Socket.IO
- Tailwind CSS
- Alpine.js
- All contributors and testers

## 📧 Contact

For any inquiries or support, please contact:

- Email: taile13092k5@gmail.com.com
- GitHub: [@leducanhtai](https://github.com/leducanhtai)

---

Made with ❤️ for safer communities
