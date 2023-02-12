Quick start with composer (php and mysql required)

copy .env.example to .env
change local db settings

run:
composer install
php artisan serve

seed db:
php artisan db:seed --class=UserSeeder (creates 10 random users and a test user)
php artisan db:seed --class=PostSeeder (you can run this few times for more posts - 10 per run)

using https://github.com/cviebrock/eloquent-taggable for post tags  - this was an experiment


login with:
{
    "email" : "test@example.com",
    "password" : "password"
}


TODO: 
- add authorization trough validator class (for update/delete/profile requests) - remove from controllers
- improve response handling
- add sail?
- improve on routes
- add tests

