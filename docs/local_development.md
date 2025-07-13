# local development

## DDEV (preferred way)

Prerequesites:

https://ddev.readthedocs.io/en/stable/users/install/ddev-installation/

Then you can set up and start a local environment using:

```sh
ddev start
```

DDEV will tell you, if anything else is missing to successfully run the local development server.

If you get the `can not connect to database error` maybe the multisite installation is not finished.
Run in terminal:

```sh
ddev wp core multisite-install --url=server.ddev.site --title=Server --admin_user=admin --admin_password=admin --admin_email=admin@fair.local
```

The local site can be reached at:
https://server.ddev.site

Login via:
```
user: admin
pw: admin
```

## Composer

If you are using ddev, then `composer install ...` will be run automatically after ddev started. So you don't needd to manually run that.

## WP -CLI

If you use ddev, just add `ddev` in front of the command, to run it inside the docker environment.

Like
```
ddev wp core version
```

## WP ENV (previous way)

This repository is pre-configured with wp-env configuration. 

You can set up a local environment using:

```sh
# First, install Composer dependencies.
composer install

# Then, start an environment.
npx @wordpress/env start
```