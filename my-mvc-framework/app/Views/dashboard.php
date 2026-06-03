<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ronde's Inventory System</title>
</head>
<body>

<h1>Ronde's Inventory System</h1>
<hr>
<p>
    Total Products: <?= $totalProducts ?> |
    Total Inventory Value: &#8369;<?= number_format($totalValue, 2) ?>
</p>
<hr>

<p><a href="<?= $baseUrl ?>/products/create">Add Product</a></p>

<div id="confirm-box" style="display:none; border:1px solid black; padding:10px; margin-bottom:10px; background:#fff8dc;">
    <p id="confirm-message"></p>
    <form id="confirm-form" method="POST" action="">
        <button type="submit">Yes, Delete</button>
        <button type="button" onclick="cancelConfirm()">No</button>
    </form>
</div>

<h2>Product List</h2>

<?php if (empty($allProducts)): ?>
    <p>No products found. <a href="<?= $baseUrl ?>/products/create">Add one.</a></p>
<?php else: ?>
<table border="1" cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th><th>Name</th><th>SKU</th><th>Category</th>
            <th>Stock</th><th>Price</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($allProducts as $p): ?>
        <tr>
            <td><?= (int) $p['id'] ?></td>
            <td><a href="<?= $baseUrl ?>/products/<?= (int) $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></a></td>
            <td><?= htmlspecialchars($p['sku']) ?></td>
            <td><?= htmlspecialchars($p['category'] ?? '—') ?></td>
            <td><?= (int) $p['stock'] ?></td>
            <td>&#8369;<?= number_format((float) $p['price'], 2) ?></td>
            <td>
                <a href="<?= $baseUrl ?>/products/<?= (int) $p['id'] ?>/edit">Edit</a> |
                <button type="button"
                    onclick="askDelete(<?= (int) $p['id'] ?>, '<?= htmlspecialchars($p['name'], ENT_QUOTES) ?>')">
                    Delete
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<script>
function askDelete(id, name) {
    document.getElementById('confirm-message').textContent =
        'Are you sure you want to delete "' + name + '"?';
    document.getElementById('confirm-form').action = '<?= $baseUrl ?>/products/' + id + '/delete';
    document.getElementById('confirm-box').style.display = 'block';
    window.scrollTo(0, 0);
}
function cancelConfirm() {
    document.getElementById('confirm-box').style.display = 'none';
    document.getElementById('confirm-form').action = '';
}
</script>

</body>
</html>
