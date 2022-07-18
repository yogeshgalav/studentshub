#!/bin/bash
eval `ssh-agent`
ssh-add ../personal_key
git reset --hard origin/Version-2.1

# composer install
cd home/studentshub/public_html/opt/remi/php74/root/bin/php /usr/bin/composer install
npm install
php74 artisan cache:clear
php74 artisan migrate
npm run watch
