@extends('layouts.template')
@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header justify-content-between d-flex d-inline">
          <h4 class="card-title"> Data Produk</h4>
        </div>
        <div class="ml-3">
            <button onclick="window.location.reload();" class="btn btn-sm btn-primary">
                <i class="now-ui-icons loader_refresh"></i> Refresh
            </button>
        </div>
        <div class="card-body">
                    <form action="{{ route('kasir.product.index') }}">
            
                <div class="row">
                        <div class="col-4">
                            <label for="search_product">Cari Kode Produk / Nama :</label>
                            <input type="text" id="search_product" name="search_product" value="{{Request::get('search_product')}}" class="form-control" autofocus>
                        </div>
                        <div class="col-4 mt-3">
                            <input type="submit" value="Cari" class="btn btn-primary btn-sm text-white">
                        </div>
                </div>
            </form>
            <form action="{{ route('kasir.product.index') }}">
                <input type="submit" value="Lihat Semua Data" class="btn btn-warning text-white">
            </form>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead class=" text-primary">
                <tr>
                    <td>
                        No.
                    </td>
                    <td>
                      Kode Produk
                    </td>
                    <td style="width: 30%">
                      Nama
                    </td>
                    <td>
                      Stok
                    </td>
                    <td>
                      Harga 1 | 3 | 6
                    </td>
                </tr>
              </thead>
              <tbody>
                  <?php 
                    $i = 1;
                    ?>
                @foreach($products as $key => $product)
                <tr>
                    <td>{{ $products->firstItem() + $key }}</td>
                    <td>{{ $product->product_code }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>@currency($product->price) x1 <br> @currency($product->price3) x3 <br> @currency($product->price6) x6</td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
            {{  $products->appends(request()->input())->links()}}
          </div>
        </div>
      </div>
    </div>
  </div>
  
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    });

</script>
@endpush