<?php
/**
 * Plugin Name: Trinity Medical Staff
 * Plugin URI:  https://omnigecko.io
 * Description: Plugin for custom staff page & shortcode.
 * Version:     1.0.3
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
	//Staff / Save Extention
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
    //Staff / Save Extention
    function save_staff_job_duties_metabox( $post_id, $post) {
        $nonceNme = 'job_duties_fields';
        $fieldID = 'job_duties';
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
    add_action( 'save_post', 'save_staff_job_duties_metabox',1 ,2 );
    //Staff / Save First Name
    function save_staff_first_name_metabox( $post_id, $post) {
        $nonceNme = 'first_name_fields';
        $fieldID = 'first_name';
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
    add_action( 'save_post', 'save_staff_first_name_metabox',1 ,2 );
    //Staff / Save Last Name
    function save_staff_last_name_metabox( $post_id, $post) {
        $nonceNme = 'last_name_fields';
        $fieldID = 'last_name';
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
    add_action( 'save_post', 'save_staff_last_name_metabox',1 ,2 );
    //Staff / Save Birthdate
    function save_staff_birth_date_metabox( $post_id, $post) {
        $nonceNme = 'birth_date_fields';
        $fieldID = 'birth_month';
        $fieldID2 = 'birth_day';
        // Return if the user doesn't have edit permissions.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
        // Verify this came from the our screen and with proper authorization,
        if ( ! isset( $_POST[$fieldID] ) || ! wp_verify_nonce( $_POST[$nonceNme], basename(__FILE__) ) ) {
            return $post_id;
        }
        update_post_meta($post->ID, $fieldID, $_POST[$fieldID]);
        // Verify this came from the our screen and with proper authorization,
        if ( ! isset( $_POST[$fieldID2] ) || ! wp_verify_nonce( $_POST[$nonceNme], basename(__FILE__) ) ) {
            return $post_id;
        }
        update_post_meta($post->ID, $fieldID2, $_POST[$fieldID2]);
    }
    add_action( 'save_post', 'save_staff_birth_date_metabox',1 ,2 );
    //Staff Extension Metaboxes
	function add_staff_ext_metabox(){
		function custom_staff_ext (){
			global $post;
			wp_nonce_field( basename( __FILE__ ), 'ext_fields' );
			// Get the Extension data if it's already been entered
			$ext = get_post_meta( $post->ID, 'ext', true );
			// Output the field
			echo '<input type="text" name="ext" value="' . esc_textarea( $ext )  . '" class="widefat">';
			echo '<p>Link to remote site.</p>';
		}
		add_meta_box(
			'staff_ext',
			'Phone #',
			'custom_staff_ext',
			array('trinitymedicalstaff'),
			'side',
			'default',
			'high'
        );
        function custom_staff_job_duties (){
			global $post;
			wp_nonce_field( basename( __FILE__ ), 'job_duties_fields' );
			// Get the Extension data if it's already been entered
			$job_duties = get_post_meta( $post->ID, 'job_duties', true );
			// Output the field
			echo '<input type="job_duties" name="job_duties" value="' . esc_textarea( $job_duties )  . '" class="widefat">';
			echo '<p>Position for staff member.</p>';
		}
		add_meta_box(
			'staff_job_duties',
			'Position',
			'custom_staff_job_duties',
			array('trinitymedicalstaff'),
			'normal',
			'default',
			'high'
        );
        function trinity_mediacal_first_name(){
            global $post;
            wp_nonce_field( basename( __FILE__ ), 'first_name_fields' );
            // Get the First Name data if it's already been entered
            $firstName = get_post_meta( $post->ID, 'first_name', true );
            echo '<input type="text" name="first_name" value="' . esc_textarea( $firstName )  . '" class="widefat">';
			echo '<p>First Name For Staff.</p>';
        }
        add_meta_box(
			'staff_first_name',
			'First Name',
			'trinity_mediacal_first_name',
			array('trinitymedicalstaff'),
			'side',
			'default',
			'high'
        );
        function trinity_mediacal_last_name(){
            global $post;
            wp_nonce_field( basename( __FILE__ ), 'last_name_fields' );
            // Get the Last Name data if it's already been entered
            $lastName = get_post_meta( $post->ID, 'last_name', true );
            echo '<input type="text" name="last_name" value="' . esc_textarea( $lastName )  . '" class="widefat">';
			echo '<p>Last Name For Staff.</p>';
        }
        add_meta_box(
			'staff_last_name',
			'Last Name',
			'trinity_mediacal_last_name',
			array('trinitymedicalstaff'),
			'side',
			'default',
			'high'
        );
        function trinity_mediacal_birth_date(){
            global $post;
            wp_nonce_field( basename( __FILE__ ), 'birth_date_fields' );
            // Get the Birth Date data if it's already been entered
            $birthMonth = get_post_meta( $post->ID, 'birth_month', true );
            $birthday = get_post_meta( $post->ID, 'birth_day', true );
            function selectedChk ($compare, $compare2){
				$compare = sanitize_text_field($compare);
				if($compare2 == $compare){
					return 'value="'.$compare.'" Selected';
				}else{
					return 'value="'.$compare.'"';
				}
			}
            echo '<select name="birth_month" class="widefat">
                    <option '.selectedChk('January', $birthMonth).'>January</option>
                    <option '.selectedChk('February', $birthMonth).'>February</option>
                    <option '.selectedChk('March', $birthMonth).'>March</option>
                    <option '.selectedChk('April', $birthMonth).'>April</option>
                    <option '.selectedChk('May', $birthMonth).'>May</option>
                    <option '.selectedChk('June', $birthMonth).'>June</option>
                    <option '.selectedChk('July', $birthMonth).'>July</option>
                    <option '.selectedChk('August', $birthMonth).'>August</option>
                    <option '.selectedChk('September', $birthMonth).'>September</option>
                    <option '.selectedChk('October', $birthMonth).'>October</option>
                    <option '.selectedChk('November', $birthMonth).'>November</option>
                    <option '.selectedChk('December', $birthMonth).'>December</option>
                 </select><br><br>';
            echo '<select name="birth_day" class="widefat">
                <option '.selectedChk('01', $birthday).' >1</option>
                <option '.selectedChk('02', $birthday).' >2</option>
                <option '.selectedChk('03', $birthday).' >3</option>
                <option '.selectedChk('04', $birthday).' >4</option>
                <option '.selectedChk('05', $birthday).' >5</option>
                <option '.selectedChk('06', $birthday).' >6</option>
                <option '.selectedChk('07', $birthday).' >7</option>
                <option '.selectedChk('08', $birthday).' >8</option>
                <option '.selectedChk('09', $birthday).' >9</option>
                <option '.selectedChk('10', $birthday).' >10</option>
                <option '.selectedChk('11', $birthday).' >11</option>
                <option '.selectedChk('12', $birthday).' >12</option>
                <option '.selectedChk('13', $birthday).' >13</option>
                <option '.selectedChk('14', $birthday).' >14</option>
                <option '.selectedChk('15', $birthday).' >15</option>
                <option '.selectedChk('16', $birthday).' >16</option>
                <option '.selectedChk('17', $birthday).' >17</option>
                <option '.selectedChk('18', $birthday).' >18</option>
                <option '.selectedChk('19', $birthday).' >19</option>
                <option '.selectedChk('20', $birthday).' >20</option>
                <option '.selectedChk('21', $birthday).' >21</option>
                <option '.selectedChk('22', $birthday).' >22</option>
                <option '.selectedChk('23', $birthday).' >23</option>
                <option '.selectedChk('24', $birthday).' >24</option>
                <option '.selectedChk('25', $birthday).' >25</option>
                <option '.selectedChk('26', $birthday).' >26</option>
                <option '.selectedChk('27', $birthday).' >27</option>
                <option '.selectedChk('28', $birthday).' >28</option>
                <option '.selectedChk('29', $birthday).' >29</option>
                <option '.selectedChk('30', $birthday).' >30</option>
                <option '.selectedChk('31', $birthday).' >31</option>
              </select>';

			echo '<p>Birth Date For Staff.</p>';
        }
        add_meta_box(
			'staff_birth_date',
			'Birth Date',
			'trinity_mediacal_birth_date',
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
        $supports = array('thumbnail', 'editor', 'page-attributes');
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
                'posts_per_page' => 20000000,
                'meta_key'			=> 'first_name',
                'orderby'			=> 'meta_value',
                'order'				=> 'ASC'
            );
             //Update Staff Search
            if(isset($_GET['staff_search']) && $_GET['staff_search'] != '' && $_GET['staff_search'] != null){
                $Args['meta_query'] = array(
                    'relation' => 'OR',
                    array(
                        'key' => 'first_name',
                        'value' => $_GET['staff_search'],
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key' => 'last_name',
                        'value' => $_GET['staff_search'],
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key' => 'ext',
                        'value' => $_GET['staff_search'],
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key' => 'job_duties',
                        'value' => $_GET['staff_search'],
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key' => 'birth_month',
                        'value' => $_GET['staff_search'],
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key' => 'birth_day',
                        'value' => $_GET['staff_search'],
                        'compare' => 'LIKE'
                    )
                );
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
                                    $job_duties = get_post_custom()['job_duties'][0];
                                    $firstName = get_post_custom()['first_name'][0];
                                    $lastName = get_post_custom()['last_name'][0];
                                    $birthMonth = get_post_custom()['birth_month'][0];
                                    $birthDay = get_post_custom()['birth_day'][0];
                                    $getPostContent = get_the_content();
                                    $postContentwithbreaks = wpautop( $getPostContent, true);
                                    $content .= '
                                        <div>
                                            <div class="header">
                                                '.get_the_post_thumbnail(null, array(100,100)).'
                                                <h3>
                                                    <span style="color: #6a6a75;">'.$firstName.' '.$lastName.'</span>
                                                </h3>
                                            </div><br>
                                            <h4 style="margin:unset;color:#6a6a75;" ><span style="color:#56adc0;">Phone # </span>'.$ext.'</h4>
                                            <h4 style="margin:unset;color:#56adc0;">Office - '.get_the_term_list_trinity_medical_staff_location( $post->ID, 'office', '<span style="color:#6a6a75;">', ' / ', '</span>' ).'</h4>
                                            <h4 style="margin:unset;color:#6a6a75;" ><span style="color:#56adc0;">Position - </span>'.$job_duties.'</h4>
                                            <h4 style="margin-top:unset;color:#56adc0;">Birthday - <span style="color:#6a6a75;">'.$birthMonth.' / '.$birthDay.'</span></h4>
                                            <p>'.substr($postContentwithbreaks, 0, 300).'</p>
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
                                width: 100%;
                                height: auto;
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
                                .trinity-medical-staff-post-flex>div{
                                    width: 45%;
                                }
                                .trinity-medical-staff-post-flex>div .header h3 {
                                    width: 70%;
                                    text-align: center;
                                }
                            }
                            /* SM */
                            @media only screen and (min-width : 768px) {
                                .trinity-medical-staff-post-flex{
                                    justify-content: space-around;
                                }
                                .trinity-medical-staff-post-flex>div .header h3 {
                                    width: 80%;
                                }
                            }
                            /* Medium Devices, Desktops */
                            @media only screen and (min-width : 992px) {
                                .trinity-medical-staff-post-flex>div{
                                    height: 28em;
                                    width: 45%;
                                }
                                .trinity-medical-staff-post-flex>div .header h3{
                                    text-align: left;
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
    //Modify Staff Post type / Admin Columns
    add_filter( 'manage_trinitymedicalstaff_posts_columns', 'trinity_medical_filter_trinitymedicalstaff_posts_columns' );
    function trinity_medical_filter_trinitymedicalstaff_posts_columns( $columns ) {
        $columns = array(
            'cb' => $columns['cb'],
            'staff_first_name' => __( 'First Name'),
            'staff_last_name' => __( 'Last Name'),
            'taxonomy-office' => __( 'Office'),
            'date' => __('date')
        );
        return $columns;
    }
    //Modify Staff Post type / Admin Columns Content
    add_action('manage_trinitymedicalstaff_posts_custom_column', 'trinity_medical_staff_posts_columns', 10, 2);
    function trinity_medical_staff_posts_columns ($column, $post_id){
        switch($column){
            case 'staff_first_name': // First Name column
                echo '<a href="'.get_edit_post_link($post_id).'">'.get_post_meta($post_id, 'first_name', true).'</a>';
                break;
        }
        switch($column){
            case 'staff_last_name': // First Name column
                echo '<a href="'.get_edit_post_link($post_id).'">'.get_post_meta($post_id, 'last_name', true).'</a>';
                break;
        }
    }
    //Modify Staff Post type / Admin Columns Sortable
    add_filter( 'manage_edit-trinitymedicalstaff_sortable_columns', 'trinity_medical_staff_sortable_columns', 10, 1);
    function trinity_medical_staff_sortable_columns($cols){
        $cols['staff_first_name'] = 'first_name';   
        $cols['staff_last_name'] = 'first_name';
        return $cols;
    }
    //Modify Staff Post Type / Admin Search Functionality
    add_filter( 'posts_join', 'trinity_medical_staff_search_join' );
    function trinity_medical_staff_search_join ( $join ) {
        global $pagenow, $wpdb;
        // I want the filter only when performing a search on edit page of Custom Post Type named "trinitymedicalstaff".
        if ( is_admin() && 'edit.php' === $pagenow && 'trinitymedicalstaff' === $_GET['post_type'] && ! empty( $_GET['s'] ) ) {    
            $join .= 'LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
        }
        return $join;
    }
    add_filter( 'posts_where', 'trinitymedicalstaff_search_where' );
    function trinitymedicalstaff_search_where( $where ) {
        global $pagenow, $wpdb;

        // I want the filter only when performing a search on edit page of Custom Post Type named "trinitymedicalstaff".
        if ( is_admin() && 'edit.php' === $pagenow && 'trinitymedicalstaff' === $_GET['post_type'] && ! empty( $_GET['s'] ) ) {
            $where = preg_replace(
                "/\(\s*" . $wpdb->posts . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
                "(" . $wpdb->posts . ".post_title LIKE $1) OR (" . $wpdb->postmeta . ".meta_value LIKE $1)", $where );
        }
        return $where;
    }
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
