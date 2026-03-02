# Server

This is the overarching repo for the code deployed to our hosted server, running at https://fair.pm/


## Local Development

This repository is pre-configured with wp-env configuration. (Better Docker Compose setup coming soon!)

You can set up a local environment using:

```sh
# First, install Composer dependencies.
composer install

# Then, start an environment.
npx @wordpress/env start
```


## Deployment

Deployment will eventually be automatic, but in the meantime, the infrastructure team needs to deploy the repository via Helm. Ping them when deployment is needed.

To ignore files from deployment, specify them in `.distignore`.

**Notes for the infrastructure team:**

```
# In this repo (fairpm/server)
git checkout main
git tag -f production
git push --tags

# Then in the fairpm/infrastructure-private repo
./jazz
cd helm/projects/site
bin/deploy production
```

## License

Licensed under the GNU General Public License, v2 or later. Copyright 2025 contributors.

Incorporates code from [WordPress/wordpress.org](https://github.com/WordPress/wordpress.org). Licensed under the GNU General Public License, v2 or later. Copyright 2025 contributors.
