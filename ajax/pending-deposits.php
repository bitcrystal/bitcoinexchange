<?php
error_reporting(0);
if(!$user_session) {
   $do = "nothing";
} else {
   $TXSSS_DISP = "";
   $bold_txxs = "";
   $Bitcoind_List_Transactions = $Bitcoind->listtransactions($wallet_id,10);
   foreach($Bitcoind_List_Transactions as $Bitcoind_List_Transaction) {
      if($bold_txxs=="") { $bold_txxs = "color: #666666; "; } else { $bold_txxs = ""; }
      if($Bitcoind_List_Transaction['category']=="receive") {
         if(5>=$Bitcoind_List_Transaction['confirmations']) {
            $TXSSS_DISP = "1";
            $TXSSS .= '<tr>
                          <td align="right" style="'.$bold_txxs.'padding-left: 5px;" nowrap>'.abs($Bitcoind_List_Transaction['amount']).' '.$my_coins->coins_names_prefix[0].' / '.$Bitcoind_List_Transaction['confirmations'].' confs</span></td>
                       </tr>';
         }
      }
   }
   $Bitcrystald_List_Transactions = $Bitcrystald->listtransactions($wallet_id,10);
   foreach($Bitcrystald_List_Transactions as $Bitcrystald_List_Transaction) {
      if($bold_txxs=="") { $bold_txxs = "color: #666666; "; } else { $bold_txxs = ""; }
      if($Bitcrystald_List_Transaction['category']=="receive") {
         if(5>=$Bitcrystald_List_Transaction['confirmations']) {
            $TXSSS_DISP = "1";
            $TXSSS .= '<tr>
                          <td align="right" style="'.$bold_txxs.'padding-left: 5px;" nowrap>'.abs($Bitcrystald_List_Transaction['amount']).'</span> '.$my_coins->coins_names_prefix[1].' / '.$Bitcrystald_List_Transaction['confirmations'].' confs</td>
                       </tr>';
         }
      }
   }
   $Bitcrystalxd_List_Transactions = $Bitcrystalxd->listtransactions($wallet_id,10);
   foreach($Bitcrystalxd_List_Transactions as $Bitcrystalxd_List_Transaction) {
      if($bold_txxs=="") { $bold_txxs = "color: #666666; "; } else { $bold_txxs = ""; }
      if($Bitcrystalxd_List_Transaction['category']=="receive") {
         if(5>=$Bitcrystalxd_List_Transaction['confirmations']) {
            $TXSSS_DISP = "1";
            $TXSSS .= '<tr>
                          <td align="right" style="'.$bold_txxs.'padding-left: 5px;" nowrap>'.abs($Bitcrystalxd_List_Transaction['amount']).' '.$my_coins->coins_names_prefix[2].' / '.$Bitcrystalxd_List_Transaction['confirmations'].' confs</td>
                       </tr>';
         }
      }
   }
   if($TXSSS_DISP=="1") {
      echo '<div align="left" class="pending-right">
            <b>Incoming:</b>
            <table style="width: 100%;">'.$TXSSS.'</table>
            </center>
            </div>
            <p></p>';
   }
}
?>