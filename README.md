# Baltic Robo
[![Build Status](https://travis-ci.org/balticrobo/legacy-website.svg?branch=master)](https://travis-ci.org/balticrobo/legacy-website)

Baltic Robo Event website. Allows to show detailed info, rules, register teams,
 members and constructions for event and hackathon. Also volunteers can register
 via this website. Many more powerful things are incoming.
## Development environment
We are using Docker Compose to setup environment.

To run container you have to enter command from the project root.
```bash
docker-compose up
```
Containers will be ready to active development with installed composer packages,
 node packages and running nginx with php-fpm and yarn watch to compile assets.
#### Pages and ports
| Service              | Address                                 | Port |
| -------------------- | --------------------------------------- | ---- |
| Website              | [localhost:8000](http://localhost:8000) | 8000 |
| Inky (email preview) | [localhost:8001](http://localhost:8001) | 8001 |
| Mailhog client       | [localhost:8002](http://localhost:8002) | 8002 |
| PhpMyAdmin           | [localhost:8003](http://localhost:8003) | 8003 |
| Mailhog SMTP         | ---                                     | 1025 |
| MySQL                | ---                                     | 3306 |
### Validate commits
`composer.json` have script which sets default **pre-commit hook** to GIT. If
 you know what are you doing, you can change or remove it in file
 `.misc/hooks/pre-commit`.
## CI/CD
### Travis
You can use Travis CI with config from `.travis.yml`.
###### Parameters
| Parameter                             | Description                                                     |
| ------------------------------------- | --------------------------------------------------------------- |
| PROD_HOST                             | `username@host` where should be uploaded files from **master**  |
| PROD_DIRECTORY                        | `/path/to/folder` where should be stored files from **master**  |
| PROD_EMAIL_ASSETS_DOMAIN              | full domain WITH trailing slash for **master**                  |
| DEPLOY_SENTRY_RELEASE_WEBHOOK_ADDRESS | address where you should enter info about each new prod release |
