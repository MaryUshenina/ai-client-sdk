<?php

namespace MaryUshenina\AiClientSdk;

class FakeClient implements ChatCompletionClientInterface
{
    private string $response;

    public function __construct(string $response)
    {
        $this->response = $response;
    }

    public function complete(array $messages, string $model = 'gpt-3.5-turbo'): string
    {
        return $this->response;
    }
}
