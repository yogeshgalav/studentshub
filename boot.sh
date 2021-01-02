#!/bin/bash

composer install
npm i
php artisan migrate:fresh
php artisan db:seed
php artisan passport:install
php artisan passport:client --personal --name="Actionable Conversations Personal Access Client"
npm run watch
