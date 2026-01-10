<?php
namespace FAIRServer\Translate;

use GP;
use GP_Locales;
use WP_CLI;
use WP_CLI_Command;

class TranslationSetCommand extends WP_CLI_Command {
	/**
	 * Ensure a translation set exists.
	 *
	 * <project>
	 * : Project slug.
	 *
	 * <locale>
	 * : Locale slug.
	 *
	 * [--set=<set>]
	 * : Translation set slug; default is "default"
	 *
	 * [--verbose]
	 * : Output additional information during execution.
	 *
	 * @subcommand ensure
	 */
	public function ensure_translation_set( $args, $assoc_args ) {
		$project = $args[0];
		$locale = $args[1];
		$set = $assoc_args['set'] ?? 'default';

		$project = GP::$project->by_path( $project );
		if ( ! $project ) {
			WP_CLI::error( 'Project not found!', 'glotpress' );
			return;
		}

		$gp_locale = GP_Locales::by_slug( $locale );
		if ( ! $gp_locale ) {
			WP_CLI::error( 'Locale not found!', 'glotpress' );
			return;
		}

		$translation_set = GP::$translation_set->by_project_id_slug_and_locale( $project->id, $set, $gp_locale->slug );
		if ( $translation_set ) {
			// Silently exit, unless verbose.
			if ( $assoc_args['verbose'] ?? false ) {
				WP_CLI::success( 'Already exists.' );
			}

			return;
		}

		// Create the translation set.
		GP::$translation_set->create( [
			'name' => $gp_locale->english_name,
			'slug' => $set,
			'project_id' => $project->id,
			'locale' => $gp_locale->slug,
		] );
		WP_CLI::success( 'Translation set created.' );
	}
}
