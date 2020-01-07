#!/bin/bash
php artisan serve --port 9097 --host 0.0.0.0 &
laravel-echo-server start &
npm run watch &
npm run open-cypress
