@extends('layouts.template')
@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header justify-content-between d-flex d-inline">
          <h4 class="card-title"> Data Produk</h4>
          <a href="#" data-toggle="modal" data-target="#tambah"><i class="btn btn-sm btn-primary shadow-sm">+ Tambah</i></a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
              <thead class=" text-primary">
                <th>
                    No.
                </th>
                <th>
                  Kode Produk
                </th>
                <th style="width: 30%">
                  Nama
                </th>
                <th>
                  Stok
                </th>
                <th>
                  Harga 1 | 3 | 6
                </th>
                <th>
                  Aksi
                </th>
              </thead>
              <tbody>
                  <?php 
                    $i = 1;
                    ?>
                  @foreach($products as $product)
                  <tr>
                      <td>{{ $i++ }}</td>
                      <td>{{ $product->product_code }}
                    </td>
                      <td>{{ $product->name }}</td>
                      <td>{{ $product->quantity }}</td>
                      <td>@currency($product->price) x1 <br> @currency($product->price3) x3 <br> @currency($product->price6) x6</td>
                      <td>
                          <a href="#" data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                            data-code="{{ $product->product_code }}" data-quantity="{{ $product->quantity }}" data-price="{{ $product->price }}" data-price3="{{ $product->price3 }}" data-price6="{{ $product->price6 }}" data-category="{{ $product->category_id }}"  data-toggle="modal" data-target="#edit"><i class="fas fa-edit"></i></a>
                          <a href="#" data-target="#delete" data-toggle="modal" data-id="{{ $product->id }}"><i class="fas fa-trash"></i></a>
                          <a href="#" data-id="{{ $product->id }}" data-toggle="modal" data-target="#print"><i class="fas fa-print"></i></a>
                      </td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.product.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Ubah</span> Data Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               
                <div class="modal-body">
                    <div class="form-group">
                        <label for="product_code">Kode Produk</label>
                        <input type="text" class="form-control @error('product_code') is-invalid @enderror" id="product_code" name="product_code">
                        @error('product_code')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                        @error('name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category_id">Kategori Produk</label>
                        <select name="category_id" id="category_id" class="custom-select @error('category_id') is-invalid @enderror">
                            <option value="">~ Pilih Kategori Produk ~</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="quantity">Jumlah</label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" required>
                        @error('quantity')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="row input_fields_wrap">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="price">Harga 1</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" required>
                                @error('price')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="price3">Harga 3</label>
                                <input type="number" class="form-control @error('price3') is-invalid @enderror" id="price3" name="price3" required>
                                @error('price3')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="price6">Harga 6</label>
                                <input type="number" class="form-control @error('price6') is-invalid @enderror" id="price6" name="price6" required>
                                @error('price6')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
             
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.product.delete') }}" method="POST">
                @csrf
                @method('delete')
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Hapus</span> Data Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus Data Produk ini ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="print" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.product.printBarcode') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Print</span>Barcode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               
                <div class="modal-body">
                    <div class="form-group">
                        <label for="banyak">Berapa Stiker?</label>
                        <select name="banyak" id="banyak">
                            <option value="1">3</option>
                            <option value="2">6</option>
                            <option value="3">9</option>
                            <option value="4">12</option>
                            <option value="5">15</option>
                            <option value="6">18</option>
                            <option value="7">21</option>
                            <option value="8">24</option>
                            <option value="9">27</option>
                            <option value="10">30</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.product.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Tambah</span> Data Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>
                        <input type="checkbox" name="otomatic" id="otomatic" value="yes" checked><a style="color: orange" data-toggle="tooltip" title="Centang jika ingin membuat kode produk otomatis"> Kode Produk otomatis</a> 
                    </label>
                    <div class="form-group">
                        <label for="product_code">Kode Produk</label>
                        <input type="text" class="form-control @error('product_code') is-invalid @enderror" id="product_code" name="product_code" value="{{ old('product_code') }}">
                        @error('product_code')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category_id">Kategori Produk</label>
                        <select name="category_id" id="category_id" class="custom-select @error('category_id') is-invalid @enderror">
                            <option value="">~ Pilih Kategori Produk ~</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="quantity">Jumlah</label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}" required>
                        @error('quantity')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="row input_fields_wrap">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="price">Harga 1</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                                @error('price')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="price3">Harga 3</label>
                                <input type="number" class="form-control @error('price3') is-invalid @enderror" id="price3" name="price3" value="{{ old('price3') }}" required>
                                @error('price3')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="price6">Harga 6</label>
                                <input type="number" class="form-control @error('price6') is-invalid @enderror" id="price6" name="price6" value="{{ old('price6') }}" required>
                                @error('price6')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    });

    $("#edit").on('show.bs.modal', (e) => {
        var id = $(e.relatedTarget).data('id');
        var code = $(e.relatedTarget).data('code');
        var name = $(e.relatedTarget).data('name');
        var quantity = $(e.relatedTarget).data('quantity');
        var price = $(e.relatedTarget).data('price');
        var price3 = $(e.relatedTarget).data('price3');
        var price6 = $(e.relatedTarget).data('price6');
        var category = $(e.relatedTarget).data('category');
        
        $('#edit').find('input[name="id"]').val(id);
        $('#edit').find('input[name="product_code"]').val(code);
        $('#edit').find('input[name="name"]').val(name);
        $('#edit').find('input[name="quantity"]').val(quantity);
        $('#edit').find('input[name="price"]').val(price);
        $('#edit').find('input[name="price3"]').val(price3);
        $('#edit').find('input[name="price6"]').val(price6);
        $('#edit').find('select[name="category_id"]').val(category);
    });
    
    $('#delete').on('show.bs.modal', (e) => {
        var id = $(e.relatedTarget).data('id');
        console.log(id);
        $('#delete').find('input[name="id"]').val(id);
    });

    $("#print").on('show.bs.modal', (e) => {
        var id = $(e.relatedTarget).data('id');

        $('#print').find('input[name="id"]').val(id);
    });
</script>
@endpush