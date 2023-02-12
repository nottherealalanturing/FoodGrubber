<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class EditProductForm extends Component
{
    public $productId;
    public $name;
    public $price;
    public $measurement;
    public $category;
    public $description;
    public $image1;
    public $image2;

    public function mount($productId)
    {
        $product = Product::findOrFail($productId);
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->measurement = $product->measurement;
        $this->category = $product->category;
        $this->description = $product->description;
        // Set other properties as needed
    }

    public function render()
    {
        // return view('livewire.edit-product-form');

        return view('livewire.edit-product-form', [
            'product' => Product::findOrFail($this->productId),
        ]);
    }

    public function updateProduct()
    {
        // Handle updating the product here
    }

    public function editProduct($productId)
    {
        $product = Product::findOrFail($productId);
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->measurement = $product->measurement;
        $this->category = $product->category;
        $this->description = $product->description;
    }
}
