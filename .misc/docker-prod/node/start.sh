#!/usr/bin/env bash

# encore
yarn
yarn build

# inky
cd _mail
yarn
yarn build
