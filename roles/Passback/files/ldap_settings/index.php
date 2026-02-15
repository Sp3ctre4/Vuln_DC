<?php

set_include_path("C:\\inetpub\\wwwroot\\printer\\includes\\");

include_once "web_functions.inc.php";
include_once "ldap_functions.inc.php";
include_once "modules.inc.php";


$completed_action="/$THIS_MODULE_PATH/";
$page_title="Ldap settings";

render_header();
#render_submenu();

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['server']) && isset($_POST['port'])){

  $adServer = "ldap://" . $_POST['server'];

  $ldap = ldap_connect($adServer, $_POST['port']);
  $username = "svc_printer";
  $password = "G82_10Lp19o1";

  $ldaprdn = 'roshar' . "\\" . $username;

  ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
  ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

  $bind = @ldap_bind($ldap, $ldaprdn, $password);

  echo 1;
  if ($bind) {
      $filter="(sAMAccountName=$username)";
      $result = ldap_search($ldap,"dc=roshar,dc=local",$filter);
      ldap_sort($ldap,$result,"sn");
      $info = ldap_get_entries($ldap, $result);
      for ($i=0; $i<$info["count"]; $i++)
      {
          if($info['count'] > 1)
              break;
          echo "<p>You are accessing <strong> ". $info[$i]["sn"][0] .", " . $info[$i]["givenname"][0] ."</strong><br /> (" . $info[$i]["samaccountname"][0] .")</p>\n";
          echo '<pre>';
          var_dump($info);
          echo '</pre>';
          $userDn = $info[$i]["distinguishedname"][0]; 
      }
      @ldap_close($ldap);
  } else {
      $msg = "Invalid email address / password";
      echo $msg;
  }

}


render_js_username_generator('first_name','last_name','username','username_div');
render_js_email_generator('username','email');

?>
<script src="//cdnjs.cloudflare.com/ajax/libs/zxcvbn/1.0/zxcvbn.min.js"></script>
<script type="text/javascript" src="/js/zxcvbn-bootstrap-strength-meter.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
   $("#StrengthProgressBar").zxcvbnProgressBar({ passwordInput: "#password" });
 });
</script>
<script type="text/javascript" src="/js/generate_passphrase.js"></script>
<script type="text/javascript" src="/js/wordlist.js"></script>
<script>

 function check_passwords_match() {

   if (document.getElementById('password').value != document.getElementById('confirm').value ) {
       document.getElementById('password_div').classList.add("has-error");
       document.getElementById('confirm_div').classList.add("has-error");
   }
   else {
    document.getElementById('password_div').classList.remove("has-error");
    document.getElementById('confirm_div').classList.remove("has-error");
   }
  }

 function random_password() {

  generatePassword(4,'-','password','confirm');
  $("#StrengthProgressBar").zxcvbnProgressBar({ passwordInput: "#password" });
 }

 function back_to_hidden(passwordField,confirmField) {

  var passwordField = document.getElementById(passwordField).type = 'password';
  var confirmField = document.getElementById(confirmField).type = 'password';

 }


</script>

<div class="container">
 <div class="col-sm-8">

  <div class="panel panel-default">
   <div class="panel-heading text-center"><?php print $page_title; ?></div>
   <div class="panel-body text-center">

    <form class="form-horizontal" action="" method="post">

     <input type="hidden" name="create_account">
     <input type="hidden" id="pass_score" value="0" name="pass_score">

     <div class="form-group">
      <label for="first_name" class="col-sm-3 control-label">Server address</label>
      <div class="col-sm-6">
       <input tabindex="1" type="text" class="form-control" id="server" name="server">
      </div>
     </div>

     <div class="form-group">
      <label for="last_name" class="col-sm-3 control-label">Server port</label>
      <div class="col-sm-6">
       <input tabindex="3" type="text" class="form-control" id="port" name="port" value="389">
      </div>
     </div>

     <div class="form-group" id="username_div">
      <label for="username" class="col-sm-3 control-label">Username</label>
      <div class="col-sm-6">
       <input tabindex="3" type="text" class="form-control" id="username" name="username" value="svc_printer" readonly>
      </div>
     </div>

     <div class="form-group" id="password_div">
      <label for="password" class="col-sm-3 control-label">Password</label>
      <div class="col-sm-6">
       <input tabindex="5" type="password" class="form-control" id="password" name="password" value="************" onkeyup="back_to_hidden('password','confirm');" readonly>
      </div>
     </div>

     <div class="form-group" id="confirm_div">
      <label for="confirm" class="col-sm-3 control-label">Confirm</label>
      <div class="col-sm-6">
       <input tabindex="6" type="password" class="form-control" id="confirm" name="password_match" value="************" onkeyup="check_passwords_match()" readonly>
      </div>
     </div>

     <div class="form-group">
       <button tabindex="8" type="submit" class="btn btn-warning">Connect</button>
     </div>

    </form>

   </div>
  </div>

 </div>
</div>
<?php



render_footer();

?>