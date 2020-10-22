# OpenClassRooms projet 5

## Dependancies
Run composer to install dependancies
```bash
composer install
```

## Configuration
Edit the file `/config/Database.php`
```php
$credentials = [
            'host'      => 'localhost',
            'user'      => 'homestead',
            'dbname'    => 'blog5',
            'password'  => 'secret'
        ];
```

## Database
Import the database structure
`/blog5.sql`