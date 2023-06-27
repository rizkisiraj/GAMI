
@extends('layouts.customer_app')

@section('title', 'GAMI')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
        <!-- Product section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0 rounded" src="{{ Storage::exists('public/img/itemImages/' . $product->image_url) ? url('storage/img/itemImages/' . $product->image_url) : 'https://dummyimage.com/600x400/bababa/000000&text=No+image+Available' }}" alt="{{ $product->name }}" /></div>
                    <div class="col-md-6">
                        <span class="badge bg-secondary mb-2">{{ $product->category_name }}</span>
                        <h1 class="display-5 fw-bolder">{{ $product->name }}</h1>
                        <div class="fs-5 mb-5">
                            <span>{{ convertToRupiah($product->price) }}</span>
                        </div>
                        {!! $product->description !!} <br>
                        <span><strong>Type : </strong>{{ $product->sex}}</span> <br>
                        <span><strong>Color : </strong>{{ $product->color_name}}</span> <br>
                        <span><strong>Size : </strong>{{ $product->size}}</span> <br>
                        <span><strong>Condition : </strong>{{ $product->condition}}</span> <br>
                        <span><strong>Origin : </strong>{{ $product->region_of_origin}}</span> <br>
                        <div class="d-flex mt-2">
                          <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button id="addToCart" class="btn btn-outline-dark flex-shrink-0" type="submit">
                                <i class="bi-cart-fill me-1"></i>
                                Add to cart
                            </button>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Related items section-->
        <section class="py-5 bg-light">
            <div class="container px-4 px-lg-5 mt-5">
                <h2 class="fw-bolder mb-4">Related products</h2>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                  @foreach ($recommendedProducts as $rec_product)
                      <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="{{ Storage::exists('public/img/itemImages/' . $rec_product->image_url) ? url('storage/img/itemImages/' . $rec_product->image_url) : 'https://dummyimage.com/400x300/bababa/000000&text=No+image+Available' }}" alt="{{ $rec_product->name }}" />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{ $rec_product->name }}</h5>
                                    <!-- Product price-->
                                    <span>{{ convertToRupiah($rec_product->price) }}</span>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="/barang/{{$rec_product->id}}">View Details</a></div>
                            </div>
                        </div>
                    </div>
                  @endforeach
                </div>
            </div>
        </section>
@endsection

@push('scripts')
        <script>
          
        </script>
@endpush