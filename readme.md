# MovieSeeder


This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require arsangamal/movie-seeder
```

<br/>

Publish configuration using
```bash
php artisan vendor:publish --tag=movie-seeder.config
```

<br/>




## Usage

Set the desired options you want in `{app_root}/config/movie-seeder.php`
you can set the cron expression to set the schedule, table names and count of movies to import.


### Schedule Seeding
in the `config/movie-seeder.php` set the cron expression that the scheduler will follow

Add the following lines to `app/Console/Kernel.php`
```php
// get cron expression from config
$expression = config('movie-seeder.configurable_interval_timer');

// register commands to run on schedule
$schedule->command('genre:seed')->cron($expression);
$schedule->command('movie:seed')->cron($expression);
```

<br/>

### Controller and routes
the package defines `/movies` endpoint which gets movies listing
<br/>
you can pass query parameters like `category_id=x` to filter movies


## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [Arsan Gamal][link-author]

## License

license. Please see the [license file](license.md) for more information.


[link-author]: https://github.com/arsangamal
