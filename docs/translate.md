# Translate (GlotPress)


## Installing

Create a site on the multisite with the slug `translate`. This should be a subdomain site, as some URLs are hardcoded to the root URL (/).

Activate the GlotPress, then FAIR Translate plugins, and activate a theme.

Run `wp --url=... fair-translate stats init` to create the stats tables.


## Importing data

Build a dump of data using the https://github.com/openwebff/glotpress-dump tool.

At a minimum, fetch the translations for the `wp/dev` project - Translate uses this as the source project for all other projects:

```sh
bin/fetch-projects.sh
bin/fetch-translations.sh wp/dev
```

Then, in your development environment, import this data using the `bin/import-gp.sh` script. The `WP_ARGS` environment variable can be used to pass common arguments, such as the site URL:

```sh
WP_ARGS="--url=translate.localserver.dev" bin/import-gp.sh wp/dev
```
