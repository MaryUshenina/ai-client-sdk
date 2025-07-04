<?php

namespace MaryUshenina\AiClientSdk;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class OpenAIClient implements ChatCompletionClientInterface
{
    protected ClientInterface $http;
    protected string $apiKey;

    public function __construct(ClientInterface $http, string $apiKey)
    {
        $this->http = $http;
        $this->apiKey = $apiKey;
    }

    public function complete(
        array $messages,
        string $model = 'gpt-3.5-turbo',
        ?string $systemPrompt = null,
        float $temperature = 0.0
    ): string {
        if ($systemPrompt !== null) {
            array_unshift($messages, [
                'role' => 'system',
                'content' => $systemPrompt,
            ]);
        }

        try {
            $response = $this->http->request('POST', 'https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => $model,
                    'messages' => $messages,
                    'temperature' => $temperature,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return $data['choices'][0]['message']['content'] ?? '';
        } catch (GuzzleException $e) {
            return '';
        }
    }
}
