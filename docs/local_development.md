# local development

## DDEV (preferred way)

Prerequesites:

https://ddev.readthedocs.io/en/stable/users/install/ddev-installation/

Then you can set up and start a local environment using:

```sh
ddev start
```

DDEV will tell you, if anything else is missing to successfully run the local development server.

The local site can be reached at:
https://server.ddev.site

## Installation / Setup

If you have not setup WordPress before, get the `can not connect to database error` or any related error, maybe the multisite installation is not finished.
Run in terminal:

```sh
ddev setup
```

Admin URL:
https://server.ddev.site/wordpress/wp-admin/

Login via:
```
user: admin
pw: admin
```

## DB URLs update

If you had previously used wp-env the URLs have to be set to the new ddev one.
```
ddev wp search-replace '<old-url>' 'https://server.ddev.site' --network
````

## Composer

If you are using ddev, then `composer install ...` will be run automatically after ddev started. So you don't needd to manually run that.

## WP-CLI

If you use ddev, just add `ddev` in front of the command, to run it inside the docker environment.

Like
```
ddev wp core version
```

## Mails

DDEV has mailpit integrated for local mail handling.
When ddev is running, open it with
```
ddev mailpit 
````

## PHPMyAdmin

The ddev setup has phpmyadmin integrated to easily check db entries.
When ddev is running, open it with
```
ddev phpmyadmin
````

## WP ENV (previous way)

This repository is pre-configured with wp-env configuration. 

You can set up a local environment using:

```sh
# First, install Composer dependencies.
composer install

# Then, start an environment.
npx @wordpress/env start
```