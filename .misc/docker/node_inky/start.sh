#!/usr/bin/env bash

cd _mail/
cp config.dist.json config.json
yarn install
yarn start
