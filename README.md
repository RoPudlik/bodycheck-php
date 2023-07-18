# API Platform & Symfony bodycheck project - Dawid Gurak & Robert Pudlik

Project requirements:
- PHP ^8.1
- Symfony ^6
- Composer ^2
- Redis

Steps to build project locally:

- composer install
- php bin/console assets:install
- symfony server:start -d
- set the proper REDIS_URL environment variable in the .env file 
- load sample data using php bin/console redis:fixtures:load
- connect with the browser to http://localhost:8000/api


