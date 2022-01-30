# Laravel State Machine

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jxckaroo/state-machine.svg?style=flat-square)](https://packagist.org/packages/jxckaroo/state-machine)
[![Total Downloads](https://img.shields.io/packagist/dt/jxckaroo/state-machine.svg?style=flat-square)](https://packagist.org/packages/jxckaroo/state-machine)
![GitHub Actions](https://github.com/Jxckaroo/laravel-state-machine/actions/workflows/php-cs-fixer.yml/badge.svg)
![GitHub Actions](https://github.com/Jxckaroo/laravel-state-machine/actions/workflows/php-cs-fixer.yml/badge.svg)
![GitHub Actions](https://github.com/Jxckaroo/laravel-state-machine/actions/workflows/psalm.yml/badge.svg)
![GitHub Actions](https://github.com/Jxckaroo/laravel-state-machine/actions/workflows/run-tests.yml/badge.svg)

This simple state machine allows transitioning model states based on pre-defined rules.

## Installation

You can install the package via composer:

```bash
composer require jxckaroo/laravel-state-machine
```

Run the package migrations:

```bash
php artisan migrate
```

## Usage

Add the `Jxckaroo\StateMachine\Stateable` trait to your model(s) that require state management & define your states on your model(s):

### States & Rules

Below is an example of a ready-to-go model.

```php
use Illuminate\Database\Eloquent\Model;
use Jxckaroo\StateMachine\Stateable;

class Order extends Model
{
    use Stateable;

    protected array $states = [
        'factory' => ExampleRule::class,
        'complete' => [
            ExampleRule::class,
            ExampleRuleFalse::class
        ]
    ];

    // ...
}
```

When defining your states, you can specify either one or many rules as above. Your rules must extend `Jxckaroo\StateMachine\Contracts\StateRule` and must contain a `validate` method as per the below example:

```php
class ExampleRule extends StateRule
{
    public function validate(Model $model): bool
    {
        return $model->getKey() !== null;
    }
}

```

### Model Interactions

```php
// Get model
$order = Order::find(1);

// Get current state of a model
$order->state;

// Get the state history of a model
$order->stateHistory;

// Attempt to transition model to one of your defined states
$order->transitionToState("factory");

// Attempt to transition model to previous state as defined in $order->states
$order->transitionToPreviousState();

// Attempt to transition model to next state as defined in $order->states
$order->transitionToNextState();

// Get all available states on model
$order->states();
```

Check if a state transition is successful:

```php
$order = Order::find(1);

if ($order->transitionToState("complete")->isSuccessful()) {
    // Successful transition
} else {
    // Get an array of all rules that failed
    $order->transitionToStateErrors();
}
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email jack@javeloper.co.uk instead of using the issue tracker.

## Credits

- [Jack Mollart](https://github.com/jxckaroo)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
