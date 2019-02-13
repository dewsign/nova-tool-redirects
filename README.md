# 301 Redirects managed through Laravel Nova

Uses [Spatie Missing Page Redirector](https://github.com/spatie/laravel-missing-page-redirector) behind the scenes.

## Installation

`composer require dewsign/nova-tool-redirects`

For Excel downloads to work you need to have your storage linked.

## Usage

If you are using Dependency Injection to inject your models into controller methods, for example, you will need to apply the `CanBeRedirected` trait to the model.  This trait overrides the `resolveRouteBinding()` method and checks for a redirect in the Spatie `MissingPageRedirector` package if the model is not found, before returning a 404.

Enjoy!
