# Straw Poller

## Installation

### Requirements

* PHP 5.3 (or up)
* PHP cURL Extension (this probably comes as default)
* PHP MYSQL Extensions (this probably comes as default as well)
* MySQL

### Prerequisites

This app uses [Composer](http://getcomposer.org/) to manage prerequisites. Run `composer install` in the `src` directory for the magic to be worked.

Database structure is built using a migrations engine. Run `php artisan migrate:install` followed by `php artisan migrate` in the `src` directory.

A SQL file to populate the database (using General Election 2010 candidates) can be found in the `sql` directory. Run as usual in your favourite MySQL interface, ensuring migrations are run first.

### Environment

The app requires the following environment variables to be set:

* `LARAVEL_APP_KEY`: A 32-character random string.
* `DB1_HOST`: Hostname of the MySQL database.
* `DB1_USER`: Username of the MySQL user.
* `DB1_PASS`: Password for the MySQL user.
* `DB1_NAME`: Name of the MySQL database.

## Things To Do...

Given more time, I would have liked to:

* A non-JavaScript version (although JS support is a fair bet in all modern browsers)
* Have made postcode input handling more reliable, done more pre-processing before sending to MapIt etc.
* Found a better dataset of candidates, or done more data massaging. Possibly even found photos of candidates.
* Tested in IE 8/9/10, with more robust degredation where necessary.
* Shown results in a more graphical manner
* Fine-tuned the presentation to be a more unique brand (or in line with brand guidelines).
* Anti-stuffing to preserve integrity.

## Thanks to...

This project makes use of the following bits of coding goodness:

* [Laravel](http://laravel.com/)
* [Bootstrap](http://twitter.github.com/bootstrap/)
* [jQuery](http://jquery.com/)
* [Guzzle](http://guzzlephp.org/)

And uses data from:

* [MapIt](http://mapit.mysociety.org/)
* [Guardian Datablog General Election 2010 Results](https://docs.google.com/spreadsheet/ccc?key=0AonYZs4MzlZbdGRMdXRfZ08wcW9fQzBKZXZJeG5aMmc#gid=1)
* [Index of United Kingdom political parties meta attributes (Wikipedia)](http://en.wikipedia.org/wiki/Wikipedia:Index_of_United_Kingdom_political_parties_meta_attributes)