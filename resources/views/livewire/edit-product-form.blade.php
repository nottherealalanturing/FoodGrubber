<div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal content -->
            <form wire:submit.prevent="updateProduct" enctype="multipart/form-data">
                <!-- Hidden input for product ID -->
                <input type="hidden" wire:model="productId">
                <!-- Product fields -->
                <div class="modal-body">
                    <!-- Remaining form fields -->
                    <div class="row g-2">
                        <div class="col-md-6 mb-0">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" wire:model="name" class="form-control" value="{{ $product->name }}" required />
                        </div>
                        <div class="col-md-6 mb-0">
                            <label for="price" class="form-label">Price</label>
                            <div class="input-group">
                                <span class="input-group-text">&#8358;</span>
                                <input type="number" class="form-control"
                                    aria-label="Text input with 2 dropdown buttons" id="price" name="price"
                                    required />
                            </div>
                        </div>
                        <div class="col-md-6 mb-0">
                            <label for="price" class="form-label">Measurement</label>
                            <input type="text" class="form-control" id="measurement" name="measurement"
                                placeholder="kg, wrap, carton..." required />
                        </div>
                        <div class="col-md-6 mb-0">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category"
                                aria-label="Default select example" required>
                                <option value="">...select product category...</option>
                                {{-- @foreach ($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach --}}
                            </select>
                        </div>
                        <div class="col-md-12 mb-0">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="5" required></textarea>
                        </div>
                        <div class="col-md-6 mb-0">
                            <label for="image1" class="form-label">Image 1</label>
                            <input type="file" id="image1" name="image1" class="form-control" required />
                        </div>
                        <div class="col-md-6 mb-0">
                            <label for="image2" class="form-label">Image 2</label>
                            <input type="file" id="image2" name="image2" class="form-control" />
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
