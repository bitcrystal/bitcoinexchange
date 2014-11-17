<?php
require'database.php';
require_once'functions_main.php';

$FEEBEE = "feebee";   // IMPORTANT, this is the account that fees will be paid to make sure to register it

$server_url = "example.com";      // url to the exchange
$script_title = "[zelles] Bitcoin Exchange";  // title of the exchange

$CSS_Stylesheet = '<link rel="stylesheet" type="text/css" href="stylesheet.css">';  // a global style sheet
$ip = $_SERVER['REMOTE_ADDR'];
$date = date("n/j/Y g:i a");;

$db_handle = mysql_connect($dbdb_host,$dbdb_user,$dbdb_pass)or die("Server error.");
$db_found = mysql_select_db($dbdb_database)or die("Server error.");

$coin_selected = $_SESSION['trade_coin'];
if(!$coin_selected) {
   $_SESSION['trade_coin'] = "BTC";    // default trade section to load when user first arrives
   header("Location: home.php");
}
if($_SESSION['trade_coin']=="BTCRY") {
   $BTC = "BTCRY"; // rate coin
   $BTCRYX = "BTCRYX"; // amount coin
   $BTCS = "Bitcrystal"; // rate coin name
   $BTCRYXS = "Bitcrystalx"; // amount coin name
}

if($_SESSION['trade_coin']=="BTCRYX") {
   $BTC = "BTC"; // rate coin
   $BTCRY = "BTCRY"; // amount coin
   $BTCS = "Bitcoin"; // rate coin name
   $BTCRYS = "Bitcrystal"; // amount coin name
}

if($_SESSION['trade_coin']=="BTC") {
   $BTC = "BTC"; // rate coin
   $BTCRYX = "BTCRYX"; // amount coin
   $BTCS = "Bitcoin"; // rate coin name
   $BTCRYXS = "Bitcrystalx"; // amount coin name
}

$RPC_Host = "127.0.0.1";  // machine clients are running on. split if needed
$RPC_Port_BTC = "8332";  // coin client 1 port
$RPC_Port_BTCRY = "19332";  // coin client 2 port
$RPC_Port_BTCRYX = "19333";  // coin client 3 port
$BTC_RPC_User = "bitcoinrpc";    // coin client 1 username
$BTCRY_RPC_User = "WernerChainer";   // coin client 2 username
$BTCRYX_RPC_User = "WernerChainer";   // coin client 3 username
$BTC_RPC_Pass = "fickdiehenneextended";    // coin client 1 password
$BTCRY_RPC_Pass = "fickdiehenne";   // coin client 2 password
$BTCRYX_RPC_Pass = "fickdiehenneextended";   // coin client 3 password

$nv93y54tjwy4t9wn = "http://".$BTC_RPC_User.":".$BTC_RPC_Pass."@".$RPC_Host.":".$RPC_Port_BTC."/";
$nu2u5p9u2np8uj5wr = "http://".$BTCRY_RPC_User.":".$BTCRY_RPC_Pass."@".$RPC_Host.":".$RPC_Port_BTCRY."/";
$n9nyv35yp9w8un95uw = "http://".$BTCRYX_RPC_User.":".$BTCRYX_RPC_Pass."@".$RPC_Host.":".$RPC_Port_BTCRYX."/";
$Bitcoind = new jsonRPCClient($nv93y54tjwy4t9wn);
$Bitcrystald = new jsonRPCClient($nu2u5p9u2np8uj5wr);
$Bitcrystalxd = new jsonRPCClient($n9nyv35yp9w8un95uw);

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
      if(!mysql_query("INSERT INTO addresses (id,username,coin1,coin2,coin3,coin4,coin5,coin6,coin7,coin8,coin9,coin10) VALUES ('','$user_session','$Bitcoind_Account_Address','$Bytecoind_Account_Address','$Chncoind_Account_Address','0','0','0','0','0','0','0')")) {
         die("Server error");
      } else {
         $r_system_action = "success";
      }
   }
   $Bitcoind_Balance = userbalance($user_session,"BTC");
   $Bitcrystald_Balance = userbalance($user_session,"BTCRY");
   $Bitcrystalxd_Balance = userbalance($user_session,"BTCRYX");
   $Bitcoind_List_Transactions = $Bitcoind->listtransactions($wallet_id,50);
   foreach($Bitcoind_List_Transactions as $Bitcoind_List_Transaction) {
      if($Bitcoind_List_Transaction['category']=="receive") {
         if(6<=$Bitcoind_List_Transaction['confirmations']) {
            $DEPOSIT_tx_type = 'deposit';
            $DEPOSIT_coin_type = "BTC";
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
                  $result = plusfunds($user_session,"BTC",$DEPOSIT_amount);
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
            $DEPOSIT_coin_type = "BTCRYX";
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
                  $result = plusfunds($user_session,"BTCRYX",$DEPOSIT_amount);
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
            $DEPOSIT_coin_type = "BTCRY";
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
                  $result = plusfunds($user_session,"BTCRY",$DEPOSIT_amount);
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
   $Bitcoind_Balance = userbalance($user_session,"BTC");      // Simple function to call the users balance
   $Bitcrystald_Balance = userbalance($user_session,"BTCRY");
   $Bitcrystalxd_Balance = userbalance($user_session,"BTCRYX");
}
?>