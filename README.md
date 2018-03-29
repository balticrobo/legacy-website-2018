# Baltic Robot Battles

Event website using Symfony 4.0.

## Development environment

We are using Docker composer to setup dev env.

You will need Docker engine in version **>= 17.06.0**.

To run container you have to enter command from the project root.

```bash
docker-compose up # with -d to daemonize
```

Containers will be ready to active development with installed composer packages,
 node packages and running nginx with php-fpm and yarn watch to compile assets.
