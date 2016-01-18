# CakePHP CakeFest APP
[![Build Status](https://api.travis-ci.org/dereuromark/cakefest.svg?branch=3.0)](https://travis-ci.org/dereuromark/cakefest)
[![Coverage Status](https://coveralls.io/repos/dereuromark/cakefest/badge.svg?branch=3.0)](https://coveralls.io/r/dereuromark/cakefest)
[![License](https://poser.pugx.org/dereuromark/cakefest/license.svg)](https://packagist.org/packages/dereuromark/cakefest)
[![Minimum PHP Version](http://img.shields.io/badge/php-%3E%3D%205.4-8892BF.svg)](https://php.net/)
[![Coding Standards](https://img.shields.io/badge/cs-PSR--2--R-yellow.svg)](https://github.com/php-fig-rectified/fig-rectified-standards)

A fun app to socialize around the upcoming CakeFest this year.
Join in and tell others about your planned trip to the conference, and maybe what else you are planning to do in the city.

* Check it out live:
  - CakePHP 2 version: *install yourself from master branch*
  - NEW CakePHP 3 version: http://cakefest.dereuromark.de

* Author: Mark Scherer alias dereuromark


## Dependencies

* CakePHP 3.x
* FriendsOfCake/Authenticate and CakeDC/Search plugin
* My Tools, Geo, TinyAuth and Setup plugins
* Uses DebugKit plugin for development

## Installation

* Clone this repo via git - or download it manually.
* Navigate into the ROOT folder.
* Run composer install/update on it (this will also install CakePHP into the vendor folder and all plugins).
* Create a `/config/app_local.php/` config file with database credentials (you can use the `app_local.default.php` template).
* Create a vhost with a local dev domain of your choice, e.g. `cakefest.local`, and use ROOT/webroot/ as document root.
* Check it out at `http://cakefest.local`.

## TODOS

* OptIn
* Geo Map

### Ideas

* Timezone
* Contact Form
* Meetups
* Real time tweats etc
