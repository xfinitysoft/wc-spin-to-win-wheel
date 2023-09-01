<?php

$spinio_style_msg = isset($_GET['spiniomsg']) ? sanitize_text_field($_GET['spiniomsg']) : 'null';
$style_action = isset($_GET['style']) ? sanitize_text_field($_GET['style']) : 'list';
$spinio_style = (isset($_GET['style']) && $_GET['style'] == 'new') ? 'new' : null;

if ($style_action != 'list' && $style_action != 'new') {
    $style_id = $style_action;
  //var_dump($style_id);
}

?>
<div id="spinio-wrapper">
<div class="">
    <div class="container-fluid">
      
      
      <?php 
      if ($style_action == 'list') {
          $spinio_style_list = get_option('spinio_style_id'); ?>
        <div class="row text-center"><h2>List of Spinio Styles</h2> </div>
          <div class="table-responsive" style="overflow: hidden;">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>
                            Spinio Style name
                        </th>
                        <th>
                           Edit
                        </th>
                        <th>
                            Delete
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php  foreach ($spinio_style_list as $sStyle) {
              ?>
                    <tr>
                        <td>
                            <?php echo $sStyle['title'] ?>
                        </td>
                        <td>
                           <a href="<?php echo admin_url('admin.php?page=spinio-style&style='.$sStyle['id']); ?>" class="btn btn-sm btn-info"><span class="dashicons dashicons-edit"></span> </a>
                        </td>
                        <td>
                           <span class="btn btn-sm btn-danger style_del"><span class="dashicons dashicons-trash" ></span><input type="hidden" value="<?php echo trim($sStyle['id']); ?>"></span>
                        </td>
                    </tr>
                    <?php 
          } ?>
                </tbody>
            </table>
            <div class="clearfix"></div>
            <div class=" ">
              <span class="left"><a href="<?php echo esc_url(admin_url('admin.php?page=spinio-style&style=new')); ?>" class="btn btn-primary">Create new</a></span>
            </div>
        </div>
        
        <?php

      } else {
          if (isset($style_id) && !empty($style_id)) {
              $spinio_data = json_decode(get_option('spinio_style_'.$style_id), true);
          } else {
              $spinio_data = json_decode(get_option('spinio_style_'.'104'), true);
          } ?>
      
    <div class="row text-center"><h2>Put Magic into Spinio Wheel with diffrent colors</h2> </div>
<div class="clearfix"></div>
<div id="styleError" class="alert alert-danger alert-dismissable fade in hidden">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error!</strong> <p>This alert box could indicate a dangerous or potentially negative action.</p>
  </div>
  <?php if (!empty($spinio_style_msg) && $spinio_style_msg == '1') {
              ?>
  <div  class="alert alert-success alert-dismissable fade in ">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong><?php _e($spinio_data['styleTitle']); ?></strong> <p><?php _e(' Style has been saved') ?></p>
  </div>
  <?php 
          } ?>
<form id="styleForm" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="form-horizontal">
  <input type="hidden" name="action" value="spinio_form_save_style">
  <input type="hidden" name="spinio_style" value="<?php echo trim($spinio_style); ?>">
  <input type="hidden" name="spinio_style_id" value="<?php echo (isset($style_id)) ? $style_id : null; ?>">
  
<div class="container-fluid header-bar">
  <div class="navbar-form navbar-left">
    <div class="form-group">
         
        <input id="styleTitle" name="styleTitle" value="<?php echo trim($spinio_data['styleTitle']); ?>" type="text" class="form-control" placeholder="Title of Spinio style">
      </div>
  </div>
    <div class="navbar-form navbar-right">
      <button id="spinio_save_btn" data-loading-text="<i class='dashicons dashicons-update fa-spin'></i> Saving Style" type="submit" class="btn btn-primary">SAVE</button>
    </div>
    
</div>
<div class="clearfix"></div>
        <div class="row">
            <div class="col-sm-12">
                      <!--<div class="accordion-option">
                      </div>-->
                      <div class="clearfix"></div>
                       <div class="panel panel-primary">
      <div class="panel-heading">
      <h4 class="panel-title">Configurations</h4>
      </div>
      <div class="panel-body">
          
                      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                          <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#spinioWheel" aria-expanded="true" aria-controls="spinioWheel">
                             Wheel
                            </a>
                          </h4>
                          </div>
                          <div id="spinioWheel" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                              
                              <div class="row">
                                  
<fieldset>
  <legend>Slice Colors:</legend>
  <div class="panel panel-default">
						<div class="panel-body">
						  <div id="sliceColors">
						  <?php
                          foreach ($spinio_data['SliceColor'] as $SliceColor) {
                              ?>
						  <div class="col-md-6 form-group">
  <label class="col-md-5 control-label" for="color">Slice Color</label>  
  <div class="col-md-7">
  <input id="color" name="SliceColor[]" type="text" placeholder="color" value="<?php echo trim($SliceColor); ?>" class="form-control input-md sliceColor">
  <span class="help-block">delete</span>  
  </div>
</div>
<?php 
                          } ?>

</div>
<div class="clearfix"></div>
<div class="text-center" style="padding:15px"><div class="button" id="addcolor">Add Slice Color</div></div>
<div class="clearfix"></div>

<!-- Slice strock color -->
<div class="col-md-6 form-group">
                  <label class="col-md-5 control-label" for="color">Slice strock color</label>  
                  <div class="col-md-7">
                  <input id="color" name="segmentStrokeColor" value="<?php echo trim($spinio_data['segmentStrokeColor']); ?>" type="text" placeholder="color" class="form-control input-md sliceColor">
                  
                  </div>
                </div>
 
                 <!-- Slice strock size -->
					<div class="col-md-6 form-group">
                  <label class="col-md-5 control-label" for="color">Slice strock size</label>  
                  <div class="col-md-7">
                    <input	type="text"
                          	name="segmentStrokeWidth"
                          	data-provide="slider"
                          	data-slider-min="0"
                          	data-slider-max="30"
                          	data-slider-step="0.5"
                          	data-slider-value="<?php echo trim($spinio_data['segmentStrokeWidth']); ?>"
                          	data-slider-tooltip="show"
                          >
                  
                  </div>
                </div>
</div>
					</div>
</fieldset>
<div class="clearfix"></div>
<fieldset>    	
					<legend>Wheel configurations</legend>
					<!-- wheel stock color -->
					<div class="panel panel-default">
						<div class="panel-body">
      		<div class="col-md-6 form-group">
                  <label class="col-md-5 control-label" for="color">Wheel Strock color</label>  
                  <div class="col-md-7">
                  <input id="color" value="<?php echo trim($spinio_data['wheelStrokeColor']); ?>" name="wheelStrokeColor" type="text" placeholder="color" class="form-control input-md sliceColor">
                  
                  </div>
                </div>
 
                 <!-- wheel stock width -->
					<div class="col-md-6 form-group">
                  <label class="col-md-5 control-label" for="color">Wheel Strock size</label>  
                  <div class="col-md-7">
                    <input	type="text"
                          	name="wheelStrokeWidth"
                          	data-provide="slider"
                          	data-slider-min="0"
                          	data-slider-max="20"
                          	data-slider-step="1"
                          	data-slider-value="<?php echo trim($spinio_data['wheelStrokeWidth']); ?>"
                          	data-slider-tooltip="show"
                          >
                  
                  </div>
                </div>
                <div class="clearfix"></div>
                 <!-- wheel text color -->
					<div class="col-md-6 form-group">
                  <label class="col-md-5 control-label" for="color">Wheel font color</label>  
                  <div class="col-md-7">
                  <input id="color" value="<?php echo trim($spinio_data['wheelTextColor']); ?>" name="wheelTextColor" type="text" placeholder="color" class="form-control input-md sliceColor">
                  
                  </div>
                </div>
 
                 <!-- wheel stock width -->
					<div class="col-md-6 form-group">
                  <label class="col-md-5 control-label" for="color">Wheel font size</label>  
                  <div class="col-md-7">
                    <input	type="text"
                          	name="wheelTextSize"
                          	data-provide="slider"
                          	data-slider-min="1"
                          	data-slider-max="4"
                          	data-slider-step="0.1"
                          	data-slider-value="<?php echo trim($spinio_data['wheelTextSize']) ?>"
                          	data-slider-tooltip="show"
                          >
                  
                  </div>
                </div>
					<div class="clearfix"></div>
					<!-- Center circle strock color -->
					<div class="col-md-6 form-group">
                  <label class="col-md-5 control-label" for="color">Center circle strock color</label>  
                  <div class="col-md-7">
                  <input id="color" value="<?php echo trim($spinio_data['centerCircleStrokeColor']); ?>" name="centerCircleStrokeColor" type="text" placeholder="color" class="form-control input-md sliceColor">
                  
                  </div>
                </div>
 
                 <!-- Center circle strock size -->
					<div class="col-md-6 form-group">
                  <label class="col-md-5 control-label" for="color">Center Circle strock size</label>  
                  <div class="col-md-7">
                    <input	type="text"
                          	name="centerCircleStrokeWidth"
                          	data-provide="slider"
                          	data-slider-min="1"
                          	data-slider-max="20"
                          	data-slider-step="1"
                          	data-slider-value="<?php echo trim($spinio_data['centerCircleStrokeWidth']); ?>"
                          	data-slider-tooltip="show"
                          >
                  
                  </div>
                </div>
					<div class="clearfix"></div>
					
					<!-- Center circle strock color -->
					<div class="col-md-6 form-group">
                  <label class="col-md-5 control-label" for="color">Center circle color</label>  
                  <div class="col-md-7">
                  <input id="color" value="<?php echo trim($spinio_data['centerCircleFillColor']); ?>" name="centerCircleFillColor" type="text" placeholder="color" class="form-control input-md sliceColor">
                  
                  </div>
                </div>
 
                 <!-- Center circle strock size -->
					<div class="col-md-6 form-group">
                  <label class="col-md-5 control-label" for="color">Center Circle size</label>  
                  <div class="col-md-7">
                    <input	type="text"
                          	name="centerCircleSize"
                          	data-provide="slider"
                          	data-slider-min="0"
                          	data-slider-max="360"
                          	data-slider-step="1"
                          	data-slider-value="<?php echo trim($spinio_data['centerCircleSize']); ?>"
                          	data-slider-tooltip="show"
                          >
                  
                  </div>
                </div>
					<div class="clearfix"></div>
					<!-- showdown button --->
					<div class="col-md-6 form-group">
                  <label class="col-md-5 control-label" for="color">Shadow on/off</label>  
                  <div class="col-md-7">
                  <label class="switch">
                  <input id="hasShadows" name="hasShadows" type="checkbox" value="<?php echo trim($spinio_data['hasShadows']); ?>" <?php echo ($spinio_data['hasShadows']) ? 'checked' : null; ?>  >
                  <span class="sler round"></span>
                </label>  
                  </div>
                </div>
						</div>
					</div>
				</fieldset>	
                              </div>
                              
                              
                            </div>
                          </div>
                        </div>
                        <div class="panel panel-default">
                          <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#spinioBackground" aria-expanded="true" aria-controls="spinioBackground">
                              Background
                            </a>
                          </h4>
                          </div>
                          <div id="spinioBackground" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">
                                <div class="row">
                                    
                                    <span class="co-md-3">
                                      <label class="btn"><img src="<?php echo spinio_path; ?>/img/bg-summer02-invert.png" alt="Spinio Background image" class="img-thumbnail img-check"><input type="radio" name="bgimage" value="<?php echo spinio_path; ?>/img/bg-summer02-invert.png" class="hidden" autocomplete="off"></label>
                                    </span>
                                    <span class="co-md-3">
                                      <label class="btn"><img src="<?php echo spinio_path; ?>/img/bg-summer02.png" alt="Spinio Background image" class="img-thumbnail img-check"><input type="radio" name="bgimage" value="<?php echo spinio_path; ?>/img/bg-summer02.png" class="hidden" autocomplete="off"></label>
                                    </span>
                                    
                                    <span class="co-md-3">
                                      <label class="btn"><img src="<?php echo spinio_path; ?>/img/bg-black_friday.png" alt="Spinio Background image" class="img-thumbnail img-check"><input type="radio" name="bgimage" value="<?php echo spinio_path; ?>/img/bg-black_friday.png" class="hidden" autocomplete="off"></label>
                                    </span>
                                    <span class="co-md-3">
                                      <label class="btn"><img src="<?php echo spinio_path; ?>/img/bg-black_friday_invert.png" alt="Spinio Background image" class="img-thumbnail img-check"><input type="radio" name="bgimage" value="<?php echo spinio_path; ?>/img/bg-black_friday_invert.png" class="hidden" autocomplete="off"></label>
                                    </span>
                                    <span class="co-md-3">
                                      <label class="btn"><img src="<?php echo spinio_path; ?>/img/bg-black-friday-white.png" alt="Spinio Background image" class="img-thumbnail img-check"><input type="radio" name="bgimage"  value="<?php echo spinio_path; ?>/img/bg-black-friday-white.png" class="hidden" autocomplete="off"></label>
                                    </span>
                                    <span class="co-md-3">
                                      <label class="btn"><img src="<?php echo spinio_path; ?>/img/bg-circles01-invert.png" alt="Spinio Background image" class="img-thumbnail img-check"><input type="radio" name="bgimage" value="<?php echo spinio_path; ?>/img/bg-circles01-invert.png" class="hidden" autocomplete="off"></label>
                                    </span>
                                    
                                    <span class="co-md-3">
                                      <label class="btn"><img src="<?php echo spinio_path; ?>/img/bg-circles02.png" alt="Spinio Background image" class="img-thumbnail img-check"><input type="radio" name="bgimage"  value="<?php echo spinio_path; ?>/img/bg-circles02.png" class="hidden" autocomplete="off"></label>
                                    </span>
                                    <span class="co-md-3">
                                      <label class="btn"><img src="<?php echo spinio_path; ?>/img/bg-pat-green.png" alt="Spinio Background image" class="img-thumbnail img-check"><input type="radio" name="bgimage" value="<?php echo spinio_path; ?>/img/bg-heart01-invert.png" class="hidden" autocomplete="off"></label>
                                    </span>
                                    <span class="co-md-3">
                                      <label class="btn"><img src="<?php echo spinio_path; ?>/img/bg-heart02-invert.png" alt="Spinio Background image" class="img-thumbnail img-check"><input type="radio" name="bgimage" value="<?php echo spinio_path; ?>/img/bg-heart02-invert.png" class="hidden" autocomplete="off"></label>
                                    </span>
                                    <span class="co-md-3">
                                      <label class="btn"><img src="<?php echo spinio_path; ?>/img/bg-heart02.png" alt="Spinio Background image" class="img-thumbnail img-check"><input type="radio" name="bgimage" value="<?php echo spinio_path; ?>/img/bg-heart02.png" class="hidden" autocomplete="off"></label>
                                    </span>
                                    <span class="co-md-3">
                                      <label class="btn"><img src="<?php echo spinio_path; ?>/img/Christmas-tree.png" alt="Spinio Background image" class="img-thumbnail img-check"><input type="radio" name="bgimage" value="<?php echo spinio_path; ?>/img/Christmas-tree.png" class="hidden" autocomplete="off"></label>
                                    </span>
                                    <span class="co-md-3">
                                      <label class="btn"><img id="image-preview" src="<?php echo (isset($spinio_data['custom_bg']) == '1') ? $spinio_data['bgimage'] : null; ?>" class="img-thumbnail img-check <?php echo ($spinio_data['custom_bg'] == '1') ? null : 'hidden'; ?> "><input type="radio" name="bgimage" value="<?php echo  (trim($spinio_data['custom_bg']) == '1') ? trim($spinio_data['custom_bg']) : null; ?>" class="hidden" autocomplete="off"></label>
                                    </span>
                                    <div class="col-md-10 form-group">
                                  <label class="col-md-3 control-label" for="color">custom Background url</label>  
                                  <div class="col-md-8">
                                  <input name="custom_bg" value="<?php echo trim($spinio_data['custom_bg']); ?>" id="bg-img-url" type="hidden" class="form-control input-md">
                                  <input id="custom_bg_button"  type="button" class="button" value="<?php _e('Browse'); ?>" />
                                  </div>
                                </div>
                                    
                                <!-- background color-->
                                <div class="col-md-6 form-group">
                                  <label class="col-md-5 control-label" for="color">Background color</label>  
                                  <div class="col-md-7">
                                  <input id="color" value="<?php echo trim($spinio_data['bgColor']); ?>" name="bgColor" type="text" placeholder="color" class="form-control input-md sliceColor">
                                  
                                  </div>
                                </div>
                                
                                <!-- background opacity  -->
                  					<div class="col-md-6 form-group">
                                    <label class="col-md-5 control-label" for="color">opacity</label>  
                                    <div class="col-md-7">
                                      <input	type="text"
                                            	name="bgOpacity"
                                            	data-provide="slider"
                                            	data-slider-min="0"
                                            	data-slider-max="1"
                                            	data-slider-step=".1"
                                            	data-slider-value="<?php echo trim($spinio_data['bgOpacity']); ?>"
                                            	data-slider-tooltip="show"
                                            >
                                    
                                    </div>
                                  </div>
                                  
                                 </div>
                                 </div>
                          </div>
                        </div>
                        <div class="panel panel-default">
                          <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#spinioRightForm" aria-expanded="true" aria-controls="spinioRightForm">
                              Right/Form Section
                            </a>
                          </h4>
                          </div>
                          <div id="spinioRightForm" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">
                              
                              
                                <div class="clearfix"></div>
                                 
                                 <div class="col-md-6 form-group">
                                <label class="col-md-5 control-label" for="color">Title color</label>  
                                <div class="col-md-7">
                                <input id="color" value="<?php echo trim($spinio_data['Ftitle']); ?>" name="Ftitle" type="text" placeholder="color" class="form-control input-md sliceColor">
                                
                                </div>
                              </div>
                                 
                                 <div class="col-md-6 form-group">
                                  <label class="col-md-5 control-label" for="color">Title highlight color</label>  
                                  <div class="col-md-7">
                                  <input id="color" value="<?php echo trim($spinio_data['FtitleHigh']); ?>" name="FtitleHigh" type="text" placeholder="color" class="form-control input-md sliceColor">
                                  
                                  </div>
                                </div>
                            
                            <div class="col-md-6 form-group">
                              <label class="col-md-5 control-label" for="color">Description color</label>  
                              <div class="col-md-7">
                              <input id="color" value="<?php echo trim($spinio_data['Fdescription']); ?>" name="Fdescription" type="text" placeholder="color" class="form-control input-md sliceColor">
                              
                              </div>
                            </div>
                            
                             <div class="col-md-6 form-group">
                              <label class="col-md-5 control-label" for="color">Button background color</label>  
                              <div class="col-md-7">
                              <input id="color" value="<?php echo trim($spinio_data['Fbutton']); ?>" name="Fbutton" type="text" placeholder="color" class="form-control input-md sliceColor">
                              
                              </div>
                            </div>
                                 
                            <div class="col-md-6 form-group">
                              <label class="col-md-5 control-label" for="color">Button text color</label>  
                              <div class="col-md-7">
                              <input id="color" value="<?php echo trim($spinio_data['FbuttonText']); ?>" name="FbuttonText" type="text" placeholder="color" class="form-control input-md sliceColor">
                              
                              </div>
                            </div>
                             
                            <div class="col-md-6 form-group">
                              <label class="col-md-5 control-label" for="color">Close/Exit text color</label>  
                              <div class="col-md-7">
                              <input id="color" value="<?php echo trim($spinio_data['closeTextclr']); ?>" name="closeTextclr" type="text" placeholder="color" class="form-control input-md sliceColor">
                               
                              </div>
                            </div>
                            
                            </div>
                          </div>
                        </div>
                      </div>
</div> 
</div>
    </div>
    
            </form>
            <div class="col-sm-12 hide">
               <div class="panel panel-primary">
      <div class="panel-heading">
      <h4 class="panel-title">Preview</h4>
      </div>
      <div class="panel-body">
      
  

      
      </div>
    </div
            </div>
        </div>
        
    
    </div>
    </form>
    <?php

      }
      ?>
</div>
</div>
</div>



