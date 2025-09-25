<?php

namespace MaryUshenina\AiClientSdk\Exception;

use RuntimeException;
use Throwable;

class OpenAiClientException extends RuntimeException
{
    protected ?int $statusCode = null;
    protected ?string $responseBody = null;

    public function __construct(
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null,
        ?int $statusCode = null,
        ?string $responseBody = null,
    ) {
        parent::__construct($message, $code, $previous);
        $this->statusCode = $statusCode;
        $this->responseBody = $responseBody;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    public function getResponseBody(): ?string
    {
        return $this->responseBody;
    }
}
