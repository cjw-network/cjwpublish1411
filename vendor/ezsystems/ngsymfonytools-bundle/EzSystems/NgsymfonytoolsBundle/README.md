# NgsymfonytoolsBundle

ngsymfonytools-bundle integrates the legacy [netgen/ngsymfonytools](https://github.com/netgen/ngsymfonytools) as a
Legacy bundle, a feature introduced in eZ Publish 5.3 (see https://github.com/ezsystems/ezpublish-kernel/pull/719).

## Features

Installing this bundle will automatically install (via composer) the legacy extension, and enable it transparently.

## Installation

It shouldn't be required to install it, since it is required by ezsystems/comments-bundle, and installed by default.

If need be, run composer require `ezsystems/ngsymfonytools-bundle:*` to your eZ Publish 5 app's composer.json,
and run composer install.

## License

This bundle is under **[GPL v2.0 license](http://www.gnu.org/licenses/gpl-2.0.html)**.
