## Project Setup Guide

Before setting up the project, make sure you have the following installed:

PHP (>= 8)
Composer
MySQL or any other database of your choice
Node.js (for frontend, if applicable)
Laravel (version 8.x or later)

## Install Dependencies
git clone https://github.com/yourusername/project-name.git
cd project-name

## Install PHP Dependencies
run: composer install
cp .env.example .env to create .env file
php artisan key:generate to generate application key

## Set Up Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

## Setting Up L5 Swagger
run: composer require "darkaonline/l5-swagger"

## Publish L5 Swagger Configuration
php artisan vendor:publish --provider="L5Swagger\L5SwaggerServiceProvider"

## Set Up Swagger Environment Variables
L5_SWAGGER_CONST_HOST=http://127.0.0.1:8000
L5_SWAGGER_USE_ABSOLUTE_PATH=true
L5_SWAGGER_UI_ASSETS_PATH=vendor/swagger-api/swagger-ui/dist/
L5_SWAGGER_GENERATE_ALWAYS=true

## Generate Swagger Documentation
php artisan l5-swagger:generate

## Access the API Documentation
http://127.0.0.1:8000/docs

## Run Database Migrations
php artisan migrate

## Run the Development Server
php artisan serve

## Visit the Swagger UI
http://127.0.0.1:8000/docs

## API Endpoints

## Permissions
GET /api/permissions: Get all permissions.
POST /api/permissions: Create a new permission.
POST /api/permissions/assign: Assign a permission to a role.

## Roles
GET /api/roles: Get all roles.
POST /api/roles: Create a new role.
PUT /api/roles/{id}: Update a role.
DELETE /api/roles/{id}: Delete a role.
