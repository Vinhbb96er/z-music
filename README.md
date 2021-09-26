## System requirements
1. OS: Mac/Linux
2. Web server: Apache2/Nginx
3. PHP version: 7.1
4. Laravel version: 5.8
5. Composer version: 1.10

## Initialization
### 1. Docker
- Set up .env
```
cp .env.example .env
```
- Build & Run docker
```
docker-compose up --build -d
```
- Migrate DB
  * Access docker container app
    ```
    docker-compose exec app sh
    ```
  * Run migrate DB command
    ```
    php artisan migrate --seed
    ```
  * Generate jwt secret
    ```
    php artisan jwt:secret
    php artisan clear-compiled && php artisan optimize
    php artisan storage:link
    ```
