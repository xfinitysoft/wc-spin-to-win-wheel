<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @see       https://xfinitysoft.com/
 * @since      1.0.0
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @author     Xfinitysoft <support@xfinitysoft.com>
 */
class spinio_Admin
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     *
     * @var string the ID of this plugin
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     *
     * @var string the current version of this plugin
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     *
     * @param string $plugin_name the name of this plugin
     * @param string $version     the version of this plugin
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        /*
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in spinio_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The spinio_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name.' bootstrap', plugin_dir_url(__FILE__).'css/bootstrap.min.css', array(), $this->version, 'all');

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__).'css/spinio-admin.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name.' slider', plugin_dir_url(__FILE__).'css/bootstrap-slider.min.css', array(), $this->version, 'all');
        wp_enqueue_style('wp-color-picker');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        /*
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in spinio_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The spinio_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_media();
        wp_enqueue_script($this->plugin_name.' bootstrap', plugin_dir_url(__FILE__).'js/bootstrap.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script($this->plugin_name.'slider', plugin_dir_url(__FILE__).'js/bootstrap-slider.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__).'js/spinio-admin.js', array('jquery', 'wp-color-picker'), $this->version, true);
    }

    /*
    check woocommerce
    */

    public function woo_check()
    {
        if (!is_plugin_active('woocommerce/woocommerce.php')) {
            ?>
		    <div class="error notice">
		      <p><?php _e('<a href="https://wordpress.org/plugins/woocommerce/" target="_blank">Woocommerce</a> is necessary for SPINIO, kindly install <a href="https://wordpress.org/plugins/woocommerce/" target="_blank">Woocommerce</a> before using SPINIO.'); ?></p>
		    </div>
		    <?php

        }
    }

    /*
    admin display pages
    */
    public function admin_display_page()
    {
        add_menu_page(
            'Spinio Wheel for WordPress and Woocommerce', //$page_title
            'Spinio', //$menu_title
            'manage_options', //$capability
            'spinio-display', //$menu_slug
            array($this, 'spinio_top_page'), //$function
            '',  //$icon_url
            '3.0' //$position number on menu from top
        );
        //add_menu_page('My Custom Page', 'My Custom Page', 'manage_options', 'my-top-level-slug');
        add_submenu_page('spinio-display', 'Spinio Wheel', 'Spinio Wheel', 'manage_options', 'spinio-display', array($this, 'spinio_top_page'));
        add_submenu_page('spinio-display', 'Spinio Style page', 'Style', 'manage_options', 'spinio-style', array($this, 'spinio_style_page'));
        add_submenu_page('spinio-display', 'Spinio Subscribers', 'Subscribers', 'manage_options', 'spinio-subscribers', array($this, 'spinio_subscriber_page'));
        add_submenu_page('spinio-display', 'Spinio Settings', 'Settings', 'manage_options', 'spinio-settings', array($this, 'spinio_settings_page'));
        add_submenu_page('spinio-display', 'Spinio Help', 'Help', 'manage_options', 'spinio-help', array($this, 'spinio_help_page'));
        add_submenu_page('spinio-display', 'Spinio Support', 'Support', 'manage_options', 'spinio-support', array($this, 'spinio_support_page'));
    }

    public function spinio_top_page()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'admin/partials/spinio-display.php';
    }

    public function spinio_style_page()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'admin/partials/spinio-style.php';
    }

    public function spinio_subscriber_page()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'admin/partials/spinio-subscribers.php';
    }

    public function spinio_help_page()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'admin/partials/spinio-help.php';
    }

    public function spinio_settings_page()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'admin/partials/spinio-settings.php';
    }
    public function spinio_support_page(){
        require_once plugin_dir_path(dirname(__FILE__)).'admin/partials/spinio-support.php';
    }

    /*----slice form processing --------*/

    public function slice_wheel_form()
    {
        global $wpdb;
            $data = array();
            parse_str($_POST['data'],$data);
            if (isset($data['slice_label']) && !empty($data['slice_label'])) {
               $wheel_title = 'new wheel';
               $label = array_map('sanitize_text_field',$data['slice_label']);
               $type = array_map('sanitize_text_field',$data['slice_type']);
               $result_Text = array_map('sanitize_text_field',$data['slice_win']);
               $value = array_map('sanitize_text_field',$data['slice_value']);
               $pro = array_map('sanitize_text_field',$data['slice_prob']);
               $wheel_id = '01';
               $slice = array();

                //loop all arrays
                foreach ($label as $key => $l) {
                    $win = ($type[$key] == 'noprize') ? false : true;
                    $slice[$key] = array(
                    'probability' => $pro[$key],
                    'type' => 'string',
                    'value' => $label[$key],
                    'win' => $win,
                    'resultText' => $result_Text[$key],
                    'slice_type' => $type[$key],
                    'userData' => array('score' => $value[$key]),
                    );
                }
                update_option('spinio-slice', $slice);
                die('1');
           } else {
               die('0');
           }
    }

    public function get_slices()
    {
        return get_option('spinio-slice');
        die();
    }

    public function spnio_wheel_themes()
    {
        $spinio_themes = array();
        $spinio_themes = array(
        array(
            'theme' => array(
            'title' => 'Multi Color',
            'bgImage' => 'this is background',
            'bgColor' => 'this is bgColor',
            ),
        'colorArray' => array('#364C62', '#F1C40F', '#E67E22', '#E74C3C', '#ECF0F1', '#95A5A6', '#16A085', '#27AE60', '#2980B9', '#8E44AD', '#2C3E50', '#F39C12', '#D35400', '#C0392B', '#BDC3C7', '#1ABC9C', '#2ECC71', '#E87AC2', '#3498DB', '#9B59B6', '#7F8C8D'), ),
        array(
        'theme' => array(
            'title' => 'Blue',
            ),
        'colorArray' => array('#364C62', '#F1C40F', '#E67E22', '#E74C3C', '#ECF0F1', '#95A5A6', '#16A085', '#27AE60', '#2980B9', '#8E44AD', '#2C3E50', '#F39C12', '#D35400', '#C0392B', '#BDC3C7', '#1ABC9C', '#2ECC71', '#E87AC2', '#3498DB', '#9B59B6', '#7F8C8D'), ),
        array(
        'theme' => array(
            'title' => 'Crack while',
            ),
        'colorArray' => array('#364C62', '#F1C40F', '#E67E22', '#E74C3C', '#ECF0F1', '#95A5A6', '#16A085', '#27AE60', '#2980B9', '#8E44AD', '#2C3E50', '#F39C12', '#D35400', '#C0392B', '#BDC3C7', '#1ABC9C', '#2ECC71', '#E87AC2', '#3498DB', '#9B59B6', '#7F8C8D'), ),
        array(
        'theme' => array(
            'title' => 'Deep Purpal',
            ),
        'colorArray' => array('#364C62', '#F1C40F', '#E67E22', '#E74C3C', '#ECF0F1', '#95A5A6', '#16A085', '#27AE60', '#2980B9', '#8E44AD', '#2C3E50', '#F39C12', '#D35400', '#C0392B', '#BDC3C7', '#1ABC9C', '#2ECC71', '#E87AC2', '#3498DB', '#9B59B6', '#7F8C8D'), ),
        array(
        'theme' => array(
            'title' => 'Faminine',
                    ),
        'colorArray' => array('#364C62', '#F1C40F', '#E67E22', '#E74C3C', '#ECF0F1', '#95A5A6', '#16A085', '#27AE60', '#2980B9', '#8E44AD', '#2C3E50', '#F39C12', '#D35400', '#C0392B', '#BDC3C7', '#1ABC9C', '#2ECC71', '#E87AC2', '#3498DB', '#9B59B6', '#7F8C8D'), ),
        array(
        'theme' => array(
            'title' => 'Green Dessert',
            ),
        'colorArray' => array('#364C62', '#F1C40F', '#E67E22', '#E74C3C', '#ECF0F1', '#95A5A6', '#16A085', '#27AE60', '#2980B9', '#8E44AD', '#2C3E50', '#F39C12', '#D35400', '#C0392B', '#BDC3C7', '#1ABC9C', '#2ECC71', '#E87AC2', '#3498DB', '#9B59B6', '#7F8C8D'), ),
        array(
        'theme' => array(
            'title' => 'Empire',
            ),
        'colorArray' => array('#364C62', '#F1C40F', '#E67E22', '#E74C3C', '#ECF0F1', '#95A5A6', '#16A085', '#27AE60', '#2980B9', '#8E44AD', '#2C3E50', '#F39C12', '#D35400', '#C0392B', '#BDC3C7', '#1ABC9C', '#2ECC71', '#E87AC2', '#3498DB', '#9B59B6', '#7F8C8D'), ),
        array(
        'theme' => array(
            'title' => 'orange',
            ),
        'colorArray' => array('#364C62', '#F1C40F', '#E67E22', '#E74C3C', '#ECF0F1', '#95A5A6', '#16A085', '#27AE60', '#2980B9', '#8E44AD', '#2C3E50', '#F39C12', '#D35400', '#C0392B', '#BDC3C7', '#1ABC9C', '#2ECC71', '#E87AC2', '#3498DB', '#9B59B6', '#7F8C8D'), ),
        array(
        'theme' => array(
            'title' => 'alt blue',
            ),
        'colorArray' => array('#364C62', '#F1C40F', '#E67E22', '#E74C3C', '#ECF0F1', '#95A5A6', '#16A085', '#27AE60', '#2980B9', '#8E44AD', '#2C3E50', '#F39C12', '#D35400', '#C0392B', '#BDC3C7', '#1ABC9C', '#2ECC71', '#E87AC2', '#3498DB', '#9B59B6', '#7F8C8D'), ),
        array(
        'theme' => array(
            'title' => 'Vintage',
            ),
        'colorArray' => array('#364C62', '#F1C40F', '#E67E22', '#E74C3C', '#ECF0F1', '#95A5A6', '#16A085', '#27AE60', '#2980B9', '#8E44AD', '#2C3E50', '#F39C12', '#D35400', '#C0392B', '#BDC3C7', '#1ABC9C', '#2ECC71', '#E87AC2', '#3498DB', '#9B59B6', '#7F8C8D'), ),
        );
    $them = json_decode(get_option('spinio_themes'));
        var_dump($them[0]->theme);

        die();
    }

    public function get_coupons()
    {
        $args = array(
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'asc',
            'post_type' => 'shop_coupon',
            'post_status' => 'publish',
        );

        $coupons = get_posts($args);

        $coupon_names = array();
        foreach ($coupons as $key => $coupon) {
            $coupon_names[$key] = array(
               'name' => $coupon->post_title,
               'code' => $coupon->post_title,
            );
        }

        return $coupon_names;
    }

    public function spinio_form_save_style()
    {

        //initialization
        $style_data = array_map('sanitize_text_field',$_POST);
        $id = 0;
        $spinio_style_msg = null;
        //validation and default values

        if (empty($style_data['SliceColor'])) {
            $style_data['SliceColor'] = array('#373737', '#ffd83d');
        }

        if (empty($style_data['segmentStrokeColor'])) {
            $style_data['segmentStrokeColor'] = '#E2E2E2';
        }

        if (empty($style_data['segmentStrokeWidth'])) {
            $style_data['segmentStrokeWidth'] = '4';
        }

        if (empty($style_data['wheelStrokeColor'])) {
            $style_data['wheelStrokeColor'] = '#D0BD0C';
        }

        if (empty($style_data['wheelStrokeWidth'])) {
            $style_data['wheelStrokeWidth'] = '4';
        }

        if (empty($style_data['wheelTextColor'])) {
            $style_data['wheelTextColor'] = '#EDEDED';
        }

        if (empty($style_data['wheelTextSize'])) {
            $style_data['wheelTextSize'] = '2.5';
        }

        if (empty($style_data['centerCircleStrokeColor'])) {
            $style_data['centerCircleStrokeColor'] = '#F1DC15';
        }

        if (empty($style_data['centerCircleStrokeWidth'])) {
            $style_data['centerCircleStrokeWidth'] = '12';
        }

        if (empty($style_data['centerCircleFillColor'])) {
            $style_data['centerCircleFillColor'] = '#EDEDED';
        }

        if (empty($style_data['centerCircleSize'])) {
            $style_data['centerCircleSize'] = '360';
        }

        if (empty($style_data['logo_url_preview'])) {
            $style_data['logo_url_preview'] = '';
        }

        if (empty($style_data['hasShadows'])) {
            $style_data['hasShadows'] = false;
        }
        if (empty($style_data['bgimage'])) {
            $style_data['bgimage'] = '0';
        }

        //var_dump($style_data);

        if (empty($style_data['spinio_style_id'])) {
            $old_id = get_option('spinio_style_id', array(array('id' => '104', 'title' => 'Spinio Default style')));
            //$id++;
            $id = substr(uniqid(rand(), true), 5, 5);
            update_option('spinio_style_id', array_merge($old_id, array(array('id' => $id, 'title' => $style_data['styleTitle']))));
            $Scount = get_option('spinio_style_count', 0);
            ++$Scount;
            update_option('spinio_style_count', $Scount);
        } else {
            $id = sanitize_text_field($_POST['spinio_style_id']);
        }
        $spinio_style_name = 'spinio_style_'.$id;

        if (update_option($spinio_style_name, json_encode($style_data))) {
            $spinio_style_msg = '1';
        } else {
            $spinio_style_msg = '0';
        }
        //	var_dump($style_data);
        header('Location: '.(admin_url('admin.php?page=spinio-style&style='.$id.'&spiniomsg='.$spinio_style_msg)));
    }

    public function spinio_style_del()
    {
        if (isset($_POST['style_id'])) {
            $style_id = sanitize_text_field($_POST['style_id']);
            //echo 'style id: '.$style_id;
            $spinio_stye_list = get_option('spinio_style_id');
            //var_export($spinio_stye_list);
            $key = null;
            foreach ($spinio_stye_list as $k => $a) {
                if ($a['id'] == $style_id) {
                    $key = $k;
                    break;
                }
            }
            //echo 'key :'.$key;
            if (!empty($key)) {
                unset($spinio_stye_list[$key]);
                //var_dump(update_option('spinio_style_id', $spinio_stye_list));
                delete_option('spinio_style_'.$style_id);
            }
        }
            die();
        }

    public function spinio_form_right()
    {
        delete_option('spinio_form_right');
        $data = array();
        parse_str($_POST['data'],$data);
        if (isset($data) && !empty($data)) {
            $spinio_data = null;
            $spinio_data['spinio_logo_url'] = filter_var($data['spinio_logo_url'], FILTER_SANITIZE_URL);
            $spinio_data['Ftitle'] = sanitize_text_field(esc_html($data['Ftitle']));
            $spinio_data['Fdescription'] = sanitize_text_field(esc_html($data['Fdescription']));
            $spinio_data['Fnameholder'] = sanitize_text_field(esc_html($data['Fnameholder']));
            $spinio_data['Femailholder'] = sanitize_text_field(esc_html($data['Femailholder']));
            $spinio_data['Fbuttontext'] = sanitize_text_field(esc_html($data['Fbuttontext']));
            $spinio_data['closeText'] = sanitize_text_field(esc_html($data['closeText']));
            update_option('spinio_form_right', $spinio_data);
        die();
        }
    }

    /*subscriber list table*/
    public function get_subscribers($per_page = 10, $page_number = 1, $orderby = null, $order = null)
    {
        $spinio_data = null;
        global $wpdb;
        $customPagHTML = '';
        $tablename = $wpdb->prefix.'spinio_emails';

        $sql = "SELECT * FROM {$tablename}";
        $total_query = "SELECT COUNT(1) FROM (${sql}) AS combined_table";
        $total = $wpdb->get_var($total_query);
        $totalPage = ceil($total / $per_page);
        if (!empty($orderby)) {
            $sql .= ' ORDER BY '.esc_sql($orderby);
            $sql .= !empty($order) ? ' '.esc_sql($order) : ' ASC';
        }

        $sql .= " LIMIT $per_page";

        $sql .= ' OFFSET '.($page_number - 1) * $per_page;

        $result = $wpdb->get_results($sql, 'ARRAY_A');
            //echo $totalPage;
        if ($totalPage > 0) {
        $pagination = paginate_links(array(
        'base' => add_query_arg('cpage', '%#%'),
        'format' => '',
        'prev_text' => __('&laquo;'),
        'next_text' => __('&raquo;'),
        'total' => $totalPage,
        'current' => $page_number,
        'type' => 'array',
        ));
            $spinio_data['result'] = $result;
            $spinio_data['pagination'] = $pagination;
        }

        return $spinio_data;
    }

    /*
    export subscribers to csv file
    */
    public function export_spinio_subscribers()
    {
        global $wpdb;
        $tablename = $wpdb->prefix.'spinio_emails';
        $output_filename = date('Ymd_His').'SPINIO_emails.csv'; // ?? not defined in original code
        $results = $wpdb->get_results("SELECT `name` ,  `email` FROM {$tablename};", ARRAY_A);
        $csv_fields = array();
        $csv_fields[] = 'Name';
        $csv_fields[] = 'Email';
        if (empty($results)) {
            return;
        }

        $output_handle = @fopen('php://output', 'w');

        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Description: File Transfer');
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename='.$output_filename);
        header('Expires: 0');
        header('Pragma: public');

    // Insert header row
    fputcsv($output_handle, $csv_fields);

    // Parse results to csv format
    foreach ($results as $Result) {
        $leadArray = (array) $Result; // Cast the Object to an array
        // Add row to file
        fputcsv($output_handle, $leadArray);
    }

    // Close output file stream
    fclose($output_handle);

        die();
    }

    public function spinio_display_save()
    {
        $data = array();
        parse_str($_POST['data'],$data);
        //var_dump($_POST);
        if (!empty($data['enableSpinio'])) {
            $spinio_data['enableSpinio'] = sanitize_text_field(esc_html($data['enableSpinio']));
        } else {
            $spinio_data['enableSpinio'] = false;
        }
        if (!empty($data['NameField'])) {
            $spinio_data['NameField'] = sanitize_text_field(esc_html($data['NameField']));
        } else {
            $spinio_data['NameField'] = false;
        }
        if (!empty($data['style_id'])) {
            $spinio_data['style_id'] = sanitize_text_field(esc_html($data['style_id']));
        } else {
            $spinio_data['style_id'] = 'new';
        }
        if (!empty($data['snow'])) {
            $spinio_data['snow'] = sanitize_text_field(esc_html($data['snow']));
        } else {
            $spinio_data['snow'] = false;
        }

        update_option('spinio_display', $spinio_data);
        die();
    }

    public function spinio_save_settings()
    {
        //var_dump($_POST);
        $spinio_data = array();
        if (isset($_POST['enableSpinio'])) {
            $spinio_data['enableSpinio'] = true;
        } else {
            $spinio_data['enableSpinio'] = false;
        }
        if (isset($_POST['spNameField'])) {
            $spinio_data['spNameField'] = true;
        } else {
            $spinio_data['spNameField'] = false;
        }
        if (isset($_POST['spExitIntent'])) {
            $spinio_data['spExitIntent'] = true;
        } else {
            $spinio_data['spExitIntent'] = false;
        }
        if (isset($_POST['spTimeTri'])) {
            $spinio_data['spTimeTri'] = true;
        } else {
            $spinio_data['spTimeTri'] = false;
        }
        if (isset($_POST['spTimeMil'])) {
            $spinio_data['spTimeMil'] = sanitize_text_field(esc_html($_POST['spTimeMil']));
        } else {
            $spinio_data['spTimeMil'] = false;
        }
        if (isset($_POST['spScrollDown'])) {
            $spinio_data['spScrollDown'] = true;
        } else {
            $spinio_data['spScrollDown'] = false;
        }
        if (isset($_POST['spScrollval'])) {
            $spinio_data['spScrollval'] = sanitize_text_field(esc_html($_POST['spScrollval']));
        } else {
            $spinio_data['spScrollval'] = false;
        }

        update_option('spinio_settings', $spinio_data);

        return header('Location: '.admin_url('admin.php?page=spinio-settings&save=true'), true);
        die();
    }
    public function xs_send_mail(){
        $data = array();
        parse_str($_POST['data'], $data);
        $data['plugin_name'] = 'Spinio';
        $data['version'] = 'lite';
        $data['website'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'];
        $to = 'xfinitysoft@gmail.com';
        switch ($data['type']) {
            case 'report':
                $subject = 'Report a bug';
                break;
            case 'hire':
                $subject = 'Hire us to customize/develope Plugin/Theme or WordPress projects';
                break;
            
            default:
                $subject = 'Request a Feature';
                break;
        }
        
        $body = '<html><body><table>';
        $body .='<tbody>';
        $body .='<tr><th>User Name</th><td>'.$data['xs_name'].'</td></tr>';
        $body .='<tr><th>User email</th><td>'.$data['xs_email'].'</td></tr>';
        $body .='<tr><th>Plugin Name</th><td>'.$data['plugin_name'].'</td></tr>';
        $body .='<tr><th>Version</th><td>'.$data['version'].'</td></tr>';
        $body .='<tr><th>Website</th><td><a href="'.$data['website'].'">'.$data['website'].'</a></td></tr>';
        $body .='<tr><th>Message</th><td>'.$data['xs_message'].'</td></tr>';
        $body .='</tbody>';
        $body .='</table></body></html>';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $params ="name=".$data['xs_name'];
        $params.="&email=".$data['xs_email'];
        $params.="&site=".$data['website'];
        $params.="&version=".$data['version'];
        $params.="&plugin_name=".$data['plugin_name'];
        $params.="&type=".$data['type'];
        $params.="&message=".$data['xs_message'];
        $sever_response = wp_remote_post("https://xfinitysoft.com/wp-json/plugin/v1/quote/save/?".$params);
        $se_api_response = json_decode( wp_remote_retrieve_body( $sever_response ), true );
        
        if($se_api_response['status']){
            $mail = wp_mail( $to, $subject, $body, $headers );
            wp_send_json(array('status'=>true));
        }else{
            wp_send_json(array('status'=>false));
        }
        wp_die();
    }
}
