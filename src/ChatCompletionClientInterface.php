<?php

namespace MaryUshenina\AiClientSdk;

interface ChatCompletionClientInterface
{
    /**
     * Sends chat messages to a model and returns its raw response.
     *
     * @param array<int, array{role: string, content: string}> $messages
     * @param string $model
     * @return string
     */
    public function complete(array $messages, string $model = 'gpt-3.5-turbo'): string;

    public function getApiKey(): string;

    public function getDefaultModel(): string;
}
