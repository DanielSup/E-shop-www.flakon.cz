<script src="catalog/view/javascript/coinpip-api.js" type="text/javascript"></script>
<script type="text/javascript">
  function ProceedBitcoinPayment() {
            var email = "";
            var amount = 0;
            var RefNo = "";
            var api_id = '';
            var Currency = "";
            var RedirectUrl = "";
            email = $('input[name="customer-email"]').val();
            amount = parseFloat($('input[name="amount"]').val());
            api_id = $('input[name="api_id"]').val();
            RefNo = $('input[name="RefNo"]').val();
            Currency = $('input[name="TxnCur"]').val();
            RedirectUrl = $('input[name="RedirectUrl"]').val();
            coinpip.RequestPayment(api_id,{
                    Title: 'Pay with bitcoins',
                    FiatAmount: amount,
                    CustomerEmail: email,
                    Reference: RefNo,
                    Currency: Currency,
                    RedirectUrl: RedirectUrl
                }
            );
        }
</script>
<form action="" method="post">
  <input type="hidden" name="api_id" value="<?php echo $MerchantId; ?>" />
  <input type="hidden" name="RefNo" value="<?php echo $RefNo; ?>" />
  <input type="hidden" name="amount" value="<?php echo $TxnAmt; ?>" />
  <input type="hidden" name="currency" value="<?php echo $TxnAmt; ?>" />
  <input type="hidden" name="RedirectUrl" value="<?php echo $ResponseURL; ?>" />
  <input type="hidden" name="customer-email" value="<?php echo $CustEmail; ?>" />
  <div class="buttons">
    <div class="pull-right right">
      <input type="submit" value="<?php echo $button_confirm; ?>" onclick="ProceedBitcoinPayment();return false;" class="btn btn-primary button" />
    </div>
  </div>
</form>  