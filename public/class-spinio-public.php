<?php

/*
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    spinio
 * @subpackage spinio/public
 * @author     Xfinitysoft <support@xfinitysoft.com>
 */
class spinio_Public
{
    /**
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
     * @param string $plugin_name the name of the plugin
     * @param string $version     the version of this plugin
     * @param      string    spinio_path    The constant path of this plugin
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        define('spinio_path', plugin_dir_url(__FILE__));
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        /*
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Plugin_Name_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Plugin_Name_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        if ($this->is_show()) {
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__).'css/spinio-public.css', array(), $this->version, 'all');
        }
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        if ($this->is_show()) {
            wp_enqueue_script($this->plugin_name.'-dialog_trigger', plugin_dir_url(__FILE__).'js/dialog_trigger.js', array('jquery'), $this->version, true);
            wp_enqueue_script($this->plugin_name.'-TweenMax', plugin_dir_url(__FILE__).'js/TweenMax.min.js', array('jquery'), $this->version, true);
            wp_enqueue_script($this->plugin_name.'-Draggable', plugin_dir_url(__FILE__).'js/Draggable.min.js', array('jquery'), $this->version, true);
            wp_enqueue_script($this->plugin_name.'-ThrowPropsPlugin', plugin_dir_url(__FILE__).'js/ThrowPropsPlugin.min.js', array('jquery'), $this->version, true);
            wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__).'js/spinio-public.js', array('jquery'), $this->version, true);
            wp_enqueue_script($this->plugin_name.'-spinio', plugin_dir_url(__FILE__).'js/spinio.js', array('jquery'), $this->version, true);
            wp_localize_script($this->plugin_name, 'spinio', array('pluginsUrl' => plugin_dir_url(__FILE__), 'ajax_url' => admin_url('admin-ajax.php')));
            wp_enqueue_script($this->plugin_name.'-TextPlugin', plugin_dir_url(__FILE__).'js/TextPlugin.min.js', array('jquery'), $this->version, true);
            wp_enqueue_script($this->plugin_name.'-index', plugin_dir_url(__FILE__).'js/index.js', array('jquery'), $this->version, true);
    //	wp_enqueue_script( $this->plugin_name.'-js', plugin_dir_url( __FILE__ ) . 'js/output.min.js', array( 'jquery' ), $this->version, true );
        wp_localize_script($this->plugin_name.'-js', 'spinio', array('pluginsUrl' => plugin_dir_url(__FILE__), 'ajax_url' => admin_url('admin-ajax.php')));
        }
    }

    public function add_short_codes()
    {
        function display_spining_wheel($atts)
        {
            echo '<div style="width:100%;height:700px !important;"><button class="spinBtn">CLICK TO SPIN!</button> <div class="wheelContainer"> <svg class="wheelSVG" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" text-rendering="optimizeSpeed"> <defs> <filter id="shadow" x="-100%" y="-100%" width="550%" height="550%"> <feOffset in="SourceAlpha" dx="0" dy="0" result="offsetOut"></feOffset> <feGaussianBlur stdDeviation="9" in="offsetOut" result="drop"/> <feColorMatrix in="drop" result="color-out" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 .3 0"/> <feBlend in="SourceGraphic" in2="color-out" mode="normal"/> </filter> </defs> <g class="mainContainer"> <g class="wheel"> </g> </g> <g class="centerCircle"/> <g class="wheelOutline"/> <g class="pegContainer" opacity="1"> <path class="peg" fill="#EEEEEE" d="M22.139,0C5.623,0-1.523,15.572,0.269,27.037c3.392,21.707,21.87,42.232,21.87,42.232 s18.478-20.525,21.87-42.232C45.801,15.572,38.623,0,22.139,0z"/> </g> <g class="valueContainer"/> </svg> <div class="toast"> <p/> </div></div></div>';
        }
    }

    /**
     *   Function to get all slices from option table.
     */
    public function get_slices($id)
    {
        return get_option('spinio-slice');
    }

    /**
     * Function to get json of the wheel
     * This function get slice options and diplay settings to make json.
     */
    public function get_wheel_json()
    {
        $spinio_data = get_option('spinio_display');
        //var_dump($spinio_data);
        $style_id = $spinio_data['style_id'];
        $spinio_style = json_decode(get_option('spinio_style_'.$style_id), true);
        $slices = get_option('spinio-slice');
        //var_dump(json_decode($slices));
            header('Content-type: application/json');
        $data = array(
        //"colorArray" => array("#018556","#8a04b3","#e10101"),
        'colorArray' => $spinio_style['SliceColor'],
        //"colorArray" => array("#2C3E50", "#F39C12", "#D35400", "#C0392B", "#BDC3C7","#1ABC9C", "#2ECC71", "#E87AC2", "#3498DB", "#9B59B6", "#7F8C8D"),
        'segmentValuesArray' => $slices,
        'svgWidth' => 1024,
        'svgHeight' => 768,
        'wheelStrokeColor' => $spinio_style['wheelStrokeColor'],
        'wheelStrokeWidth' => $spinio_style['wheelStrokeWidth'],
        'wheelSize' => 800,
        'wheelTextOffsetY' => 80,
        'wheelTextColor' => $spinio_style['wheelTextColor'],
        'wheelTextSize' => $spinio_style['wheelTextSize'].'em',
        'wheelImageOffsetY' => 40,
        'wheelImageSize' => 50,
        'centerCircleSize' => $spinio_style['centerCircleSize'],
        'centerCircleStrokeColor' => $spinio_style['centerCircleStrokeColor'],
        'centerCircleStrokeWidth' => $spinio_style['centerCircleStrokeWidth'],
        'centerCircleFillColor' => $spinio_style['centerCircleFillColor'],
        'segmentStrokeColor' => $spinio_style['segmentStrokeColor'],
        'segmentStrokeWidth' => $spinio_style['segmentStrokeWidth'],
        'centerX' => 512,
        'centerY' => 384,
        'hasShadows' => $spinio_style['hasShadows'],
        'numSpins' => 1,
        'spinDestinationArray' => array(),
        'minSpinDuration' => 7,
        //"gameOverText" => "THANK YOU FOR PLAYING SPIN2WIN WHEEL. COME AND PLAY AGAIN SOON!",
        'invalidSpinText' => 'INVALID SPIN. PLEASE SPIN AGAIN.',
        'introText' => "YOU HAVE TO<br>SPIN IT <span style='color=>#F282A9;'>2</span> WIN IT!",
        'hasSound' => true,
        'gameId' => 'spinio-1',
        'clickToSpin' => false,
        );

        echo json_encode($data);

        die();
    }

    /**
     * Function to get all subscribers.
     */
    public function spinio_set_subscriber()
    {
        $spinio_msg = null;
        $spinio_data = $_POST;
        if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            //email valid not lets check if it's already exits
            $spinio_data['email'] = sanitize_email($_POST['email']);
            global $wpdb;
            $table_name = $wpdb->prefix.'spinio_emails';
            $result = $wpdb->get_results("
	            SELECT * from $table_name WHERE email = '{$spinio_data['email']}'
	            ", ARRAY_A);
            if (empty($result)) {
                if (!isset($spinio_data['name'])) {
                    $spinio_data['name'] = null;
                }
                $wpdb->insert($table_name, array(
                'name' => $spinio_data['name'],
                'email' => $spinio_data['email'],
                'date' => current_time('mysql', 1),
                ));
                $spinio_msg['error'] = false;
            } else {
                $spinio_msg['error'] = true;
                $spinio_msg['email'] = 'Email already used';
            }
        } else {
            $spinio_msg['error'] = true;
            $spinio_msg['email'] = 'Invalid email.';
        }
        echo json_encode($spinio_msg);
        die();
    }

    /**
     *Function to show wheel. it depends upon is_show function.
     */
    public function showWheel()
    {
        if ($this->is_show()) {
            $spinio_data = get_option('spinio_display');
            $spinio_settings = get_option('spinio_settings');
            //var_dump($spinio_data);
            $style_id = $spinio_data['style_id'];
            $spinio_style = json_decode(get_option('spinio_style_'.$style_id), true);
            $spinio_right = get_option('spinio_form_right');
            //var_dump($spinio_right);
     ?>
     <style type="text/css">
     <?php if ($spinio_data['snow']) {
         ?>
         .spinio-modal-content{
        background-image: url('<?php echo plugin_dir_url(__FILE__).'img/s1.png'; ?>'), url('<?php echo plugin_dir_url(__FILE__).'img/s2.png'; ?>'), url('<?php echo plugin_dir_url(__FILE__).'img/s3.png'; ?>');
    	-webkit-animation: snow 10s linear infinite;
    	-moz-animation: snow 10s linear infinite;
    	-ms-animation: snow 10s linear infinite;
    	animation: snow 10s linear infinite;
    }
    <?php 
     } ?>
         .toast{
          background-color:yellow !important;   
         }
         .spinio-title{
             color: <?php echo $spinio_style['Ftitle']; ?>;
             text-shadow: 2px 2px 0 rgba(0,0,0,.3);
         }
         .spinio-title strong{
             color: <?php echo $spinio_style['FtitleHigh']; ?>;
             text-shadow: 2px 2px 0 rgba(0,0,0,.3);
         }
         .spinio-desc{
             color: <?php echo $spinio_style['Fdescription']; ?>;
         }
         .spinio-form-btn{
             color:<?php echo $spinio_style['FbuttonText'] ?>;
             background-color:<?php echo $spinio_style['Fbutton']; ?>;
         }
         .spinio-modal-content{
             background-color:<?php echo $spinio_style['bgColor']; ?>;
         }
         #spinio-modal-content:before{
             background-image:url('<?php echo $spinio_style['bgimage'] ?>');
             opacity:<?php echo $spinio_style['bgOpacity']; ?>;
         }
         .spinio-close{
             color:<?php echo $spinio_style['closeTextclr']; ?>;
         }
         
     </style>
     <script type="text/javascript" >
         var spinioEintent  = <?php echo ($spinio_settings['spExitIntent']) ? 'true' : 'false'; ?>;
         var spinioEtimer   = <?php echo ($spinio_settings['spTimeTri']) ? 'true' : 'false'; ?>;
         var spTimeMil      = <?php echo ($spinio_settings['spTimeMil'] > 0) ? $spinio_settings['spTimeMil'] : 'false'; ?>;
         var spinioEscroll  = <?php echo ($spinio_settings['spScrollDown']) ? 'true' : 'false'; ?>;
         var spScrollval    = <?php echo ($spinio_settings['spScrollval'] > 0) ? $spinio_settings['spScrollval'] : 'false'; ?>;
     </script>
     <!--floating button-->
     <!-- Trigger/Open Spinio Modal -->
    <div class="spinio-btn-wrapper" id="btn-wrap">
        <a id="spinio-btn" href="javascript:;"></a>
    </div>
     
     
     <!-- The Modal -->
    <div id="spinio-modal" class="spinio">
        <!--Spinio Modal content -->
        <div class="spinio-modal-content" id="spinio-modal-content">
            <div class="spinio-modal-header">
                <span class="spinio-close"><?php echo trim($spinio_right['closeText']); ?> &times;</span>
                <!-- <h2>Modal Header</h2> -->
            </div>
            <div class="spinio-modal-body">
                <div class="spinio-row">
                    <div class="spinio-col-7">
                        <div class="wheel-wrapper">
                            <button class="spinBtn" style="display:none"></button>
                            <div class="wheelContainer">
                                <svg class="wheelSVG" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                     text-rendering="optimizeSpeed">
                                    <defs>
                                        <filter id="shadow" x="-100%" y="-100%" width="550%" height="550%">
                                            <feOffset in="SourceAlpha" dx="0" dy="0" result="offsetOut"></feOffset>
                                            <feGaussianBlur stdDeviation="9" in="offsetOut" result="drop"/>
                                            <feColorMatrix in="drop" result="color-out" type="matrix" values="0 0 0 0   0
    								              0 0 0 0   0
    								              0 0 0 0   0
    								              0 0 0 .3 0"/>
                                            <feBlend in="SourceGraphic" in2="color-out" mode="normal"/>
                                        </filter>
                                    </defs>
                                    <g class="mainContainer">
                                        <g class="wheel">
                                            <!-- <image  xlink:href="http://example.com/images/wheel_graphic.png" x="0%" y="0%" height="100%" width="100%"></image> -->
                                        </g>
                                    </g>
                                    <g class="centerCircle"/>
                                    <g class="wheelOutline"/>
                                    <g class="pegContainer" opacity="1">
                                        <path class="peg" fill="#EEEEEE"
                                              d="M22.139,0C5.623,0-1.523,15.572,0.269,27.037c3.392,21.707,21.87,42.232,21.87,42.232 s18.478-20.525,21.87-42.232C45.801,15.572,38.623,0,22.139,0z"/>
                                    </g>
                                    <g class="valueContainer"/>
                                </svg>
                                <div class="toast">
                                    <p/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="spinio-col-5">
                        <div class="spinio-form-wrapper">
                            <img src="<?php echo trim($spinio_right['spinio_logo_url']); ?>" class="spinio-logo">
                            <div class="spinio-result">
                                <div id="spinio-result-msg" class="spinio-title"></div>
                                <p id="spinio-result-desc" class="spinio-desc"></p>
                                <form>
                                <input id="spinio-coupon-code" type="text" name="" class="form-spinio" >
                                <button id="spinio_copy" class="button spinio-form-btn">Copy to clipboard</button>
                                </form>
                            </div>
                            
                            <div class="spinio-intro">
                            <div class="spinio-title"><?php echo trim($spinio_right['Ftitle']); ?></div>
                            <p class="spinio-desc"><?php echo trim($spinio_right['Fdescription']); ?></p>
                            <form id="spinio_sub_form" method="post">
                               <?php if ($spinio_settings['spNameField']) {
         ?> <input type="text" name="name" class="form-spinio" placeholder="<?php echo trim($spinio_right['Fnameholder']); ?>"> <?php 
     } ?>
                                <input type="email" name="email" class="form-spinio" placeholder="<?php echo trim($spinio_right['Femailholder']); ?>">
                                <input type="hidden" name="action" value="spinio_set_subscriber">
                                <button type="submit"  id="spinio_form_btn" class="button spinio-form-btn"><?php echo trim($spinio_right['Fbuttontext']); ?></button>
                            </form>
                            </div>
                                <div class="spinio-error"> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <?php 
        }
    }

    /**
     * Function to check wheather to show the wheel or not based on cookies and display settings.
     */
    public function is_show()
    {
        //$spinio_data = get_option('spinio_display');
        $spinio_settings = get_option('spinio_settings');
        if (isset($spinio_settings['enableSpinio']) && $spinio_settings['enableSpinio']) {
            if (is_admin()) {
                return true;
            } elseif (isset($_COOKIE['spinio_show'])) {
                return false;
            } else {
                return true;
            }
        }
    }
}
