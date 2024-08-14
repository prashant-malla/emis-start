#!/bin/bash
set -e

# Check if application is already in production
if grep -q "^APP_ENV=production" .env; then
    echo "The application is already in production mode. Exiting..."
    exit 1
fi

echo "Host started ..."

# Checkout to akmemis branch
git checkout akmemis

# Prompt user for domain name
echo "Enter Domain Name:"
read domainName

# Prompt user for database name
echo "Enter Database Name:"
read dbName

# Prompt user for db username
echo "Enter DB Username:"
read dbUsername

# Prompt user for db password
echo "Enter DB Password:"
read dbPassword

# Copy .env.example to .env
cp .env.example .env

# Update .env settings
sed -i "s/APP_NAME=Laravel/APP_NAME=$domainName/g" .env
sed -i "s/APP_DEBUG=true/APP_DEBUG=false/g" .env
sed -i "s/APP_URL=http:\/\/localhost/APP_URL=https:\/\/$domainName.akmemis.com/g" .env

sed -i "s/DB_DATABASE=test_db/DB_DATABASE=$dbName/g" .env
sed -i "s/DB_USERNAME=root/DB_USERNAME=$dbUsername/g" .env
sed -i "s/DB_PASSWORD=/DB_PASSWORD=$dbPassword/g" .env

# Install composer dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader

# Generate application key
php artisan key:generate

# Clear configuration cache
php artisan config:clear

# Create symbolic link for storage
php artisan storage:link

# Setup .htaccess
cp ../emis_demo/.htaccess .htaccess

# Run database migrations
php artisan migrate

# Run database seeders
php artisan db:seed

# Set application to production
sed -i "s/APP_ENV=local/APP_ENV=production/g" .env

echo "Host setup finished!"
