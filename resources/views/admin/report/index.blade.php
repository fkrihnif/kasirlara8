@extends('layouts.template')
@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header justify-content-between d-flex d-inline">
          <h4 class="card-title"> Laporan Transaksi</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.report.index') }}">
            
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
            <form action="{{ route('admin.report.index') }}">
                <input type="submit" value="Semua Data" class="btn btn-warning text-white">
            </form>

          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
            <thead>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Online/Offline</th>
                <th>Total Penjualan</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </thead>
              <tbody>
                @php
                $totalOrder = [];
                @endphp
                  @foreach($transactions as $key => $transaction)
                  <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{ $transaction->transaction_code }}</td>
                      <td>{{ $transaction->method }}</td>
                      <td>{{ format_uang($transaction->purchase_order) }}</td>
                      <td>{{ date('d-m-Y H:i:s', strtotime($transaction->created_at)) }}</td>
                      <td>
                          <a href="{{ route('admin.report.show', $transaction->id) }}"><i class="fas fa-eye"></i></a>
                          <a href="#" data-target="#delete" data-toggle="modal" data-id="{{ $transaction->id }}"><i class="fas fa-trash"></i></a>
                      </td>
                  </tr>
                  @php
                  $totalOrder[] = $transaction->purchase_order;
                  @endphp
                  @endforeach
                  <tr>
                    @php
                    $total = array_sum($totalOrder);
                    @endphp
                    <p>Total Keseluruhan: {{ format_uang($total)  }}</p>
                  </tr>
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
            <form action="{{ route('admin.report.delete') }}" method="POST">
                @csrf
                @method('delete')
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Hapus</span> Laporan Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus Laporan Transaksi ini ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#delete').on('show.bs.modal', (e) => {
        var id = $(e.relatedTarget).data('id');
        console.log(id);
        $('#delete').find('input[name="id"]').val(id);
    });
</script>
@endpush