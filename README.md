Unsecure site tutorial
======================

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cgrandval/unsecure-site-tutorial/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cgrandval/unsecure-site-tutorial/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/99894...d00c2/mini.png)](https://insight.sensiolabs.com/projects/99894...0c2)
[![Build Status](https://travis-ci.org/cgrandval/unsecure-site-tutorial.svg?branch=master)](https://travis-ci.org/cgrandval/unsecure-site-tutorial)

This project will show you that a website, even made on a framework, can contain security flaws.

Install this project, and find them !

Good hacking !


## Technical environment

- PHP >= 5.5
- Symfony 2.7 beta


## Deployment

``` bash
php ../composer.phar update
php app/console doctrine:database:create
php app/console doctrine:schema:update --force
php app/console khepin:yamlfixtures:load --purge-orm
php app/console doctrine:fixtures:load --append
php app/console assets:install --env=prod
php app/console assetic:dump --env=prod
```


## License

This project is under [MIT](LICENSE) license.
