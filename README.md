# AI Client SDK for PHP

Lightweight SDK for interacting with the OpenAI Chat Completion API using PHP.

[![Tests](https://github.com/MaryUshenina/ai-client-sdk/actions/workflows/tests.yml/badge.svg)](https://github.com/MaryUshenina/ai-client-sdk/actions)
[![Packagist](https://img.shields.io/packagist/v/maryushenina/ai-client-sdk.svg)](https://packagist.org/packages/maryushenina/ai-client-sdk)
[![License](https://img.shields.io/github/license/MaryUshenina/ai-client-sdk)](LICENSE)

## Installation

```bash
composer require maryushenina/ai-client-sdk
```

## Usage

```php
use GuzzleHttp\Client;
use MaryUshenina\AiClientSdk\OpenAIClient;

$client = new OpenAIClient(new Client(), 'your-api-key');

$response = $client->complete([
    ['role' => 'system', 'content' => 'You are a helpful assistant.'],
    ['role' => 'user', 'content' => 'What is PHP?']
]);

echo $response;
```

## Testing

```bash
./vendor/bin/phpunit
```
### Install dependencies
make install

### Rebuild environment (clean + install)
make rebuild

### Run tests inside Docker (optional)
make docker-test

## License

MIT
