# Terranet News

terranet/news provides the default skeleton from Admin Architect news module.
It includes News, News Categories modules as like as eloquent models and repository.

## Installation

Learn the composer how to install the package by registering new repository

```
"repositories": [
    {
        "type": "git",
        "url": "git@gitlab.top.md:terranet/news.git"
    }
]
```
then require it:

```
composer require terranet/news
```

register News service provider by adding to the app/config.php `providers` section:

```
'providers' => [
	...
	Terranet\News\ServiceProvider::class
	...
]
```

now you can publish the whole package resources by running:

```
php artisan vendor:publish [--provider="Terranet\\News\\ServiceProvider"]
```
Two new modules: News and NewsCategories will be copied into the `App\Http\Terranet\Administrator\Modules` directory.
Also associated eloquent models will be added as well to `app` directory...

## Migrations

Run artisan command to create migration:

```
php artisan news:tables
```

this will create the migration file in the database/migrations directory...

Run migration:
```
php artisan migrate
```