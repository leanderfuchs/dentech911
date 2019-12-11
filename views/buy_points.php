<script
	src="https://www.paypal.com/sdk/js?client-id=AXwxv8jS2H8d4SQsEPb5YnUByIMFJ17oxX6XXCawlkntV3qft-9MfrjRTcqKZHIW1Dq97XYtGZs93SgB">
</script>
      
      
<div class="container">
    Vous avez 4 points correspondant a 4 fichiers.
</div>

<form id="buy-points" method="post" action="#">
  <div class="form-inline mt-5">
    <label for="point-input" class="pr-2">Combien de points avez-vous besoin ? </label>
    <input type="text" class="form-control" name="point-input" id="point-input" placeholder="Aujourd'hui 1 point = 0.25€">
    <button type="submit" class="btn btn-primary ml-2">Acheter des points</button>
    </div>
</form>

  <!-- PayPal payment button -->
  <div id="paypal-button-container"></div>
 

<script>
  paypal.Buttons({
    createOrder: function(data, actions) {
      // This function sets up the details of the transaction, including the amount and line item details.
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: '0.01'
          }
        }]
      });
    }
    onApprove: function(data, actions) {
      // This function captures the funds from the transaction.
      return actions.order.capture().then(function(details) {
        // This function shows a transaction success message to your buyer.
        alert('Transaction completed by ' + details.payer.name.given_name);
        // Call your server to save the transaction
        return fetch('/paypal-transaction-complete', {
          method: 'post',
          headers: {
            'content-type': 'application/json'
          },
          body: JSON.stringify({
            orderID: data.orderID
          })
        });
      });
    }
  }).render('#paypal-button-container');
</script>