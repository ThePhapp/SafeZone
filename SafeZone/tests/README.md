# SafeZone Test Suite

Comprehensive test coverage for SafeZone disaster management platform.

## Test Structure

```
tests/
├── Feature/
│   ├── Admin/
│   │   ├── AlertControllerTest.php     (23 tests)
│   │   └── UserControllerTest.php      (11 tests)
│   ├── Auth/                           (Laravel Breeze defaults)
│   ├── ExampleTest.php
│   └── ProfileTest.php
└── Unit/
    ├── Models/
    │   ├── AlertTest.php               (11 tests)
    │   └── UserTest.php                (12 tests)
    ├── Notifications/
    │   └── AlertCreatedNotificationTest.php (15 tests)
    └── ExampleTest.php
```

## Running Tests

### All tests

```bash
docker compose exec laravel php artisan test
```

### Specific test file

```bash
docker compose exec laravel php artisan test tests/Feature/Admin/AlertControllerTest.php
```

### Specific test method

```bash
docker compose exec laravel php artisan test --filter=admin_can_create_alert_with_valid_data
```

### With coverage (requires Xdebug)

```bash
docker compose exec laravel php artisan test --coverage
```

### Parallel execution (faster)

```bash
docker compose exec laravel php artisan test --parallel
```

## Test Categories

### Feature Tests - AlertController (23 tests)

✅ View alerts index (with filtering & search)  
✅ Create alerts with validation  
✅ Image upload handling  
✅ Realtime broadcast integration  
✅ Notification dispatch to users in radius  
✅ Update & delete alerts  
✅ Authorization checks

### Feature Tests - UserController (11 tests)

✅ View users index with pagination  
✅ Update user details with validation  
✅ Delete users  
✅ Authorization & error handling

### Unit Tests - Alert Model (11 tests)

✅ Fillable attributes & casts  
✅ Relationships (creator, reports, address)  
✅ CRUD operations  
✅ Enum validation (type, severity)

### Unit Tests - User Model (12 tests)

✅ Fillable attributes & hidden fields  
✅ Password hashing  
✅ Relationships (alerts, reports, addresses, rescues, notifications)  
✅ Vonage phone formatting  
✅ Role management

### Unit Tests - AlertCreatedNotification (15 tests)

✅ Queue implementation  
✅ Channel selection (DB, mail, SMS)  
✅ Mail message content  
✅ SMS formatting & truncation  
✅ Array payload structure  
✅ Graceful handling of missing data

## Factories

Created factories for test data generation:

-   `AlertFactory` - with `flood()`, `fire()`, `critical()`, `active()`, `withAddress()` states
-   `ReportFactory`
-   `RescueFactory`
-   `UserFactory` (existing)

## Mocking & Fakes

Tests use Laravel fakes for:

-   `Notification::fake()` - verify notification dispatch without sending
-   `Http::fake()` - mock realtime server broadcast
-   `Storage::fake()` - test file uploads without disk I/O

## Environment

Tests use in-memory SQLite database (configured in `phpunit.xml`):

```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

This ensures:

-   Fast execution
-   No pollution of development database
-   Parallel test support

## Coverage Summary

| Component                | Coverage                                                                     |
| ------------------------ | ---------------------------------------------------------------------------- |
| AlertController          | ✅ Full (create, read, update, delete, validation, broadcast, notifications) |
| UserController           | ✅ Full (CRUD, validation, authorization)                                    |
| Alert Model              | ✅ Full (attributes, relationships, enums)                                   |
| User Model               | ✅ Full (auth, relationships, phone formatting)                              |
| AlertCreatedNotification | ✅ Full (channels, content, edge cases)                                      |

**Total: 72 tests**

## Best Practices

1. **RefreshDatabase** - Each test gets clean database
2. **Factories** - Use factories instead of manual model creation
3. **Fakes** - Mock external services (HTTP, notifications, storage)
4. **Descriptive names** - Test method names describe behavior
5. **Arrange-Act-Assert** - Clear test structure
6. **Edge cases** - Test missing data, validation failures, authorization

## Next Steps

Potential test additions:

-   ShelterController tests
-   DisasterDataController tests
-   Emergency route calculation tests
-   WebSocket realtime event tests
-   API endpoint tests (if API routes exist)
-   Browser tests with Laravel Dusk

## Troubleshooting

### Tests fail with "Class not found"

```bash
docker compose exec laravel composer dump-autoload
```

### Database connection errors

Check `phpunit.xml` has SQLite config:

```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

### Queue/notification tests fail

Ensure fakes are used:

```php
Notification::fake();
Http::fake();
```

### Factory errors

Re-run with verbose output:

```bash
docker compose exec laravel php artisan test --testdox
```
