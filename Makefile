
vendor/autoload.php:
		composer install

unitTest: vendor/autoload.php
	vendor/bin/phpunit

test: unitTest

bash:
	docker run \
		--name=dotfiles_installer_console \
		--volume=$(shell pwd):/srv \
		--env USERNAME=$(shell whoami) \
		--env UNIX_UID=$(shell id -u) \
		--env=CONTAINER_SHELL=/bin/bash \
		--workdir=/srv \
		--interactive \
		--tty \
		--rm \
		meuhmeuhconcept/php-console \
		/bin/login -p -f $(shell whoami)

console:
	docker run \
		--name=dotfiles_installer_console \
		--volume=$(shell pwd):/srv \
		--volume=$$HOME/.home-developer:/home/developer \
		--env USERNAME=$(shell whoami) \
		--env UNIX_UID=$(shell id -u) \
		--env=CONTAINER_SHELL=/bin/zsh \
		--workdir=/srv \
		--interactive \
		--tty \
		--rm \
		meuhmeuhconcept/php-console \
		/bin/login -p -f $(shell whoami)
