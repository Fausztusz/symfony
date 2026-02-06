# Házi feladat - Fauszt András

Futtatás

~~~shell
docker compose up -d
~~~

Az oldal elérhető a böngészőből
~~~
http://localhost
~~~

~~~shell
# Copy env file
cp .env.example .env

# Seed database
php bin/console doctrine:fixtures:load
~~~
