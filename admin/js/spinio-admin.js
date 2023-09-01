var $ = jQuery;
(function($) {
    'use strict';

    function sortOrder() {
        var sl = 0;
        $('.slice').each(function(i) {
            $("td:first", this).html(i + 1);
            sl++;
        });
        return sl;
    }
    sortOrder();
    // Find and remove selected table rows
    function slice_del() {
        $(".slice-delete").click(function() {
            console.log(this);
            if (sortOrder() > 2) {
                $(this).parents("tr").fadeOut("normal", function() {
                    $(this).remove();
                    sortOrder();
                });
            }
            else {
                alert("Minimum 2 slices required.");
            }
            // sortOrder();
        });
    }
    slice_del();
    //Add new row
    $(".add-slice").click(function() {
        //var markup = '<tr class="slice"><td class="center-text"></td><td><input type="text" value="" name="slice_label[]" maxlength="50" class="form-control"></td><td><select name="slice_type[]"   class="form-control"><option selected="selected" value="coupon">Coupon code</option><option value="product">Free product</option><option value="noprize">No prize</option></select></td><td><input type="text" value="" name="slice_win[]" maxlength="50" class="form-control"></td><td><input type="text" value="" name="slice_value[]" class="form-control"></td><td><input type="text" value="" name="slice_prob[]" class="form-control"></td><td>%</td><td><a  class="button btn-danger slice-delete"><span class="dashicons dashicons-trash"></span></a></td></tr>';
        var markup = $('#slice_tr').clone();
        $("#wheel-slices > tbody:last-child").append(markup).hide().fadeIn();
        $(markup).find('input:text').val('');
        $(markup).find(".slice_value").removeAttr('disabled');
        sortOrder();
        slice_del();
        slice_value_disbale();
        slice_value_i();
    });

    function slice_value_disbale() {
        jQuery('.slice_type').change(
            function() {
                // alert($(this).find(":selected").val());
                var Svalue = $(this).find(":selected").val();

                if (Svalue === 'noprize') {
                    $(this).parents('tr').find(".slice_value").attr('disabled', 'disabled');
                    $(this).parents('tr').find(".slice_value").attr('required', 'true');
                }
                else {
                    $(this).parents('tr').find(".slice_value").removeAttr('disabled');
                    $(this).parents('tr').find(".slice_value").removeAttr('required');

                }
            }
        );
    }

    slice_value_disbale();

    function slice_value_i() {
        jQuery('.slice_value').change(
            function() {
                var Svalue = $(this).find(":selected").val();
                $(this).parents('tr').find(".slice_valuei").val(Svalue);
            }
        );
    }
    slice_value_i();


})(jQuery);

$(document).ready(function() {

    $(".toggle-accordion").on("click", function() {
        var accordionId = $(this).attr("accordion-id"),
            numPanelOpen = $(accordionId + ' .collapse.in').length;

        $(this).toggleClass("active");

        if (numPanelOpen == 0) {
            openAllPanels(accordionId);
        }
        else {
            closeAllPanels(accordionId);
        }
    })

    openAllPanels = function(aId) {
        console.log("setAllPanelOpen");
        $(aId + ' .panel-collapse:not(".in")').collapse('show');
    }
    closeAllPanels = function(aId) {
        console.log("setAllPanelclose");
        $(aId + ' .panel-collapse.in').collapse('hide');
    }

    // Add Color Picker to all inputs that have 'color-field' class
    $('.sliceColor').wpColorPicker();

    $('.img-check').click(function(e) {
        $('.img-check').not(this).removeClass('check')
            .siblings('input').prop('checked', false);
        $(this).addClass('check')
            .siblings('input').prop('checked', true);

        $('#bg-img-url').prop('value', '0');
    });
    $('.btnNext').on('click', function () {
        moveTab("Next");
    });
    $('.btnPrevious').on('click', function () {
        moveTab("Previous");
    });


    function moveTab(nextOrPrev) {
        var currentTab = "";
        $('.nav-tabs li a').each(function () {
            if ($(this).hasClass('active')) {
                currentTab = $(this).parent();
                //currentTab.removeClass('active');
            }
        });

        if (nextOrPrev == "Next") {
            if (currentTab.next().length) {
                currentTab.next('li').find('a').trigger('click');
            }

        } else {
            if (currentTab.prev().length) 
            {
                currentTab.prev('li').find('a').trigger('click')
            }

        }
    }
 
    $('#slicesForm').on('submit',function(event) {
        // var Form = $('#slicesFrom').val();
        event.preventDefault();
        $('#save_slices_btn').button('loading');
        $.ajax ({
            url: ajaxurl,
            type: 'POST',
            data:{
                action: 'slice_wheel_form',
                data:$('#slicesForm').serialize(),
            },
            success:function(response){
                  //alert(response);
                if(response){
                       jQuery('#save_slices_btn').button('reset');
                      var top_alert = jQuery('#slice_alert').position().top;
                      jQuery("html, body").animate({ scrollTop: top_alert }, "slow");
                      jQuery("#slice_alert").removeClass('hide').show();
                      moveTab("Next");
                     window.setTimeout(function () { 
                          jQuery("#slice_alert").hide(); }, 8000);              
                
                }
                console.log(response);
                },
                error: function(errorThrown){
                    alert(errorThrown);
                } 
        } );
        return false;

    });
    $('#displayform').submit(function(event) {
        $('#save_display').button('loading');
        $.ajax ({
            url: ajaxurl,
            type: 'POST',
            data: { 
                action: 'spinio_display_save',
                data:$('#displayform').serialize()
            },
            success:function(response){
               // alert(response);
                if(response){
                    $('#save_display').button('reset');
                    var top_alert = $('#display_alert').position().top;
                    $(window).scrollTop(top_alert);
                    $("#display_alert").removeClass('hide').show();
                    window.setTimeout(function () { 
                        $("#display_alert").hide(); }, 8000); 
                    }
                  $('#save_display').button('reset');
              },
              error: function(errorThrown){
                  alert(errorThrown);
                  jQuery('#save_display').button('reset');
              } 
        } );
        return false;

    });
    $('#save_spinio_form_right').click(function() {
        $(this).button('loading');
        $.ajax ({
            url: ajaxurl,
            type: 'POST',
            data:{
                action: 'spinio_form_right',
                data:$('#spinio_form_right').serialize(),
            },
            success:function(response){
                 $('#save_spinio_form_right').button('reset');
                 moveTab("Next");
              console.log(response);
              },
              error: function(errorThrown){
                  alert(errorThrown);
                  $('#save_spinio_form_right').button('reset');
              } 


        });
        return false;

    });
    //upload logo
    // Uploading files
    var file_frame1=null;
    var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
    $('#logo_url_button').on('click', function( event ){
        event.preventDefault();
                // If the media frame already exists, reopen it.
        if ( file_frame1 ) {
            // Set the post ID to what we want
            //  file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
            // Open frame
            file_frame1.open();
            return;
        } else {
            // Set the wp.media post id so the uploader grabs the ID we want when initialised
            //  wp.media.model.settings.post.id = set_to_post_id;
        }
                // Create the media frame.
        file_frame1 = wp.media.frames.file_frame = wp.media({
            title: 'Select a image to upload',
            button: {
                text: 'Use this image',
            },
            multiple: false // Set to true to allow multiple files to be selected
        });
            // When an image is selected, run a callback.
        file_frame1.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
        attachment = file_frame1.state().get('selection').first().toJSON();
        // Do something with attachment.id and/or attachment.url here
        $( '#logo_url_preview' ).attr( 'src', attachment.url ).addClass('check').removeClass('hidden').siblings('input').prop('checked',true).val( attachment.url );
            $( '#spinio_logo_url' ).val( attachment.url );
            // Restore the main post ID
            wp.media.model.settings.post.id = wp_media_post_id;
        });
            // Finally, open the modal
        file_frame1.open();
    });
            // Restore the main ID when the add media button is pressed
    $( 'a.add_media' ).on( 'click', function() {
        wp.media.model.settings.post.id = wp_media_post_id;
    });

    $("#snow").on('change', function() {
        if ($(this).is(':checked')) {
          $(this).attr('value', 'true');
        } else {
          $(this).attr('value', 'false');
        }
        
    });
    var url_string = window.location.href;
    var url = new URL(url_string);
    var sav = url.searchParams.get("save");
    if(sav){
        $('#setting_alert').removeClass('hide').show();
        window.setTimeout(function () { 
        $("#setting_alert").hide(); }, 5000);         
    }
    $("#enableSpinio").on('change', function() {
        if ($(this).is(':checked')) {
            $(this).attr('value', 'true');
        } else {
            $(this).attr('value', 'false');
        }
    });
    $(".spcheckval").on('change', function() {
        if ($(this).is(':checked')) {
            $(this).attr('value', 'true');
        } else {
            $(this).attr('value', 'false');
        }
    });
    $('.img-check').each(function (i) {
        var s = "<?php echo isset($spinio_data['bgimage']) ? $spinio_data['bgimage'] : null; ?>";
        var a = $(this).attr('src');
        if(a==s){
            $(this).addClass('check').siblings('input').prop('checked',true);
            return false;
        }
    });
    
    // Uploading files
    var file_frame;
    var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
    $('#custom_bg_button').on('click', function( event ){
        event.preventDefault();
        // If the media frame already exists, reopen it.
        if ( file_frame ) {
            // Set the post ID to what we want
            //  file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
            // Open frame
            file_frame.open();
            return;
        } else {
            // Set the wp.media post id so the uploader grabs the ID we want when initialised
        //  wp.media.model.settings.post.id = set_to_post_id;
        }
        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select a image to upload',
            button: {
                text: 'Use this image',
            },
            multiple: false // Set to true to allow multiple files to be selected
        });
        // When an image is selected, run a callback.
        file_frame.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            attachment = file_frame.state().get('selection').first().toJSON();
            // Do something with attachment.id and/or attachment.url here
            $( '#image-preview' ).attr( 'src', attachment.url ).removeClass('hidden').siblings('input').prop('checked',true).val( attachment.url );
            $( '#bg-img-url' ).val('1');
            // Restore the main post ID
            wp.media.model.settings.post.id = wp_media_post_id;
        });
                    // Finally, open the modal
        file_frame.open();
    });
    // Restore the main ID when the add media button is pressed
    $( 'a.add_media' ).on( 'click', function() {
        wp.media.model.settings.post.id = wp_media_post_id;
    });
    // form validation for Save button 
    $('#spinio_save_btn').click(function(e){
        e.preventDefault();   
        if($('#styleTitle').val()==''){
            $('#styleError').find('p').text('Title should not empty');
            $('#styleError').removeClass('hidden');
        }else{
            $(this).button('loading');
            $('#styleForm').submit();
        }
    });
            
    //check box value to true or false
    $("#hasShadows").on('change', function() {
        if ($(this).is(':checked')) {
            $(this).attr('value', 'true');
        } else {
            $(this).attr('value', 'false');
        }
      
    });
            
    //style_del function
    $('.style_del').click( function(){
        var style_id = $(this).find('input').val();
        //console.log(style_id);
        var r = confirm("Are you sure to delete it?");
        if(r){
            $(this).parents("tr").fadeOut("slow", function() { $(this).remove(); });
            $.ajax ( data = {
                action: 'spinio_style_del',
                url: ajaxurl+'?action=spinio_style_del',
                type: 'POST',
                data: 'style_id='+style_id,
                success:function(response){
                   // alert(response);
                  console.log(response);
                  },
                  error: function(errorThrown){
                      alert(errorThrown);
                  } 
            });
        }
    });        
    $("#addcolor").click(function(){
        var markup = '<div class="col-md-6 form-group"><label class="col-md-5 control-label" for="color">Slice Color</label><div class="col-md-7"><input id="color" name="SliceColor[]" type="text" placeholder="color" value="" class="form-control input-md sliceColor"><span class="help-block">delete</span></div></div>';
        $("#sliceColors").append(markup).hide().fadeIn();
        $(markup).find('input:text').val('');
        $( '.sliceColor' ).wpColorPicker();
    });
            
    $('#sliceColors').on('click', '.help-block', function(){
        $(this).parents('.form-group').remove();
    });
    $('#spinio_export').click(function(){
        $(this).button('loading');
        setTimeout(function() {
            $('#spinio_export').button('reset');
        }, 600);
    });
    jQuery('#xs_name , #xs_email , #xs_message').on('change',function(e){
        if(!jQuery(this).val()){
            jQuery(this).addClass("error");
        }else{
            jQuery(this).removeClass("error");
        }
    });
    $('.xs_support_form').on('submit' , function(e){ 
        e.preventDefault();
        jQuery('.xs-send-email-notice').hide();
        jQuery('.xs-mail-spinner').addClass('xs_is_active');
        jQuery('#xs_name').removeClass("error");
        jQuery('#xs_email').removeClass("error");
        jQuery('#xs_message').removeClass("error"); 
        
        $.ajax({ 
            url:ajaxurl,
            type:'post',
            data:{'action':'xs_send_mail','data':$(this).serialize()},
            beforeSend: function(){
                if(!jQuery('#xs_name').val()){
                    jQuery('#xs_name').addClass("error");
                    jQuery('.xs-send-email-notice').removeClass('notice-success');
                    jQuery('.xs-send-email-notice').addClass('notice');
                    jQuery('.xs-send-email-notice').addClass('error');
                    jQuery('.xs-send-email-notice').addClass('is-dismissible');
                    jQuery('.xs-send-email-notice p').html('Please fill all the fields');
                    jQuery('.xs-send-email-notice').show();
                    jQuery('.xs-notice-dismiss').show();
                    window.scrollTo(0,0);
                    jQuery('.xs-mail-spinner').removeClass('xs_is_active');
                    return false;
                }
                 if(!jQuery('#xs_email').val()){
                    jQuery('#xs_email').addClass("error");
                    jQuery('.xs-send-email-notice').removeClass('notice-success');
                    jQuery('.xs-send-email-notice').addClass('notice');
                    jQuery('.xs-send-email-notice').addClass('error');
                    jQuery('.xs-send-email-notice').addClass('is-dismissible');
                    jQuery('.xs-send-email-notice p').html('Please fill all the fields');
                    jQuery('.xs-send-email-notice').show();
                    jQuery('.xs-notice-dismiss').show();
                    window.scrollTo(0,0);
                    jQuery('.xs-mail-spinner').removeClass('xs_is_active');
                    return false;
                }
                 if(!jQuery('#xs_message').val()){
                    jQuery('#xs_message').addClass("error");
                    jQuery('.xs-send-email-notice').removeClass('notice-success');
                    jQuery('.xs-send-email-notice').addClass('notice');
                    jQuery('.xs-send-email-notice').addClass('error');
                    jQuery('.xs-send-email-notice').addClass('is-dismissible');
                    jQuery('.xs-send-email-notice p').html('Please fill all the fields');
                    jQuery('.xs-send-email-notice').show();
                    jQuery('.xs-notice-dismiss').show();
                    window.scrollTo(0,0);
                    jQuery('.xs-mail-spinner').removeClass('xs_is_active');
                    return false;
                }
                jQuery(".xs_support_form :input").prop("disabled", true);
                jQuery("#xs_message").prop("disabled", true);
                jQuery('.xs-send-mail').prop('disabled',true);
            },
            success: function(res){
                jQuery('.xs-send-email-notice').find('.xs-notice-dismiss').show();
                jQuery('.xs-send-mail').prop('disabled',false);
                jQuery(".xs_support_form :input").prop("disabled", false);
                jQuery("#xs_message").prop("disabled", false);
                if(res.status == true){
                    jQuery('.xs-send-email-notice').removeClass('error');
                    jQuery('.xs-send-email-notice').addClass('notice');
                    jQuery('.xs-send-email-notice').addClass('notice-success');
                    jQuery('.xs-send-email-notice').addClass('is-dismissible');
                    jQuery('.xs-send-email-notice p').html('Successfully sent');
                    jQuery('.xs-send-email-notice').show();
                    jQuery('.xs-notice-dismiss').show();
                    jQuery('.xs_support_form')[0].reset();
                }else{
                    jQuery('.xs-send-email-notice').removeClass('notice-success');
                    jQuery('.xs-send-email-notice').addClass('notice');
                    jQuery('.xs-send-email-notice').addClass('error');
                    jQuery('.xs-send-email-notice').addClass('is-dismissible');
                    jQuery('.xs-send-email-notice p').html('Sent Failed');
                    jQuery('.xs-send-email-notice').show();
                    jQuery('.xs-notice-dismiss').show();
                }
                jQuery('.xs-mail-spinner').removeClass('xs_is_active');
            }

        });
    });
    $('.xs-notice-dismiss').on('click',function(e){
        e.preventDefault();
        $(this).parent().hide();
        $(this).hide();
    });
});
