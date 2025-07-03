<?php

namespace MaryUshenina\AiClientSdk\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use MaryUshenina\AiClientSdk\OpenAIClient;
use PHPUnit\Framework\TestCase;

class OpenAIClientTest extends TestCase
{
    public function test_it_returns_chat_completion_response()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'choices' => [
                    ['message' => ['content' => 'Hello, world!']]
                ]
            ])),
        ]);

        $client = new Client(['handler' => HandlerStack::create($mock)]);
        $openAiClient = new OpenAIClient($client, 'fake-key');

        $result = $openAiClient->complete([
            ['role' => 'user', 'content' => 'Say hello']
        ]);

        $this->assertEquals('Hello, world!', $result);
    }

    public function test_it_returns_empty_string_on_error()
    {
        $mock = new MockHandler([
            new Response(500, [], 'Internal Server Error'),
        ]);

        $client = new Client(['handler' => HandlerStack::create($mock)]);
        $openAiClient = new OpenAIClient($client, 'fake-key');

        $result = $openAiClient->complete([
            ['role' => 'user', 'content' => 'Trigger error']
        ]);

        $this->assertSame('', $result);
    }
}
