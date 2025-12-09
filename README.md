# fair.pm web site

This is the overarching repo for the code deployed to our hosted server, running at https://fair.pm/.  It will eventually form a template repository for wordpress installations in general, but for now it's specifically configured for the fair.pm site.

## Quick Start for Local Development

```
bin/init
bin/up
```

## Local Development 

The fair.pm server is built on the [Roots Bedrock](https://roots.io/bedrock/) distribution of WordPress, so all plugins and themes are managed via Composer.

Local development is primarily based on Docker containers, using a FrankenPHP web server container for WordPress, with other support containers defined in `docker-compose.yml`.  The default configuration is to expose the server through Traefik at https://site.local.dev.fair.pm (which always resolves to localhost), but local ports can be used instead by renaming the `docker-compose.override.example.yml` file to `docker-compose.override.yml` and editing it to your needs.

## Deployment

TODO

## License

Licensed under the GNU General Public License, v2 or later. Copyright 2025 contributors.

Incorporates code from [WordPress](https://github.com/WordPress/wordpress.org) and [Roots Bedrock](https://github.com/roots/bedrock). Licensed under the GNU General Public License, v2 or later. Copyright 2025 contributors.
