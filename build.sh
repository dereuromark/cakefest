#!/bin/bash
# Warning: This is NOT a productive script, but for local dev envs only!

echo "### INSTALL/UPDATE ###";
[ ! -f composer.phar ] && curl -sS https://getcomposer.org/installer | php
php composer.phar selfupdate

git pull

php composer.phar install --prefer-dist --no-dev --optimize-autoloader --no-interaction

chmod +x bin/cake

[ ! -f config/app_local.php ] && cp config/app_local.default.php config/app_local.php

mkdir -p ./tmp
mkdir -p ./logs
mkdir -p ./webroot/js/cjs/
mkdir -p ./webroot/css/ccss/

#echo "### DB MIGRATION ###";
#bin/cake Migrations migrate

echo "### ASSETS ###";
bin/cake AssetCompress.AssetCompress build

echo "### CLEANUP ###";
rm -rf ./tmp/cache/models/*
rm -rf ./tmp/cache/persistent/*

chown -R www-data:www-data *
chmod -R 0770 ./tmp
chmod -R 0770 ./webroot/js/cjs/
chmod -R 0770 ./webroot/css/ccss/

echo "### DONE ###";
