# Aptus

## Description

a social media app.

## Framework

Aptus uses [Laravel](http://laravel.com), the best existing PHP framework, as the foundation framework.

## Installation Steps

> prerequisite: PHP > 8.1

* clone repository
* composer

### Local installation

* Create DB `aptus`
* `composer install`
* `composer setup` (copies `env` file, generates key, and migrates DB)
* Create sample data (optional): `php artisan db:seed`
* `npm install`
### Development

* Run `php artisan serve`
* Run `npm run dev`