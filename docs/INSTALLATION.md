### Installation

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
