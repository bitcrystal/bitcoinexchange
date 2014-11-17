<?php
error_reporting(0);
if(!$user_session) {
   echo '<b>Finances:</b><p></p>
         <table style="width: 100%;">
            <tr>
               <td align="right" style="padding-left: 5px;" nowrap><a href="fundsbtc.php">BTC</a></td>
               <td align="right" style="padding-left: 5px;" nowrap><span id="balance-btc">?</span></td>
            </tr><tr>
               <td align="right" style="padding-left: 5px;" nowrap><a href="fundsbtcryx.php">BTCRYX</a></td>
               <td align="right" style="padding-left: 5px;" nowrap><span id="balance-btcryx">?</span></td>
            </tr><tr>
               <td align="right" style="padding-left: 5px;" nowrap><a href="fundsbtcry.php">BTCRY</a></td>
               <td align="right" style="padding-left: 5px;" nowrap><span id="balance-btcry">?</span></td>
            </tr>
         </table>';
} else {
   echo '<b>Finances:</b><p></p>
         <table style="width: 100%;">
            <tr>
               <td align="right" style="padding-left: 5px;" nowrap><a href="fundsbtc.php">BTC</a></td>
               <td align="right" style="padding-left: 5px;" nowrap><span id="balance-btc">'.userbalance($user_session,"BTCRY").'</span></td>
            </tr><tr>
               <td align="right" style="padding-left: 5px;" nowrap><a href="fundsbtcryx.php">BTCRYX</a></td>
               <td align="right" style="padding-left: 5px;" nowrap><span id="balance-btcryx">'.userbalance($user_session,"BTCRYX").'</span></td>
            </tr><tr>
               <td align="right" style="padding-left: 5px;" nowrap><a href="fundsbtcry.php">BTCRY</a></td>
               <td align="right" style="padding-left: 5px;" nowrap><span id="balance-btcry">'.userbalance($user_session,"BTCRY").'</span></td>
            </tr>
         </table>';
}
?>