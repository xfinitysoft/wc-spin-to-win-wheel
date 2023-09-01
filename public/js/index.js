//cookies functions
function createCookie(name, value, days) {
  var expires = "";
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    expires = "; expires=" + date.toUTCString();
  }
  document.cookie = name + "=" + value + expires + "; path=/";
}
/**
 * get cookies
 * 
 */
function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') c = c.substring(1, c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
  }
  return null;
}
/**
 * remove cookies
 *
 */
function eraseCookie(name) {
  createCookie(name, "", -1);
}


//load your JSON (you could jQuery if you prefer)
function loadJSON(callback) {
  var jsonurl = spinio.ajax_url + '?action=get_wheel_json';
  //var adminurl='https://spin-globalsite.c9users.io/wp-admin/admin-ajax.php';
  var xobj = new XMLHttpRequest();
  xobj.overrideMimeType("application/json");

  xobj.open('GET', jsonurl, true);
  xobj.onreadystatechange = function() {
    if (xobj.readyState == 4 && xobj.status == "200") {
      //Call the anonymous function (callback) passing in the response
      //console.log(xobj.responseText);
      callback(xobj.responseText);
    }
  };
  xobj.send(null);
}

//function to capture the spin results
function myResult(e) {
  //e is the result object
  console.log('Spin Count: ' + e.spinCount + ' - ' + 'Win: ' + e.win + ' - ' + 'Message: ' + e.msg);

  // if you have defined a userData object...
  if (e.win) {
    if (e.userData) {
      jQuery('.spinio-intro').hide();
      jQuery('#spinio-result-msg').text(e.msg);
      jQuery('#spinio-result-desc').text('copy this coupon code and use with your cart.');
      jQuery('#spinio-coupon-code').val(e.userData.score);
      jQuery('.spinio-result').show();
      jQuery('#spinio_copy').click(function(e) {
        e.preventDefault();
        var copyText = document.getElementById("spinio-coupon-code");
        copyText.select();
        document.execCommand("Copy");

      });
      console.log(e);
      console.log('User defined score: ' + e.userData.score);
    } // e.userData end 
  }
  else {
    jQuery('.spinio-intro').hide();
    jQuery('#spinio-result-msg').text(e.msg);
    jQuery('#spinio-result-desc').text('');
    jQuery('#spinio-coupon-code').hide();
    jQuery('#spinio_copy').hide();
    jQuery('.spinio-result').show();

  }

  createCookie('spinio_show', 'show', '360');

}

//your own function to capture any errors
function myError(e) {
  //e is error object
  console.log('Spin Count: ' + e.spinCount + ' - ' + 'Message: ' + e.msg);

}

function myGameEnd(e) {
  //e is gameResultsArray
  console.log(e);
  TweenMax.delayedCall(5, function() {
    /*location.reload();*/
  })


}

function spinio_init() {
  loadJSON(function(response) {
    // Parse JSON string to an object
    var jsonData = JSON.parse(response);
    //if you want to spin it using your own button, then create a reference and pass it in as spinTrigger
    var mySpinBtn = document.querySelector('.spinBtn');
    //create a new instance of Spin2Win Wheel and pass in the vars object
    var myWheel = new Spin2WinWheel();

    //WITH your own button
    myWheel.init({ data: jsonData, onResult: myResult, onGameEnd: myGameEnd, onError: myError, spinTrigger: mySpinBtn });

    //WITHOUT your own button
    //myWheel.init({data:jsonData, onResult:myResult, onGameEnd:myGameEnd, onError:myError);



  });
}



//And finally call it
spinio_init();
