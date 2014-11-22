<?php
error_reporting(0);
if(!$user_session) {
   echo '<b>Finances:</b><p></p>
         <table style="width: 100%;">
            <tr>
               <td align="right" style="padding-left: 5px;" nowrap><a href="fundsbtc.php">'.$my_coins->coins_names_prefix[0].'</a></td>
               <td align="right" style="padding-left: 5px;" nowrap><span id="balance-btc">?</span></td>
               <td align="right" style="padding-left: 5px;" nowrap><a href="fundsbtcry.php">'.$my_coins->coins_names_prefix[1].'</a></td>
            </tr><tr>
               <td align="right" style="padding-left: 5px;" nowrap><span id="balance-btcry">?</span></td>
            </tr><tr>
               <td align="right" style="padding-left: 5px;" nowrap><a href="fundsbtcryx.php">'.$my_coins->coins_names_prefix[2].'</a></td>
               <td align="right" style="padding-left: 5px;" nowrap><span id="balance-btcryx">?</span></td>
            </tr>
         </table>';
} else {
   echo '<b>Finances:</b><p></p>
         <table style="width: 100%;">
            <tr>
               <td align="right" style="padding-left: 5px;" nowrap><a href="fundsbtc.php">'.$my_coins->coins_names_prefix[0].'</a></td>
               <td align="right" style="padding-left: 5px;" nowrap><span id="balance-btc">'.userbalance($user_session,$my_coins->coins_names_prefix[0]).'</span></td>
            </tr><tr>
               <td align="right" style="padding-left: 5px;" nowrap><a href="fundsbtcry.php">'.$my_coins->coins_names_prefix[1].'</a></td>
               <td align="right" style="padding-left: 5px;" nowrap><span id="balance-btcry">'.userbalance($user_session,$my_coins->coins_names_prefix[1]).'</span></td>
            </tr><tr>
               <td align="right" style="padding-left: 5px;" nowrap><a href="fundsbtcryx.php">'.$my_coins->coins_names_prefix[2].'</a></td>
               <td align="right" style="padding-left: 5px;" nowrap><span id="balance-btcryx">'.userbalance($user_session,$my_coins->coins_names_prefix[2]).'</span></td>
            </tr>
         </table>';
}
?>