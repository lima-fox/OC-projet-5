# OpenClassRooms projet 5

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/073c18dd490d4192a4e582895fd2c7c7)](https://app.codacy.com/gh/lima-fox/OC-projet-5?utm_source=github.com&utm_medium=referral&utm_content=lima-fox/OC-projet-5&utm_campaign=Badge_Grade_Settings)


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