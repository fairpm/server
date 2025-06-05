# Server

This is the overarching repo for the code deployed to our development server, running at https://beta.web-pub.org/


## Accessing

During development, the beta environment is protected with Basic authentication. The credentials are:

* **Username**: `openwebff`
* **Password**: `wither-nodding-dues-morals-splat`


## Local Development

This repository is pre-configured with wp-env configuration. You can set up a local environment using:

```sh
# First, install Composer dependencies.
composer install

# Then, start an environment.
npx @wordpress/env start
```


## Deployment

Deployment will eventually be automatic, but in the meantime, you can run `bin/deploy.sh`. This will synchronize the `content/` directory to the server using rsync.

To ignore files from deployment, specify them in `.distignore`.


## License

Licensed under the GNU General Public License, v2 or later. Copyright 2025 contributors.

Incorporates code from [WordPress/wordpress.org](https://github.com/WordPress/wordpress.org). Licensed under the GNU General Public License, v2 or later. Copyright 2025 contributors.
