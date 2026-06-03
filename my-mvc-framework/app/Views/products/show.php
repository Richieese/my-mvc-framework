<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']) ?> — Ronde's Inventory System</title>
</head>
<body>

<h1>Ronde's Inventory System</h1>
<hr>
<h2><?= htmlspecialchars($product['name']) ?></h2>
<a href="<?= $baseUrl ?>/">&#8592; Back to Dashboard</a> |
<a href="<?= $baseUrl ?>/products/<?= (int) $product['id'] ?>/edit">Edit</a>
<br><br>

<table border="1" cellpadding="6" cellspacing="0">
    <tr><th>SKU</th><td><?= htmlspecialchars($product['sku']) ?></td></tr>
    <tr><th>Category</th><td><?= htmlspecialchars($product['category'] ?? '—') ?></td></tr>
    <tr><th>Stock</th><td><?= (int) $product['stock'] ?></td></tr>
    <tr><th>Price</th><td>&#8369;<?= number_format((float) $product['price'], 2) ?></td></tr>
    <tr><th>Added</th><td><?= htmlspecialchars($product['created_at']) ?></td></tr>
</table>

</body>
</html>