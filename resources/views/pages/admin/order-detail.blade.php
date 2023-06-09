@extends('layouts.app')

@section('title', 'Order')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                <a href="/admin/order"
                        class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>Order</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/admin">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="/admin/order">Order</a></div>
                    <div class="breadcrumb-item">Order #{{ $order->order_id }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="invoice">
                    <div class="invoice-print">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="invoice-title">
                                    <h2>Order</h2>
                                    <div class="invoice-number">Order #{{ $order->order_id }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <address>
                                            <strong>Shipped To:</strong><br>
                                            {{$order->name}}<br>
                                            {{$order->address}}
                                        </address>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                        <address>
                                            <strong>Order Date:</strong><br>
                                            {{convertDateToIndo($order->date)}}<br><br>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="section-title">Order Summary</div>
                                <p class="section-lead">All items here cannot be deleted.</p>
                                <div class="table-responsive">
                                    <table class="table-striped table-hover table-md table">
                                        <tr>
                                            <th data-width="40">#</th>
                                            <th>Item</th>
                                            <th class="text-right">Price</th>
                                        </tr>
                                        @for ($i = 0; $i < count($items); $i++)
                                        <tr>
                                            <td>{{ $i+1 }}</td>
                                            <td>{{ $items[$i]->name }}</td>
                                            <td class="text-right">{{ convertToRupiah($items[$i]->price) }}</td>
                                        </tr>
                                        @endfor
                                    </table>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 text-right">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Subtotal</div>
                                            <div class="invoice-detail-value">{{ convertToRupiah($subtotal) }}</div>
                                        </div>
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Diskon</div>
                                            <div class="invoice-detail-value">{{ convertToRupiah(calculateDiskon($subtotal, $order->diskon)) }}</div>
                                        </div>
                                        <hr class="mt-2 mb-2">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Total</div>
                                            <div class="invoice-detail-value invoice-detail-value-lg">{{ convertToRupiah(calculatePriceAfter($subtotal, $order->diskon)) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-md-left">
                        <form id="formChangeStatus" action="{{ route('order.update',$order->order_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input id="statusInput" type="hidden" name="status" value="">
                        <div class="mb-3">
                            @if($order->status == 1)
                                <button id="buttonBatal" type="button" class="btn btn-danger btn-icon icon-left">Batalkan Pesanan</button>
                                <button id="buttonKirim" type="button" class="btn btn-primary icon-left">Kirim Pesanan</button>
                            @elseif($order->status == 2)
                                <p class="fs-3">Pesanan telah selesai, pesanan dibatalkan</p>
                            @elseif($order->status == 3)
                                <button type="button" id="buttonTerima" class="btn btn-success icon-left">Selesaikan Pesanan</button>
                            @else
                                <p class="fs-3">Pesanan telah selesai, pesanan telah diterima oleh kustomer</p>
                            @endif
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
    <script>
        $('#buttonBatal').on('click', function() {
            $('#statusInput').val('2');
            $('#formChangeStatus').trigger('submit');
        });

        $('#buttonKirim').on('click', function() {
            $('#statusInput').val('3');
            $('#formChangeStatus').trigger('submit');
        });

        $('#buttonTerima').on('click', function() {
            $('#statusInput').val('4');
            $('#formChangeStatus').trigger('submit');
        });
    </script>
@endpush
