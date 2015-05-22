OpCacheGUI
==========

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PeeHaa/OpCacheGUI/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PeeHaa/OpCacheGUI/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/PeeHaa/OpCacheGUI/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/PeeHaa/OpCacheGUI/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/PeeHaa/OpCacheGUI/badges/build.png?b=master)](https://scrutinizer-ci.com/g/PeeHaa/OpCacheGUI/build-status/master)

GUI for PHP's OpCache. I started this project to see what you can do with PHP's OpCache. There are already a couple of projects who implement something like this, but they are either a "one file to rule them all" or just not very nice looking.

If you are looking for a simple single file status GUI please see [Rasmus' one-page OpCache project][rasmus].

Installation
-

For installation instructions and example configuration see the [installation wiki page](https://github.com/PeeHaa/OpCacheGUI/wiki/Installation).

Contributing
-

[How to contribute](https://github.com/PeeHaa/OpCacheGUI/wiki/Contributing)

License
-

[MIT License (`MIT`)][MIT]

Roadmap
-

###### v1.1.0

- [ ] Add brazilian portuguese translations
- [ ] Add support for the ipv6 loopback address to the firewall

###### v2.0.0

- [ ] Add APCu support
- [ ] Add Memcached support
- [ ] Separate firewall and authentcaion layers
- [ ] Add jailing / seperation of directories
- [ ] Add adapter for external authentication
- [ ] Add support to invalidate entire directories
- [ ] Add support to warm up cache
- [ ] Add support to manage other servers centrally
- [ ] Delegate autoloading to Composer's PSR4 autoloader
- [ ] Delegate routing to external library (fastroute, fasterroute, fastererroute, fastestfasterererroute)
- [ ] Add installation page for fresh installs
- [ ] Add update/upgrade page for existing installs
- [ ] Add support for IPV6 addresses
- [ ] Use proper language + region codes for translation files (http://en.wikipedia.org/wiki/IETF_language_tag) / POSIX
- [ ] Split up individual components:
  - [ ] IP firewall
  - [ ] Human readable byte formatter
  - [ ] I18n
  - [ ] Templating system
  - [ ] CSRF token generator
  - [ ] Simple session storage

Timeline
-

###### v1.1.0

| Phase                                              | Start      | End        |
| -------------------------------------------------- | ---------- | ---------- |
| Finalize roadmap                                   | 22-05-2015 | 23-05-2015 |
| Create v1.1.0 branch                               | 23-05-2015 | 23-05-2015 |     
| Development                                        | 23-05-2015 | 25-05-2015 |
| RC1 release                                        | 25-05-2015 | 31-05-2015 |
| Stable  (when no blocking issues are found in RC1) | 31-05-2015 | 31-05-2015 |

###### v2.0.0

| Phase                                              | Start      | End        |
| -------------------------------------------------- | ---------- | ---------- |
| Finalize roadmap                                   | 23-05-2015 | 24-05-2015 |
| Create v1.1.0 branch                               | 24-05-2015 | 24-05-2015 |     
| Development                                        | 01-06-2015 | 31-07-2015 |
| RC1 release                                        | 01-08-2015 | 15-08-2015 |
| RC2 release                                        | 15-08-2015 | 31-08-2015 |
| Update documentation                               | 22-08-2015 | 31-08-2015 |
| Stable  (when no blocking issues are found in RC2) | 01-09-2015 | 01-09-2015 |

Screenshots
-

###### Status page

[![OpCacheGUI status][1]][1]

###### Cached scripts

[![OpCacheGUI cached scripts][2]][2]

###### Graphs

[![OpCacheGUI graphs][3]][3]

###### Status page on mobile devices

[![OpCacheGUI status mobile][4]][4]

###### Cached scripts page on mobile devices

[![OpCacheGUI cached scripts mobile][5]][5]

[rasmus]: https://github.com/rlerdorf/opcache-status
[releases]: https://github.com/PeeHaa/OpCacheGUI/releases
[issues]: https://github.com/PeeHaa/OpCacheGUI/issues
[MIT]: http://spdx.org/licenses/MIT

[1]: http://i.imgur.com/Py4YtsC.png
[2]: http://i.imgur.com/buzbl8V.png
[3]: http://i.imgur.com/mEhfhDA.png
[4]: http://i.imgur.com/Mi3JegX.png
[5]: http://i.imgur.com/4tMSEWD.png
