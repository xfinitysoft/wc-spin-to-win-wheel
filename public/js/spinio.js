jQuery(document).ready(function() {
    var spinio_show = false;
    var spinio_spin = false;
    // Get Spinio the modal Content
    var spiniomodalContent = document.getElementById('spinio-modal-content');
    // Get Spinio the modal
    var spiniomodal = document.getElementById('spinio-modal');
    // Get the Spinio button that opens the spinio modal
    var spiniobtn = document.getElementById("spinio-btn");
    var btnwrap = document.getElementById("btn-wrap");
    // Get the Spinio <span> element that closes the spinio modal
    var spiniospan = document.getElementsByClassName("spinio-close")[0];
    // When the user clicks the Spinio button, open the spinio modal

    spiniobtn.onclick = function() {
        spiniomodalContent.classList.remove('hide-me');
        btnwrap.style.display = "none";
        jQuery('.spinio').css('z-index', '999999');
        fadeIn(spiniomodal);
    };
    // When the user clicks on Spinio <span> (x), close the spinio modal
    spiniospan.onclick = function() {
        spiniomodalContent.classList.add('hide-me');
        if (!spinio_spin)
            btnwrap.style.display = "block";
        jQuery('.spinio').css('z-index', '0');
        fadeOut(spiniomodal);
    };

    document.addEventListener("mouseleave", function(e) {
        if (localStorage.getItem('SpinioState') != 'shown') {
            if (e.clientY < 0) {
                spiniomodalContent.classList.remove('hide-me');
                btnwrap.style.display = "none";
                jQuery('.spinio').css('z-index', '999999');
                fadeIn(spiniomodal);
                localStorage.setItem('SpinioState', 'shown')
            }
        }
    }, false);


    // When the user clicks anywhere outside of the Spinio modal, close it
    window.onclick = function(event) {
        if (event.target == spiniomodal) {
            console.log(spinio_spin);
            spiniomodalContent.classList.add('hide-me');
            if (!spinio_spin)
                btnwrap.style.display = "block";
            fadeOut(spiniomodal);
        }
    };

    function fadeOut(el) {
        el.style.opacity = 1;

        (function fade() {
            if ((el.style.opacity -= .1) < 0) {
                el.style.visibility = "hidden";
            }
            else {
                requestAnimationFrame(fade);
            }
        })();
    }

    // fade in

    function fadeIn(el) {
        el.style.opacity = 0;
        el.style.visibility = "visible";

        (function fade() {
            var val = parseFloat(el.style.opacity);
            if (!((val += .1) > 1)) {
                el.style.opacity = val;
                requestAnimationFrame(fade);
            }
        })();
    }


    jQuery('.wheelContainer').click(function() { return false; });
    // alert('starting function');
    jQuery('#spinio_form_btn').click(function(e) {
        jQuery('#spinio_form_btn').attr("disabled", "disabled");
        //alert(jQuery('#spinio_sub_form').serialize());
        e.preventDefault();
        jQuery.ajax(data = {
            action: 'spinio_set_subscriber',
            url: spinio.ajax_url + '?action=spinio_set_subscriber',
            type: 'POST',
            data: jQuery('#spinio_sub_form').serialize(),
            success: function(response) {
                console.log(response);
                obj = JSON.parse(response);
                if (!obj.error) {
                    jQuery('.spinio-error').removeClass('spinio-dang').hide();
                    jQuery('.spinBtn').trigger('click');
                    spinio_spin = true;
                    jQuery('#btn-wrap').hide();
                }
                else {
                    jQuery('#spinio_form_btn').removeAttr("disabled");
                    jQuery('.spinio-error').text(obj.email);
                    jQuery('.spinio-error').addClass('spinio-dang').show();
                }
            },
            error: function(errorThrown) {
                alert(errorThrown);
            }


        });
        return false;

    }); //form right section
    function triggerSpinioPopup() {
        if (!spinio_show) {
            jQuery('#spinio-btn').trigger('click');
            spinio_show = true;
        }
    }
    if (spinioEintent) {
        var dtExit = new DialogTrigger(triggerSpinioPopup, { trigger: 'exitIntent' });
    }
    if (spinioEscroll) {
        var dtScrollDown = new DialogTrigger(triggerSpinioPopup, { trigger: 'scrollDown', percentDown: spScrollval });
    }
    //var dtScrollUp = new DialogTrigger(triggerSpinioPopup, { trigger: 'scrollUp', percentUp: 10 });
    //var dtScrollDown = new DialogTrigger(triggerSpinioPopup, { trigger: 'scrollDown', percentDown: 50 });
    if (spinioEtimer) {
        var dtTimer = new DialogTrigger(triggerSpinioPopup, { trigger: 'timeout', timeout: spTimeMil });
    }


}); // main function ready state
