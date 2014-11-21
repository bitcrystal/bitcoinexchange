<?php
class w_coins_settings
{
	public $coins;
	public function __construct() {
		$coins = array();
		init_names();
		init_prefixes();
		init_rpc_settings_coin_1();
		init_rpc_settings_coin_2();
		init_rpc_settings_coin_3();
		init_fees();
	}
	
	private function init_names()
	{
		$coin_name_1="Bitcoin";
		$coin_name_2="Bitcrystal";
		$coin_name_3="Bitcrystalx";
		$coins["coin_name_1"] = $coin_name_1;
		$coins["coin_name_2"] = $coin_name_2;
		$coins["coin_name_3"] = $coin_name_3;
		$coins[$coin_name_1] = array();
		$coins[$coin_name_2] = array();
		$coins[$coin_name_3] = array();
	}
	
	private function init_prefixes()
	{
		$coin_prefix_1="BTC";
		$coin_prefix_2="BTCRY";
		$coin_prefix_3="BTCRYX";
		$coins["coin_prefix_1"] = $coin_prefix_1;
		$coins["coin_prefix_2"] = $coin_prefix_2;
		$coins["coin_prefix_3"] = $coin_prefix_3;
	}
	
	private function init_fees()
	{
		$coin_fee_1=0.01;
		$coin_fee_2=0.01;
		$coin_fee_3=0.01;
		$coins["coin_fee_1"] = $coin_fee_1;
		$coins["coin_fee_2"] = $coin_fee_2;
		$coins["coin_fee_3"] = $coin_fee_3;
	}
	
	public function set_names($coin_name_1, $coin_name_2, $coin_name_3)
	{
		$coins["coin_name_1"] = $coin_name_1;
		$coins["coin_name_2"] = $coin_name_2;
		$coins["coin_name_3"] = $coin_name_3;
	}
	
	public function set_prefixes($coin_prefix_1, $coin_prefix_2, $coin_prefix_3)
	{
		$coins["coin_prefix_1"] = $coin_prefix_1;
		$coins["coin_prefix_2"] = $coin_prefix_2;
		$coins["coin_prefix_3"] = $coin_prefix_3;
	}
	
	public function set_fees($coin_fee_1, $coin_fee_2, $coin_fee_3)
	{
		$coins["coin_fee_1"] = $coin_fee_1;
		$coins["coin_fee_2"] = $coin_fee_2;
		$coins["coin_fee_3"] = $coin_fee_3;
	}
	
	private function init_rpc_settings_coin_1()
	{
		$coins_name = $coins["coin_name_1"];
		$coins[$coins_name]["rpcsettings"] = array();
		
		$coins[$coins_name]["rpcsettings"]["user"]="bitcoinrpc";
		$coins[$coins_name]["rpcsettings"]["pass"]="fickdiehenneextended";
		$coins[$coins_name]["rpcsettings"]["host"]="127.0.0.1";
		$coins[$coins_name]["rpcsettings"]["port"]="8332";
	}
	
	private function init_rpc_settings_coin_2()
	{
		$coins_name = $coins["coin_name_2"];
		$coins[$coins_name]["rpcsettings"] = array();
		
		$coins[$coins_name]["rpcsettings"]["user"]="WernerChainer";
		$coins[$coins_name]["rpcsettings"]["pass"]="fickdiehenne";
		$coins[$coins_name]["rpcsettings"]["host"]="127.0.0.1";
		$coins[$coins_name]["rpcsettings"]["port"]="19332";
	}
	
	private function init_rpc_settings_coin_3()
	{
		$coins_name = $coins["coin_name_3"];
		$coins[$coins_name]["rpcsettings"] = array();
		
		$coins[$coins_name]["rpcsettings"]["user"]="WernerChainer";
		$coins[$coins_name]["rpcsettings"]["pass"]="fickdiehenneextended";
		$coins[$coins_name]["rpcsettings"]["host"]="127.0.0.1";
		$coins[$coins_name]["rpcsettings"]["port"]="19333";
	}
	
	public function set_rpc_settings_coin_1($rpc_user, $rpc_pass, $rpc_host, $rpc_port)
	{
		$coins_name = $coins["coin_name_1"];
		
		$coins[$coins_name]["rpcsettings"]["user"]=$rpc_user;
		$coins[$coins_name]["rpcsettings"]["pass"]=$rpc_pass;
		$coins[$coins_name]["rpcsettings"]["host"]=$rpc_host;
		$coins[$coins_name]["rpcsettings"]["port"]=$rpc_port;
	}
	
	public function set_rpc_settings_coin_2($rpc_user, $rpc_pass, $rpc_host, $rpc_port)
	{
		$coins_name = $coins["coin_name_2"];
		
		$coins[$coins_name]["rpcsettings"]["user"]=$rpc_user;
		$coins[$coins_name]["rpcsettings"]["pass"]=$rpc_pass;
		$coins[$coins_name]["rpcsettings"]["host"]=$rpc_host;
		$coins[$coins_name]["rpcsettings"]["port"]=$rpc_port;
	}
	
	public function set_rpc_settings_coin_3($rpc_user, $rpc_pass, $rpc_host, $rpc_port)
	{
		$coin_name = $coins["coin_name_3"];
		
		$coins[$coins_name]["rpcsettings"]["user"]=$rpc_user;
		$coins[$coins_name]["rpcsettings"]["pass"]=$rpc_pass;
		$coins[$coins_name]["rpcsettings"]["host"]=$rpc_host;
		$coins[$coins_name]["rpcsettings"]["port"]=$rpc_port;
	}
}


?>