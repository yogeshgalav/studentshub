#!/bin/bash

composer install
npm install
php artisan cache:clear
php artisan migrate
npm run watch
