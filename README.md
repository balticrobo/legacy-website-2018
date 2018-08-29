# Baltic Robo Battles

Event website using Symfony 4.0.

## Development environment

We are using Docker composer to setup dev env.

You will need Docker engine in version **>= 18.06.0**.

To run container you have to enter command from the project root.

```bash
docker-compose up # with -d to daemonize
```

Containers will be ready to active development with installed composer packages,
 node packages and running nginx with php-fpm and yarn watch to compile assets.

#### Docker pages
* [localhost:8000](http://localhost:8000) - BRB webpage,
* [localhost:8001](http://localhost:8001) - MailHog,
* [localhost:8002](http://localhost:8002) - Inky (email preview),
* localhost:1025 - Mailhog SMTP,
* localhost:3306 - MySQL,
* localhost:9000 - PHP Xdebug.

For more information check `docker-compose.yaml` and `docs/docker/`.

### Validate commits

`composer.json` have script which sets default **pre-commit hook** to GIT. If
 you know what are you doing, you can change or remove it in file
 `docs/hooks/pre-commit`.

Same rules of validating commits are included in [Gitlab CI](#gitlab-ci).

## CI/CD

### Gitlab CI

You can use Gitlab CI with config from `gitlab-ci.yml`.

You have to set next parameters:

| Parameter | Description | Private |
| --- | --- | --- |
| CI_DATABASE_USER | username for MySQL database on CI runner | false |
| CI_DATABASE_PASSWORD | password for MySQL database on CI runner | false |
| DEVELOP_HOST | `username@host` where should be uploaded files from **develop** | true |
| DEVELOP_DIRECTORY | `/path/to/folder` where should be stored files from **develop** | true |
| DEVELOP_EMAIL_ASSETS_DOMAIN | full domain WITH trailing slash for **develop** | false |
| PROD_HOST | `username@host` where should be uploaded files from **master** | true |
| PROD_DIRECTORY | `/path/to/folder` where should be stored files from **master** | true |
| PROD_EMAIL_ASSETS_DOMAIN | full domain WITH trailing slash for **master** | false |
| PROD_SENTRY_RELEASE_WEBHOOK_ADDRESS | address where you should enter info about each new prod release | true |

*_EMAIL_ASSETS_DOMAIN, eg `https://baltyckiebitwyrobotow.pl/email/`
