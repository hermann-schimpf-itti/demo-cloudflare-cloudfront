<?php declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use Carbon\Carbon;
use Nwidart\Modules\Laravel\Module;

uses(Tests\TestCase::class)->in(
    'Unit', 'Feature',
    __DIR__.'/../modules/*/Tests/Unit',
    __DIR__.'/../modules/*/Tests/Feature',
);

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

expect()->extend('toHaveDateFormat', function(bool $allow_nullable = false) {
    if ($allow_nullable && $this->value === null) {
        return $this->toBeNull();
    }

    return $this->toMatch('/^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/',
        message: sprintf('Failed asserting that %s has date format %s', $this->value, 'Y-m-d'));
});

expect()->extend('toBeSameDay', function(
    Carbon | DateTimeInterface | string | null $date = null,
    string $format = 'Y-m-d'
) {
    $this->value = Carbon::createFromFormat($format, $value = $this->value)?->isSameDay($date = Carbon::make($date));

    return $this->toBe(true,
        message: sprintf('Failed asserting that %s is same day as %s.', $value, $date->format($format)));
});

expect()->extend('toHaveUnitTests', function() {
    /** @var Module $module */
    $module = $this->value;

    $this->value = count(glob(sprintf('%s/Tests/*/*.php', $module->getPath()))) > 0;

    return $this->toBeTrue(sprintf('Module "%s" doesn\'t have any unit test', $module->getName()));
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}
