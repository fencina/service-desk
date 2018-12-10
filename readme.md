## Requirements

- PHP >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extension

## Installation

Clone this repository and configure the environment. Copy the .env.example file into a .env file,
in root directory.

- cp .env.example .env

You must create a mysql DB and configure the next .env variables

```
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

API_URL=
API_USER=
API_PASSWORD=
```

Once configured, step into root directory and run this commands:
1. composer install
2. php artisan key:generate
3. php artisan migrate

## Run

Set up your favourite web server and visit root page or hit api endpoints.
If you have PHP installed locally and you would like to use PHP's built-in development server to serve your application, you may use the serve Artisan command. This command will start a development server at http://localhost:8000:
```
php artisan serve
```
For endpoints documentation, import `Service Desk.postman_collection.json` file into Postman.


## Test

Run phpunit in root directory.
You can use phpunit vendor from project, running `./vendor/bin/phpunit`

