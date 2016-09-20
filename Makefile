
vendor/autoload.php:
		composer install

unitTest: vendor/autoload.php
	vendor/bin/phpunit

test: unitTest

