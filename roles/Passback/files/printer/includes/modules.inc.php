<?php

 #Modules and how they can be accessed.

 #access:
 #user = need to be logged-in to see it
 #hidden_on_login = only visible when not logged in
 #admin = need to be logged in as an admin to see it

 $MODULES = array(
                    'ldap_settings'  => 'hidden_on_login',
                    'access'  => 'hidden_on_login',
                  );

?>