# Database Dumps

Use this folder for optional SQL dump files used during manual deployment or local restoration.

## Recommended Practice

-   Prefer Laravel migrations + seeders for schema & initial data.
-   Only place anonymized / non-sensitive sample data here.
-   Do NOT commit production dumps containing real user data or secrets.

## Example Dump Creation (MySQL)

```
mysqldump -h 127.0.0.1 -u root -p SafeZone > database/dumps/safezone_sample.sql
```

For a compressed dump:

```
mysqldump -h 127.0.0.1 -u root -p SafeZone | gzip > database/dumps/safezone_sample.sql.gz
```

## Restore

From project root inside container or server:

```
mysql -h 127.0.0.1 -u root -p SafeZone < database/dumps/safezone_sample.sql
```

Or for gzip:

```
gunzip -c database/dumps/safezone_sample.sql.gz | mysql -h 127.0.0.1 -u root -p SafeZone
```

## Suggested Naming

-   safezone_sample.sql (anonymized minimal set)
-   safezone_seed_reference.sql (reference for creating seeders)
-   YYYYMMDD_safezone_structure.sql (schema only)
-   YYYYMMDD_safezone_full.sql.gz (not committed; keep private)

## .gitignore Recommendation

Add lines to `.gitignore` (manual step):

```
# Ignore real/full dumps
SafeZone/database/dumps/*full*.sql*
SafeZone/database/dumps/*.gz
```

Keep only small, safe sample dumps if truly needed.

## Alternative: Seeders

Instead of dumps, create seeders in `database/seeders/`:

```
php artisan make:seeder ShelterSeeder
php artisan db:seed --class=ShelterSeeder
```

## Security Notes

-   Remove emails, phone numbers, API keys before committing.
-   Hash or replace passwords.
-   If in doubt, do not commit the dump.
