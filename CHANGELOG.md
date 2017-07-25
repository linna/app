 release
# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [v0.10.1](https://github.com/linna/app/compare/v0.10.0...v0.10.1) - 2017-07-25

### Changed
* `config/config.php` option `useCompiledRoutes` default changed to `false`

### Added
* `config/config.php` option `rewriteModeOffRouter` in `router` section

### Fixed
* app working in rewrite mode off

## [v0.10.0](https://github.com/linna/app/compare/v0.9.0...v0.10.0) - 2017-07-17

### Added
* `bin/compile-routes` script for export routes as php array
* possibility to declare routes as `Linna\Http\RouteCollection` and export it as php array
* `favicon.png` in `/public` directory
* `robots.txt` in `/public` directory

### Changed
* `declare(strict_types=1);` added where missing
* `.htaccess` configurations moved to virtual host config file
* `README.md` virtual host rewrite mod config added
* require [linna/framework v0.20.0](https://github.com/linna/framework/releases/tag/v0.20.0)

### Fixed
* `CHANGELOG.md` links url
* file permissions

### Removed
* `.htaccess` in `/` directory
* `.htaccess` in `/public` directory

## [v0.9.0](https://github.com/linna/app/v0.8.0...v0.9.0) - 2017-06-24

### Changed
* require [linna/framework v0.19.0](https://github.com/linna/framework/releases/tag/v0.19.0)

## [v0.8.0](https://github.com/linna/app/compare/v0.7.0...v0.8.0) - 2017-06-01

### Removed
* all files for login and user
* EnhancedUserMapper.php from `src/Mappers` directory
* PermissionMapper.php from `src/Mappers` directory
* RoleMapper.php from `src/Mappers` directory

### Changed
* app theme and templates
* templates that implements `Linna\Mvc\TemplateInterface` now contain `public function getOutput() : string` instead of `public function output()`
* option default for `urlSubFolder` changed from `/app/` to `/app`
* option default for `urlPublicFolder` changed from `public` to `/app/public`
* `Linna\Mvc\FrontController` usage changed on `public/index.php`
* require [linna/framework v0.17.0](https://github.com/linna/framework/releases/tag/v0.17.0)

## [v0.7.0](https://github.com/linna/app/compare/v0.6.1...v0.7.0) - 2017-03-28

### Changed
* require [linna-framework v0.15.0](https://github.com/linna/framework/releases/tag/v0.15.0)
