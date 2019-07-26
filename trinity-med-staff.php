<?php
/**
 * Plugin Name: Trinity Medical Staff
 * Plugin URI:  https://omnigecko.io
 * Description: Plugin for custom staff page & shortcode.
 * Version:     1.0.1
 * Author:      Omni Gecko Solutions
 * Author URI:  https://omnigecko.io
 */
?>
<?php
    add_filter( 'plugin_action_links', 'ttt_wpmdr_add_action_plugin', 10, 5 );
    function ttt_wpmdr_add_action_plugin( $actions, $plugin_file ){
        static $plugin;
        if (!isset($plugin))
            $plugin = plugin_basename(__FILE__);
        if ($plugin == $plugin_file) {
            $site_link = array('support' => '<a href="https://omnigecko.io/contact" target="_blank">Support</a>');
            $actions = array_merge($site_link, $actions);
        }
            return $actions;
    }
?>
<?php
//Functions After Initalize
    //Staff Extension Metabox - Save
	//Model / Save Sub Optional Features
    function save_staff_ext_metabox( $post_id, $post) {
        $nonceNme = 'ext_fields';
        $fieldID = 'ext';
        // Return if the user doesn't have edit permissions.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
        // Verify this came from the our screen and with proper authorization,
        if ( ! isset( $_POST[$fieldID] ) || ! wp_verify_nonce( $_POST[$nonceNme], basename(__FILE__) ) ) {
            return $post_id;
        }
        update_post_meta($post->ID, $fieldID, $_POST[$fieldID]);
    }
    add_action( 'save_post', 'save_staff_ext_metabox',1 ,2 );
    //Staff Extension Metabox
	function add_staff_ext_metabox(){
		function custom_staff_ext (){
			global $post;
			wp_nonce_field( basename( __FILE__ ), 'ext_fields' );
			// Get the location data if it's already been entered
			$ext = get_post_meta( $post->ID, 'ext', true );
			// Output the field
			echo '<input type="text" name="ext" value="' . esc_textarea( $ext )  . '" class="widefat">';
			echo '<p>Link to remote site.</p>';
		}
		add_meta_box(
			'staff_ext',
			'Ext #',
			'custom_staff_ext',
			array('trinitymedicalstaff'),
			'side',
			'default',
			'high'
		);
	}
    //Staff / Post Type
    function trinity_mediacal_setup_staff_post_type() {
        $lbls = array(
            'name' => __('Staff'),
            'singular_name' => __('Staff'),
            'add_new'            => __( 'Add New Staff' ),
            'add_new_item'       => __( 'Add New Staff (Blurb turnicated at 300 Charachters)' ),
            'edit_item'          => __( 'Edit Staff (Blurb turnicated at 300 Charachters)' ),
            'new_item'           => __( 'Add New Staff' ),
            'view_item'          => __( 'View Staff' ),
            'search_items'       => __( 'Search Staff' ),
            'not_found'          => __( 'No Staff found' ),
            'not_found_in_trash' => __( 'No Staff found in trash' )
        );
        $supports = array('title', 'thumbnail', 'editor', 'page-attributes');
        //Add Catagories to plugin
        $args = array(
            'labels'=> $lbls,
            'description'=> __('Post type for Staff.'),
            'public'      => true,
            'capability_type' => 'post',
            'rewrite'     => array( 'slug' => 'trinity-medical-staff'), // my custom slug
            'has_archive' => true,
            'supports' => $supports,
            'taxonomies' => array( 'office' ),
            'register_meta_box_cb' => 'add_staff_ext_metabox'
        );
        register_post_type('trinitymedicalstaff', $args);
    }
    add_action( 'init', 'trinity_mediacal_setup_staff_post_type' );
    //Redirect for single posts
    add_action( 'template_redirect', 'trinity_mediacal_staff_post_type_single_post_redirect' );
    function trinity_mediacal_staff_post_type_single_post_redirect() {
        $queried_post_type = get_query_var('post_type');
        if ( is_single() && 'trinitymedicalstaff' ==  $queried_post_type ) {
            wp_redirect( home_url(), 301 );
            exit;
        }
    }
    //Modified get_the_term_list
    function get_the_term_list_trinity_medical_staff_location ( $id, $taxonomy, $before = '', $sep = '', $after = '' ) {
        $terms = get_the_terms( $id, $taxonomy );
     
        if ( is_wp_error( $terms ) ) {
            return $terms;
        }
     
        if ( empty( $terms ) ) {
            return false;
        }
     
        $links = array();
     
        foreach ( $terms as $term ) {
            $link = get_term_link( $term, $taxonomy );
            if ( is_wp_error( $link ) ) {
                return $link;
            }
            $links[] = $term->name;
        }
     
        /**
         * Filters the term links for a given taxonomy.
         *
         * The dynamic portion of the filter name, `$taxonomy`, refers
         * to the taxonomy slug.
         *
         * @since 1.0.0
         *
         * @param string[] $links An array of term links.
         */
        $term_links = apply_filters( "term_links-{$taxonomy}", $links );
     
        return $before . join( $sep, $term_links ) . $after;
    }
    //Staff / Shortcode
    function trinity_medical_staff_flex_short_code (){
        function trinity_medical_flex_SC($content= null){
            $Args = array(
                'post_type' => 'trinitymedicalstaff',
                'posts_per_page' => 200,
                'order' => 'ASC'
            );
            //Update Staff Search
            if(isset($_GET['staff_search']) && $_GET['staff_search'] != '' && $_GET['staff_search'] != null){
                $Args['s'] = $_GET['staff_search'];
                $search = $_GET['staff_search'];
            }else{
                $search = '';
            }
            //Update Office Drop Down
            if( isset($_GET['staff_office']) && $_GET['staff_office'] != '' && $_GET['staff_office'] != null ){
                $Args['tax_query'] = array(
                    array(
                        'taxonomy' => 'office',
                        'field'    => 'term_id',
                        'terms'    => $_GET['staff_office']
                    ),
                );
                $condJava = '<script>
                                document.querySelector(".staff-search-contain .postform").value = "'.$_GET['staff_office'].'";
                             </script>';
            }else{
                $condJava = '';
            }
            $Loop = new WP_Query($Args);
            $dropDownArgs = array(
                'taxonomy' => 'office',
                'show_option_none' => 'Select An Office',
                'option_none_value' => '',
                'echo' => 0
            );
            $content = '<div class="staff-search-contain">
                            '.wp_dropdown_categories($dropDownArgs).'
                            <input class="staff-search" value="'.$search.'" placeholder="Search"/><button>Update List</button>
                        </div>
                        <div class="trinity-medical-staff-post-flex">'; 
                            if($Loop->have_posts()){
                                while ($Loop->have_posts()){
                                    $Loop->the_post();
                                    $ext = get_post_custom()['ext'][0];
                                    $content .= '
                                        <div>
                                            <div class="header">
                                                '.get_the_post_thumbnail(null, array(100,100)).'
                                                <h3><span>'.get_the_title().'</span><span>Phone #'.$ext.'</span></h3>
                                            </div>
                                            '.get_the_term_list_trinity_medical_staff_location( $post->ID, 'office', '<h4 class="office" >', '<br>', '</h4>' ).'
                                            <p>'.substr(get_the_content(), 0, 300).'</p>
                                        </div>';
                                }
                            }else{
                                $content .= '<p>Could not find Staff that mached Search</p>';
                            }
            $content .= '</div>';
            $content .= $condJava;//Conditional Javascript based on query string
            $content .= '<script>
                            document.addEventListener("DOMContentLoaded", function() {
                                document.querySelector(".staff-search-contain button").onclick = function(){
                                    var search = document.querySelector(".staff-search-contain .staff-search").value;
                                    var dropDown = document.querySelector(".staff-search-contain .postform").value;
                                    window.location.replace("'.$getURL.'?staff_search=" + search + "&staff_office=" + dropDown);
                                };
                             });
                         </script>';
            $content .= "<style>
                            .staff-search-contain {
                                display: block;
                                width: 100%;
                                max-width: 980px;
                                margin: auto;
                                border-radius: 50%;
                            }
                            .staff-search-contain input{
                                margin-right: 2em;
                            }
                            .trinity-medical-staff-post-flex {
                                display: flex;
                                max-width: 980px;
                                flex-flow: row wrap;
                                justify-content: space-around;
                                margin: auto;           
                            }
                            .trinity-medical-staff-post-flex>div{
                                height: 22em;
                                margin-top: 1em;
                            }
                            .trinity-medical-staff-post-flex>div .header{
                                display: flex;
                                flex-flow: row nowrap;
                                justify-content: space-between;
                                height: 100px;
                            }
                            .trinity-medical-staff-post-flex>div .header h3{
                                display: flex;
                                flex-flow: column;
                                justify-content: space-between;
                                width: 56%;
                                margin: unset;
                            }
                            /*Small devices (landscape phones, 576px and up)*/
                            @media (min-width: 576px) {
                                .trinity-medical-staff-post-flex>div .header h3 {
                                    width: 70%;
                                }
                            }
                            /* SM */
                            @media only screen and (min-width : 768px) {
                                .trinity-medical-staff-post-flex>div .header h3 {
                                    width: 80%;
                                }
                            }
                            /* Medium Devices, Desktops */
                            @media only screen and (min-width : 992px) {
                                .trinity-medical-staff-post-flex>div{
                                    height: 20em;
                                    width: 45%;
                                }
                                .trinity-medical-staff-post-flex>div .header h3{
                                    width: 60%;
                                }
                            }
                            /*MD-LG*/
                            @media only screen and (min-width : 1000px) {
                                .trinity-medical-staff-post-flex>div{
                                    width: 30%;
                                }
                            }
                            /*LG*/
                            @media only screen and (min-width : 1200px) {

                            }
                        </style>";
            
            return $content;
        }
        add_shortcode('trinity_medical_staff', 'trinity_medical_flex_SC');
    }
    add_action( 'init', 'trinity_medical_staff_flex_short_code');
    //Office / Taxonomy
    function create_office_hierarchical_taxonomy() {
        $labels = array(
            'name' => _x( 'Office', 'taxonomy general name' ),
            'singular_name' => _x( 'Office', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Office' ),
            'all_items' => __( 'All Office' ),
            'parent_item' => __( 'Parent Office' ),
            'parent_item_colon' => __( 'Parent Office:' ),
            'edit_item' => __( 'Edit Office' ), 
            'update_item' => __( 'Update Office' ),
            'add_new_item' => __( 'Add New Office' ),
            'new_item_name' => __( 'New Office Name' ),
            'menu_name' => __( 'Offices' ),
        );    
        register_taxonomy('office',array('post'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'office' ),
        ));
    }
    add_action( 'init', 'create_office_hierarchical_taxonomy', 0 );
//Activations
    //Application / Custom Post Type Activation
    function trinity_mediacal_staff_plugin_staff_activation(){
        trinity_mediacal_setup_staff_post_type();
        flush_rewrite_rules();
    }
    register_activation_hook( __FILE__, 'trinity_mediacal_staff_plugin_staff_activation' );
//Deactivations
    ///Application / Custom Post Type Deactivation
    function trinity_mediacal_staff_plugin_staff_de_activation() {
        unregister_post_type( 'trinitymedicalstaff' );
        flush_rewrite_rules();
    }
    register_deactivation_hook( __FILE__, 'trinity_mediacal_staff_plugin_staff_de_activation' );
//Unsinstallation
    // register_uninstall_hook(__FILE__, 'whisper_room_plugin_uninstall');
?>
