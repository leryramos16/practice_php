<?php 
require_once __DIR__ . '/../../views/inc/header.php';
?>

<div class="container mt-4">
    <h3>Products</h3>
    <div class="row">

        <?php foreach ($products as $product): ?>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <?php if ($product->image): ?>
                        <img src="<?= ROOT ?>/uploads/<?= $product->image ?>" class="card-img-top" alt="Product">
                    <?php else: ?>
                        <img src="<?= ROOT ?>/assets/noimage.png" class="card-img-top">
                    <?php endif; ?>

                    <div class="card-body">
                        <h5 class="card-title"><?= $product->name ?></h5>
                        <p class="card-text">₱<?= number_format($product->price, 2) ?></p>

                        <a href="<?= ROOT ?>/products/show/<?= $product->id ?>" class="btn btn-primary btn-sm w-100">
                            View Product
                        </a>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php 
require_once __DIR__ . '/../../views/inc/footer.php';
?>
