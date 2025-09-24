# Changelog

All notable changes to this project will be documented in this file.

## [dev-main] 2025-09-24
### Added
- Support for setting a default model via `OpenClient` constructor.
- `OpenClient::getDefaultModel()` method to retrieve the default model.
- `OpenClient::getKey()` method to access the API key.
> These additions improve compatibility with client interfaces and allow greater flexibility when integrating with DI containers or higher-level service abstractions.

## [dev-main] 2025-07-03
### Added
- `systemPrompt` support (as first message with role: system)
- Optional `temperature` parameter (default: 0.0)

## [v0.1.0] - 2025-07-03
### Added
- Initial release of `ai-client-sdk`
- PSR-4 structured SDK for OpenAI ChatCompletion API
- Interface: `ChatCompletionClientInterface`
- Implementation: `OpenAIClient`, `FakeClient`
- Basic PHPUnit test coverage with Guzzle mocking
- GitHub Actions CI (PHP 8.1, 8.2, 8.3)
- Dockerfile (optional, not required)
- `Makefile` for dev convenience
