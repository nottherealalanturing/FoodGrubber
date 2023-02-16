<div class="card h-100 product-card" data-name="{{ strtolower($product->name) }}">
    {{-- <img class="card-img-top"
        src="{{ $product->image1 ? asset('img/products/' . $product->image1) : asset('img/products/no-product-image.png') }}"
        alt="Product Image" style="height: 200px; object-fit:cover;" /> --}}
    @if ($product->image1)
        <img class="card-img-top" src="{{ $product->image1 }}" alt="Product Image"
            style="height: 200px; object-fit: cover;" />
    @else
        <img class="card-img-top" src="{{ asset('img/default_store_logo.jpg') }}" alt="Product Image"
            style="height: 200px; object-fit: cover;" />
    @endif

    <div class="card-body text-start">
        <h6 class="card-subtitle text-muted mb-3">({{ $product->category }})</h6>
        <h5 class="card-title">{{ $product->name }}</h5>
        <p class="card-text">
            {{ $product->description ? Str::words($product->description, 10, '...') : 'No product description available' }}
        </p>
        <h5 class="card-title">&#8358;{{ $product->price }}</h5>
        <div class="btn-group flex justify-center" role="group" aria-label="First group">
            @if ($product->availability == 1)
                <button type="button" class="btn btn-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Deactivate" wire:click="deactivate">
                    <i class="tf-icons bx bx-lock" style="color: #f0ad4e;"></i>
                </button>
            @else
                <button type="button" class="btn btn-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Activate" wire:click="activate">
                    <i class="tf-icons bx bx-lock-open-alt" style="color: #14A44D;"></i>
                </button>
            @endif

            {{-- <button type="button" class="btn btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                <i class="tf-icons bx bx-pencil" style="color: #17a2b8;"></i>
            </button> --}}

            <button type="button" class="btn btn-icon" data-bs-toggle="modal"
                data-bs-target="#editProductModal{{ $product->id }}">
                <i class="tf-icons bx bx-pencil" style="color: #17a2b8;"></i>
            </button>

            <button type="button" class="btn btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                wire:click="delete">
                <i class="tf-icons bx bx-trash" style="color: #dc3545;"></i>
            </button>
        </div>
    </div>

    @if ($product->availability == 0)
        <div class="card-f bg-danger text-white text-center"
            style="height: 20px !important; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
            <p style="margin-top:-2px;">inactive</p>
        </div>
    @endif

    <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editProductForm" method="POST" action="{{ route('product.update', $product->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col-md-6 mb-0">
                                <label for="name{{ $product->id }}" class="form-label">Product Name</label>
                                <input type="text" id="name{{ $product->id }}" name="name" class="form-control" value="{{ $product->name }}" required />
                            </div>
                            <div class="col-md-6 mb-0">
                                <label for="price{{ $product->id }}" class="form-label">Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">&#8358;</span>
                                    <input type="number" class="form-control"
                                        aria-label="Text input with 2 dropdown buttons" id="price{{ $product->id }}" name="price"
                                        value="{{ $product->price }}" required />
                                </div>
                            </div>
                            <div class="col-md-6 mb-0">
                                <label for="measurement{{ $product->id }}" class="form-label">Measurement</label>
                                <input type="text" class="form-control" id="measurement{{ $product->id }}" name="measurement"
                                    placeholder="kg, wrap, carton..." value="{{ $product->measurement }}" required />
                            </div>
                            <div class="col-md-6 mb-0">
                                <label for="category{{ $product->id }}" class="form-label">Category</label>
                                <input type="text" class="form-control" id="category{{ $product->id }}" name="category"
                                    value="{{ $product->category }}" required />
                            </div>
                            <div class="col-md-12 mb-0">
                                <label for="description{{ $product->id }}" class="form-label">Description</label>
                                <textarea class="form-control" id="description{{ $product->id }}" name="description" rows="5" required>{{ $product->description }}</textarea>
                            </div>
                            <div class="col-md-6 mb-0">
                                <label for="image1{{ $product->id }}" class="form-label">Replace Image</label>
                                <input type="file" id="image1{{ $product->id }}" name="image1" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
