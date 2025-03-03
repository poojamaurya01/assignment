# Laravel API

<p align="center">
<a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a>
</p>

## About the Project

This project is a Basic Laravel API with authentication, authorization, and encryption features. Users can register, log in, manage their articles, and securely communicate with the API.

## Features

-   User authentication using Laravel Sanctum
-   CRUD operations on articles (Create, Read, Update, Delete)
-   User authorization middleware
-   Secure encryption and decryption of API requests and responses
-   API rate limiting to prevent abuse

## Requirements

-   PHP 8.1 or higher
-   Composer
-   Laravel 11
-   MySQL or SQLite database

## Installation

### Step 1: Clone the Repository

```sh
 git clone https://github.com/poojamaurya01/assignment.git
 cd assignment
```

### Step 2: Install Dependencies

```sh
 composer install
```

### Step 3: Set Up Environment

Copy the `.env.example` file and configure the environment variables.

```sh
 cp .env.example .env
```

Then update the database settings in `.env`:

```env
 DB_CONNECTION=mysql
 DB_HOST=127.0.0.1
 DB_PORT=3306
 DB_DATABASE=your_database_name
 DB_USERNAME=your_username
 DB_PASSWORD=your_password
```

### Step 4: Generate Application Key

```sh
 php artisan key:generate
```

### Step 5: Run Migrations

```sh
 php artisan migrate
```

### Step 6: Start the Server

```sh
 php artisan serve
```

## API Endpoints

### Authentication Routes

-   `POST /api/register` - Register a new user
-   `POST /api/login` - Login and receive an API token

### Article Routes

-   `GET /api/articles` - Retrieve a list of articles
-   `POST /api/articles` - Create a new article
-   `GET /api/articles/{id}` - Retrieve a single article
-   `PUT /api/articles/{id}` - Update an article
-   `DELETE /api/articles/{id}` - Delete an article

### Encryption Routes

-   `POST /api/encrypt` - Encrypt request data
-   `POST /api/decrypt` - Decrypt response data
