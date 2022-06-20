<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class Disciple_Tools_Meetings_Tile
{
    private static $_instance = null;
    public static function instance(){
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct(){
        add_filter( 'dt_details_additional_tiles', [ $this, "dt_details_additional_tiles" ], 10, 2 );
        add_filter( "dt_custom_fields_settings", [ $this, "dt_custom_fields" ], 1, 2 );
        add_action( "dt_details_additional_section", [ $this, "dt_add_section" ], 30, 2 );

        //svelte/Vite Stuff
        // dist subfolder - defined in vite.config.json
        define('DIST_DEF', 'dist');

        // defining some base urls and paths
        define('DIST_URI', trailingslashit( plugin_dir_url( __DIR__ ) ) . 'members-list-component/dist' );
        define('DIST_PATH', trailingslashit( plugin_dir_url( __DIR__ ) ) . 'members-list-component/dist' );

        // js enqueue settings
        define('JS_DEPENDENCY', ""); // array('jquery') as example
        define('JS_LOAD_IN_FOOTER', true); // load scripts in footer?
        // deafult server address, port and entry point can be customized in vite.config.json
        define('VITE_SERVER', 'http://localhost:3000');
        define('VITE_ENTRY_POINT', '/src/main.js');

        // enqueue hook
        add_action( 'wp_enqueue_scripts', function() {
//This should be commented out for production
$IS_VITE_DEVELOPMENT = true;
            if ( $IS_VITE_DEVELOPMENT === true) {
                // insert hmr into head for live reload
                function vite_head_module_hook() {
                    echo '<script type="module" crossorigin src="' . constant( 'VITE_SERVER' ) . constant( 'VITE_ENTRY_POINT' ) . '"></script>';
                }
                add_action('wp_head', 'vite_head_module_hook');

            } else {

                // production version, 'npm run build' must be executed in order to generate assets
                // ----------

                // read manifest.json to figure out what to enqueue
                $manifest = json_decode( file_get_contents( trailingslashit( plugin_dir_url( __DIR__ ) ) . 'members-list-component/dist/manifest.json' ), true ) ;

                // is ok
                if (is_array($manifest)) {
                    // get first key, by default is 'main.js' but it can change
                    $manifest_key = array_keys($manifest);
                    if (isset($manifest_key[0])) {

                        // enqueue CSS files
                        foreach(@$manifest[$manifest_key[0]]['css'] as $css_file) {
                            wp_enqueue_style( 'main', trailingslashit( plugin_dir_url( __DIR__ ) ) . 'members-list-component/dist/' . $css_file );
                        }

                        // enqueue main JS file
                        $js_file = @$manifest[$manifest_key[0]]['file'];
                        if ( ! empty($js_file)) {
                            wp_enqueue_script( 'main', trailingslashit( plugin_dir_url( __DIR__ ) ) . 'members-list-component/dist/' . $js_file, '', '', true);
                        }

                    }

                }

            }


});

    }

    /**
     * This function registers a new tile to a specific post type
     *
     * @todo Set the post-type to the target post-type (i.e. contacts, groups, trainings, etc.)
     * @todo Change the tile key and tile label
     *
     * @param $tiles
     * @param string $post_type
     * @return mixed
     */
    public function dt_details_additional_tiles( $tiles, $post_type = "" ) {
        if ( $post_type === "groups" ){
            $tiles["disciple_tools_meetings"] = [ "label" => __( "Meetings", 'disciple-tools-meetings' ) ];
        }
        return $tiles;
    }

    /**
     * @param array $fields
     * @param string $post_type
     * @return array
     */
    public function dt_custom_fields( array $fields, string $post_type = "" ) {
        /**
         * @todo set the post type
         */
        if ( $post_type === "contacts" || $post_type === "meetings" ){
            /**
             * @todo Add the fields that you want to include in your tile.
             *
             * Examples for creating the $fields array
             * Contacts
             * @link https://github.com/DiscipleTools/disciple-tools-theme/blob/256c9d8510998e77694a824accb75522c9b6ed06/dt-contacts/base-setup.php#L108
             *
             * Groups
             * @link https://github.com/DiscipleTools/disciple-tools-theme/blob/256c9d8510998e77694a824accb75522c9b6ed06/dt-groups/base-setup.php#L83
             */

            /**
             * This is an example of a text field
             */
            $fields['disciple_tools_meetings_description'] = [
                'name'        => __( 'Meeting Description', 'disciple-tools-meetings' ),
                'description' => _x( 'Text', 'Optional Documentation', 'disciple-tools-meetings' ),
                'type'        => 'text',
                'default'     => '',
                'tile' => 'disciple_tools_meetings',
                'icon' => get_template_directory_uri() . '/dt-assets/images/edit.svg',
            ];
            /**
             * This is an example of a multiselect field
             */
            $fields["disciple_tools_meetings_multiselect"] = [
                "name" => __( 'Multiselect', 'disciple-tools-meetings' ),
                "default" => [
                    "one" => [ "label" => __( "One", 'disciple-tools-meetings' ) ],
                    "two" => [ "label" => __( "Two", 'disciple-tools-meetings' ) ],
                    "three" => [ "label" => __( "Three", 'disciple-tools-meetings' ) ],
                    "four" => [ "label" => __( "Four", 'disciple-tools-meetings' ) ],
                ],
                "tile" => "disciple_tools_meetings",
                "type" => "multi_select",
                "hidden" => false,
                'icon' => get_template_directory_uri() . '/dt-assets/images/edit.svg',
            ];
            /**
             * This is an example of a key select field
             */
            $fields["disciple_tools_meetings_keyselect"] = [
                'name' => "Key Select",
                'type' => 'key_select',
                "tile" => "disciple_tools_meetings",
                'default' => [
                    'first'   => [
                        "label" => _x( 'First', 'Key Select Label', 'disciple-tools-meetings' ),
                        "description" => _x( "First Key Description", "Training Status field description", 'disciple-tools-meetings' ),
                        'color' => "#ff9800"
                    ],
                    'second'   => [
                        "label" => _x( 'Second', 'Key Select Label', 'disciple-tools-meetings' ),
                        "description" => _x( "Second Key Description", "Training Status field description", 'disciple-tools-meetings' ),
                        'color' => "#4CAF50"
                    ],
                    'third'   => [
                        "label" => _x( 'Third', 'Key Select Label', 'disciple-tools-meetings' ),
                        "description" => _x( "Third Key Description", "Training Status field description", 'disciple-tools-meetings' ),
                        'color' => "#366184"
                    ],
                ],
                'icon' => get_template_directory_uri() . '/dt-assets/images/edit.svg',
                "default_color" => "#366184",
                "select_cannot_be_empty" => true
            ];
        }
        return $fields;
    }

    public function dt_add_section( $section, $post_type ) {
        /**
         * @todo set the post type and the section key that you created in the dt_details_additional_tiles() function
         */
        if ( $post_type === "groups" && $section === "disciple_tools_meetings" ){
            /**
             * These are two sets of key data:
             * $this_post is the details for this specific post
             * $post_type_fields is the list of the default fields for the post type
             *
             * You can pull any query data into this section and display it.
             */
            $this_post = DT_Posts::get_post( $post_type, get_the_ID() );
            $post_type_fields = DT_Posts::get_post_field_settings( $post_type );
            ?>

            <!--
            @todo you can add HTML content to this section.
            -->

            <div id="app"></div>

        <?php }
    }

}
Disciple_Tools_Meetings_Tile::instance();
