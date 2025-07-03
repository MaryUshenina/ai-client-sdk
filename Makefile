# Makefile for ai-client-sdk

# Run tests using PHPUnit
.PHONY: test

test:
	vendor/bin/phpunit --testdox

# Install PHP dependencies
.PHONY: install

install:
	composer install

# Remove vendor directory and lock file
.PHONY: clean

clean:
	rm -rf vendor composer.lock

# Clean and reinstall dependencies
.PHONY: rebuild

rebuild: clean install

# Run tests inside Docker container
.PHONY: docker-test

docker-test:
	docker compose up --build --abort-on-container-exit

# Validate composer.json
.PHONY: validate

validate:
	composer validate --strict

# Update dependencies
.PHONY: update

update:
	composer update
