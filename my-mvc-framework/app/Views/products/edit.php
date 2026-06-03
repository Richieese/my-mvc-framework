<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product — Ronde's Inventory System</title>
</head>
<body>

<h1>Ronde's Inventory System</h1>
<hr>
<h2>Edit Product</h2>
<a href="<?= $baseUrl ?>/">&#8592; Back to Dashboard</a>
<br><br>

<div id="confirm-box" style="display:none; border:1px solid black; padding:10px; margin-bottom:10px; background:#fff8dc;">
    <p>Are you sure you want to save changes to this product?</p>
    <button type="button" onclick="document.getElementById('edit-form').submit()">Yes, Save</button>
    <button type="button" onclick="document.getElementById('confirm-box').style.display='none'">Cancel</button>
</div>

<form method="POST" action="<?= $baseUrl ?>/products/<?= (int) $product['id'] ?>/update" id="edit-form">

    <label>Product Name:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>"><br>
    <?php if (!empty($errors['name'])): ?>
        <span style="color:red;"><?= $errors['name'] ?></span><br>
    <?php endif; ?>
    <br>

    <label>SKU:</label><br>
    <input type="text" name="sku" value="<?= htmlspecialchars($product['sku']) ?>"><br>
    <?php if (!empty($errors['sku'])): ?>
        <span style="color:red;"><?= $errors['sku'] ?></span><br>
    <?php endif; ?>
    <br>

    <label>Category:</label><br>
    <select name="category">
        <option value="">-- Select Category --</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= htmlspecialchars($cat) ?>"
                <?= (($product['category'] ?? '') === $cat) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat) ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    <?php if (!empty($errors['category'])): ?>
        <span style="color:red;"><?= $errors['category'] ?></span><br>
    <?php endif; ?>
    <br>

    <label>Stock:</label><br>
    <input type="text" name="stock" value="<?= htmlspecialchars((string) $product['stock']) ?>"><br>
    <?php if (!empty($errors['stock'])): ?>
        <span style="color:red;"><?= $errors['stock'] ?></span><br>
    <?php endif; ?>
    <br>

    <label>Price (&#8369;):</label><br>
    <input type="text" name="price" value="<?= htmlspecialchars((string) $product['price']) ?>"><br>
    <?php if (!empty($errors['price'])): ?>
        <span style="color:red;"><?= $errors['price'] ?></span><br>
    <?php endif; ?>
    <br>

    <button type="button" onclick="document.getElementById('confirm-box').style.display='block'; window.scrollTo(0,0);">
        Update Product
    </button>
    <a href="<?= $baseUrl ?>/">Cancel</a>

</form>

</body>
</html>
