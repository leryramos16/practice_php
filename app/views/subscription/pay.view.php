<?php 
require_once __DIR__ . '/../../views/inc/header.php';
?>

<h2>Pay for Your Plan</h2>

<form id="userForm">
    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
    <input type="hidden" name="coach_id" value="<?= htmlspecialchars($coach_id) ?>">

    <label>Plan</label>
    <select name="plan">
        <option value="Basic" data-amount="500">Basic - ₱500</option>
        <option value="Standard" data-amount="1200">Standard - ₱1200</option>
        <option value="Premium" data-amount="2500">Premium - ₱2500</option>
    </select>
    <input type="hidden" name="amount" value="500">

    <div id="paypal-button-container"></div>
</form>

<script src="https://www.paypal.com/sdk/js?client-id=YOUR_CLIENT_ID&currency=PHP"></script>
<script>
const planSelect = document.querySelector('select[name="plan"]');
const amountInput = document.querySelector('input[name="amount"]');
planSelect.addEventListener('change', () => {
    amountInput.value = planSelect.selectedOptions[0].dataset.amount;
});

paypal.Buttons({
    createOrder: (data, actions) => {
        return actions.order.create({
            purchase_units: [{ amount: { value: amountInput.value } }]
        });
    },
    onApprove: (data, actions) => {
        return actions.order.capture().then(details => {
            const formData = new FormData(document.getElementById('userForm'));
            formData.append('orderID', details.id);

            fetch('<?= ROOT ?>/subscription/process', {
                method: 'POST',
                body: formData
            }).then(res => res.json())
              .then(data => {
                alert('Payment successful!');
                window.location.href = '<?= ROOT ?>/subscription/mySubscriptions';
            });
        });
    }
}).render('#paypal-button-container');
</script>


<?php 
require_once __DIR__ . '/../../views/inc/footer.php';
?>
