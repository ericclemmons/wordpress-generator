WordPress Generator
===================

Used internally by the [WordPress Skeleton][1] to create configuration
files specific to WordPress, Vagrant, & Capistrano.


Installation
------------

_This package is meant to be added to your `composer.json` as a depdendency
and not installed directly_

Add the following to `composer.json`:

    "require": {
        ...
        "ericclemmons/wordpress-generator": "dev-master",
        ...
    },

    "repositories": {
        ...
        {
            "type": "vcs",
            "url":  "git://github.com/ericclemmons/wordpress-generator.git"
        },
        ...
    }


Usage
-----

See the [WordPress Skeleton][1].

[1]: https://github.com/ericclemmons/wordpress-skeleton
[2]: http://getcomposer.org/
