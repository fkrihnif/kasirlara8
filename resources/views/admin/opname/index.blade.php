@extends('layouts.template')
@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header justify-content-between d-flex d-inline">
          <h4 class="card-title"> Data Opname</h4>
          <a href="#" data-toggle="modal" data-target="#tambah"><i class="btn btn-sm btn-primary shadow-sm">+ Tambah</i></a>
        </div>
        <div class="ml-3 justify-content-between d-flex d-inline mr-2">
            <button onclick="window.location.reload();" class="btn btn-sm btn-primary">
                <i class="now-ui-icons loader_refresh"></i> Refresh
            </button>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.opname.index') }}">
            
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
                <form action="{{ route('admin.opname.index') }}">
                    <input type="submit" value="Semua Data" class="btn btn-warning text-white">
                </form>
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
              <thead>
                <th>
                  No
                </th>
                <th>
                    Tanggal
                </th>
                <th>
                  Barcode
                </th>
                <th>
                  Nama Barang
                </th>
                <th>
                  Qty
                </th>
                <th>
                  Aksi
                </th>
              </thead>
              <tbody>
                  @foreach($opnames as $key => $opname)
                  <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{ date('d M Y H:i:s', strtotime($opname->created_at)) }}</td>
                      <td>{{ $opname->product->product_code }}</td>
                      <td>{{ $opname->product->name }}</td>
                      @if ($opname->quantity[0] != '-')
                      <td>+{{ $opname->quantity }}</td>                          
                      @else
                      <td>{{ $opname->quantity }}</td>
                      @endif
                      <td>
                          <a href="#" data-target="#delete" data-toggle="modal" data-id="{{ $opname->id }}"><i class="fas fa-trash"></i></a>
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
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.opname.delete') }}" method="POST">
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
                    Apakah Anda yakin ingin menghapus Data Opname ini ?
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
            <form action="{{ route('admin.opname.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Perbarui</span> Data Barang</h5>
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
                            <button type="button" id="tambahKolom" class="btn btn-primary add_field_button" style="margin-top: 27px;">Tambah</button>
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
</script>
@endpush
