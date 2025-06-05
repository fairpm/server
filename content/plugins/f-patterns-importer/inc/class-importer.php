<?php

namespace FAIR\Patterns;

use WP_CLI;
use WP_CLI_Command;

class Importer extends WP_CLI_Command {
    /**
     * Create pattern categories.
     *
     * ## EXAMPLES
     *
     *     wp fair_patterns create_categories
     *
     * @when after_wp_load
     */
    public function create_categories() {
        $categories = [
            'Buttons',
            'Columns',
            'Gallery',
            'Headers',
            'Text',
            'Images',
            'Featured',
            'Footers',
            'Posts',
            'Wireframe',
            'Call to Action',
            'About',
            'Banners',
            'Team',
            'Testimonials',
            'Services',
            'Contact',
            'Portfolio',
            'Media',
            'Audio',
            'Intro'
        ];

        foreach ( $categories as $category ) {
            if ( ! term_exists( $category, 'wporg-pattern-category' ) ) {
                wp_insert_term( $category, 'wporg-pattern-category' );
                WP_CLI::success( "Category '{$category}' created." );
            } else {
                WP_CLI::warning( "Category '{$category}' already exists." );
            }
        }
    }

    /**
     * Create pattern keywords.
     *
     * ## EXAMPLES
     *
     *     wp fair_patterns create_keywords
     *
     * @when after_wp_load
     */
    public function create_keywords() {
        $keywords = [
            'Core',
            'Featured',
            'Fullwidth',
            'posts',
            'blog',
            'loop',
            'call to action',
            'banner',
            'cover',
            'image',
            'alternating images',
            'columns',
            'CV',
            'resume',
            'text'
        ];

        foreach ( $keywords as $keyword ) {
            if ( ! term_exists( $keyword, 'wporg-pattern-keyword' ) ) {
                wp_insert_term( $keyword, 'wporg-pattern-keyword' );
                WP_CLI::success( "Keyword '{$keyword}' created." );
            } else {
                WP_CLI::warning( "Keyword '{$keyword}' already exists." );
            }
        }
    }

    /**
     * Import patterns from a JSON file.
     *
     * ## OPTIONS
     *
     * <dir>
     * : The path to a directory containing pattern JSON files.
     *
     * ## EXAMPLES
     *
     *     wp fair_patterns import /path/to/patterns
     *
     * @when after_wp_load
     */
    public function import( $args ) {
        $dir = $args[0];

        if ( ! file_exists( $dir ) || ! is_dir( $dir ) ) {
            WP_CLI::error( "Directory not found: {$dir}" );
            return;
        } elseif ( ! is_readable( $dir ) ) {
            WP_CLI::error( "Directory is not readable: {$dir}" );
            return;
        }

        $pattern_files = glob( $dir . '/*.json' );
        if ( empty( $pattern_files ) ) {
            WP_CLI::error( "No pattern files found in directory: {$dir}" );
            return;
        }

        foreach ( $pattern_files as $pattern_file ) {
            $patterns = json_decode( file_get_contents( $pattern_file ), true );
            if ( $patterns === false ) {
                WP_CLI::error( "Failed to read pattern file: {$pattern_file}" );
                return;
            }

            // A file may contain a single pattern.
            if ( isset( $pattern['slug'] ) ) {
                $pattern = [ $pattern ];
            }

            foreach ( $patterns as $pattern ) {
                if ( ! is_array( $pattern ) || empty( $pattern ) ) {
                    WP_CLI::warning( 'Invalid or empty pattern data, skipping.' );
                    continue;
                }

                if ( ! $this->import_pattern( $pattern ) ) {
                    WP_CLI::error( "Failed to import pattern: {$pattern['title']['rendered']}" );
                } else {
                    WP_CLI::success( "Pattern '{$pattern['title']['rendered']}' imported successfully." );
                }
            }
        }
    }

    /**
     * Import a single pattern.
     *
     * @param array $data Pattern data.
     * @return bool True on success, false on failure.
     */
    private function import_pattern( $data ) {
        $args = [
            'post_date' => $data['date'],
            'post_date_gmt' => $data['date_gmt'],
            'post_modified' => $data['modified'],
            'post_modified_gmt' => $data['modified_gmt'],
            'post_name' => $data['slug'],
            'post_title' => $data['title']['rendered'],
            'post_content' => $data['pattern_content'],
            'post_type' => 'wporg-pattern',
            'post_status' => 'publish',
            'meta_input' => [
                'author_meta' => $data['author_meta'] ?? [],
            ],
            'tax_input' => [
                'wporg-pattern-category' => [],
                'wporg-pattern-keyword' => [],
            ],
        ];

        if ( ! empty( $data['meta'] ) ) {
            foreach ( $data['meta'] as $key => $value ) {
                $args['meta_input'][ $key ] = $value;
            }
        }

        if ( ! empty( $data['pattern-categories'] ) ) {
            $args['tax_input']['wporg-pattern-category'] = $this->get_local_category_ids( $data['pattern-categories'] );
        }

        if ( ! empty( $data['pattern-keywords'] ) ) {
            $args['tax_input']['wporg-pattern-keyword'] = $this->get_local_keyword_ids( $data['pattern-keywords'] );
        }

        $inserted = wp_insert_post( $args );
        if ( is_wp_error( $inserted ) || $inserted === 0 ) {
            return false;
        }

        // WP_CLI lacks appropriate capabilities to set terms during wp_insert_post().

        if ( ! empty( $args['tax_input']['wporg-pattern-category'] ) ) {
            WP_CLI::runcommand(
                sprintf(
                    'post term set %d wporg-pattern-category %s --by=id --quiet',
                    $inserted,
                    implode( ',', $args['tax_input']['wporg-pattern-category'] )
                )
            );
        }

        if ( ! empty( $args['tax_input']['wporg-pattern-keyword'] ) ) {
            WP_CLI::runcommand(
                sprintf(
                    'post term set %d wporg-pattern-keyword %s --by=id --quiet',
                    $inserted,
                    implode( ',', $args['tax_input']['wporg-pattern-keyword'] )
                )
            );
        }

        return true;
    }

    /**
     * Get local category IDs based on old IDs.
     *
     * @param int[] $old_ids
     * @return int[]
     */
    private function get_local_category_ids( $old_ids ) {
        $map = [
            2 => 'Buttons',
            3 => 'Columns',
            4 => 'Gallery',
            5 => 'Headers',
            6 => 'Text',
            13 => 'Images',
            26 => 'Featured',
            37 => 'Footers',
            38 => 'Posts',
            39 => 'Wireframe',
            42 => 'Call to Action',
            47 => 'About',
            60 => 'Banners',
            61 => 'Team',
            62 => 'Testimonials',
            63 => 'Services',
            64 => 'Contact',
            65 => 'Portfolio',
            66 => 'Media',
            67 => 'Audio',
            82 => 'Intro',
        ];

        $names = [];
        foreach ( $old_ids as $old_id ) {
            if ( isset( $map[ $old_id ] ) ) {
                $names[] = $map[ $old_id ];
            }
        }

        return $this->get_term_ids_from_names( $names, 'wporg-pattern-category' );
    }

    /**
     * Get local keyword IDs based on old IDs.
     *
     * @param int[] $old_ids
     * @return int[]
     */
    private function get_local_keyword_ids( $old_ids ) {
        $map = [
            11 => "Core",
            59 => "Featured",
            68 => "Fullwidth",
            69 => "posts",
            70 => "blog",
            71 => "loop",
            72 => "call to action",
            73 => "banner",
            74 => "cover",
            75 => "image",
            76 => "alternating images",
            77 => "columns",
            78 => "CV",
            79 => "resume",
            80 => "text",
        ];

        $names = [];
        foreach ( $old_ids as $old_id ) {
            if ( isset( $map[ $old_id ] ) ) {
                $names[] = $map[ $old_id ];
            }
        }

        return $this->get_term_ids_from_names( $names, 'wporg-pattern-keyword' );
    }

    /**
     * Get term IDs from names in a specific taxonomy.
     *
     * @param string[] $names
     * @param string $taxonomy
     * @return int[]
     */
    private function get_term_ids_from_names( $names, $taxonomy ) {
        $ids = [];

        foreach ( $names as $name ) {
            $term = get_term_by( 'name', $name, $taxonomy );

            if ( false !== $term ) {
                $ids[] = $term->term_id;
            }
        }

        return $ids;
    }
}
