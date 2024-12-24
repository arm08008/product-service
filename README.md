# Development Setup Instructions

- Add DATABASE_URL="mysql://root:password@127.0.0.1:3306/products_shop?serverVersion=8.0.37" in .env file.
- Add MESSENGER_TRANSPORT_DSN=doctrine://default?auto_setup=0 in .env file.

- Install Dependencies
```bash
composer install
```

- Run migrations to create tables in database
```bash
php bin/console doctrine:migrations:migrate
```

- Start application
```bash
symfony server:start
```

- Run this command to consume messages from the message queue
```bash
php bin/console messenger:consume async
```

## Endpoints

```json
Create products
POST /api/v1/products
Content-Type: application/json

{
    "name": "Test",
    "price": 12
    "quantity": 12
}

List all products
GET /api/v1/products
Content-Type: application/json