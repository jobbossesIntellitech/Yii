<?php
require 'dbconfig.php';
class User {
    function checkUser($uid, $oauth_provider, $username,$data = "", $token = "", $token_secret = "") 
	{
        $query = mysql_query("SELECT * FROM `users` WHERE oauth_uid = '$uid' and oauth_provider = '$oauth_provider'") or die(mysql_error());
        $result = mysql_fetch_array($query);
        if (!empty($result)) {
            # User is already present
			$query = mysql_query("UPDATE `users` SET data = '$data' WHERE oauth_uid = '$uid' and oauth_provider = '$oauth_provider'");
        } else {
            #user not present. Insert a new Record
            $query = mysql_query("INSERT INTO `users` (oauth_provider, oauth_uid, username, data,twitter_oauth_token,twitter_oauth_token_secret ) VALUES ('$oauth_provider', $uid, '$username','$data','$token','$token_secret')") or die(mysql_error());
            $query = mysql_query("SELECT * FROM `users` WHERE oauth_uid = '$uid' and oauth_provider = '$oauth_provider'");
            $result = mysql_fetch_array($query);
            return $result;
        }
        return $result;
    }
}

?>
