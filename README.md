# Admin Architect - News module
adminarchitect/news provides the default skeleton for Admin Architect news module.
It includes News &amp; News Categories modules out of the box as like as eloquent models and news repository.

## Installation

`Note:` this is not standalone package, it can be used only in conjunction with `Admin Architect` (`terranet/administrator`) package.


then require it:

```
composer require adminarchitect/news
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

## Modules
`News` and `NewsCategories` modules will be copied into the `app\Http\Terranet\Administrator\Modules` directory.

## Models
Associated eloquent models as: `NewsItem`, `NewsCategory` and pivot `NewsCategoryItem` will be added as well to `app` directory.

## Routes
Routes become available at `app\Http\Terranet\News\routes.php`.

## Migrations
Run artisan command to create migration:

```
php artisan news:tables
```

this will create the migration file inside of `database/migrations` directory...

Run migration:
```
php artisan migrate
```

*Enjoy!*
