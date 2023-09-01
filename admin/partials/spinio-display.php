<?php
if (!defined('ABSPATH')) {
}
  /**
   * Provide a admin area view for the plugin which controls wheel slices, right form section and display settings, in tabbed manners.
   *
   * This file is used to markup the admin-facing aspects of the plugin.
   *
   * @see       https://xfinitysoft.com/
   * @since      1.0.0
   */
  $slices = $this->get_slices();

  if (empty($slices)) {
      $slices = array('value' => '', 'resultText' => '', 'slice_type' => '', 'probability' => '');
  }

      $coupons = $this->get_coupons();

?>
<div id="spinio-wrapper">
  <div class="content container-fluid">
    <div class="row text-center">
      <h2>Spinio Wheel</h2>
    </div>
    <div class="content">
      <ul class="nav nav-tabs">
        <li class= "nav-item ">
          <a class="nav-link active" data-toggle="tab" href="#slices">Step 1</a>
        </li>
        <li class= "nav-item">
          <a class="nav-link" data-toggle="tab" href="#formsection">Step 2</a>
        </li>
        <li class= "nav-item">
          <a class="nav-link" data-toggle="tab" href="#settings">Step 3</a>
        </li>
      </ul>
    </div>
    <div class="tab-content" style="margin-bottom: 35px;">
      <div  id="slices" class="tab-pane  container active in" style="margin-bottom: 35px;">
        <div class="text-center">
          <h1>Slices</h1>
        </div>
        <div id="slice_alert" class="alert alert-success alert-dismissable fade in hide">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Saved!</strong>
          <p>Slices has been saved.</p>
        </div>
        <?php if (empty($coupons)) {
    ?>
        <div class="alert alert-danger fade in">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Coupons not found!</strong>
          <p>Please 
            <a href="
              <?php echo admin_url('post-new.php?post_type=shop_coupon'); ?>" >add coupons 
            </a> in woocommerce, before using SPINIO slices.
          </p>
        </div>
        <?php 
} ?>
        <div>
          <form id="slicesForm" method="POST">
            <table id="wheel-slices" class="table-responsive table table-striped table-hover">
              <thead>
                <tr>
                  <th width="10">Order</th>
                  <th>Label</th>
                  <th width="150">Type</th>
                  <th>Wining/Loss Message</th>
                  <th width="150">Coupon</th>
                  <th width="8">Probability</th>
                  <th width="5"></th>
                  <th width="5">Delete</th>
                </tr>
              </thead>
              <tbody>
                <?php 
            foreach ($slices as  $slice) {
                ?>
                <tr class="slice" id="slice_tr">
                  <td class="center-text"></td>
                  <td>
                    <input required type="text" value="<?php echo trim($slice['value']); ?>" name="slice_label[]" maxlength="50" class="form-control">
                    </td>
                    <td>
                      <select name="slice_type[]" required  class="slice_type form-control">
                        <option 
                          <?php selected($slice['slice_type'], 'coupon'); ?> value="coupon">Coupon code
                        </option>
                        <option 
                          <?php selected($slice['slice_type'], 'noprize'); ?> value="noprize">No prize
                        </option>
                      </select>
                    </td>
                    <td>
                      <input required type="text" value="<?php echo trim($slice['resultText']); ?>" name="slice_win[]" maxlength="50" class="form-control">
                      </td>
                      <td>
                        <select name="slice_value1[]"   class="slice_value form-control" 
                          <?php echo ($slice['slice_type'] == 'noprize') ? 'disabled="disabled"' : 'required'; ?> >
                          <option value="">Select</option>
                          <?php
                    $coupons = $this->get_coupons();
                foreach ($coupons as $key => $coupon) {
                    ?>
                          <option 
                            <?php selected($slice['userData']['score'], $coupon['code']); ?> value="<?php echo trim($coupon['code']); ?>"><?php echo $coupon['name']; ?></option>
                          <?php 
                } ?>
                        </select>
                        <input class="slice_valuei" type="hidden" name="slice_value[]" value="<?php echo trim($slice['userData']['score']); ?>">
                        </td>
                        <td>
                          <input required type="text" value="<?php echo trim($slice['probability']); ?>" name="slice_prob[]" class="form-control">
                          </td>
                          <td>%</td>
                          <td>
                            <a  class="button btn-danger slice-delete">
                              <span class="dashicons dashicons-trash"></span>
                            </a>
                          </td>
                        </tr>
                        <?php 
            }
            ?>
                      </tbody>
                    </table>
                    <div class="row" style="padding:15px">
                      <div class="col-sm-4" >
                        <span class="right">
                          <a  class="button btn-primary add-slice">
                            <span class="dashicons dashicons-plus"></span>Add
                          </a>
                        </span>
                      </div>
                      <div class="col-sm-4"></div>
                      <div class="col-sm-4">
                        <span class="left">
                          <button  id="save_slices_btn" class="button btn-success" data-loading-text="
                            <i class='dashicons dashicons-update fa-spin'></i> Saving Slices">
                            <span class="dashicons dashicons-yes"></span>Save
                          </button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <a class="btn btn-primary btnNext" >Next</a>
                </form>
              </div>
              <div id="formsection" class="tab-pane container fade">
                <div class="text-center">
                  <h1>Form configuration</h1>
                </div>
                <?php 
         $spinio_fdata = get_option('spinio_form_right');

         ?>
                <div>
                  <form id="spinio_form_right" method="POST">
                    <div class="text-center">
                      <img style="max-height:150px" id="logo_url_preview" src="
                        <?php echo $spinio_fdata['spinio_logo_url']; ?>" class="img-thumbnail">
                        <input type="text" id="spinio_logo_url" name="spinio_logo_url" value="<?php echo $spinio_fdata['spinio_logo_url']; ?>" class="hidden" autocomplete="off">
                        </div>
                        <div class="row form-group">
                          <label class="col-md-2 control-label" for="color">Logo/custom image</label>
                          <div class="col-md-8">
                            <input id="logo_url_button" type="button" class="button" value="<?php _e('Browse'); ?>" />
                              <span class="help-block">Logo or custom image to show on top of title.</span>
                            </div>
                          </div>
                          <div class="row form-group">
                            <label class="col-md-2 control-label">Title</label>
                            <div class="col-md-8">
                              <input name="Ftitle" value="<?php echo trim($spinio_fdata['Ftitle']); ?>" type="text" placeholder="GET YOUR CHANCE TO 
                                <strong>>WIN</strong> AMAZING PRIZES." class="form-control input-md">
                              </div>
                            </div>
                            <div class="row form-group">
                              <label class="col-md-2 control-label">Short Description</label>
                              <div class="col-md-8">
                                <input name="Fdescription" value="<?php echo trim($spinio_fdata['Fdescription']); ?>" type="text" placeholder="Enter your email below to try your luck." class="form-control input-md">
                                </div>
                              </div>
                              <div class="row form-group">
                                <label class="col-md-2 control-label">Name field placeholder</label>
                                <div class="col-md-8">
                                  <input name="Fnameholder" value="<?php echo trim($spinio_fdata['Fnameholder']); ?>" type="text" placeholder="Enter your name" class="form-control input-md">
                                  </div>
                                </div>
                                <div class="row form-group">
                                  <label class="col-md-2 control-label">Email field placeholder</label>
                                  <div class="col-md-8">
                                    <input name="Femailholder" value="<?php echo trim($spinio_fdata['Femailholder']); ?>" type="text" placeholder="Enter your email" class="form-control input-md">
                                    </div>
                                  </div>
                                  <div class="row form-group">
                                    <label class="col-md-2 control-label">Button text</label>
                                    <div class="col-md-8">
                                      <input name="Fbuttontext" value="<?php echo trim($spinio_fdata['Fbuttontext']); ?>" type="text" placeholder="Try your luck." class="form-control input-md">
                                      </div>
                                    </div>
                                    <div class="row form-group">
                                      <label class="col-md-2 control-label">Close/Exit text</label>
                                      <div class="col-md-8">
                                        <input name="closeText" value="<?php echo trim($spinio_fdata['closeText']); ?>" type="text" placeholder="Try your luck." class="form-control input-md">
                                        </div>
                                      </div>
                                      <div class="row form-group">
                                        <div class="text-center">
                                          <button id="save_spinio_form_right" data-loading-text="
                                            <i class='dashicons dashicons-update fa-spin'></i> Saving Slices" class="button btn-success">
                                            <span class="dashicons dashicons-yes"></span>Save
                                          </button>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                  <a class="btn btn-primary btnPrevious" >Previous</a>
                                  <a class="btn btn-primary btnNext" >Next</a>
                                </div>
                                <div id="settings" class="tab-pane container fade">
                                  <div class="text-center">
                                    <h1>Select theme</h1>
                                  </div>
                                  <?php $spinio_data = get_option('spinio_display'); ?>
                                  <div id="display_alert" class="alert alert-success alert-dismissable fade in hide">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Saved!</strong>
                                    <p>Spinio settings has been saved.</p>
                                  </div>
                                  <form method="POST" id="displayform">
                                    <div class="row form-group">
                                      <label class="col-md-2 control-label">Spinio Style</label>
                                      <div class="col-md-8">
                                        <select required name="style_id" class="form-control input-md">
                                          <option value="">Select</option>
                                          <?php $spinio_style_list = get_option('spinio_style_id');
                                     foreach ($spinio_style_list as $sStyle) {
                                         ?>
                                          <option value="<?php echo trim($sStyle['id']); ?>"<?php selected($sStyle['id'], $spinio_data['style_id']); ?>><?php echo $sStyle['title']; ?></option>
                                          <?php 
                                     } ?>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row form-group">
                                      <label class="col-md-2 control-label">Snow Falling Disable/Enable</label>
                                      <div class="col-md-8">
                                        <label class="switch">
                                          <input id="snow" name="snow" type="checkbox" value="<?php echo trim($spinio_data['snow']); ?>" 
                                            <?php echo ($spinio_data['snow']) ? 'checked' : null; ?>  >
                                            <span class="sler round"></span>
                                          </label>
                                        </div>
                                      </div>
                                      <div class="col-md-12 form-group">
                                        <div class="text-center">
                                          <button id="save_display" data-loading-text="
                                            <i class='dashicons dashicons-update fa-spin'></i> Saving display settings" class="button btn-success">
                                            <span class="dashicons dashicons-yes"></span>Save
                                          </button>
                                        </div>
                                      </div>
                                    </form>
                                    <a class="btn btn-primary btnPrevious" >Previous</a>
                                  </div>
                                </div>
                              </div>
                              <!-- content wrapper ends -->
                            </div>