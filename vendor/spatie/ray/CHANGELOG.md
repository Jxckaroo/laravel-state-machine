# Changelog

All notable changes to `ray` will be documented in this file

## 1.33.0 - 2022-01-13

1.33.0

- add support for screen colors
- add support for project names
- send hostname along with request

## 1.33.0 - 2022-01-13

- add support for screen colors
- add support for project names
- send hostname along with request

## 1.32.3 - 2022-01-09

- allow Laravel 9

## 1.32.2 - 2021-12-20

- allow symfony 6

## 1.32.1 - 2021-11-30

- fix deprecation warning in PHP 8.1

## 1.32.0 - 2021-11-26

## What's Changed

- Add separator payload by @freekmurze in https://github.com/spatie/ray/pull/599

**Full Changelog**: https://github.com/spatie/ray/compare/1.31.0...1.32.0

## 1.31.0 - 2021-11-17

## What's Changed

- Docs for duplicate queries logging by @masterix21 in https://github.com/spatie/ray/pull/560
- Add context to ApplicationLog by @keithbrink in https://github.com/spatie/ray/pull/562

## New Contributors

- @masterix21 made their first contribution in https://github.com/spatie/ray/pull/560
- @keithbrink made their first contribution in https://github.com/spatie/ray/pull/562

**Full Changelog**: https://github.com/spatie/ray/compare/1.30.4...1.31.0

## 1.30.4 - 2021-11-11

## What's Changed

- Point to "servers" instead of singular "server" by @jmslbam in https://github.com/spatie/ray/pull/583
- Fix for sending "value" (by @freekmurze)

**Full Changelog**: https://github.com/spatie/ray/compare/1.30.3...1.30.4

## 1.30.3 - 2021-10-08

- Bug/567 global functions (#573)

## 1.30.2 - 2021-09-10

- align carbon call argument type with carbon payload (#556)

## 1.30.1 - 2021-09-07

- support PHP 8.1

## 1.30.0 - 2021-08-20

- add `catch` method

## 1.29.2 - 2021-08-15

- revert curl check

## 1.29.1 - 2021-08-14

- fix curl check

## 1.29.0 - 2021-08-02

- add `label` method

## 1.28.0 - 2021-07-04

- add support for base64-encoded images (#499)

## 1.27.1 - 2021-06-24

- remove typehint to allow override

## 1.27.0 - 2021-06-23

- add `once()` (#481)

## 1.26.0 - 2021-06-10

- add rate limiter

## 1.25.0 - 2021-06-07

- add `if` method

## 1.24.0 - 2021-06-04

- add limit method (#464)

## 1.23.0 - 2021-05-29

- add `text` method (#460)

## 1.22.1 - 2021-04-28

- allow Throwables to be logged

## 1.22.0 - 2021-04-28

- access named counter values (#437)

## 1.21.4 - 2021-04-17

- color exceptions red by default

## 1.21.3 - 2021-04-14

- allow spatie/macroable v2 [#426](https://github.com/spatie/ray/pull/426)

## 1.21.2 - 2021-03-04

- fix hostname for other ray packages

## 1.21.1 - 2021-03-03

- do not require hostname

## 1.21.0 - 2021-03-03

- add `hostname` in the origin section of a payload

## 1.20.1 - 2021-02-26

- fix config loading priorities in other packages

## 1.20.0 - 2021-02-22

- add `exception` method

## 1.19.5 - 2021-02-17

- allow instances of `CarbonInterface` to be used for `CarbonPayload` (#316)

## 1.19.4 - 2021-02-11

- fix enabled status (#301)

## 1.19.3 - 2021-02-09

- fix Client cache fingerprint initialization (#292)

## 1.19.2 - 2021-02-09

- add curl throttling after failed connection (#286)

## 1.19.1 - 2021-02-08

- allow symfony/stopwatch 4.0 (#284)

## 1.19.0 - 2021-02-03

- send XML payloads (#272)

## 1.18.0 - 2021-02-03

- add `enable` and `disable` methods

## 1.17.4 - 2021-02-03

- fix: remote_path/local_path replacements (#269)

## 1.17.3 - 2021-02-02

- use http v1.1 instead of 1.0 (#267)

## 1.17.2 - 2021-02-02

- cache config file

## 1.17.1 - 2021-01-27

- add support for PHP 7.3

## 1.17.0 - 2021-01-25

- add `showApp` and `hideApp`

## 1.16.0 - 2021-01-22

- add `phpinfo` method

## 1.15.0 - 2021-01-22

- add `table` method

## 1.14.1 - 2021-01-22

- fix bug when `remote_path` is also in `filePath` (#227)

## 1.14.0 - 2021-01-20

- Add support for CraftRay

## 1.13.0 - 2021-01-18

- the package will now select the best payload type when passing something to `ray()`
- added `html` method
- added `NullPayload`
- added `BoolPayload`

## 1.12.0 - 2021-01-18

- add `carbon`

## 1.11.1 - 2021-01-17

- lower deps

## 1.11.0 - 2021-01-15

- add `image()`

## 1.10.0 - 2021-01-15

- add `clearAll`

## 1.9.2 - 2021-01-15

- fix bugs around settings

## 1.9.1 - 2021-01-15

- improve helper functions

## 1.9.0 - 2021-01-15

- add `count`

## 1.8.0 - 2021-01-14

- add a check for YiiRay's instance

## 1.7.2 - 2021-01-13

- when passing `null`, let argument convertor return `null`

## 1.7.1 - 2021-01-13

- improve return type of ray function

## 1.7.0 - 2021-01-13

- support multiple arguments to `toJson()` and `json()` (#148)

## 1.6.1 - 2021-01-13

- prevent possible memory leak (#143)

## 1.6.0 - 2021-01-13

- add `file` function (#134)

## 1.5.10 - 2021-01-13

- allow better compatibility with WordPress

## 1.5.9 - 2021-01-13

- ignore package version errors

## 1.5.8 - 2021-01-13

- ignore package check errors

## 1.5.7 - 2021-01-13

- remove unneeded symfony/console dependency

## 1.5.6 - 2021-01-13

- allow lower dependencies

## 1.5.5 - 2021-01-11

- split origin factory in overridable functions

## 1.5.4 - 2021-01-11

- support WordPressRay

## 1.5.3 - 2021-01-10

- fix for traces of WordPress

## 1.5.2 - 2021-01-10

- colorize app frames

## 1.5.1 - 2021-01-10

- polish json functions

## 1.5.0 - 2021-01-09

- add `json` function

## 1.4.0 - 2021-01-09

- add `rd` function

## 1.3.7 - 2021-01-09

- add `vendor_frame` attribute to frames

## 1.3.6 - 2021-01-09

- allow older version of uuid package

## 1.3.5 - 2021-01-09

- fix search for `$indexOfRay` to include calls from the parent directory (#80)

## 1.3.4 - 2021-01-08

- prevent warning if `open_basedir` is enabled

## 1.3.3 - 2021-01-08

- do not require Composer 2

## 1.3.2 - 2021-01-08

- prevent ray from blowing up when there is no config file

## 1.3.1 - 2021-01-08

- do not blow up when the Ray app is not running

## 1.3.0 - 2021-01-08

- add support for `remote_path` and `local_path` config values

## 1.2.0 - 2021-01-08

- add `pass` function

## 1.1.3 - 2021-01-08

- prevent exception when installing in an Orchestra powered testsuite

## 1.1.2 - 2021-01-08

- enforce Composer 2 requirement

### 1.1.1 - 2021-01-08

- fix for repeated calls to `ray()` throwing an exception (#30)

## 1.1.0 - 2021-01-07

- add `makePathOsSafe`
- fix tests

## 1.0.1 - 2021-01-07

- fix default settings

## 1.0.0 - 2021-01-07

- initial release
