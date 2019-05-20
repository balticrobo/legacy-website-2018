#!/usr/bin/env bash

cd _mail/
cp config.dist.json config.json
yarn
yarn start
