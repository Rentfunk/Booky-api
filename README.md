# Booky-api
API for application Booky

Older version: https://github.com/Rentfunk/Booky-backend-old

# Developer setup

Install `composer` https://getcomposer.org/download/

Install all dependencies and libraries with `composer install`.

Run `docker-compose up -d` or `docker compose up -d` and then `symfony console doctrine:migrations:migrate`

And finally run `symfony serve -d`
