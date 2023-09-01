<?php
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'report';
?>
<div class="warp">
    <div id="icon-options-general" class="icon32"></div>
    <h1>
        <?php esc_html_e('Spinio') ?>
        <a class="xs-pro-link" href="https://codecanyon.net/item/spinio-fortune-wheel-for-woocommcer-lead-booster/22175475" target="_blank">
            <div class="xs-button-main">
                <?php submit_button(esc_html__("Pro Version"), 'secondary' , "xs-button"); ?>
            </div>
        </a>
    </h1>
   <nav class="nav-tab-wrapper wp-clearfix" aria-label="Secondary menu">
        <a class="nav-tab <?php  if($tab =='report' ){ echo 'nav-tab-active'; } ?>" href="?page=spinio-support&tab=report" class="nav-tab">
                <?php esc_html_e( 'Report a bug'); ?>
        </a>
        <a class="nav-tab <?php  if($tab =='request' ){ echo 'nav-tab-active'; } ?>" href="?page=spinio-support&tab=request" class="nav-tab">
                <?php esc_html_e( 'Request a Feature'); ?>
        </a>
        <a class="nav-tab <?php  if($tab =='hire' ){ echo 'nav-tab-active'; } ?>" href="?page=spinio-support&tab=hire" class="nav-tab">
                <?php esc_html_e( 'Hire US'); ?>
        </a>
        <a class="nav-tab <?php  if($tab =='review' ){ echo 'nav-tab-active'; } ?>" href="?page=spinio-support&tab=review" class="nav-tab">
                <?php esc_html_e( 'Review'); ?>
        </a>

    </nav>
    <div class="tab-content">
        <?php switch ($tab) {
            case 'report':
                ?>
                <div class="xs-send-email-notice xs-top-margin">
                    <p></p>
                    <button type="button" class="notice-dismiss xs-notice-dismiss"><span class="screen-reader-text"><?php esc_html_e('Dismiss this notice');?></span></button>
                </div>
                <form method="post" class="xs_support_form">
                    <input type="hidden" name="type" value="report">
                    <table class="form-table">
                        <tbody>
                            <tr valign="top">
                                <th>
                                    <label for='xs_name'><?php esc_html_e('Your Name:'); ?></label>
                                </th>
                                <td>
                                    <input type="text" id="xs_name" name="xs_name" required="required">
                                </td>
                            </tr>
                            <tr valign="top">
                                <th>
                                    <label for="xs_email"><?php esc_html_e('Your Email'); ?></label>
                                </th>
                                <td>
                                    <input type="email" id="xs_email" name="xs_email" required="required">
                                </td>
                            </tr>
                            <tr valign="top">
                                <th>
                                    <label for="xs_message"><?php esc_html_e('Message'); ?></label>
                                </th>
                                <td>
                                    <textarea id="xs_message" name="xs_message" rows="12", cols="47" required="required"></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="input-group">
                        <?php submit_button(__( 'Send'), 'primary xs-send-mail'); ?>
                        <span class="spinner xs-mail-spinner"></span> 
                    </div>
                    
                </form>
                
                <?php
                break;
            case 'request':
                ?>
                <div class="xs-send-email-notice xs-top-margin">
                    <p></p>
                    <button type="button" class="notice-dismiss xs-notice-dismiss"><span class="screen-reader-text"><?php esc_html_e('Dismiss this notice');?></span></button>
                </div>
                <form method="post" class="xs_support_form">
                    <input type="hidden" name="type" value="request">
                    <table class="form-table">
                        <tbody>
                            <tr valign="top">
                                <th>
                                    <label for='xs_name'><?php esc_html_e('Your Name:'); ?></label>
                                </th>
                                <td>
                                    <input type="text" id="xs_name" name="xs_name" required>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th>
                                    <label for="xs_email"><?php esc_html_e('Your Email'); ?></label>
                                </th>
                                <td>
                                    <input type="email" id="xs_email" name="xs_email" required>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th>
                                    <label for="xs_message"><?php esc_html_e('Message'); ?></label>
                                </th>
                                <td>
                                    <textarea id="xs_message" name="xs_message" rows="12", cols="47" required></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="input-group">
                        <?php submit_button(__( 'Send'), 'primary xs-send-mail'); ?>
                        <span class="spinner xs-mail-spinner"></span> 
                    </div>
                    
                </form>
                <?php
                break;
            case 'hire':
                ?>
                <h2><?php esc_html_e("Hire us to customize/develope Plugin/Theme or WordPress projects") ?></h2>
                <div class="xs-send-email-notice xs-top-margin">
                    <p></p>
                    <button type="button" class="notice-dismiss xs-notice-dismiss"><span class="screen-reader-text"><?php esc_html_e('Dismiss this notice');?></span></button>
                </div>
                <form method="post" class="xs_support_form">
                    <input type="hidden" name="type" value="hire">
                    <table class="form-table">
                        <tbody>
                            <tr valign="top">
                                <th>
                                    <label for='xs_name'><?php esc_html_e('Your Name:'); ?></label>
                                </th>
                                <td>
                                    <input type="text" id="xs_name" name="xs_name" required="required">
                                </td>
                            </tr>
                            <tr valign="top">
                                <th>
                                    <label for="xs_email"><?php esc_html_e('Your Email'); ?></label>
                                </th>
                                <td>
                                    <input type="email" id="xs_email" name="xs_email" required="required">
                                </td>
                            </tr>
                            <tr valign="top">
                                <th>
                                    <label for="xs_message"><?php esc_html_e('Message'); ?></label>
                                </th>
                                <td>
                                    <textarea id="xs_message" name="xs_message" rows="12", cols="47" required="required"></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="input-group">
                        <?php submit_button(__( 'Send'), 'primary xs-send-mail'); ?>
                        <span class="spinner xs-mail-spinner"></span> 
                    </div>
                </form>
                <?php
                break;
            case 'review':
            ?>
                <p class="about-description xs-top-margin"><?php esc_html_e("If you like our plugin and support than kindly share your") ?> <a href="https://wordpress.org/plugins/wc-spin-to-win-wheel/#reviews" target="_blank"> <?php esc_html_e("feedback") ?> </a><?php esc_html_e("Your feedback is valuable.") ?> </p>
            <?php
                break;
            default:
                break;
        }
            ?>
    </div>
</div>