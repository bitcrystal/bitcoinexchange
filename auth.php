<?php
require'database.php';
require_once'functions_main.php';
include'coins.php';

$server_url = "example.com";      // url to the exchange
$script_title = "[zelles/Werris] Bitcoin Exchange";  // title of the exchange

$CSS_Stylesheet = '<link rel="stylesheet" type="text/css" href="stylesheet.css">';  // a global style sheet
$ip = $_SERVER['REMOTE_ADDR'];
$date = date("n/j/Y g:i a");;

$db_handle = mysql_connect($dbdb_host,$dbdb_user,$dbdb_pass)or die("Server error.");
$db_found = mysql_select_db($dbdb_database)or die("Server error.");

//echo $my_coins->coins_names_prefix[2];
$coin_selected = $_SESSION['trade_coin'];
if(!$coin_selected) {
   $_SESSION['trade_coin'] = $my_coins->coins_names_prefix[0];    // default trade section to load when user first arrives
   header("Location: home.php");
}

$trade_coin = $_SESSION['trade_coin'];
if($trade_coin == $my_coins->coins_names_prefix[0])
{
	$my_coins->set_current_from_trade_coin_prefix_and_name($my_coins->coins_names_prefix[0], $my_coins->coins_names[0]);
	$my_coins->set_current_to_trade_coin_prefix_and_name($my_coins->coins_names_prefix[1], $my_coins->coins_names[1]);
}
if($trade_coin == $my_coins->coins_names_prefix[2])
{
	$my_coins->set_current_from_trade_coin_prefix_and_name($my_coins->coins_names_prefix[2], $my_coins->coins_names[2]);
	$my_coins->set_current_to_trade_coin_prefix_and_name($my_coins->coins_names_prefix[1], $my_coins->coins_names[1]);
}
$BTC = $my_coins->trade_coins["BTCRY"]["BTC"]; // rate coin
$BTCRYX = $my_coins->trade_coins["BTCRY"]["BTCRYX"]; // amount coin
$BTCS = $my_coins->trade_coins["BTCRY"]["BTCS"]; // rate coin name
$BTCRYXS = $my_coins->trade_coins["BTCRY"]["BTCRYXS"]; // amount coin name

/*$coin0rpc = $coins[$my_coins->coins_names[0]]["rpcsettings"];
$coin1rpc = $coins[$my_coins->coins_names[1]]["rpcsettings"];
$coin2rpc = $coins[$my_coins->coins_names[2]]["rpcsettings"];
set_coins_daemon($my_coins->coins_names[0], $coin0rpc["user"], $coin0rpc["pass"], $coin0rpc["host"], $coin0rpc["port"]);
set_coins_daemon($my_coins->coins_names[1], $coin1rpc["user"], $coin1rpc["pass"], $coin1rpc["host"], $coin1rpc["port"]);
set_coins_daemon($my_coins->coins_names[2], $coin2rpc["user"], $coin2rpc["pass"], $coin2rpc["host"], $coin2rpc["port"]);
*/
$Bitcoind = $my_coins->get_coins_daemon($my_coins->coins_names[0]);
$Bitcrystald = $my_coins->get_coins_daemon($my_coins->coins_names[1]);
$Bitcrystalxd = $my_coins->get_coins_daemon($my_coins->coins_names[2]);

$user_session = $_SESSION['user_session'];
if(!$user_session) {
   $Logged_In = 2;
} else {
   $Logged_In = 7;
   $wallet_id = "zellesExchange(".$user_session.")";
   $Bitcoind_Account_Address = $Bitcoind->getaccountaddress($wallet_id);
   $Bitcrystald_Account_Address = $Bitcrystald->getaccountaddress($wallet_id);
   $Bitcrystalxd_Account_Address = $Bitcrystalxd->getaccountaddress($wallet_id);
   $SQL = "SELECT * FROM balances WHERE username='$user_session'";
   $result = mysql_query($SQL);
   $num_rows = mysql_num_rows($result);
   if($num_rows!=1) {
      if(!mysql_query("INSERT INTO balances (id,username,coin1,coin2,coin3,coin4,coin5,coin6,coin7,coin8,coin9,coin10) VALUES ('','$user_session','0','0','0','0','0','0','0','0','0','0')")) {
         die("Server error");
      } else {
         $r_system_action = "success";
      }
   }
   $SQL = "SELECT * FROM addresses WHERE username='$user_session'";
   $result = mysql_query($SQL);
   $num_rows = mysql_num_rows($result);
   if($num_rows!=1) {
      if(!mysql_query("INSERT INTO addresses (id,username,coin1,coin2,coin3,coin4,coin5,coin6,coin7,coin8,coin9,coin10) VALUES ('','$user_session','$Bitcoind_Account_Address','$Bitcrystald_Account_Address','$Bitcrystalxd_Account_Address','0','0','0','0','0','0','0')")) {
         die("Server error");
      } else {
         $r_system_action = "success";
      }
   }
   $Bitcoind_Balance = userbalance($user_session,$my_coins->coins_names_prefix[0]);
   $Bitcrystald_Balance = userbalance($user_session,$my_coins->coins_names_prefix[1]);
   $Bitcrystalxd_Balance = userbalance($user_session,$my_coins->coins_names_prefix[2]);
   $Bitcoind_List_Transactions = $Bitcoind->listtransactions($wallet_id,50);
   foreach($Bitcoind_List_Transactions as $Bitcoind_List_Transaction) {
      if($Bitcoind_List_Transaction['category']=="receive") {
         if(6<=$Bitcoind_List_Transaction['confirmations']) {
            $DEPOSIT_tx_type = 'deposit';
            $DEPOSIT_coin_type = $my_coins->coins_names_prefix[0];
            $DEPOSIT_date = date('n/j/y h:i a',$Bitcoind_List_Transaction['time']);
            $DEPOSIT_address = $Bitcoind_List_Transaction['address'];
            $DEPOSIT_amount = abs($Bitcoind_List_Transaction['amount']);
            $DEPOSIT_txid = $Bitcoind_List_Transaction['txid'];
            $SQL = "SELECT * FROM transactions WHERE coin='$DEPOSIT_coin_type' and txid='$DEPOSIT_txid'";
            $result = mysql_query($SQL);
            $num_rows = mysql_num_rows($result);
            if($num_rows!=1) {
               if(!mysql_query("INSERT INTO transactions (id,date,username,action,coin,address,txid,amount) VALUES ('','$DEPOSIT_date','$user_session','$DEPOSIT_tx_type','$DEPOSIT_coin_type','$DEPOSIT_address','$DEPOSIT_txid','$DEPOSIT_amount')")) {
                  die("Server error");
               } else {
                  $result = plusfunds($user_session,$my_coins->coins_names_prefix[0],$DEPOSIT_amount);
                  if($result) {
                     $r_system_action = "success";
                  } else {
                     die("Server error");
                  }
               }
            }
         }
      }
   }
   $Bitcrystalxd_List_Transactions = $Bitcrystalxd->listtransactions($wallet_id,50);
   foreach($Bitcrystalxd_List_Transactions as $Bitcrystalxd_List_Transaction) {
      if($Bitcrystalxd_List_Transaction['category']=="receive") {
         if(6<=$Bitcrystald_List_Transaction['confirmations']) {
            $DEPOSIT_tx_type = 'deposit';
            $DEPOSIT_coin_type = $my_coins->coins_names_prefix[2];
            $DEPOSIT_date = date('n/j/y h:i a',$Bitcrystalxd_List_Transaction['time']);
            $DEPOSIT_address = $Bitcrystalxd_List_Transaction['address'];
            $DEPOSIT_amount = abs($Bitcrystalxd_List_Transaction['amount']);
            $DEPOSIT_txid = $Bitcrystalxd_List_Transaction['txid'];
            $SQL = "SELECT * FROM transactions WHERE coin='$DEPOSIT_coin_type' and txid='$DEPOSIT_txid'";
            $result = mysql_query($SQL);
            $num_rows = mysql_num_rows($result);
            if($num_rows!=1) {
               if(!mysql_query("INSERT INTO transactions (id,date,username,action,coin,address,txid,amount) VALUES ('','$DEPOSIT_date','$user_session','$DEPOSIT_tx_type','$DEPOSIT_coin_type','$DEPOSIT_address','$DEPOSIT_txid','$DEPOSIT_amount')")) {
                  die("Server error");
               } else {
                  $result = plusfunds($user_session,$my_coins->coins_names_prefix[2],$DEPOSIT_amount);
                  if($result) {
                     $r_system_action = "success";
                  } else {
                     die("Server error");
                  }
               }
            }
         }
      }
   }
   $Bitcrystald_List_Transactions = $Bitcrystald->listtransactions($wallet_id,50);
   foreach($Bitcrystald_List_Transactions as $Bitcrystald_List_Transaction) {
      if($Bitcrystald_List_Transaction['category']=="receive") {
         if(6<=$Bitcrystald_List_Transaction['confirmations']) {
            $DEPOSIT_tx_type = 'deposit';
            $DEPOSIT_coin_type = $my_coins->coins_names_prefix[1];
            $DEPOSIT_date = date('n/j/y h:i a',$Bitcrystal_List_Transaction['time']);
            $DEPOSIT_address = $Bitcrystald_List_Transaction['address'];
            $DEPOSIT_amount = abs($Bitcrystald_List_Transaction['amount']);
            $DEPOSIT_txid = $Bitcrystald_List_Transaction['txid'];
            $SQL = "SELECT * FROM transactions WHERE coin='$DEPOSIT_coin_type' and txid='$DEPOSIT_txid'";
            $result = mysql_query($SQL);
            $num_rows = mysql_num_rows($result);
            if($num_rows!=1) {
               if(!mysql_query("INSERT INTO transactions (id,date,username,action,coin,address,txid,amount) VALUES ('','$DEPOSIT_date','$user_session','$DEPOSIT_tx_type','$DEPOSIT_coin_type','$DEPOSIT_address','$DEPOSIT_txid','$DEPOSIT_amount')")) {
                  die("Server error");
               } else {
                  $result = plusfunds($user_session,$my_coins->coins_names_prefix[1],$DEPOSIT_amount);
                  if($result) {
                     $r_system_action = "success";
                  } else {
                     die("Server error");
                  }
               }
            }
         }
      }
   }
   $Bitcoind_Balance = userbalance($user_session,$my_coins->coins_names_prefix[0]);      // Simple function to call the users balance
   $Bitcrystald_Balance = userbalance($user_session,$my_coins->coins_names_prefix[1]);
   $Bitcrystalxd_Balance = userbalance($user_session,$my_coins->coins_names_prefix[2]);
}
?>