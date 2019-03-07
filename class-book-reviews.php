<?php
/**
 * Plugin Name.
 *
 * @package   Book_Reviews
 * @author    
 * @license   
 * @link      
 * @copyright 2018
 */

/**
 * Plugin class.
 *
 * @package Book_Reviews
 * @author  Alpesh
 */
class Book_Reviews {

    /**
     * Plugin version, used for cache-busting of style and script file references.
     *
     * @since   1.0.0
     *
     * @var     string
     */
    protected $version = '1.0.0';

    /**
     * Unique identifier for your plugin.
     *
     * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
     * match the Text Domain file header in the main plugin file.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $plugin_slug = 'library-book-search';

    /**
     * Instance of this class.
     *
     * @since    1.0.0
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Slug of the plugin screen.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $plugin_screen_hook_suffix = null;

    /**
     * Initialize the plugin by setting localization, filters, and administration functions.
     *
     * @since     1.0.0
     */
    private function __construct() {

        include_once( 'views/actions.php' );
    }

    /**
     * Return an instance of this class.
     *
     * @since     1.0.0
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance() {

        // If the single instance hasn't been set, set it now.
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    // Fired when the plugin is activated
    public static function activate() {
        // Add some code for execute
    }

    // Fired when the plugin is de-activated
    public static function deactivate() {
        // Add some code for execute
    }

    // Added styles
    public function enqueue_styles() {
        global $post;

        wp_register_style('custom_css', plugins_url('css/custom.css', __FILE__));
        wp_enqueue_style('custom_css');

        wp_register_style('bootstrap_css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
        wp_enqueue_style('bootstrap_css');

        wp_register_style('jquery_ui_css', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
        wp_enqueue_style('jquery_ui_css');
    }

    // Added scripts
    public function enqueue_scripts() {
        global $post;

        wp_register_script('jquery_js', 'https://code.jquery.com/jquery-1.12.4.js');
        wp_enqueue_script('jquery_js');

        wp_register_script('jquery_ui_js', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js');
        wp_enqueue_script('jquery_ui_js');

        wp_register_script('custom_js', plugins_url('js/custom.js', __FILE__));
        wp_enqueue_script('custom_js');

        // make the ajaxurl var available to the above script
        wp_localize_script('custom_js', 'the_ajax_script', array('ajaxurl' => admin_url('admin-ajax.php')));
    }

    // Add admin page for display shortcode
    public function add_plugin_admin_menu() {
        add_menu_page('Library Menu', 'Library Menu', 'manage_options', 'books-menu', array($this, 'my_menu_output'));
    }

    // Admin page data display function
    public function my_menu_output() {
        echo '<div id="wpbody"><div class="wrap"><h1>Shortcode Usage :</h1>
            <h3>Use below shortcode to see book list and filter books by title, author, publisher, price and review.</h3><h3>For wordpress page : [book-search-library]</h3><h3>For PHP page : do_shortcode("[book-search-library]")</h3></div></div>';
    }

    // Create custom post type BOOK
    public function my_custom_post_book() {
        $labels = array(
            'name' => _x('Book', 'post type general name'),
            'singular_name' => _x('Book', 'post type singular name'),
            'add_new' => _x('Add New', 'book'),
            'add_new_item' => __('Add New Book'),
            'edit_item' => __('Edit Book'),
            'new_item' => __('New Book'),
            'all_items' => __('All Books'),
            'view_item' => __('View Book'),
            'search_items' => __('Search Book'),
            'not_found' => __('No products found'),
            'not_found_in_trash' => __('No products found in the Trash'),
            'parent_item_colon' => '',
            'menu_name' => 'Books'
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Holds our products and product specific data',
            'public' => true,
            'menu_position' => 5,
            'rewrite' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
            'has_archive' => true,
            'menu_icon' => 'dashicons-editor-table'
        );
        register_post_type('book', $args);
    }

    // Register Custom Taxonomy - Author
    function add_custom_taxonomies_author() {

        $labels = array(
            'name' => _x('Authors', 'Taxonomy General Name', 'text_domain'),
            'singular_name' => _x('Author', 'Taxonomy Singular Name', 'text_domain'),
            'menu_name' => __('Author', 'text_domain'),
            'all_items' => __('All Author', 'text_domain'),
            'parent_item' => __('Parent Author', 'text_domain'),
            'parent_item_colon' => __('Parent Author:', 'text_domain'),
            'new_item_name' => __('New Author Name', 'text_domain'),
            'add_new_item' => __('Add Author Item', 'text_domain'),
            'edit_item' => __('Edit Author', 'text_domain'),
            'update_item' => __('Update Author', 'text_domain'),
            'view_item' => __('View Author', 'text_domain'),
            'separate_items_with_commas' => __('Separate Author with commas', 'text_domain'),
            'add_or_remove_items' => __('Add or remove Author', 'text_domain'),
            'choose_from_most_used' => __('Choose from the most used', 'text_domain'),
            'popular_items' => __('Popular Author', 'text_domain'),
            'search_items' => __('Search Author', 'text_domain'),
            'not_found' => __('Not Found', 'text_domain'),
            'no_terms' => __('No Author', 'text_domain'),
            'items_list' => __('Authors list', 'text_domain'),
            'items_list_navigation' => __('Author list navigation', 'text_domain'),
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
        );
        register_taxonomy('book_author', array('book'), $args);
    }

    // Register Custom Taxonomy - Publisher
    function add_custom_taxonomies_publisher() {

        $labels = array(
            'name' => _x('Publishers', 'Taxonomy General Name', 'text_domain'),
            'singular_name' => _x('Publisher', 'Taxonomy Singular Name', 'text_domain'),
            'menu_name' => __('Publisher', 'text_domain'),
            'all_items' => __('All Publisher', 'text_domain'),
            'parent_item' => __('Parent Publisher', 'text_domain'),
            'parent_item_colon' => __('Parent Publisher:', 'text_domain'),
            'new_item_name' => __('New Publisher Name', 'text_domain'),
            'add_new_item' => __('Add Publisher Item', 'text_domain'),
            'edit_item' => __('Edit Publisher', 'text_domain'),
            'update_item' => __('Update Publisher', 'text_domain'),
            'view_item' => __('View Publisher', 'text_domain'),
            'separate_items_with_commas' => __('Separate Publisher with commas', 'text_domain'),
            'add_or_remove_items' => __('Add or remove Publisher', 'text_domain'),
            'choose_from_most_used' => __('Choose from the most used', 'text_domain'),
            'popular_items' => __('Popular Publisher', 'text_domain'),
            'search_items' => __('Search Publisher', 'text_domain'),
            'not_found' => __('Not Found', 'text_domain'),
            'no_terms' => __('No Publisher', 'text_domain'),
            'items_list' => __('Publisher list', 'text_domain'),
            'items_list_navigation' => __('Publisher list navigation', 'text_domain'),
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
        );
        register_taxonomy('publisher', array('book'), $args);
    }

    // Create shortcode for display data in front
    public function create_shortcode() {
        return include_once( 'inc/book_search_shortcode.php' );
    }

    // AJAX call wordpress function
    public function search_books_fun() {

        // parse the AJAX serialized data
        parse_str($_POST['request_data'], $my_array_of_vars);

        $book_name = $my_array_of_vars['book_name'];
        $book_author = $my_array_of_vars['book_author'];
        $book_publisher = $my_array_of_vars['book_publisher'];
        $book_rating = $my_array_of_vars['book_rating'];
        $start_price = $my_array_of_vars['start_price'];
        $end_price = $my_array_of_vars['end_price'];

        $tax_queries = '';
        if ($book_author) {
            $tax_queries[] =
                    array(
                        'taxonomy' => 'book_author',
                        'terms' => $book_author,
                        'field' => 'term_id',
                        'operator' => 'IN'
            );
        }
        if ($book_publisher) {
            $tax_queries[] =
                    array(
                        'taxonomy' => 'publisher',
                        'terms' => $book_publisher,
                        'field' => 'term_id',
                        'operator' => 'IN'
            );
        }

        $meta_queries = '';
        if ($book_rating) {
            $meta_queries[] =
                    array(
                        'key' => 'book_review',
                        'value' => $book_rating,
                        'type' => 'numeric',
                        'compare' => '='
            );
        }
        if ($start_price != "" && $end_price != "") {
            $meta_queries[] =
                    array(
                        'key' => 'book_price',
                        'value' => array($start_price, $end_price),
                        'type' => 'numeric',
                        'compare' => 'BETWEEN'
            );
        }

        $page = $_POST['page'];
        $per_page = get_option('posts_per_page');
        $offset = $page * $per_page;
        $args = array(
            "post_type" => "book",
            "s" => $book_name,
            'posts_per_page' => $per_page,
            'offset' => $offset,
            'tax_query' => $tax_queries,
            'meta_query' => $meta_queries
        );
        $book_list_query = get_posts($args);

        $html = "";
        if (!empty($book_list_query)) {
            if ($page == 0) {
                $l = 1;
            } else {
                $l = $per_page * $page + 1;
            }
            foreach ($book_list_query as $post) {
                $html .= '<tr>';
                $html .= '<td>' . $l . '</td>';
                $html .= '<td><a href="' . get_permalink($post->ID) . '">' . $post->post_title . '</a></td>';
                $html .= '<td>$' . get_post_meta($post->ID, 'book_price', true) . '</td>';

                $term_list_author = wp_get_post_terms($post->ID, 'book_author');
                $au_list = "";
                $a=0;
                foreach ($term_list_author as $au){
                    if($a!=0){ $au_list .= ", "; }
                    $au_list .= '<a href="'.get_term_link($au).'">'.$au->name.'</a>';
                    $a++;
                }
                $html .= '<td>' . $au_list . '</td>';

                $term_list_publisher = wp_get_post_terms($post->ID, 'publisher');
                $pu_list = "";
                $p=0;
                foreach ($term_list_publisher as $pu){
                    if($p!=0){ $pu_list .= ", "; }
                    $pu_list .= '<a href="'.get_term_link($pu).'">'.$pu->name.'</a>';
                    $p++;
                }
                $html .= '<td>' . $pu_list . '</td>';

                //$html .= '<td>' . get_post_meta($post->ID, 'book_review', true) . '</td>';

                $rev_cnt = get_post_meta($post->ID, 'book_review', true);
                $rem_rev_cnt = 5 - $rev_cnt;

                $html .= '<td>';
                for($i=0; $i<$rev_cnt; $i++){
                    $html .= '<img src="'.plugins_url( 'inc/images/star_black.png', __FILE__ ).'">';
                }
                for($i=0; $i<$rem_rev_cnt; $i++){
                    $html .= '<img src="'.plugins_url( 'inc/images/star_normal.png', __FILE__ ).'">';
                }
                $html .= '</td>';

                $html .= '</tr>';

                $l++;
            }

            $count_args = array(
                "post_type" => "book",
                "s" => $book_name,
                'posts_per_page' => -1,
                'tax_query' => $tax_queries,
                'meta_query' => $meta_queries
            );
            $book_list_count = get_posts($count_args);
            $count = count($book_list_count);
            $total_pages = ceil($count / $per_page);

            if ($total_pages > 1) {
                $html .= '<tr><td colspan=6><div class="book_pagination"><ul>';
                if ($page == 0) {
                    $html .= '<li><span>Previous</span></li>';
                } else {
                    $html .= '<li><a data-page="' . ($page - 1) . '" href="javascript:void(0);">Previous</a></li>';
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == ($page + 1)) {
                        $html .= '<li class="active"><span>' . $i . '</span></li>';
                    } else {
                        $html .= '<li><a data-page="' . ($i - 1) . '" href="javascript:void(0);">' . $i . '</a></li>';
                    }
                }
                if ($page == ($total_pages - 1)) {
                    $html .= '<li><span>Next</span></li>';
                } else {
                    $html .= '<li><a data-page="' . ($page + 1) . '" href="javascript:void(0);">Next</a></li>';
                }
                $html .= '</ul></div><td></tr>';
            }
        } else {
            $html .= "<tr><td colspan=6>No Books found in your search creteria...</td></tr>";
        }
        wp_reset_query();
        echo $html;
        die();
    }

    // created meta box for books post type
    public function global_notice_meta_box() {
        add_meta_box(
                'global-notice', __('Book Price & Rating', 'sitepoint'), array($this, 'global_notice_meta_box_callback'), 'book'
        );
    }

    // meta box callback function to register fields
    public function global_notice_meta_box_callback($post) {
        // Add a nonce field so we can check for it later.
        wp_nonce_field('global_notice_nonce', 'global_notice_nonce');
        $book_price = get_post_meta($post->ID, 'book_price', true);
        $book_review = get_post_meta($post->ID, 'book_review', true);
        ?>
        <div class="book_cutom_meta">
            <label>Book Price ($1-$3000)</label><br>
            ($) <input type="number" style="width:97%" id="book_price" name="book_price" value="<?php echo $book_price; ?>" placeholder="Please insert book price (in US dollar)"><br><br>
            <label>Book Rating (1-5)</label><br>
            <select style="width:100%" name="book_review" id="book_review">
                <option value="">--</option>
                <option value="1" <?php selected($book_review, '1'); ?>>1</option>
                <option value="2" <?php selected($book_review, '2'); ?>>2</option>
                <option value="3" <?php selected($book_review, '3'); ?>>3</option>
                <option value="4" <?php selected($book_review, '4'); ?>>4</option>
                <option value="5" <?php selected($book_review, '5'); ?>>5</option>
            </select>
        </div>
        <?php
    }

    // save meta box fields
    function save_global_notice_meta_box_data($post_id) {
        // Check if our nonce is set.
        if (!isset($_POST['global_notice_nonce'])) {
            return;
        }
        // Verify that the nonce is valid.
        if (!wp_verify_nonce($_POST['global_notice_nonce'], 'global_notice_nonce')) {
            return;
        }
        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        // Check the user's permissions.
        if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return;
            }
        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return;
            }
        }

        // Make sure that it is set.
        if (!isset($_POST['book_price']) && !isset($_POST['book_review'])) {
            return;
        }
        // not save if price or rating lessthan zero
        if ($_POST['book_price'] < 1 || $_POST['book_review'] < 1) {
            return;
        }
        // not save if price or rating greater
        if ($_POST['book_price'] <= 3000) {
            // Sanitize user input.
            $book_price = sanitize_text_field($_POST['book_price']);
            // Update the meta field in the database.
            update_post_meta($post_id, 'book_price', $book_price);
        }
        if ($_POST['book_review'] <= 5) {
            // Sanitize user input.
            $book_review = sanitize_text_field($_POST['book_review']);
            // Update the meta field in the database.
            update_post_meta($post_id, 'book_review', $book_review);
        }
    }

}
?>