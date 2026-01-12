<?php
namespace FAIRServer\Translate;

use Exception;
use GP;
use GP_Locales;
use GP_Project;
use WP_CLI;
use WP_CLI_Command;

class ProjectCommand extends WP_CLI_Command {
	/**
	 * Import projects from a projects.json file.
	 *
	 * <file>
	 * : The path to the projects.json file (use glotpress-dump to generate)
	 *
	 * @subcommand import
	 */
	public function import( $args ) {
		if ( $args[0] !== '-' ) {
			$path = realpath( $args[0] );
			$data = file_get_contents( $path );
		} else {
			$data = file_get_contents( 'php://stdin' );
		}

		$items = json_decode( $data );

		foreach ( $items as $item ) {
			// Does this project already exist?
			$existing = GP::$project->get( $item->id );
			if ( $existing ) {
				// Update the existing project.
				$project = $this->sync_project( $item );
			} else {
				// Manually create, to ensure the ID matches.
				$project = $this->import_project( $item );
			}
		}
		// var_dump( $projects );
	}

	protected function import_project( object $data ) : GP_Project {
		global $wpdb;

		$args = [
			'name' => $data->name,
			'slug' => $data->slug,
			'description' => $data->description,
			'parent_project_id' => $data->parent_project_id ?? 0,
			'source_url_template' => $data->source_url_template,
			'active' => $data->active,
		];
		$args = GP::$project->prepare_fields_for_save( $args );
		$args = GP::$project->prepare_fields_for_create( $args );

		// Manually set the ID, to ensure it matches.
		// This would otherwise be stripped in prepare_fields_for_save
		$args['id'] = $data->id;

		$field_formats = GP::$project->get_db_field_formats( $args );

		// Let it rip.
		$res = $wpdb->insert( GP::$project->table, $args, $field_formats );
		if ( false === $res ) {
			throw new Exception(
				sprintf(
					'Failed to create project: %s',
					$wpdb->last_error
				)
			);
		}

		$inserted = new GP_Project( $args );
		$inserted->id = $wpdb->insert_id;
		$inserted->after_create();

		return $inserted;
	}

	protected function sync_project( object $data ) : GP_Project {
		$project = GP::$project->get( $data->id );
		if ( ! $project ) {
			throw new Exception( 'Project not found' );
		}

		$needs_update = false;
		$fields = GP::$project->field_names;
		foreach ( $fields as $field ) {
			if ( in_array( $field, GP::$project->non_updatable_attributes, true ) ) {
				continue;
			}

			if ( $project->$field !== $data->$field ) {
				$needs_update = true;
				$project->$field = $data->$field;
			}
		}

		// Needs update.
		if ( $needs_update ) {
			WP_CLI::line( sprintf( 'Updating project %d (%s)', $project->id, $project->slug ) );
			// $project->update();
		}

		return $project;
	}
}
