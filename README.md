# Laravel Vue To-Do

This application was built using Laravel and Vue.js with the intent of showcasing the languages abilities to bootstrap a simple to-do list.

![](https://i.ibb.co/s6xXRYM/imagem.png)

### Prerequisites
You need to have the [Docker Engine](https://docs.docker.com/engine/install/) installed to setup and run the application. 

### Setup
Follow these steps one-by-one to install the application.
```
$ git clone https://github.com/joaopatrocinio/laravel-vue-todo.git
$ cd laravel-vue-todo/
$ cp .env.example .env
$ docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
$ ./vendor/bin/sail up -d
$ ./vendor/bin/sail artisan key:generate
$ ./vendor/bin/sail artisan migrate:fresh --seed
$ ./vendor/bin/sail npm install
$ ./vendor/bin/sail npm run build
```

The application should now be available at [http://localhost](http://localhost)

To shutdown the application run the command `./vendor/bin/sail down`

### Documentation
The backend API is documented at [http://localhost/api/documentation](http://localhost/api/documentation) with Swagger UI.

### Testing
Feature tests are available with the command `./vendor/bin/sail artisan test`