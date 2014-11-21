<?php
require_once 'w_coins_settings.php';
class w_coins {
	private $my_w;
	public $coins_names;
	public $coins_names_prefix;
	private $coins_count;
	public $coins;
	private $enabled_coins;
	private $enabled_coins_count;
	private $is_enabled_coins;
	private $is_enabled_default_coins;
	private $current_trade_coin_names;
	private $current_trade_coin_names_prefix;
	private $current_trade_from_coin_prefix;
	private $current_trade_from_coin_name;
	private $current_trade_to_coin_prefix;
	private $current_trade_to_coin_name;
	public $trade_coins;
	private static $SINGLETON = NULL;
	
	private function __construct() {
		$my_w = new w_coins_settings();
		$coins = array();
		$coins_names = array();
		$coins_names_prefix = array();
		
		$coins_names[0]=$my_w->$coins["coin_name_1"];
		$coins_names[1]=$my_w->$coins["coin_name_2"];
		$coins_names[2]=$my_w->$coins["coin_name_3"];

		$coins_names_prefix[0]=$my_w->$coins["coin_prefix_1"];
		$coins_names_prefix[1]=$my_w->$coins["coin_prefix_2"];
		$coins_names_prefix[2]=$my_w->$coins["coin_prefix_3"];
		$coins_count=count($coins_names);
		
		$coins[$coins_names[0]] = array();
		$coins[$coins_names[0]]["enabled"]=false;
		$coins[$coins_names[0]]["daemon"]=false;
		$coins[$coins_names[0]]["rpcsettings"]=array();
		$coins[$coins_names[0]]["fee"]=$my_w->$coins["coin_fee_1"];

		$coins[$coins_names[1]] = array();
		$coins[$coins_names[1]]["enabled"]=false;
		$coins[$coins_names[1]]["daemon"]=false;
		$coins[$coins_names[1]]["rpcsettings"]=array();
		$coins[$coins_names[1]]["fee"]=$my_w->$coins["coin_fee_2"];

		$coins[$coins_names[2]] = array();
		$coins[$coins_names[2]]["enabled"]=false;
		$coins[$coins_names[2]]["daemon"]=false;
		$coins[$coins_names[2]]["rpcsettings"]=array();
		$coins[$coins_names[2]]["fee"]=$my_w->$coins["coin_fee_3"];

		$coin0rpc = $my_w->$coins[$coins_names[0]]["rpcsettings"];
		$coin1rpc = $my_w->$coins[$coins_names[1]]["rpcsettings"];
		$coin2rpc = $my_w->$coins[$coins_names[2]]["rpcsettings"];
		
		$coins[$coins_names[0]]["rpcsettings"]["user"]=$coin0rpc["user"];
		$coins[$coins_names[0]]["rpcsettings"]["pass"]=$coin0rpc["pass"];
		$coins[$coins_names[0]]["rpcsettings"]["host"]=$coin0rpc["host"];
		$coins[$coins_names[0]]["rpcsettings"]["port"]=$coin0rpc["port"];

		$coins[$coins_names[1]]["rpcsettings"]["user"]=$coin1rpc["user"];
		$coins[$coins_names[1]]["rpcsettings"]["pass"]=$coin1rpc["pass"];
		$coins[$coins_names[1]]["rpcsettings"]["host"]=$coin1rpc["host"];
		$coins[$coins_names[1]]["rpcsettings"]["port"]=$coin1rpc["port"];

		$coins[$coins_names[2]]["rpcsettings"]["user"]=$coin2rpc["user"];
		$coins[$coins_names[2]]["rpcsettings"]["pass"]=$coin2rpc["pass"];
		$coins[$coins_names[2]]["rpcsettings"]["host"]=$coin2rpc["host"];
		$coins[$coins_names[2]]["rpcsettings"]["port"]=$coin2rpc["port"];
		
		$enabled_coins=array();
		
		$enabled_coins[0]=$coins_names[0];
		$enabled_coins[1]=$coins_names[1];
		$enabled_coins[2]=$coins_names[2];

		$enabled_coins_count = count($enabled_coins);

		$is_enabled_coins=false;
		$is_enabled_default_coins=false;

		$current_trade_coin_names = array();
		
		$current_trade_coin_names[0]=$coins_names[0];
		$current_trade_coin_names[1]=$coins_names[1];

		$current_trade_coin_names_prefix = array();
		
		$current_trade_coin_names_prefix[0]=$coins_names_prefix[0];
		$current_trade_coin_names_prefix[1]=$coins_names_prefix[1];

		$current_trade_from_coin_prefix=$coins_names_prefix[0];
		$current_trade_from_coin_name=$coins_names[0];
		$current_trade_to_coin_prefix=$coins_names_prefix[1];
		$current_trade_to_coin_name=$coins_names[1];
		
		$trade_coins=array();
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
		enable_default_coins();
	}
	
	public function set_current_from_trade_coin_prefix_and_name($prefix, $name)
	{
		$current_trade_from_coin_prefix=$prefix;
		$current_trade_from_coin_name=$name;
		$trade_coins["BTCRY"]["BTC"]= $current_trade_from_coin_prefix;
		$trade_coins["BTCRY"]["BTCS"]= $current_trade_from_coin_name;
		$trade_coins["BTCRYX"]["BTC"]= $current_trade_from_coin_prefix;
		$trade_coins["BTCRYX"]["BTCS"]= $current_trade_from_coin_name;
	}

	public function set_current_to_trade_coin_prefix_and_name($prefix, $name)
	{
		$current_trade_to_coin_prefix=$prefix;
		$current_trade_to_coin_name=$name;
		$trade_coins["BTCRY"]["BTCRYX"]= $current_trade_to_coin_prefix;
		$trade_coins["BTCRY"]["BTCRYXS"]= $current_trade_to_coin_name;
		$trade_coins["BTCRYX"]["BTCRYX"]= $current_trade_to_coin_prefix;
		$trade_coins["BTCRYX"]["BTCRYXS"]= $current_trade_to_coin_name;
	}

	public function get_current_from_trade_coin_prefix_and_name(&$prefix, &$name)
	{
		$prefix=$current_from_trade_coin_prefix;
		$name=$current_from_trade_coin_name;
	}

	public function get_current_to_trade_coin_prefix_and_name(&$prefix, &$name)
	{
		$prefix=$current_to_trade_coin_prefix;
		$name=$current_to_trade_coin_name;
	}

	public function get_coins_prefix_of_name($name)
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

	public function get_coins_name_of_prefix($prefix)
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

	public function set_coins_daemon($name, $rpc_user, $rpc_pass, $rpc_host, $rpc_port)
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

	public function get_coins_daemon_safe($name, $rpc_user, $rpc_pass, $rpc_host, $rpc_port)
	{
		$rv=set_coins_daemon($name, $rpc_user, $rpc_pass, $rpc_host, $rpc_port);
		if($rv==true)
		{
			return $coins[$name]["daemon"];
		}
	}

	public function get_coins_daemon($name)
	{
		if($coins[$name]["enabled"] == false || $coins[$name]["daemon"] == false)
		{
			return false;
		} else {
			return $coins[$name]["daemon"];
		}
	}

	public function get_coins_balance($name, $user_session)
	{
		if($coins[$name]["enabled"]==false)
			return "";
		return userbalance($user_session,get_coins_prefix_of_name($name));
	}

	public function get_coins_balance_from_prefix($prefix, $user_session)
	{
		if($coins[get_coins_name_of_prefix($prefix)]["enabled"]==false)
			return "";
		return userbalance($user_session,$prefix);
	}

	public function get_coins_address($name, $wallet_id)
	{
		if($coins[$name]["enabled"]==false)
			return "";
		$daemon = get_coins_daemon($name);
		if($daemon==false)
		{
			return "";
		}
		return $daemon->getaccountaddress($wallet_id);
	}

	public function get_coins_address_from_prefix($prefix, $wallet_id)
	{
		$name=get_coins_name_of_prefix($prefix);
		if($coins[$name]["enabled"]==false)
			return "";
		$daemon = get_coins_daemon($name);
		if($daemon==false)
		{
				return "";
		}
		return $daemon->getaccountaddress($wallet_id);
	}


	private function enable_coins()
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

	private function enable_default_coins()
	{
		if($is_enabled_default_coins==true)
			return;

		for($i = 0; $i < $coins_count; $i++)
		{
			$name = $coins_names[$i];
			$rpc_user = $coins[$name]["rpcsettings"]["user"];
			$rpc_pass = $coins[$name]["rpcsettings"]["pass"];
			$rpc_host = $coins[$name]["rpcsettings"]["host"];
			$rpc_port = $coins[$name]["rpcsettings"]["port"];
			$coins[$name]["enabled"]=true;
			set_coins_daemon($name, $rpc_user, $rpc_pass, $rpc_host, $rpc_port);
		}
		$is_enabled_default_coins=true;
	}
	
	public static function get()
	{
		if(self::$SINGLETON == NULL)
			self::$SINGLETON=new w_coins();
		return self::$SINGLETON;
	}
}
?>