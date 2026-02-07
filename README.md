# Házi feladat - Fauszt András

### To run

~~~shell
# Copy env file and update values
cp .env .env.local

docker compose up -d
~~~

Open in the browser at `http://localhost`

~~~shell
# Open interactive shell to the container
docker compose exec -it app /bin/bash

# Migrate database
php bin/console doctrine:migrations:migrate
# Seed database
php bin/console doctrine:fixtures:load
~~~
