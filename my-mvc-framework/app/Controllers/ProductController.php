<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Category;
use App\Models\ProductRepositoryInterface;
use Core\Http\Request;
use Core\Http\Response;
use Core\Validation\Validator;
use Core\View\Engine;

class ProductController extends BaseController
{
    public function __construct(
        Engine $view,
        private readonly ProductRepositoryInterface $products,
        private readonly Validator                  $validator,
    ) {
        parent::__construct($view);
    }


    public function create(): Response
    {
        return $this->render('products/create', [
            'categories' => Category::labels(),
            'errors'     => [],
            'old'        => [],
        ]);
    }

    public function store(): Response
    {
        $request = new Request();
        $data    = $request->all();

        $valid = $this->validator->validate($data, [
            'name'     => 'required|maxlen:255',
            'sku'      => 'required|maxlen:100',
            'price'    => 'required|numeric|min:0',
            'stock'    => 'required|integer|min:0',
            'category' => 'required',
        ]);

        if (!$valid) {
            return $this->render('products/create', [
                'categories' => Category::labels(),
                'errors'     => $this->validator->errors(),
                'old'        => $data,
            ]);
        }

        $this->products->create([
            'name'        => trim($data['name']),
            'sku'         => trim($data['sku']),
            'description' => trim($data['description'] ?? ''),
            'price'       => (float) $data['price'],
            'stock'       => (int) $data['stock'],
            'category'    => $data['category'],
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        return $this->redirect('/');
    }

    public function edit(string $id): Response
    {
        $product = $this->products->find((int) $id);
        if ($product === false) {
            throw new \RuntimeException('Product not found.', 404);
        }

        return $this->render('products/edit', [
            'product'    => $product,
            'categories' => Category::labels(),
            'errors'     => [],
        ]);
    }

    public function update(string $id): Response
    {
        $request = new Request();
        $data    = $request->all();
        $product = $this->products->find((int) $id);

        if ($product === false) {
            throw new \RuntimeException('Product not found.', 404);
        }

        $valid = $this->validator->validate($data, [
            'name'     => 'required|maxlen:255',
            'sku'      => 'required|maxlen:100',
            'price'    => 'required|numeric|min:0',
            'stock'    => 'required|integer|min:0',
            'category' => 'required',
        ]);

        if (!$valid) {
            return $this->render('products/edit', [
                'product'    => array_merge($product, $data),
                'categories' => Category::labels(),
                'errors'     => $this->validator->errors(),
            ]);
        }

        $this->products->update((int) $id, [
            'name'        => trim($data['name']),
            'sku'         => trim($data['sku']),
            'description' => trim($data['description'] ?? ''),
            'price'       => (float) $data['price'],
            'stock'       => (int) $data['stock'],
            'category'    => $data['category'],
        ]);

        return $this->redirect('/');
    }

    public function destroy(string $id): Response
    {
        $this->products->delete((int) $id);
        return $this->redirect('/');
    }

    public function show(string $id): Response
    {
    $product = $this->products->find((int) $id);
    if ($product === false) {
        throw new \RuntimeException('Product not found.', 404);
    }
    return $this->render('products/show', compact('product'));
    }

    }
