<?php
class w_coins_settings
{
	public $coins;
	public function __construct() {
		$coins = array();
		$this->init_names();
		$this->init_prefixes();
		$this->init_rpc_settings_coin_1();
		$this->init_rpc_settings_coin_2();
		$this->init_rpc_settings_coin_3();
		$this->init_fees();
	}
	
	private function init_names()
	{
		$coin_name_1="Bitcoin";
		$coin_name_2="Bitcrystal";
		$coin_name_3="Bitcrystalx";
		$this->coins["coin_name_1"] = $coin_name_1;
		$this->coins["coin_name_2"] = $coin_name_2;
		$this->coins["coin_name_3"] = $coin_name_3;
		$this->coins[$coin_name_1] = array();
		$this->coins[$coin_name_2] = array();
		$this->coins[$coin_name_3] = array();
	}
	
	private function init_prefixes()
	{
		$coin_prefix_1="BTC";
		$coin_prefix_2="BTCRY";
		$coin_prefix_3="BTCRYX";
		$this->coins["coin_prefix_1"] = $coin_prefix_1;
		$this->coins["coin_prefix_2"] = $coin_prefix_2;
		$this->coins["coin_prefix_3"] = $coin_prefix_3;
	}
	
	private function init_fees()
	{
		$coin_fee_1=0.01;
		$coin_fee_2=0.01;
		$coin_fee_3=0.01;
		$this->coins["coin_fee_1"] = $coin_fee_1;
		$this->coins["coin_fee_2"] = $coin_fee_2;
		$this->coins["coin_fee_3"] = $coin_fee_3;
	}
	
	public function set_names($coin_name_1, $coin_name_2, $coin_name_3)
	{
		$this->coins["coin_name_1"] = $coin_name_1;
		$this->coins["coin_name_2"] = $coin_name_2;
		$this->coins["coin_name_3"] = $coin_name_3;
	}
	
	public function set_prefixes($coin_prefix_1, $coin_prefix_2, $coin_prefix_3)
	{
		$this->coins["coin_prefix_1"] = $coin_prefix_1;
		$this->coins["coin_prefix_2"] = $coin_prefix_2;
		$this->coins["coin_prefix_3"] = $coin_prefix_3;
	}
	
	public function set_fees($coin_fee_1, $coin_fee_2, $coin_fee_3)
	{
		$this->coins["coin_fee_1"] = $coin_fee_1;
		$this->coins["coin_fee_2"] = $coin_fee_2;
		$this->coins["coin_fee_3"] = $coin_fee_3;
	}
	
	private function init_rpc_settings_coin_1()
	{
		$coins_name = $this->coins["coin_name_1"];
		$this->coins[$coins_name]["rpcsettings"] = array();
		
		$this->coins[$coins_name]["rpcsettings"]["user"]="bitcoinrpc";
		$this->coins[$coins_name]["rpcsettings"]["pass"]="fickdiehenneextended";
		$this->coins[$coins_name]["rpcsettings"]["host"]="127.0.0.1";
		$this->coins[$coins_name]["rpcsettings"]["port"]="8332";
	}
	
	private function init_rpc_settings_coin_2()
	{
		$coins_name = $this->coins["coin_name_2"];
		$this->coins[$coins_name]["rpcsettings"] = array();
		
		$this->coins[$coins_name]["rpcsettings"]["user"]="WernerChainer";
		$this->coins[$coins_name]["rpcsettings"]["pass"]="fickdiehenne";
		$this->coins[$coins_name]["rpcsettings"]["host"]="127.0.0.1";
		$this->coins[$coins_name]["rpcsettings"]["port"]="19332";
	}
	
	private function init_rpc_settings_coin_3()
	{
		$coins_name = $this->coins["coin_name_3"];
		$this->coins[$coins_name]["rpcsettings"] = array();
		
		$this->coins[$coins_name]["rpcsettings"]["user"]="WernerChainer";
		$this->coins[$coins_name]["rpcsettings"]["pass"]="fickdiehenneextended";
		$this->coins[$coins_name]["rpcsettings"]["host"]="127.0.0.1";
		$this->coins[$coins_name]["rpcsettings"]["port"]="19333";
	}
	
	public function set_rpc_settings_coin_1($rpc_user, $rpc_pass, $rpc_host, $rpc_port)
	{
		$coins_name = $this->coins["coin_name_1"];
		
		$this->coins[$coins_name]["rpcsettings"]["user"]=$rpc_user;
		$this->coins[$coins_name]["rpcsettings"]["pass"]=$rpc_pass;
		$this->coins[$coins_name]["rpcsettings"]["host"]=$rpc_host;
		$this->coins[$coins_name]["rpcsettings"]["port"]=$rpc_port;
	}
	
	public function set_rpc_settings_coin_2($rpc_user, $rpc_pass, $rpc_host, $rpc_port)
	{
		$coins_name = $this->coins["coin_name_2"];
		
		$this->coins[$coins_name]["rpcsettings"]["user"]=$rpc_user;
		$this->coins[$coins_name]["rpcsettings"]["pass"]=$rpc_pass;
		$this->coins[$coins_name]["rpcsettings"]["host"]=$rpc_host;
		$this->coins[$coins_name]["rpcsettings"]["port"]=$rpc_port;
	}
	
	public function set_rpc_settings_coin_3($rpc_user, $rpc_pass, $rpc_host, $rpc_port)
	{
		$coin_name = $this->coins["coin_name_3"];
		
		$this->coins[$coins_name]["rpcsettings"]["user"]=$rpc_user;
		$this->coins[$coins_name]["rpcsettings"]["pass"]=$rpc_pass;
		$this->coins[$coins_name]["rpcsettings"]["host"]=$rpc_host;
		$this->coins[$coins_name]["rpcsettings"]["port"]=$rpc_port;
	}
}


?>