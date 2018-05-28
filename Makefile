test:
	./vendor/bin/phpunit tests/

coverage:
	./vendor/bin/phpunit --coverage-html ./logs/coverage --whitelist src/ tests/
