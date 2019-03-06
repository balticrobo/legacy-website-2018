# Baltic Robo
[![Build Status](https://travis-ci.org/balticrobo/legacy-website-2018.svg?branch=master)](https://travis-ci.org/balticrobo/legacy-website-2018)

Event website using Symfony 4.0.

This website was used only at first edition of Baltic Robo event.

## Development environment
We are using Docker compose to setup dev env.

To run container you have to enter command from the project root.
```bash
docker-compose up # with -d to daemonize
```
Containers will be ready to active development with installed composer packages,
 node packages and running nginx with php-fpm and yarn watch to compile assets.

#### Docker pages
| Service              | Address                                 | Port |
| -------------------- | --------------------------------------- | ---- |
| Webpage              | [localhost:8000](http://localhost:8000) | 8000 |
| Mailhog client       | [localhost:8001](http://localhost:8001) | 8001 |
| Inky (email preview) | [localhost:8002](http://localhost:8002) | 8002 |
| PhpMyAdmin           | [localhost:8003](http://localhost:8003) | 8003 |
| Mailhog SMTP         | ---                                     | 1025 |
| MySQL                | ---                                     | 3306 |
| Xdebug (PHP)         | ---                                     | 9000 |

#### Docker compose cheatsheet
* Running containers in background: `docker-compose up -d`,
* Running containers in foreground: `docker-compose up` (logs will be shown in
 console),
* Stop containers: `docker-compose stop`,
* Kill container: `docker-compose kill` (while container not responding),
* Remove containers and data: `docker-compose down -v` (forget project),
* Run command inside container: `docker-compose exec SERVICE_NAME COMMAND`
 where `COMMAND` is command you want to run; Examples:
  * Bash in PHP: `docker-compose exec php bash`
  * MySQL console: `docker-compose exec mysql mysql -uroot -p12345`

### Validate commits
`composer.json` have script which sets default **pre-commit hook** to GIT. If
 you know what are you doing, you can change or remove it in file
 `.misc/hooks/pre-commit`.

## CI/CD
### Travis
You can use Travis CI with config from `.travis.yml`.
You have to set next parameters:

| Parameter                             | Description                                                     |
| ------------------------------------- | --------------------------------------------------------------- |
| PROD_HOST                             | `username@host` where should be uploaded files from **master**  |
| PROD_DIRECTORY                        | `/path/to/folder` where should be stored files from **master**  |
| PROD_EMAIL_ASSETS_DOMAIN              | full domain WITH trailing slash for **master**                  |
| DEPLOY_SENTRY_RELEASE_WEBHOOK_ADDRESS | address where you should enter info about each new prod release |
| encrypted_a54708e5d9c1_iv             | thing related to encrypted SSH key                              |
| encrypted_a54708e5d9c1_key            | thing related to encrypted SSH key                              |
