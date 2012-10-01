WordPress Generator
===================

Used internally by the [WordPress Skeleton][1] to create configuration
files specific to WordPress, Vagrant, & Capistrano.


Installation
------------

_Installation is automatically performed by [Composer][2] when using the skeleton._


Usage
-----

View all available commands:

    $ ./bin/skeleton


Configure a new or existing skeleton (located in `./config/skeleton.yml`):

    $ ./bin/skeleton configure


After configuration, the project is populated using a [template skeleton][3]
in your root.

If you make any changes to `skeleton.yml`, you can re-generate your project
skeleton via:

    $ ./bin/skeleton generate


[1]: https://github.com/ericclemmons/wordpress-skeleton
[2]: http://getcomposer.org/
[3]: https://github.com/ericclemmons/wordpress-generator/tree/master/library/Skeleton/Resources/skeleton
