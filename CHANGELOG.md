# Changelog

All notable changes to `laravel-sitemap` will be documented in this file.

## v1.0.5 - 2025-11-09

### What's Changed

* Bump driftingly/rector-laravel from 2.0.7 to 2.1.2 by @dependabot[bot] in https://github.com/fuelviews/laravel-sitemap/pull/109

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v1.0.4...v1.0.5

## v1.0.4 - 2025-11-09

### What's Changed

* Bump rector/rector from 2.1.7 to 2.2.7 by @dependabot[bot] in https://github.com/fuelviews/laravel-sitemap/pull/108
* Bump spatie/crawler from 8.4.3 to 8.4.5 by @dependabot[bot] in https://github.com/fuelviews/laravel-sitemap/pull/110
* Bump actions/checkout from 4 to 5 by @dependabot[bot] in https://github.com/fuelviews/laravel-sitemap/pull/101
* Bump laravel/pint from 1.24.0 to 1.25.1 by @dependabot[bot] in https://github.com/fuelviews/laravel-sitemap/pull/104

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v1.0.3...v1.0.4

## v1.0.3 - 2025-10-10

### What's Changed

* Change sitemap storage directory from 'sitemap' to 'fv-sitemap' to reflect updated folder structure and update related tests accordingly. by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/106

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v1.0.2...v1.0.3

## v1.0.2 - 2025-10-10

### What's Changed

* Bump spatie/laravel-sitemap from 7.3.6 to 7.3.7 by @dependabot[bot] in https://github.com/fuelviews/laravel-sitemap/pull/96
* Bump rector/rector from 2.1.2 to 2.1.4 by @dependabot[bot] in https://github.com/fuelviews/laravel-sitemap/pull/97
* Bump orchestra/testbench from 10.4.0 to 10.6.0 by @dependabot[bot] in https://github.com/fuelviews/laravel-sitemap/pull/98
* Bump anothrNick/github-tag-action from 1.73.0 to 1.75.0 by @dependabot[bot] in https://github.com/fuelviews/laravel-sitemap/pull/100
* Bump driftingly/rector-laravel from 2.0.5 to 2.0.7 by @dependabot[bot] in https://github.com/fuelviews/laravel-sitemap/pull/102
* Bump rector/rector from 2.1.4 to 2.1.7 by @dependabot[bot] in https://github.com/fuelviews/laravel-sitemap/pull/103
* Change sitemap index storage path and update sitemap regeneration logic to only regenerate when the sitemap file is missing, removing time-based cache expiration. by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/105

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v1.0.1...v1.0.2

## v1.0.1 - 2025-08-20

### What's Changed

* Tweak boost refactor by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/95

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v1.0.0...v1.0.1

## v1.0.0 - 2025-08-20

### What's Changed

* Refactor package with laravel boost #major by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/94

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.25...v1.0.0

## v0.0.25 - 2025-08-12

### What's Changed

* Add registration of sitemap generate command to enable console comman… by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/93

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.24...v0.0.25

## v0.0.24 - 2025-08-12

### What's Changed

* Tweak sp by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/92

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.23...v0.0.24

## v0.0.22 - 2025-08-12

### What's Changed

* Refactor service provider to register multiple commands using hasCommands method for better scalability. by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/90

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.21...v0.0.22

## v0.0.21 - 2025-08-11

### What's Changed

* Fix typo by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/89

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.20...v0.0.21

## v0.0.20 - 2025-08-11

### What's Changed

* Bump orchestra/testbench from 10.3.0 to 10.4.0 by @dependabot[bot] in https://github.com/fuelviews/laravel-sitemap/pull/81
* Bump laravel/pint from 1.22.1 to 1.24.0 by @dependabot[bot] in https://github.com/fuelviews/laravel-sitemap/pull/84
* Bump spatie/laravel-package-tools from 1.92.4 to 1.92.7 by @dependabot[bot] in https://github.com/fuelviews/laravel-sitemap/pull/85
* Bump rector/rector from 2.1.0 to 2.1.2 by @dependabot[bot] in https://github.com/fuelviews/laravel-sitemap/pull/86
* Refactor sitemap generation to run command directly instead of using Artisan facade, improving error handling and command execution. Rename package to 'sitemap', register sitemap route, and enhance service provider with route and command setup for better integration. by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/88

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.19...v0.0.20

## v0.0.19 - 2025-06-25

### What's Changed

* Bump rector/rector from 2.0.16 to 2.0.17 by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/80

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.18...v0.0.19

## v0.0.18 - 2025-06-25

### What's Changed

* Bump spatie/crawler from 8.4.2 to 8.4.3 by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/79

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.17...v0.0.18

## v0.0.17 - 2025-05-15

### What's Changed

* Fix workflows by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/76

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.16...v0.0.17

## v0.0.16 - 2025-05-15

### What's Changed

* Bump spatie/laravel-package-tools from 1.16.4 to 1.17.0 by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/47
* Bump laravel/pint from 1.18.1 to 1.18.3 by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/43
* Bump orchestra/testbench from 8.27.2 to 8.30.0 by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/48
* Bump spatie/browsershot from 4.1.0 to 4.4.0 in the composer group across 1 directory by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/49
* Bump laravel/pint from 1.19.0 to 1.21.1 by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/67
* Update GitHub Actions workflows to enhance release note generation and adjust permissions for pull requests. Refactor the SitemapController and ServiceProvider for improved clarity and functionality. by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/75

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.12...v0.0.16

## v0.0.15 - 2025-05-15

* Update GitHub Actions workflows to improve release note generation and adjust permissions for pull requests. Add a new route for sitemap generation and refactor the SitemapController and ServiceProvider for better clarity and functionality. by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/74

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.15...v0.0.15

## v0.0.14 - 2025-05-15

### What's Changed

* Bump laravel/pint from 1.19.0 to 1.21.1 by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/67
* Update tests workflow and refactor by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/73

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.13...v0.0.14

## v0.0.13 - 2025-01-08

### What's Changed

* Bump spatie/laravel-package-tools from 1.16.4 to 1.17.0 by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/47
* Bump laravel/pint from 1.18.1 to 1.18.3 by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/43
* Bump orchestra/testbench from 8.27.2 to 8.30.0 by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/48
* Bump spatie/browsershot from 4.1.0 to 4.4.0 in the composer group across 1 directory by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/49
* Update deps, add php-cs-fix config by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/56

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.12...v0.0.13

## v0.0.12 - 2024-12-18

### What's Changed

* Bump poseidon/wait-for-status-checks from 0.5.0 to 0.6.0 by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/33
* Bump poseidon/wait-for-status-checks from 0.5.0 to 0.6.0 by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/35
* Bump laravel/framework from 10.48.12 to 10.48.23 in the composer group across 1 directory by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/38
* Bump pestphp/pest from 2.34.8 to 2.36.0 by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/39
* Bump orchestra/testbench from 8.23.2 to 8.27.2 by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/41
* Refactored the GitHub workflow to run only if the actor is not Dependabot. Updated the return type of the  method in the  class to use the  constants for success and failure. by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/46

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.11...v0.0.12

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.9...v0.0.12

## v0.0.11 - 2024-11-10

### What's Changed

* Bump symfony/http-foundation from 6.4.8 to 6.4.14 in the composer group across 1 directory by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/37

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.10...v0.0.11

## v0.0.10 - 2024-11-10

### What's Changed

* Bump poseidon/wait-for-status-checks from 0.5.0 to 0.6.0 by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/33
* Bump poseidon/wait-for-status-checks from 0.5.0 to 0.6.0 by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/35
* Bump symfony/process from 6.4.8 to 6.4.14 in the composer group across 1 directory by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/36

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.9...v0.0.10

## v0.0.8 - 2024-09-27

### What's Changed

* Update dependabot-auto-merge.yml by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/27

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.7...v0.0.8

## v0.0.7 - 2024-09-27

### What's Changed

* Bump laravel/pint from 1.16.1 to 1.17.3 by @dependabot in https://github.com/fuelviews/laravel-sitemap/pull/26

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.6...v0.0.7

## v0.0.6 - 2024-07-11

### What's Changed

* Update sitemap defaults by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/15

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.5...v0.0.6

## v0.0.5 - 2024-07-07

### What's Changed

* Refactor sitemap generation and linking functionality. The changes were made to improve the flexibility and reusability of the code, allowing for dynamic sitemap filenames and routes. by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/14

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.4...v0.0.5

## v0.0.4 - 2024-07-07

### What's Changed

* Refactor SitemapController and SitemapServiceProvider to allow for default sitemap file name and update the route to only accept requests for the specific sitemap.xml file. by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/13

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.3...v0.0.4

## v0.0.3 - 2024-06-13

### What's Changed

* Package polish by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/11

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.2...v0.0.3

## v0.0.2 - 2024-06-05

### What's Changed

* Update readme deps and service provider by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/10

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.1...v0.0.2

## v0.0.1 - 2024-04-06

### What's Changed

* Refactored the README.md file to update the package name description, and URLs. by @thejmitchener in https://github.com/fuelviews/laravel-sitemap/pull/5

**Full Changelog**: https://github.com/fuelviews/laravel-sitemap/compare/v0.0.1-RC2...v0.0.1
