<?php
run(
    // Update libraries
    onchange(['composer.json'], 'composer install;') .
    // Update front end
    onchange(['resources/js','resources/sass','resources/images'], 'npm run prod;') .
    // Rebuild database
    onchange(['database/migrations'], 'composer dumpautoload;php artisan migrate;')
);
