@extends('layouts.template')
@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header justify-content-between d-flex d-inline">
          <h4 class="card-title"> Laporan Transaksi</h4>
        </div>
        <div class="ml-3">
            <button onclick="window.location.reload();" class="btn btn-sm btn-primary">
                <i class="now-ui-icons loader_refresh"></i> Refresh
            </button>
        </div>
        <i style="color: grey; font-size:90%" class="ml-3">Secara default menampilkan penjualan hari ini, silahkan filter tanggal untuk melakukan pencarian</i>
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
                <input type="submit" value="Lihat hari ini" class="btn btn-warning text-white">
            </form>

            @if (Request::get('to_date'))
            <p>Total Pendapatan dari Tanggal <br>{{ Request::get('from_date') }} sampai {{ Request::get('to_date') }} =<b> @currency($total_earn)</b></p>
            @else
            <p>Total Pendapatan Hari Ini :<b> @currency($total_earn)</b></p>
            @endif


            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
            <thead>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Online/Offline</th>
                <th>Metode Pembayaran</th>
                <th>Total Penjualan</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </thead>
              <tbody>
                  @foreach($transactions as $key => $transaction)
                  <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{ $transaction->transaction_code }} <div style="font-size: 75%">{{ $transaction->user->name }}</div></td>
                      <td>{{ $transaction->method }}</td>
                      <td>
                        @if ($transaction->customer_name != null or $transaction->account_number != null)
                          {{ $transaction->payment_method }} <br>
                          {{ $transaction->customer_name ?? '' }} 
                         - {{ $transaction->account_number ?? '' }}
                          @else
                          Tunai
                        @endif
                      </td>
                      <td>@currency($transaction->purchase_order)</td>
                      <td>{{ date('d M Y H:i:s', strtotime($transaction->created_at)) }}</td>
                      <td>
                          <a href="{{ route('admin.report.show', $transaction->id) }}"><i class="fas fa-eye"></i></a>
                          <a href="#" data-target="#delete" data-toggle="modal" data-id="{{ $transaction->id }}"><i class="fas fa-trash"></i></a>
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