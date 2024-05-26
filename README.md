# classroom app 🏛️
##Set up backend
Get a clone
Go to backend folder
```
cd classroom-be
```
This project can be set up using sail

Set up project using sail
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```
Run migrations
```
php artisan migrate
```
Run seeders
```
php artisan db:seed
```
## Set up front end
Go to frontend folder
```
cd classroom-fe
```
Install packages
```
npm install
```
Start server
```
npm run dev
```

Enjoy 💠
