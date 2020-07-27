CSS_FILES := $(patsubst %.less, %.css, $(wildcard public/css/*.less))
NM_BIN := ./node_modules/.bin
WS_FILES := Makefile $(wildcard *.php) $(wildcard inc/*.php) $(wildcard public/css/*.less) $(wildcard public/js/*.js) $(wildcard lib/*.php) $(wildcard lib/handlers/*.php) $(wildcard lib/handlers/api/*.php) $(wildcard lib/templates/*.php) $(wildcard public/*.php)

all: whitespace less

%.css: %.less
	$(NM_BIN)/lessc $< | $(NM_BIN)/cleancss -o $@

less: $(CSS_FILES)

run: less
	php --server localhost:8080 --docroot public/ router.php

rsync: whitespace less
	[ -x ./local/rsync.sh ] && ./local/rsync.sh

$(WS_FILES):
	sed -ri --follow-symlinks 's/\s+$$//' $@

.PHONY whitespace: $(WS_FILES)
