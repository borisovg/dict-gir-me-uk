CSS_FILES = $(patsubst %.less, %.css, $(wildcard public/css/*.less))
WS_FILES = Makefile $(wildcard *.php) $(wildcard inc/*.php) $(wildcard inc/css/*.less) $(wildcard inc/js/*.js) $(wildcard lib/*.php) $(wildcard lib/handlers/*.php) $(wildcard lib/handlers/api/*.php) $(wildcard public/*.php) $(wildcard views/*.php)

all: whitespace less

%.css: %.less
	lessc $< | cleancss -o $@

less: $(CSS_FILES)

run: less
	php --server localhost:8080 --docroot public/ router.php

rsync: whitespace less
	[ -x ./local/rsync.sh ] && ./local/rsync.sh

$(WS_FILES):
	sed -ri --follow-symlinks 's/\s+$$//' $@

.PHONY whitespace: $(WS_FILES)
