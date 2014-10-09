OpCacheGUI
==========

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PeeHaa/OpCacheGUI/badges/quality-score.png?b=v1.0.0.dev)](https://scrutinizer-ci.com/g/PeeHaa/OpCacheGUI/?branch=v1.0.0.dev) [![Code Coverage](https://scrutinizer-ci.com/g/PeeHaa/OpCacheGUI/badges/coverage.png?b=v1.0.0.dev)](https://scrutinizer-ci.com/g/PeeHaa/OpCacheGUI/?branch=v1.0.0.dev) [![Build Status](https://scrutinizer-ci.com/g/PeeHaa/OpCacheGUI/badges/build.png?b=v1.0.0.dev)](https://scrutinizer-ci.com/g/PeeHaa/OpCacheGUI/build-status/v1.0.0.dev)

GUI for PHP's OpCache. I started this project to see what you can do with PHP's OpCache. There are already a couple of projects who implement something like this, but they are either a "one file to rule them all" or just not very nice looking.

If you are looking for a simple single file status GUI please see [Rasmus' one-page OpCache project][rasmus].

Installation
-

###Installation Steps

####Get the source

######Git clone

    git clone https://github.com/PeeHaa/OpCacheGUI.git

######Manual download a release

Download the latest tagged [release][releases].

######Composer

    php composer.phar require peehaa/opcachegui:0.0.*

####Setting up the project

1. Set the vhost's document root to the `public` folder
2. In case of using apache create an `.htaccess` file in the `public/` directory with the following content:

```
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_URI} !=/favicon.ico
RewriteRule ^ index.php [L]
```

Status
-

###Implemented

- OpCache status
- OpCache statistics
- Cached scripts overview
- Cached scripts invalidation
- Shiny graphs

Some features that will be implemented soon are:

- Authentication
- Auto refresh
- Sorting of columns
- Changing of graph types
- Fix design of cached scripts and config pages

If you would like to see a feature please add [an issue][issues]. If you want to contribute please feel free to send a PR.

License
-

[MIT License (`MIT`)][MIT]

Screenshots
-

[![OpCacheGUI status][1]][1][![OpCacheGUI graphs][2]][2]

[rasmus]: https://github.com/rlerdorf/opcache-status
[releases]: https://github.com/PeeHaa/OpCacheGUI/releases
[issues]: https://github.com/PeeHaa/OpCacheGUI/issues
[MIT]: http://spdx.org/licenses/MIT

[1]: https://opcachegui.pieterhordijk.com/style/opcachegui-home.png
[2]: https://opcachegui.pieterhordijk.com/style/opcachegui-graphs.png
