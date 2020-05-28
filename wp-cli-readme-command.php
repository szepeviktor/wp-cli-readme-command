<?php

use WordPressdotorg\Plugin_Directory\Readme\Validator;

use function WP_CLI\Utils\parse_str_to_argv;

/**
 * Manage readme.txt files.
 */
class WP_CLI_Readme_Validator extends WP_CLI_Command {

    /**
     * Validate readme.txt
     *
     * <path-to-readme-txt>
     * : Path to readme.txt.
     */
    public function validate( $args ) {

        // Load Readme validator classes from WordPress Meta SVN repository
        require_once __DIR__ . '/src/class-markdown.php';
        require_once __DIR__ . '/src/readme/class-parser.php';
        require_once __DIR__ . '/src/readme/class-validator.php';

        $this->validate_file( $args[0] );
    }

    protected function validate_file( $path ) {

        if ( ! file_exists( $path ) ) {
            WP_CLI::error( 'File does not exist: ' . $path );
            return;
        }

        $result = Validator::instance()->validate_content( file_get_contents( $path ) );

        // Show messages
        $valid = true;
        foreach ( $result['errors'] as $message ) {
            WP_CLI::error( $message );
            $valid = false;
        }
        foreach ( $result['warnings'] as $message ) {
            WP_CLI::warning( $message );
            $valid = false;
        }
        foreach ( $result['notes'] as $message ) {
            WP_CLI::log( $message );
        }
        if ( $valid ) {
            WP_CLI::success( 'readme.txt is valid: ' . $path );
        }
    }
}

WP_CLI::add_command( 'readme', 'WP_CLI_Readme_Validator' );
