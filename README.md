# Laravel Excludable

[![Latest Version on Packagist](https://img.shields.io/packagist/v/zaratedev/laravel-excludable)
[![Total Downloads](https://img.shields.io/packagist/dt/zaratedev/laravel-excludable.svg?style=flat-square)](https://packagist.org/packages/zaratedev/laravel-excludable)
[![GitHub Actions](https://github.com/zaratedev/laravel-excludable/actions/workflows/main.yml/badge.svg?branch=main)](https://github.com/zaratedev/laravel-excludable/actions/workflows/main.yml)

![Banner](https://banners.beyondco.de/Laravel%20Excludable.png?theme=light&packageManager=composer+require&packageName=zaratedev%2Flaravel-excludable&pattern=fourPointStars&style=style_1&description=Exclude+the+provided+elements+from+the+query+results&md=1&showWatermark=0&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg)

This package allow to your eloquent models apply exclude provides elements from the query results.

## Installation

You can install the package via composer:

```bash
composer require zaratedev/laravel-excludable
```

## Usage
Use the Excludable trait in any Eloquent Model.

```php

use Illuminate\Database\Eloquent\Model;
use ZarateDev\LaravelExcludable\Excludable;

class User extends Model
{
    use Excludable;
}
```

Now you have available scope `exclude()` method in Eloquent Model.

```php

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $users = User::query()->exclude($user)->get();

        return view('users.index', compact('users'));
    }
}
```

The method `exclude` can recieved attribute of type collection, model, integer, array. For more examples see test suits.

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email zaratedev@gmail.com instead of using the issue tracker.

## Credits

-   [Jonathan Zarate](https://github.com/zaratedev)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
