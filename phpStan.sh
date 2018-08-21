#!/bin/bash

reset

if [[ -z $1 ]]; then
    stan_path="./src"
else
    stan_path="$1"
fi

echo $stan_path

./vendor/bin/phpstan analyse \
    --configuration=./phpstan.neon \
    --level=4 \
    --memory-limit=4096M \
    "${stan_path}"
