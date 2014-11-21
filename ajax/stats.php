<?php
require_once('coins.php');
error_reporting(0);
$buy_subtotal = "0";
$buy_amounttotal = "0";
$Query = mysql_query("SELECT amount, rate FROM buy_orderbook WHERE want='".$my_coins->coins_names_prefix[2]."' and processed='1' ORDER BY rate ASC");
while($Row = mysql_fetch_assoc($Query)) {
   $buy_amount = $Row['amount'];
   $buy_rate = $Row['rate'];
   $buy_subtotal += ($buy_amount * $buy_rate);
}
$btevalue = satoshitrim(satoshitize($buy_subtotal));

$buy_amounttotal = "0";
$Query = mysql_query("SELECT amount FROM sell_orderbook WHERE want='".$my_coins->coins_names_prefix[2]."' and processed='1' ORDER BY rate ASC");
while($Row = mysql_fetch_assoc($Query)) {
   $buy_amount = $Row['amount'];
   $buy_amounttotal += $buy_amount;
}
$btevolume = satoshitrim(satoshitize($buy_amounttotal));

$buy_subtotal = "0";
$buy_amounttotal = "0";
$Query = mysql_query("SELECT amount, rate FROM buy_orderbook WHERE want='".$my_coins->coins_names_prefix[1]."' and processed='1' ORDER BY rate ASC");
while($Row = mysql_fetch_assoc($Query)) {
   $buy_amount = $Row['amount'];
   $buy_rate = $Row['rate'];
   $buy_subtotal += ($buy_amount * $buy_rate);
}
$cncvalue = satoshitrim(satoshitize($buy_subtotal));

$buy_amounttotal = "0";
$Query = mysql_query("SELECT amount FROM sell_orderbook WHERE want='".$my_coins->coins_names_prefix[1]."' and processed='1' ORDER BY rate ASC");
while($Row = mysql_fetch_assoc($Query)) {
   $buy_amount = $Row['amount'];
   $buy_amounttotal += $buy_amount;
}
$cncvolume = satoshitrim(satoshitize($buy_amounttotal));

echo '<table>
         <tr>
            <td nowrap>'.$my_coins->coins_names_prefix[2].'/'.$my_coins->coins_names_prefix[0].'</td>
            <td style="padding-left: 10px;" nowrap>Volume '.$btevolume.' / '.$cncvalue.' '.$my_coins->coins_names_prefix[2].'</td>
            <td style="padding-left: 30px;" nowrap>'.$my_coins->coins_names_prefix[1].'/'.$my_coins->coins_names_prefix[2].'</td>
            <td style="padding-left: 10px;" nowrap>Volume '.$cncvolume.' / '.$btevalue.' '.$my_coins->coins_names_prefix[1].'</td>
         </tr>
      </table>';
?>