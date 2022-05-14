@extends('layouts.template')
@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header justify-content-between d-flex d-inline">
          <h4 class="card-title"> Data Pembelian</h4>
          <a href="#" data-toggle="modal" data-target="#tambah"><i class="btn btn-sm btn-primary shadow-sm">+ Tambah</i></a>
        </div>
        <div class="ml-3 justify-content-between d-flex d-inline mr-2">
            <button onclick="window.location.reload();" class="btn btn-sm btn-primary">
                <i class="now-ui-icons loader_refresh"></i> Refresh
            </button>
            <a href="#" data-toggle="modal" data-target="#tambahBaru"><i class="btn btn-sm btn-primary shadow-sm">+ Tambah (Baru)</i></a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.supply.index') }}">
            
                <div class="row">
                        <div class="col-4">
                            <label for="from_date">Dari Tanggal</label>
                            <input type="date" id="from_date" name="from_date" value="{{Request::get('from_date')}}" class="form-control">
                        </div>
                        <div class="col-4">
                            <label for="to_date">Hingga Tanggal</label>
                            <input type="date" id="to_date" name="to_date" value="{{Request::get('to_date')}}" class="form-control">
                        </div>
                        <div class="col-4">
                            <div class="col-4" style="margin-top: 10px;">
                                <input type="submit" value="Cari" class="btn btn-primary text-white">
                            </div>
                        </div>
                </div>
                </form>
                <form action="{{ route('admin.supply.index') }}">
                    <input type="submit" value="Semua Data" class="btn btn-warning text-white">
                </form>
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
              <thead>
                <th>
                  No
                </th>
                <th>
                    Kode
                </th>
                <th>
                  Nama Penjual
                </th>
                <th>
                  Tanggal
                </th>
                <th>
                  Total Item
                </th>
                <th>
                    Total Pembelian
                </th>
                <th>
                  Aksi
                </th>
              </thead>
              <tbody>
                  @php
                      $totalBuy = [];
                  @endphp
                  @foreach($supplies as $key => $supply)
                  <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{ $supply->code }}</td>
                      <td>{{ $supply->supplier_name }}</td>
                      @php
                            $date = \Carbon\Carbon::parse($supply->supply_date)->format('d-m-Y');
                      @endphp
                      <td>{{ $date }}</td>
                      <td>{{ $supply->productSupply()->count() }}</td>
                      <td>@currency($supply->total)</td>
                      <td>
                          <a href="{{ route('admin.supply.show', $supply->id) }}"><i class="fas fa-eye"></i></a>
                          <a href="#" data-target="#delete" data-toggle="modal" data-id="{{ $supply->id }}"><i class="fas fa-trash"></i></a>
                      </td>
                  </tr>
                  @php
                  $totalBuy[] = $supply->total;
                  @endphp
                  @endforeach
                  
                    @php
                    $total = array_sum($totalBuy);
                    @endphp
                    <p>Total Keseluruhan: @currency($total)</p>
                  
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.supply.delete') }}" method="POST">
                @csrf
                @method('delete')
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Hapus</span> Data Pembelian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus Data Pembelian ini ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" id="tambah" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">

    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.supply.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Tambah</span> Data Pembelian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row input_fields_wrap">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="product_code">Kode Produk</label>
                                <input list="code" name="product_code[]" id="product_id">
                                    <datalist id="code">
                                        @foreach($products as $product)
                                        <option value="{{ $product->product_code }}">{{ $product->name }}</option>
                                        @endforeach
                                    </datalist>
                                @error('product_id')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="quantity">Jumlah</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity[]" value="{{ old('quantity') }}" required autocomplete="off">
                                @error('quantity')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="price">Harga Modal</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price[]" value="{{ old('price') }}" required autocomplete="off">
                                @error('price')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <button type="button" id="tambahKolom" class="btn btn-primary add_field_button" style="margin-top: 27px;">Tambah</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="supplier_name">Nama Penjual</label>
                        <input type="text" class="form-control @error('supplier_name') is-invalid @enderror" id="supplier_name" name="supplier_name" value="{{ old('supplier_name') }}">
                        @error('supplier_name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="supply_date">Tanggal</label>
                        <input type="date" class="form-control @error('supply_date') is-invalid @enderror" id="supply_date" name="supply_date" value="{{ old('supply_date') }}">
                        @error('supply_date')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
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

<div class="modal fade bd-example-modal-xl" id="tambahBaru" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">

    <div class="modal-dialog modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.supply.storeNew') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Tambah</span> Data Pembelian (Barang Baru)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row input_fields_wrap_new">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="product_name">Nama Barang</label>
                                <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name[]" value="{{ old('product_name') }}" required autocomplete="off">
                                @error('product_name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="category_id">Kategori</label>
                                <select name="category_id[]" id="category_id" class="custom-select @error('category_id') is-invalid @enderror">
                                    <option value="">~ Pilih Kategori ~</option>
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
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="quantity">Jumlah</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity[]" value="{{ old('quantity') }}" required autocomplete="off">
                                @error('quantity')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="price">Harga Modal</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price[]" value="{{ old('price') }}" required autocomplete="off">
                                @error('price')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="price1">Harga Jual 1</label>
                                <input type="number" class="form-control @error('price1') is-invalid @enderror" id="price1" name="price1[]" value="{{ old('price1') }}" required autocomplete="off">
                                @error('price1')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="price3">Harga Jual 3</label>
                                <input type="number" class="form-control @error('price3') is-invalid @enderror" id="price3" name="price3[]" value="{{ old('price3') }}" required autocomplete="off">
                                @error('price3')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="price6">Harga Jual 6</label>
                                <input type="number" class="form-control @error('price6') is-invalid @enderror" id="price6" name="price6[]" value="{{ old('price6') }}" required autocomplete="off">
                                @error('price6')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <button type="button" id="tambahKolomNew" class="btn btn-primary add_field_button_new" style="margin-top: 27px;">Tambah</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="supplier_name">Nama Penjual</label>
                                <input type="text" class="form-control @error('supplier_name') is-invalid @enderror" id="supplier_name" name="supplier_name" value="{{ old('supplier_name') }}">
                                @error('supplier_name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="supply_date">Tanggal</label>
                                <input type="date" class="form-control @error('supply_date') is-invalid @enderror" id="supply_date" name="supply_date" value="{{ old('supply_date') }}">
                                @error('supply_date')
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
    $("#edit").on('show.bs.modal', (e) => {
        var id = $(e.relatedTarget).data('id');
        var code = $(e.relatedTarget).data('code');
        var name = $(e.relatedTarget).data('name');
        var quantity = $(e.relatedTarget).data('quantity');
        var price = $(e.relatedTarget).data('price');
        $('#edit').find('input[name="id"]').val(id);
        $('#edit').find('input[name="product_code"]').val(code);
        $('#edit').find('input[name="name"]').val(name);
        $('#edit').find('input[name="quantity"]').val(quantity);
        $('#edit').find('input[name="price"]').val(price);
    });
    
    $('#delete').on('show.bs.modal', (e) => {
        var id = $(e.relatedTarget).data('id');
        console.log(id);
        $('#delete').find('input[name="id"]').val(id);
    });

    //utk tambah yg sudah ada
    $(document).ready(function() {
        var max_fields      = 50; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID

        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append(`
                    <div class="container">
                        <div class="row input_fields_wrap">
                            <div class="col-3">
                                <div class="form-group">
                                <label for="product_code">Kode Produk</label>
                                <input list="code" name="product_code[]" id="product_id">
                                    <datalist id="code">
                                        @foreach($products as $product)
                                        <option value="{{ $product->product_code }}"></option>
                                        @endforeach
                                    </datalist>
                                @error('product_id')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="quantity">Jumlah</label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity[]" value="{{ old('quantity') }}" required autocomplete="off">
                                    @error('quantity')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="price">Harga Modal</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price[]" value="{{ old('price') }}" required autocomplete="off">
                                    @error('price')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-3">
                                <button type="button" class="btn btn-primary remove_field" style="margin-top: 27px;">Hapus</button>
                            </div>
                        </div>
                    </div>`); //add input box
            }
        });

        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); 
            $(this).parent().parent().remove(); x--;
        })
    });

        //utk tambah yg barang baru
        $(document).ready(function() {
        var max_fields_new      = 50; //maximum input boxes allowed
        var wrapper_new         = $(".input_fields_wrap_new"); //Fields wrapper
        var add_button_new      = $(".add_field_button_new"); //Add button ID

        var x = 1; //initlal text box count
        $(add_button_new).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields_new){ //max input box allowed
                x++; //text box increment
                $(wrapper_new).append(`
                <div class="container">
                    <hr>
                    <div class="row input_fields_wrap_new">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="product_name">Nama Barang</label>
                                <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name[]" value="{{ old('product_name') }}" required autocomplete="off">
                                @error('product_name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="category_id">Kategori</label>
                                <select name="category_id[]" id="category_id" class="custom-select @error('category_id') is-invalid @enderror">
                                    <option value="">~ Pilih Kategori ~</option>
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
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="quantity">Jumlah</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity[]" value="{{ old('quantity') }}" required autocomplete="off">
                                @error('quantity')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="price">Harga Modal</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price[]" value="{{ old('price') }}" required autocomplete="off">
                                @error('price')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="price1">Harga Jual 1</label>
                                <input type="number" class="form-control @error('price1') is-invalid @enderror" id="price1" name="price1[]" value="{{ old('price1') }}" required autocomplete="off">
                                @error('price1')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="price2">Harga Jual 3</label>
                                <input type="number" class="form-control @error('price2') is-invalid @enderror" id="price2" name="price3[]" value="{{ old('price2') }}" required autocomplete="off">
                                @error('price2')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="price3">Harga Jual 6</label>
                                <input type="number" class="form-control @error('price3') is-invalid @enderror" id="price3" name="price6[]" value="{{ old('price3') }}" required autocomplete="off">
                                @error('price3')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                                <button type="button" class="btn btn-primary remove_field_new" style="margin-top: 27px;">Hapus</button>
                        </div>
                    </div>
                </div>`); //add input box
            }
        });

        $(wrapper_new).on("click",".remove_field_new", function(e){ //user click on remove text
            e.preventDefault(); 
            $(this).parent().parent().remove(); x--;
        })
    });
</script>
@endpush
