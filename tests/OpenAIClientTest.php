<?php

namespace MaryUshenina\AiClientSdk\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use MaryUshenina\AiClientSdk\OpenAIClient;
use PHPUnit\Framework\TestCase;

class OpenAIClientTest extends TestCase
{
    public function testItReturnsChatCompletionResponse()
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

    public function testItReturnsEmptyStringOnError()
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

    public function testCompleteSendsCorrectPayload()
    {
        $http = $this->createMock(ClientInterface::class);

        $http->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://api.openai.com/v1/chat/completions',
                $this->callback(function ($options) {
                    $json = $options['json'];

                    $this->assertEquals('gpt-3.5-turbo', $json['model']);
                    $this->assertEquals(0.7, $json['temperature']);

                    // Проверяем наличие systemPrompt в messages
                    $this->assertEquals('system', $json['messages'][0]['role']);
                    $this->assertEquals('You are a helpful assistant.', $json['messages'][0]['content']);

                    // Проверяем user message
                    $this->assertEquals('user', $json['messages'][1]['role']);
                    $this->assertEquals('Hello!', $json['messages'][1]['content']);

                    return true;
                })
            )
            ->willReturn(
                new Response(200, [], json_encode([
                    'choices' => [
                        ['message' => ['content' => 'Hi there!']]
                    ]
                ]))
            );

        $client = new OpenAIClient($http, 'test-api-key');

        $response = $client->complete(
            [['role' => 'user', 'content' => 'Hello!']],
            'gpt-3.5-turbo',
            'You are a helpful assistant.',
            0.7
        );

        $this->assertEquals('Hi there!', $response);
    }
}
