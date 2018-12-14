#!/usr/bin/env bash

# encore
yarn install
node assets.config.js
yarn build

# inky
cd _mail
yarn install
yarn build
