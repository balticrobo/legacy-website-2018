#!/usr/bin/env bash

function run {
  echo "############ $1 ############" | tr '_' ' '
  shift
  eval $@
  quit_when_fail
}

function quit_when_fail {
  if [[ $? -ne 0 ]]; then
    echo "> Task failed!"
    exit 1
  fi
}

run Install_vendors_from_Composer composer install
run Lint_configs bin/console lint:yaml config
run Lint_translations bin/console lint:yaml translations
run Lint_templates bin/console lint:twig templates
run PHP_CodeSniffer vendor/bin/phpcs -p
run PHP_Code_Styler vendor/bin/php-cs-fixer fix --dry-run --diff -vvv
run VarDump_Check vendor/bin/var-dump-check --symfony src
