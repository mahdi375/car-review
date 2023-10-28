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
---

### screenshots
- tests result
    ![](doc/Screenshot%20from%202023-10-28%2022-02-07.png)
- postman collection
    ![](doc/Screenshot%20from%202023-10-28%2021-59-57.png)