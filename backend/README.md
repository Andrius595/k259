## Requirements

- Docker
- Composer
- WSL2 (For Windows only)

## First time installation

Copy environment file
```bash
cp .env.example .env
```

Install vendor dependencies
```bash
composer install
```

Start project in the background
```bash
./vendor/bin/sail up -d
```

Generate app key
```bash
./vendor/bin/sail artisan key:generate
```

Run database migrations
```bash
./vendor/bin/sail artisan migrate:fresh
```
