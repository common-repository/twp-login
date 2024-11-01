<?php if(!defined('ABSPATH'))exit;
global $wpdb;
$success = [];
$error = [];
$msgn = 0;
if(isset($_POST['sbmitredi'])){
  if(isset($_POST['sbmredi'])){$redir = 1;} else { $redir = 0;}
  $pth = sanitize_text_field($_POST['sbmpage']);
  $wpdb->query($wpdb->prepare("update ".$wpdb->prefix."twpLogin set h = %d, hpath = %s where id = 1",$redir, $pth));
  if($redir){
    array_push($success,[__("Redirect activated","twp-login"),1]);
    array_push($success,[__("Are you sure that you have another login page or form!","twp-login"),1]);
    array_push($success,[__("wp-admin and wp-login arent more available!","twp-login"),1]);
  } else {
    array_push($success,[__("Redirect deactivated","twp-login"),1]);
  }
}
if(isset($_POST['twpasubmit'])){
  $log = sanitize_text_field($_POST['logo']);
  $logo = explode(home_url(),$log);
  $bg = sanitize_text_field($_POST['bg']);
  $bgtextcolor = sanitize_text_field($_POST['bgtextcolor']);
  $formbg = sanitize_text_field($_POST['formbg']);
  $formtext = sanitize_text_field($_POST['formtext']);
  $btncolor = sanitize_text_field($_POST['btncolor']);
  $btntxtcolor = sanitize_text_field($_POST['btntxtcolor']);
  $shadow = isset($_POST['btnshadow']) ? 1 : 0;
  global $wpdb;
  $wpdb->query($wpdb->prepare("update ".$wpdb->prefix."twpLogin set logo = %s, bg = %s, bgtextcolor = %s, formbg = %s, formtext = %s, btncolor = %s, btntxtcolor = %s, shadow = %d where id = 1",$logo[1],$bg,$bgtextcolor,$formbg,$formtext,$btncolor,$btntxtcolor, $shadow));
  array_push($success,[__("Settings saved","twp-login"),1]);
}
if(isset($_POST['dltdata'])){
  if(isset($_POST['datarmv'])){$wpdb->query($wpdb->prepare('update '.$wpdb->prefix.'twpLogin set d = %f',1));array_push($success,[__("At plugin deletion all twp login data will be removed","twp-login"),1]);}
  else{$wpdb->query($wpdb->prepare('update '.$wpdb->prefix.'twpLogin set d = %f',0));array_push($success,[__("At plugin deletion all twp login data will be keeped","twp-login"),1]);}
}
$result = $wpdb->get_results("select * from ".$wpdb->prefix."twpLogin where id = 1");
$logo = $result[0]->logo ? home_url().$result[0]->logo : ""; 
?>
<div> <?php
  foreach($success as $a){ ?>
    <div class="<?php if($a[1]){echo esc_attr('twpmessage');} ?> notice notice-success is-dismissible">
      <p><strong><?php echo esc_attr($a[0]) ?></strong></p><button type="button" class="notice-dismiss" onclick="twpmsgnone(<?php echo esc_attr($msgn) ?>)"></button>
    </div> <?php
    $msgn += 1;
  }
  foreach($error as $a){ ?>
    <div class="<?php if($a[1]){echo esc_attr('twpmessage');}?> notice notice-error is-dismissible">
      <p><strong><?php echo esc_attr($a[0]) ?></strong></p><button type="button" class="notice-dismiss" onclick="twpmsgnone(<?php echo esc_attr($msgn) ?>)"></button>
    </div> <?php
    $msgn += 1;
  } ?>
</div>
<div id="twpemailadminpage"> 
  <div id="twpleft">
    <div class="title">
      <h1><?php echo __("Admin login page","twp-login") ?></h1> 
    </div>
    <form class="twpboxsetup" method="post" style="padding-bottom:20px;">
      <input type="checkbox" id="twpredit" name="sbmredi" <?php if($result[0]->h){ echo 'checked';} ?> onclick="twpl_redirect()" style="margin-top:2px;">
      <label><?php echo __("Hide/Redirect wp-admin and wp-login","twp-login") ?></label>
      <input type="submit" name="sbmitredi" class="twpbtnsave button-secondary" value="Save">
      <div id="twpredirect" <?php if(!$result[0]->h){echo 'style="display:none"';} ?>>
        <label style="margin-top:27px;"><?php echo home_url() ?>/</label>
        <input type="text" name="sbmpage" value="<?php echo esc_attr($result[0]->hpath); ?>">
      </div>
    </form>
    <form class="twpboxsetup" id="twplogincss" method="post" <?php if($result[0]->h){echo 'style="display:none"';} ?>>
      <h2><?php echo __("login page css","twp-login") ?></h2>
      <div class="twpmailsetup"> <?php
        wp_enqueue_script('jquery');
        wp_enqueue_media();  ?>
        <label class="twpallabel"><?php echo __("Logo","twp-login") ?></label>
        <div>
          <input type="hidden" name="logo" id="twpimage_url" value="<?php echo esc_attr($logo) ?>" maxlength="160">
          <input type="button" name="upload-btn" id="twpupload_btn" class="button-secondary" value="<?php echo __("Image","twp-login") ?>" style="margin-bottom:5px;">
        </div>
        <script type="text/javascript">
          jQuery(document).ready(function($){
              $('#twpupload_btn').click(function(e) {
                  e.preventDefault();
                  var image = wp.media({
                      title: 'twp image upload',
                      multiple: false
                  }).open()
                  .on('select', function(e){
                      var uploaded_image = image.state().get('selection').first();
                      var image_url = uploaded_image.toJSON().url;
                      $('#twpimage_url').val(image_url);
                      document.getElementById('twpLoginFormLogo').src = image_url;
                  });
              });
          });
        </script>
      </div>
      <div class="twpmailsetup">
        <label class="twpalabel"><?php echo __("Background","twp-login") ?></label>
        <input class="my-color-field" type="text" id="twpformbg" name="bg" onchange="twp_background_change()" value="<?php echo esc_attr($result[0]->bg) ?>" maxlength="10"/>
      </div>
      <div class="twpmailsetup">
        <label class="twpalabel"><?php echo __("Background text color","twp-login") ?></label>
        <input class="my-color-field" type="text" id="twpformbgtextcolor" name="bgtextcolor" value="<?php echo esc_attr($result[0]->bgtextcolor) ?>" maxlength="10"/>
      </div>
      <div class="twpmailsetup">
        <label class="twpalabel"><?php echo __("Form background","twp-login") ?></label>
        <input class="my-color-field" type="text" id="twpformformbg" name="formbg" value="<?php echo esc_attr($result[0]->formbg) ?>" maxlength="10"/>
      </div>
      <div class="twpmailsetup">
        <label class="twpalabel"><?php echo __("Form text","twp-login") ?></label>
        <input class="my-color-field" type="text" id="twpformformtext" name="formtext" value="<?php echo esc_attr($result[0]->formtext) ?>" maxlength="10"/>
      </div>
      <div class="twpmailsetup">
        <label class="twpalabel"><?php echo __("Button color","twp-login") ?></label>
        <input class="my-color-field" type="text" id="twpformbtncolor" name="btncolor" value="<?php echo esc_attr($result[0]->btncolor) ?>" maxlength="10"/>
      </div>
      <div class="twpmailsetup">
        <label class="twpalabel"><?php echo __("Button text color","twp-login") ?></label>
        <input class="my-color-field" type="text" id="twpformbtntxtcolor" name="btntxtcolor" value="<?php echo esc_attr($result[0]->btntxtcolor) ?>" maxlength="10"/>
      </div>
      <div class="twpmailsetup">
        <label class="twpalabel">box shadow</label>
        <input id="btnshadow" type="checkbox" name="btnshadow" onchange="twpcheckshadow()" <?php if($result[0]->shadow){echo 'checked';}?>>
      </div>
      <div class="twpmailsubmit">
        <input type="submit" class="button-secondary" name="twpasubmit" value="<?php echo __("Save","twp-login") ?>">
      </div>
    </form>
    <form id="twpmailremovable" method="post">
      <input id="twpdltsmt" type="checkbox" name="datarmv" onchange="twp_ltdata()" <?php if($result[0]->d){echo 'checked';}?>>
      <label><?php echo __("At plugin deletion remove ALL TWP login settings.","twp-login") ?></label>
      <input id="twpdltdatasmt" type="submit" name="dltdata" style="display:none;">
    </form>
  </div>

  <div id="twpright">
    <h1>Preview</h1>
    <div id="twpLoginFormDemo">
      <div id="twploginDemo">
        <div id="twpLoginFormDemoLogo">
          <img id="twpLoginFormLogo" src="<?php echo $logo ?>" alt="">
        </div>
		    <div id="loginform">
			    <p id="twploginuser">
				    <label id="twploginlabels" for="user_login">Username or Email Address</label>
				    <input type="text" name="log" id="user_login" class="input" value="" size="20" autocapitalize="none" autocomplete="username">
			    </p>
			    <div class="user-pass-wrap">
            <label id="twploginlabels2" for="user_pass">Password</label>
            <div>
              <input type="password" name="pwd" id="user_pass" class="input password-input" value="" size="20" autocomplete="current-password">
              <button type="button" id="twpshowpass">
                <span class="dashicons dashicons-visibility" aria-hidden="true"></span>
              </button>
            </div>
			    </div>
          <div id="twpforgetmenot">
            <p class="forgetmenot"><input type="checkbox"> <label id="rememberme" for="rememberme">Remember Me</label></p>
            <p>
              <input type="submit" id="wp-submit" class="button button-primary button-large" value="Log In">
            </p>
          </div>
		    </div>
				<p id="twpnav">
				  <a  id="twpnava" href="#">Lost your password?</a>
        </p>
				<script type="text/javascript">
			    function wp_attempt_focus() {setTimeout( function() {try {d = document.getElementById( "user_login" );d.focus(); d.select();} catch( er ) {}}, 200);}
          wp_attempt_focus();
        </script>
				<p id="backtoblog">
			    <a id="backtobloga" href="#">← Go to twp login</a>
        </p>
			</div>














    </div>





















  </div> 
</div>
<script type="text/javascript">
  var twpmsg = document.getElementsByClassName("twpmessage");
  if(twpmsg[0]){setTimeout(function(){for(var i = 0; i < twpmsg.length; i++){twpmsg[i].style.display = "none";}},8000);}
  function twp_ltdata(){document.getElementById("twpdltdatasmt").click();}
  function twpl_redirect(){
    var check = document.getElementById('twpredit').checked;
    if(check){
      document.getElementById('twplogincss').style.display = "none";
      document.getElementById('twpredirect').style.display = "flex";
    }
    else{
      document.getElementById('twplogincss').style.display = "block";
      document.getElementById('twpredirect').style.display = "none";
    }
  }
  function twpcheckshadow(){
    var shadow = document.getElementById('btnshadow').checked;
    var div = document.getElementById('loginform');
    if(shadow){
      div.classList.add("twpshadow");
    } else {
      div.classList.remove("twpshadow");
    }
  }
  var div = document.getElementById('twpLoginFormDemo');
  var colour = document.getElementById('twpformbg').value;
  div.style.background = colour;
  var div2 = document.getElementById('twpnava');
  var div3 = document.getElementById('backtobloga');
  var colour1 = document.getElementById('twpformbgtextcolor').value;
  div2.style.color = colour1;
  div3.style.color = colour1;
  var colour3 = document.getElementById('twpformformbg').value;
  var div4 = document.getElementById('loginform');
  div4.style.background = colour3;
  var colour4 = document.getElementById('twpformformtext').value;
  var div5 = document.getElementById('twploginlabels');
  var div6 = document.getElementById('twploginlabels2');
  var div7 = document.getElementById('rememberme'); 
  div5.style.color = colour4;
  div6.style.color = colour4;
  div7.style.color = colour4;
  var colour5 = document.getElementById('twpformbtncolor').value;
  var div8 = document.getElementById('wp-submit');
  div8.style.background = colour5;
  var colour6 = document.getElementById('twpformbtntxtcolor').value;
  var div9 = document.getElementById('wp-submit');
  div9.style.color = colour6;
  var shadow = document.getElementById('btnshadow').checked;
  var div10 = document.getElementById('loginform');
  if(shadow){
    div10.classList.add("twpshadow");
  } else {
    div10.classList.remove("twpshadow");
  }
</script>

<?php
function devprint($a){
  echo '<pre>';
  print_r($a);
  echo '</pre>';
}
function devprintexit($a){
  echo '<pre>';
  print_r($a);
  echo '</pre>';
  exit();
}