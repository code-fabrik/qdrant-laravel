# Qdrant Laravel

## Installation

Install the package via Composer:

```bash
composer require codefabrik/qdrant-laravel
```

Publish the configuration file:

```bash
php artisan vendor:publish --tag="qdrant-laravel-config"
```

## Usage

Configure the client in the .env file:

```bash
QDRANT_HOST=http://localhost
QDRANT_PORT=6333
QDRANT_COLLECTION=publicsearch
```

Create a client:

```php
$qdrant = new QdrantClient();
```

Run actions:

```php
$qdrant->collection()->create(1024, 'Cosine');
```

### Methods

Check if the collection already exists

```php
$qdrant->collection()->exists()
```

Create the collection

```php
$qdrant->collection()->create(int $vectorSize, string $distanceMetric)
```

* vectorSize: the length of the vectors to store, e.g. `1024`
* distanceMetric: the method for distance calculation, e.g. `Cosine`

## Development

### Linting

`./vendor/bin/pint`

### Static Code Analysis

`./vendor/bin/phpstan analyse`
