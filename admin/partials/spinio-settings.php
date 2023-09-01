<?php
   $page_ids = get_all_page_ids();
   $spinio_data = get_option('spinio_settings');

   ?>
<div id="spinio-wrapper">
  <div class="container-fluid">
    <div class="text-center">
      <h1>Spinio Settings</h1>
    </div>
    <?php if(isset($_GET['save'])){ ?>
    <div id="setting_alert" class="alert alert-success alert-dismissable out hide">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Saved!</strong>
      <p>settings has been saved.</p>
    </div>
    <?php } ?>
    <div class="form-horizontal" style="margin-bottom: 35px;">
      <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="spinio_save_settings">
          <div class="row form-group">
            <label class="col-md-2 control-label">SPINIO Disable/Enable</label>
            <div class="col-md-8">
              <label class="switch">
                <input id="enableSpinio" name="enableSpinio" type="checkbox" value="<?php echo isset($spinio_data['enableSpinio']) ? trim($spinio_data['enableSpinio']):''; ?>" <?php echo (isset($spinio_data['enableSpinio']) && !empty($spinio_data['enableSpinio'])) ? 'checked' : null; ?>  >
                  <span class="sler round"></span>
                </label>
              </div>
            </div>
            <div class="row form-group">
              <label class="col-md-2 control-label">Name Field </label>
              <div class="col-md-8">
                <label class="switch">
                  <input class="spcheckval" id="spNameField" name="spNameField" type="checkbox" value="<?php echo isset($spinio_data['spNameField']) ? trim($spinio_data['spNameField']):''; ?>"<?php echo (isset($spinio_data['spNameField'])&& !empty($spinio_data['spNameField'])) ? 'checked' : null; ?>  >
                    <span class="sler round"></span>
                  </label>
                </div>
              </div>
              <div class="row form-group">
                <label class="col-md-2 control-label">Exit intent</label>
                <div class="col-md-8">
                  <label class="switch">
                    <input class="spcheckval" id="spExitIntent" name="spExitIntent" type="checkbox" value="<?php echo isset($spinio_data['spExitIntent'])? trim($spinio_data['spExitIntent']):''; ?>" <?php echo (isset($spinio_data['spExitIntent'])&& !empty($spinio_data['spExitIntent'])) ? 'checked' : null; ?>  >
                      <span class="sler round"></span>
                    </label>
                  </div>
                </div>
                <div class="row form-group">
                  <label class="col-md-2 control-label">Time trigger</label>
                  <div class="col-md-8">
                    <label class="switch">
                      <input class="spcheckval" id="spTimeTri" name="spTimeTri" type="checkbox" value="<?php echo isset($spinio_data['spTimeTri'])?trim($spinio_data['spTimeTri']):''; ?>" <?php echo (isset($spinio_data['spTimeTri'])&& !empty($spinio_data['spTimeTri'])) ? 'checked' : null; ?>  >
                        <span class="sler round"></span>
                      </label>
                    </div>
                  </div>
                  <div class="row form-group">
                    <label class="col-md-2 control-label">Time in miliseconds</label>
                    <div class="col-md-2">
                      <input name="spTimeMil" value="<?php echo isset($spinio_data['spTimeMil']) ? trim($spinio_data['spTimeMil']) : null; ?>" type="text" placeholder="e.g: 800" class="form-control input-md">
                      </div>
                    </div>
                    <div class="row form-group">
                      <label class="col-md-2 control-label">Scroll Down</label>
                      <div class="col-md-8">
                        <label class="switch">
                          <input class="spcheckval" id="spScrollDown" name="spScrollDown" type="checkbox" value="<?php echo isset($spinio_data['spScrollDown']) ? trim($spinio_data['spScrollDown']) : null; ?>" <?php echo (isset($spinio_data['spScrollDown'])&& !empty($spinio_data['spScrollDown'])) ? 'checked' : null; ?>  >
                            <span class="sler round"></span>
                          </label>
                        </div>
                      </div>
                      <div class="row form-group">
                        <label class="col-md-2 control-label">Scroll threshold</label>
                        <div class="col-md-2">
                          <input name="spScrollval" value="<?php echo isset($spinio_data['spScrollval']) ? trim($spinio_data['spScrollval']) : null; ?>" type="text" placeholder="50%" class="form-control input-md">
                          </div>
                        </div>
                        <div class="text-center">
                          <button id="save_settings" data-loading-text="
                            
                            <i class='dashicons dashicons-update fa-spin'></i> Saving display settings" class="button btn-success">
                            <span class="dashicons dashicons-yes"></span>Save
                          
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
