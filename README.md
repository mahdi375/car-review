# Devish

### pull the project

```bash
git pull git@github.com:mahdi375/car-review.git
```

### copy env
```bash
cp ./.env.example .env
```

### modify env file if desired
---
### set up docker containers
```bash
docker compose up -d
```

### run seeders
```bash
docker exec -it devish-app-1 php artisan db:seed
```

### run tests
```bash
docker exec -it devish-app-1 php artisan test
```