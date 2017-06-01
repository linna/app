
# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) 
and this project adheres to [Semantic Versioning](http://semver.org/).

## [v0.8.0](https://github.com/s3b4stian/linna-app/compare/v0.7.0...v0.8.0) - 2017-06-01

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
* require [linna-framework v0.17.0](https://github.com/s3b4stian/linna-framework/releases/tag/v0.17.0)

## [v0.7.0](https://github.com/s3b4stian/linna-app/compare/v0.6.1...v0.7.0) - 2017-03-28

### Changed
* require [linna-framework v0.15.0](https://github.com/s3b4stian/linna-framework/releases/tag/v0.15.0)
