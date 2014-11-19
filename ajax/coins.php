<?php
$coins_names = array();
$coins_names_prefix = array();

$coins_names[0]="Bitcoin";
$coins_names[1]="Bitcrystal";
$coins_names[2]="Bitcrystalx";

$coins_names_prefix[0]="BTC";
$coins_names_prefix[1]="BITCRY";
$coins_names_prefix[2]="BITCRYX";

$coins_count=count($coins_names);

$coins = array();

$coins["Bitcoin"] = array();
$coins["Bitcoin"]["enabled"]=false;
$coins["Bitcoin"]["daemon"]=false;
$coins["Bitcoin"]["rpcsettings"]=array();

$coins["Bitcrystal"] = array();
$coins["Bitcrystal"]["enabled"]=false;
$coins["Bitcrystal"]["daemon"]=false;
$coins["Bitcrystal"]["rpcsettings"]=array();

$coins["Bitcrystalx"] = array();
$coins["Bitcrystalx"]["enabled"]=false;
$coins["Bitcrystalx"]["daemon"]=false;
$coins["Bitcrystalx"]["rpcsettings"]=array();

$coins["Bitcoin"]["rpcsettings"]["user"]="bitcoinrpc";
$coins["Bitcoin"]["rpcsettings"]["pass"]="fickdiehenneextended";
$coins["Bitcoin"]["rpcsettings"]["host"]="127.0.0.1";
$coins["Bitcoin"]["rpcsettings"]["port"]="8332";

$coins["Bitcrystal"]["rpcsettings"]["user"]="WernerChainer";
$coins["Bitcrystal"]["rpcsettings"]["pass"]="fickdiehenne";
$coins["Bitcrystal"]["rpcsettings"]["host"]="127.0.0.1";
$coins["Bitcrystal"]["rpcsettings"]["port"]="19332";

$coins["Bitcrystalx"]["rpcsettings"]["user"]="WernerChainer";
$coins["Bitcrystalx"]["rpcsettings"]["pass"]="fickdiehenneextended";
$coins["Bitcrystalx"]["rpcsettings"]["host"]="127.0.0.1";
$coins["Bitcrystalx"]["rpcsettings"]["port"]="19333";



$enabled_coins = array();

$enabled_coins[0]="Bitcoin";
$enabled_coins[1]="Bitcrystal";
$enabled_coins[2]="Bitcrystalx";

$enabled_coins_count = count($enabled_coins);

$is_enabled_coins=false;

$current_trade_coin_names = array();
$current_trade_coin_names[0]=$coins_names[0];
$current_trade_coin_names[1]=$coins_names[1];

$current_trade_coin_names_prefix = array();
$current_trade_coin_names_prefix[0]=$coins_names_prefix[0];
$current_trade_coin_names_prefix[1]=$coins_names_prefix[1];

//$current_trade_coin_prefix="BTE";
//$current_trade_coin_name="Bytecoin";
$current_trade_from_coin_prefix="BTC";
$current_trade_from_coin_name="Bitcoin";
$current_trade_to_coin_prefix="BTCRY";
$current_trade_to_coin_name="Bitcrystal";
$trade_coins=array();
/*
$trade_coins["BTC"] = array();
$trade_coins["BTC"]["BTC"]= "BTC";
$trade_coins["BTC"]["BTE"]= $current_trade_coin_prefix;
$trade_coins["BTC"]["BTCS"]= "Bitcoin";
$trade_coins["BTC"]["BTES"]= $current_trade_coin_name;
$trade_coins["LTC"] = array();
$trade_coins["LTC"]["BTC"]= "LTC";
$trade_coins["LTC"]["BTE"]= $current_trade_coin_prefix;
$trade_coins["LTC"]["BTCS"]= "Litecoin";
$trade_coins["LTC"]["BTES"]= $current_trade_coin_name;
*/
$trade_coins["BTCRY"] = array();
$trade_coins["BTCRY"]["BTC"]= $current_trade_from_coin_prefix;
$trade_coins["BTCRY"]["BTCRYX"]= $current_trade_to_coin_prefix;
$trade_coins["BTCRY"]["BTCS"]= $current_trade_from_coin_name;
$trade_coins["BTCRY"]["BTCRYXS"]= $current_trade_to_coin_name;
$trade_coins["BTCRYX"] = array();
$trade_coins["BTCRYX"]["BTC"]= $current_trade_from_coin_prefix;
$trade_coins["BTCRYX"]["BTCRYX"]= $current_trade_to_coin_prefix;
$trade_coins["BTCRYX"]["BTCS"]= $current_trade_from_coin_name;
$trade_coins["BTCRYX"]["BTCRYXS"]= $current_trade_to_coin_name;


function set_current_from_trade_coin_prefix_and_name($prefix, $name)
{
	$current_trade_from_coin_prefix=$prefix;
	$current_trade_from_coin_name=$name;
	$trade_coins["BTCRY"]["BTC"]= $current_trade_from_coin_prefix;
	$trade_coins["BTCRY"]["BTCS"]= $current_trade_from_coin_name;
	$trade_coins["BTCRYX"]["BTC"]= $current_trade_from_coin_prefix
	$trade_coins["BTCRYX"]["BTCS"]= $current_trade_from_coin_name;
}

function set_current_to_trade_coin_prefix_and_name($prefix, $name)
{
	$current_trade_to_coin_prefix=$prefix;
	$current_trade_to_coin_name=$name;
	$trade_coins["BTCRY"]["BTCRYX"]= $current_trade_to_coin_prefix;
	$trade_coins["BTCRY"]["BTCRYXS"]= $current_trade_to_coin_name;
	$trade_coins["BTCRYX"]["BTCRYX"]= $current_trade_to_coin_prefix;
	$trade_coins["BTCRYX"]["BTCRYXS"]= $current_trade_to_coin_name;
}

function get_current_from_trade_coin_prefix_and_name(&$prefix, &$name)
{
	$prefix=$current_from_trade_coin_prefix;
	$name=$current_from_trade_coin_name;
}

function get_current_to_trade_coin_prefix_and_name(&$prefix, &$name)
{
	$prefix=$current_to_trade_coin_prefix;
	$name=$current_to_trade_coin_name;
}

function get_coins_prefix_of_name($name)
{
	for($i=0; $i < $coins_count; $i++)
	{
		if($coins_names[$i]==$name)
		{
			return $coins_names_prefix[$i];
		}
	}
	return "unknown";
}

function get_coins_name_of_prefix($prefix)
{
	for($i=0; $i < $coins_count; $i++)
	{
		if($coins_names_prefix[$i]==$prefix)
		{
			return $coins_names[$i];
		}
	}
	return "unknown";
}

function set_coins_daemon($name, $rpc_user, $rpc_pass, $rpc_host, $rpc_port)
{
	if($coins[$name]["enabled"]==false)
	{
		return false;
	} else {
		if($coins[$name]["daemon"]==false)
		{
			$url = "http://".$rpc_user.":".$rpc_pass."@".$rpc_host.":".$rpc_port."/";
			$coins[$name]["daemon"]=new jsonRPCClient($url);
		}
		return true;
	}
}

function get_coins_daemon_safe($name, $rpc_user, $rpc_pass, $rpc_host, $rpc_port)
{
	$rv=set_coins_daemon($name, $rpc_user, $rpc_pass, $rpc_host, $rpc_port);
	if($rv==true)
	{
		return $coins[$name]["daemon"];
	}
}

function get_coins_daemon($name)
{
	if($coins[$name]["enabled"] == false || $coins[$name]["daemon"] == false)
	{
		return false;
	} else {
		return $coins[$name]["daemon"];
	}
}

function get_coins_balance($name, $user_session)
{
	if($coins[$name]["enabled"]==false)
		return "";
	return userbalance($user_session,get_coins_prefix_of_name($name));
}

function get_coins_balance_from_prefix($prefix, $user_session)
{
	if($coins[get_coins_name_of_prefix($prefix)]["enabled"]==false)
		return "";
	return userbalance($user_session,$prefix);
}

function get_coins_address($name, $wallet_id)
{
	if($coins[$name]["enabled"]==false)
		return "";
	$daemon = $get_coins_daemon($name);
	if($daemon==false)
	{
		return "";
	}
	return $daemon->getaccountaddress($wallet_id);
}

function get_coins_address_from_prefix($prefix, $wallet_id)
{
	$name=get_coins_name_of_prefix($prefix);
	if($coins[$name]["enabled"]==false)
		return "";
	$daemon = $get_coins_daemon($name);
	if($daemon==false)
	{
		return "";
	}
	return $daemon->getaccountaddress($wallet_id);
}


function enable_coins()
{
	if($is_enabled_coins==true)
		return;
	
	for($i=0; $i < $enabled_coins_count; $i++)
	{
		for($j = 0; $j < $coins_count; $j++)
		{
			if($coins_names[$j]==$enabled_coins[$i])
			{
				$name = $coins_names[$j];
				$rpc_user = $coins[$name]["rpcsettings"]["user"];
				$rpc_pass = $coins[$name]["rpcsettings"]["pass"];
				$rpc_host = $coins[$name]["rpcsettings"]["host"];
				$rpc_port = $coins[$name]["rpcsettings"]["port"];
				$coins[$name]["enabled"]=true;
				set_coins_daemon($name, $rpc_user, $rpc_pass, $rpc_host, $rpc_port);
				$j = $coins_count;
			}
		}
	}
	$is_enabled_coins=true;
}
?>