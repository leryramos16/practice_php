
<?php 
require_once __DIR__ . '/../../views/inc/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-5">
            <?php if ($product->image): ?>
                <img src="<?= ROOT ?>/uploads/<?= $product->image ?>" class="img-fluid rounded">
            <?php else: ?>
                <img src="<?= ROOT ?>/assets/noimage.png" class="img-fluid">
            <?php endif; ?>
        </div>

        <div class="col-md-7">
            <h3><?= $product->name ?></h3>
            <h4 class="text-success">₱<?= number_format($product->price, 2) ?></h4>
            <p><?= $product->description ?></p>

            <form method="POST" action="<?= ROOT ?>/cart/add/<?= $product->id ?>">
                <label>Quantity</label>
                <input type="number" name="qty" value="1" class="form-control w-25" min="1">

                <button class="btn btn-primary mt-3">
                    Add to Cart
                </button>
            </form>
        </div>
    </div>
</div>







<?php 
require_once __DIR__ . '/../../views/inc/footer.php';
?>

