TARGET := $(firstword $(MAKECMDGOALS))
ARGS := $(wordlist 2, $(words $(MAKECMDGOALS)), $(MAKECMDGOALS))

ifeq ($(TARGET),exec)
$(eval $(ARGS):;@:)
#previous line can't start with tab
	SERVICE := $(firstword $(ARGS))
	ARGS := $(wordlist 2, $(words $(ARGS)), $(ARGS))
endif


down: stop

exec:
	docker-compose exec $(SERVICE) bash

in:
	@$(MAKE) --silent exec php

restart:
	docker-compose restart

start:
	docker-compose up --detach

stop:
	docker-compose down

test: qa

qa:
	docker-compose exec php composer cmd:qa

up: start

.PHONY: exec in restart start stop qa
