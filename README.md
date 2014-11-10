# CakePHP CakeFest APP

A fun app to socialize around the upcoming CakeFest this year.
Join in and tell others about your planned trip to Madrid and the fest.

* Check it out live: http://cakefest.dereuromark.de
* Author: Mark Scherer alias dereuromark


### Dependencies

* CakePHP 3.x
* FriendsOfCake/Authenticate and CakeDC/Search plugin
* My Tools, Geo, TinyAuth and Setup plugins
* Uses DebugKit plugin for development

### Installation

* Clone this repo via git - or download it manually.
* Navigate into the ROOT folder.
* Run composer install/update on it (this will also install CakePHP into the vendor folder and all plugins).
* Create a `/config/app_local.php/` config file with database credentials.
* Create a vhost with a local dev domain of your choice, e.g. `cakefest.local`, and use ROOT/webroot/ as document root.
* Check it out at `http://cakefest.local`.

### TODOS

* OptIn

#### Ideas

* Timezone
* Contact Form
* Meetups
* Real time tweats etc