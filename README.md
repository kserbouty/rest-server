# REST Server

Learning REST standards with Symfony 5.

Create a CRUD on a server side in order to learn how HTTP requests and responses
are managed by Symfony. Use Serializer and Validator interfaces to send and receive JSON format.

### Technologies

- Symfony 5.2
- PHP 7.2
- MySQL 8.0

### Visuals

![image](./docs/screenshots/create-function.png)

## Installation

### Requirements

- PHP 7.2+ with Composer
- MySQL 8.0+

### Manual installation

Clone the repository :

```bash
git clone https://github.com/kserbouty/rest-server.git
```

Switch to the repository folder :

```bash
cd rest-server
```

Install all the dependencies with composer :

```bash
composer install
```

Make the required configuration changes in the .env file :

> DATABASE_URL="mysql://username:password@127.0.0.1:3306/sandbox_symfony?serverVersion=8.0&charset=utf8"

Run the database migrations :

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

Start a local server :

```bash
php -S localhost:8000 -t public
```

Ports set for <http://localhost:8000>.

### Docker installation

To run with Docker, follow these commands :

```bash
git clone https://github.com/kserbouty/rest-server.git
cd rest-server
docker compose up -d --build
docker exec web-server composer install
```

Make the required configuration changes in the .env file :

```bash
DATABASE_URL="mysql://root:@database:3306/rest_symfony?serverVersion=8.0&charset=utf8"
```

Run the database migrations :

```bash
docker exec web-server php bin/console doctrine:database:create
docker exec web-server php bin/console doctrine:migrations:migrate -q
docker exec web-server php bin/console doctrine:fixtures:load -q
```

Ports set for <http://localhost:8000>.

## Usage

### Parameters

| Name        | Type    | Required |
|-------------|---------|----------|
| name        | string  | Yes      |
| description | string  | Yes      |
| quantity    | integer | Yes      |
| price       | integer | Yes      |

### Endpoints

| HTTP      | Endpoints             | Content-Type     |
|-----------|-----------------------|------------------|
| GET       | /api/json/get         | application/json |
| GET       | /api/json/get/{id}    | application/json |
| POST      | /api/json/create      | application/json |
| PATCH/PUT | /api/json/update/{id} | application/json |
| DELETE    | /api/json/delete/{id} | application/json |

## License

[MIT](./LICENSE.md)

## Project status

*Completed*
