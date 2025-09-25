<?php

namespace MaryUshenina\AiClientSdk;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use MaryUshenina\AiClientSdk\Exception\OpenAiClientException;

class OpenAIClient implements ChatCompletionClientInterface
{
    public const DEFAULT_MODEL = 'gpt-3.5-turbo';

    public function __construct(
        protected ClientInterface $http,
        protected readonly string $apiKey,
        protected readonly ?string $defaultModel = self::DEFAULT_MODEL
    ) {
    }

    public function complete(
        array $messages,
        ?string $model = null,
        ?string $systemPrompt = null,
        float $temperature = 0.0
    ): string {

        if (!is_null($systemPrompt)) {
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
                    'model' => $model ?? $this->defaultModel,
                    'messages' => $messages,
                    'temperature' => $temperature,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return $data['choices'][0]['message']['content'] ?? '';
        } catch (GuzzleException $e) {
            $statusCode = $e->getCode();
            $body = method_exists($e, 'getResponse') && $e->getResponse()
                ? (string) $e->getResponse()->getBody()
                : null;

            throw new OpenAiClientException(
                'Failed to get chat completion from OpenAI: ' . $e->getMessage(),
                0,
                $e,
                $statusCode,
                $body
            );
        }
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getDefaultModel(): string
    {
        return $this->defaultModel;
    }
}
