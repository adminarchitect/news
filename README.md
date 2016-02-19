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