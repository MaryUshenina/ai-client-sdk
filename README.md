# AI Client SDK for PHP

Lightweight SDK for interacting with the OpenAI Chat Completion API using PHP.

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

## License

MIT
