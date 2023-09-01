<?php

/**
 * Fired during plugin activation.
 *
 * @see       https://xfinitysoft.com/
 * @since      1.0.0
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 *
 * @author     Xfinitysoft <support@xfinitysoft.com>
 */
class spinio_Activator
{
    /**
     * Short Description. (use period).
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        $spinio_version = get_option('SPINIO_VERSION');
        $img_url = plugins_url('/public', __DIR__);
        if (empty($spinio_version)) {
            add_option('SPINIO_VERSION', '1.0.0');

            global $wpdb;

            $table_name = $wpdb->prefix.'spinio_emails';

            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
			id int(10) NOT NULL AUTO_INCREMENT,
			name  varchar(255) ,
    		email varchar (255),
    		date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			page LONGTEXT  ,
			status LONGTEXT,
			PRIMARY KEY (id)
		) $charset_collate;";

            require_once ABSPATH.'wp-admin/includes/upgrade.php';
            dbDelta($sql);

     /**
      * Insert Pre-made Style.
      *
      * Default theme
      */
     $spinio_data = array('action' => 'spinio_form_save_style', 'spinio_style' => '', 'spinio_style_id' => '104', 'styleTitle' => 'Spinio Default style', 'SliceColor' => array(0 => '#2c3e50', 1 => '#f39c12', 2 => '#d35400', 3 => '#c0392b', 4 => '#bdc3c7', 5 => '', 6 => '#1abc9c', 7 => '#2ecc71'), 'segmentStrokeColor' => '#e2e2e2', 'segmentStrokeWidth' => '4', 'wheelStrokeColor' => '#eaeaea', 'wheelStrokeWidth' => '17', 'wheelTextColor' => '#ffffff', 'wheelTextSize' => '2.5', 'centerCircleStrokeColor' => '#e2e2e2', 'centerCircleStrokeWidth' => '3', 'centerCircleFillColor' => '#f9f9f9', 'centerCircleSize' => '4', 'hasShadows' => 'true', 'bgimage' => ''.$img_url.'/bg-summer02.png', 'custom_bg' => '0', 'bgColor' => '#012d41', 'bgOpacity' => '0.5', 'Ftitle' => '#ffffff', 'FtitleHigh' => '#2bc3ce', 'Fdescription' => '#ffffff', 'Fbutton' => '#dd9933', 'FbuttonText' => '#ffffff', 'closeTextclr' => '#ffffff', 'logo_url_preview' => '');
            update_option('spinio_style_104', json_encode($spinio_data));

    /**
     * Insert Candy Style.
     */
    $spinio_data = array('action' => 'spinio_form_save_style', 'spinio_style' => '', 'spinio_style_id' => '04757', 'styleTitle' => 'Candy style', 'SliceColor' => array(0 => '#2fc5cc', 1 => '#6df1cc', 2 => '#E3FFC3', 3 => '#ff89c0'), 'segmentStrokeColor' => '#ffffff', 'segmentStrokeWidth' => '4', 'wheelStrokeColor' => '#ffffff', 'wheelStrokeWidth' => '17', 'wheelTextColor' => '#35495f', 'wheelTextSize' => '2.5', 'centerCircleStrokeColor' => '#e2e2e2', 'centerCircleStrokeWidth' => '3', 'centerCircleFillColor' => '#f9f9f9', 'centerCircleSize' => '83', 'hasShadows' => 'true', 'bgimage' => ''.$img_url.'/img/bg-circles02.png', 'custom_bg' => '0', 'bgColor' => '#22313f', 'bgOpacity' => '0.5', 'Ftitle' => '#ffffff', 'FtitleHigh' => '#ff89c0', 'Fdescription' => '#ffffff', 'Fbutton' => '#2fc5cc', 'FbuttonText' => '#ffffff', 'closeTextclr' => '#ffffff', 'logo_url_preview' => '');
            update_option('spinio_style_04757', json_encode($spinio_data));

    /**
     * Insert Chocolate Style.
     */
    $spinio_data = array('action' => 'spinio_form_save_style', 'spinio_style' => '', 'spinio_style_id' => '90014', 'styleTitle' => 'Chocolate', 'SliceColor' => array(0 => '#6b5443', 1 => '#c2aa8c'), 'segmentStrokeColor' => '#e2e2e2', 'segmentStrokeWidth' => '4', 'wheelStrokeColor' => '#eaeaea', 'wheelStrokeWidth' => '17', 'wheelTextColor' => '#ffffff', 'wheelTextSize' => '2.5', 'centerCircleStrokeColor' => '#e2e2e2', 'centerCircleStrokeWidth' => '3', 'centerCircleFillColor' => '#f9f9f9', 'centerCircleSize' => '4', 'hasShadows' => 'true', 'bgimage' => '0', 'custom_bg' => '0', 'bgColor' => '#00474f', 'bgOpacity' => '0.5', 'Ftitle' => '#ffffff', 'FtitleHigh' => '#c2aa8c', 'Fdescription' => '#ffffff', 'Fbutton' => '#6b5443', 'FbuttonText' => '#ffffff', 'closeTextclr' => '#ffffff', 'logo_url_preview' => '');
            update_option('spinio_style_90014', json_encode($spinio_data));

    /**
     * Insert Classic Style.
     */
    $spinio_data = array('action' => 'spinio_form_save_style', 'spinio_style' => '', 'spinio_style_id' => '91438', 'styleTitle' => 'Classic', 'SliceColor' => array(0 => '#27323a', 1 => '#435055', 2 => '#29a19c'), 'segmentStrokeColor' => '#ffffff', 'segmentStrokeWidth' => '4', 'wheelStrokeColor' => '#ffffff', 'wheelStrokeWidth' => '17', 'wheelTextColor' => '#ffffff', 'wheelTextSize' => '2.5', 'centerCircleStrokeColor' => '#e2e2e2', 'centerCircleStrokeWidth' => '3', 'centerCircleFillColor' => '#f9f9f9', 'centerCircleSize' => '4', 'hasShadows' => 'true', 'bgimage' => ''.$img_url.'/img/bg-circles02.png', 'custom_bg' => '0', 'bgColor' => '#393e46', 'bgOpacity' => '0.5', 'Ftitle' => '#ffffff', 'FtitleHigh' => '#29a19c', 'Fdescription' => '#ffffff', 'Fbutton' => '#29a19c', 'FbuttonText' => '#ffffff', 'closeTextclr' => '#ffffff', 'logo_url_preview' => '');
            update_option('spinio_style_91438', json_encode($spinio_data));

    /**
     * Insert Pinkish Style.
     */
    $spinio_data = array('action' => 'spinio_form_save_style', 'spinio_style' => '', 'spinio_style_id' => '94031', 'styleTitle' => 'Pinkish', 'SliceColor' => array(0 => '#d01257', 1 => '#fb90b7', 2 => '#f6318c'), 'segmentStrokeColor' => '#ffffff', 'segmentStrokeWidth' => '8.5', 'wheelStrokeColor' => '#ffffff', 'wheelStrokeWidth' => '18', 'wheelTextColor' => '#233142', 'wheelTextSize' => '2.5', 'centerCircleStrokeColor' => '#e2e2e2', 'centerCircleStrokeWidth' => '3', 'centerCircleFillColor' => '#f9f9f9', 'centerCircleSize' => '297', 'hasShadows' => 'true', 'bgimage' => ''.$img_url.'/img/bg-heart02.png', 'custom_bg' => '0', 'bgColor' => '#353940', 'bgOpacity' => '0.6', 'Ftitle' => '#ffffff', 'FtitleHigh' => '#f6318c', 'Fdescription' => '#ffffff', 'Fbutton' => '#f6318c', 'FbuttonText' => '#ffffff', 'closeTextclr' => '#f6318c', 'logo_url_preview' => '');
            update_option('spinio_style_94031', json_encode($spinio_data));

    /**
     * Insert Christmas  Style.
     */
    $spinio_data = array('action' => 'spinio_form_save_style', 'spinio_style' => '', 'spinio_style_id' => '79439', 'styleTitle' => 'Christmas ', 'SliceColor' => array(0 => '#da1b1a', 1 => '#ffffff'), 'segmentStrokeColor' => '#045127', 'segmentStrokeWidth' => '4', 'wheelStrokeColor' => '#b7b7b7', 'wheelStrokeWidth' => '17', 'wheelTextColor' => '#233142', 'wheelTextSize' => '2.5', 'centerCircleStrokeColor' => '#e2e2e2', 'centerCircleStrokeWidth' => '3', 'centerCircleFillColor' => '#f9f9f9', 'centerCircleSize' => '4', 'hasShadows' => 'true', 'bgimage' => ''.$img_url.'/img/Christmas-tree.png', 'custom_bg' => '0', 'bgColor' => '#045127', 'bgOpacity' => '0.5', 'Ftitle' => '#ffffff', 'FtitleHigh' => '#da1b1a', 'Fdescription' => '#ffffff', 'Fbutton' => '#da1b1a', 'FbuttonText' => '#ffffff', 'closeTextclr' => '#ffffff', 'logo_url_preview' => '');
            update_option('spinio_style_79439', json_encode($spinio_data));

     /**
      * Insert list of themes that will be used to edit.
      */
     $spinio_style_list = array(
    1 => array(
        'id' => '04757',
        'title' => 'Candy style',
    ),
    2 => array(
        'id' => '94031',
        'title' => 'Pinkish',
    ),
    3 => array(
        'id' => '79439',
        'title' => 'Christmas',
    ),
    4 => array(
        'id' => '90014',
        'title' => 'Chocolate',
    ),
    5 => array(
        'id' => '91438',
        'title' => 'Classic',
    ),
    );
            update_option('spinio_style_id', $spinio_style_list);

     /**
      * Insert default slices.
      */
     $spinio_data = array(0 => array('probability' => '10', 'type' => 'string', 'value' => '10%OFF', 'win' => true, 'resultText' => 'You won Zero', 'slice_type' => 'coupon', 'userData' => array('score' => '10discount')), 1 => array('probability' => '10', 'type' => 'string', 'value' => 'No Prize', 'win' => false, 'resultText' => 'Better luck next time', 'slice_type' => 'noprize', 'userData' => array('score' => '70OFF')), 2 => array('probability' => '10', 'type' => 'string', 'value' => 'No Prize', 'win' => false, 'resultText' => 'Oh! No luck today', 'slice_type' => 'noprize', 'userData' => array('score' => '2usdoff')), 3 => array('probability' => '10', 'type' => 'string', 'value' => 'No Prize', 'win' => false, 'resultText' => 'oh! Bad luck', 'slice_type' => 'noprize', 'userData' => array('score' => null)), 4 => array('probability' => '10', 'type' => 'string', 'value' => '20%OFF', 'win' => true, 'resultText' => 'Congratulations you won 20% OFF', 'slice_type' => 'coupon', 'userData' => array('score' => null)), 5 => array('probability' => '10', 'type' => 'string', 'value' => 'No Prize', 'win' => false, 'resultText' => 'Better luck next time', 'slice_type' => 'noprize', 'userData' => array('score' => null)), 6 => array('probability' => '10', 'type' => 'string', 'value' => 'No Prize', 'win' => false, 'resultText' => 'Maybe you win next time', 'slice_type' => 'noprize', 'userData' => array('score' => null)), 7 => array('probability' => '10', 'type' => 'string', 'value' => '2 USD OFF', 'win' => true, 'resultText' => '2 USD off for you', 'slice_type' => 'coupon', 'userData' => array('score' => null)));
            update_option('spinio-slice', $spinio_data);

     /**
      * Insert default right form settings.
      */
     $spinio_data = array('spinio_logo_url' => 'https://spinio.bixab.com/bixab.png', 'Ftitle' => 'GET YOUR CHANCE TO <strong>WIN AMAZING</strong> <strong>PRIZES</strong>', 'Fdescription' => 'Enter your name and email address below to try your luck.', 'Fnameholder' => 'Enter your name', 'Femailholder' => 'Enter your email', 'Fbuttontext' => 'Try your luck', 'closeText' => 'No Thanks');
            update_option('spinio_form_right', $spinio_data);
     /**
      * Insert default display settings.
      */
     $spinio_data = array('enableSpinio' => 'true', 'NameField' => 'true', 'style_id' => '79439', 'snow' => 'true');
            update_option('spinio_display', $spinio_data);
        }
    }
}
