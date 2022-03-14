@extends('layouts.template')
@section('content')
<style>
    .card-header{
        background-color: #1B3A5D !important;
        color: white !important;
    }
    .fa-eye:hover {
        cursor: pointer;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="pesan">

</div>
<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-header justify-content-between d-flex d-inline">
                <h5 class="card-title">Order Produk</h5>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <label for="get_product_code">Barcode Produk</label>
                        <select class="js-example-basic-single" name="get_product_code" id="get_product_code" required style="width: 100% !important;">
                            <option value="" selected></option>
                            @foreach($products as $product)
                                <option value="{{ $product->product_code }}">{{ $product->product_code }}</option>
                            @endforeach
                            </select>
                    </div>
                    <div class="col-3">
                        <label for="get_product_quantity">Jumlah</label>
                        <input type="number" id="get_product_quantity" disabled placeholder="Jumlah" class="form-control" min="0">
                    </div>
                    <div class="col-3">
                        <label for="get_product_disc_rp">Discount Rp</label>
                        <input type="number" id="get_product_disc_rp" disabled placeholder="Discount Rp" class="form-control" min="0">
                    </div>
                    <div class="col-3">
                        <label for="get_product_disc_prc">Discount %</label>
                        <input type="number" id="get_product_disc_prc" disabled placeholder="Discount %" class="form-control" min="0">
                    </div>
                </div><hr>
                <div class="row">
                    <div class="col-3">
                        <label for="get_product_name">Nama Produk</label>
                        <input type="text" id="get_product_name" disabled placeholder="Nama" class="form-control">
                    </div>
                    <div class="col-3">
                        <label for="get_product_price">Harga</label>
                        <input type="text" id="get_product_price" disabled placeholder="Harga" class="form-control">
                        <input type="hidden" id="get_product_price3" disabled class="form-control">
                        <input type="hidden" id="get_product_price6" disabled class="form-control">
                    </div>
                    <div class="col-3">
                        <label for="get_product_total">Total Harga</label>
                        <input type="text" id="get_product_total" disabled placeholder="Total Harga" class="form-control">
                    </div>
                    <div class="col-3">
                        <div class="col-4" style="margin-top: 10px;">
                            <input type="button" value="Tambahkan" id="addToCart" disabled class="btn btn-primary text-white">
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>Nama Produk</td>
                                <td>Jumlah</td>
                                <td>Harga</td>
                                <td>Diskon</td>
                                <td>Total</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody id="posts-crud">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-header justify-content-between d-flex d-inline">
                <h5 class="card-title" id="totalBuy"></h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.transaction.pay') }}" method="post">
                    @csrf
                    <div class="form-group" id="containerCustomer">
                        <div class="justify-content-between d-flex d-inline">
                            <label for="customer_name" id="l_customer_name">Nama Pembeli</label><i class="fas fa-eye" id="anonym"></i>
                        </div>
                        <input type="text" class="form-control" id="customer_name" name="customer_name">
                    </div>
                    <div class="form-group">
                        <label for="payment">Bayar</label>
                        <input type="number" class="form-control" id="payment" name="payment">
                    </div>
                    <div class="form-group">
                        <label for="return">Kembalian</label>
                        <input type="number" class="form-control" id="return" readonly name="return">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="tPayment" disabled> Bayar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
@endsection
@push('scripts')

  <script>
      
    $(document).ready(function(){
        $('.js-example-basic-single').select2();
        const totalBuy = document.getElementById('totalBuy');
        function fetchstudent() {
            $.ajax({
                type: "GET",
                url: '{{ route('admin.transaction.indexs') }}',
                dataType: "json",
                success: function (response) {
                    $('tbody').html("");
                    $.each(response.data, function (key, item) {
                    if (item.quantity>=1 && item.quantity<=2) {
                        var harga = item.product.price;
                    }else if(item.quantity>=3 && item.quantity<=5) {
                        var harga = item.product.price3;
                    }else if(item.quantity>=6) {
                        var harga = item.product.price6;
                    }
                    let content = `<tr>\
                        <td>${item.product.name}</td>\
                        <td>${item.quantity}</td>\
                        <td>${harga}</td>\
                        <td>${+item.disc_rp + ((item.disc_prc / 100) * (harga * item.quantity)) }</td>\
                        <td>${item.quantity * harga - item.disc_rp - ((item.disc_prc / 100) * (harga * item.quantity))}</td>\
                        <td><button type="button" value="${item.id}" data-id="${item.id}" class="btn btn-danger delete-btn btn-sm">Hapus</button></td>\
                    \</tr>`
                    $('tbody').append(content);
                    });
                }
            });
        }
        fetchstudent();
        getTotalBuy();
        let productCode = document.getElementById('get_product_code');
        let productName = document.getElementById('get_product_name');
        $('.js-example-basic-single').on('change', function(e) {
            $value = $(e.currentTarget).val();
                $.ajax({
                    type: 'GET',
                    url: '{{ route('admin.transaction.getProductCode') }}',
                    dataType: 'json',
                    data: {'search' : $value},
                    success: function (data) {
                        if(data.data ==''){
                            $('#addToCart').prop('disabled', true);
                            $('#get_product_quantity').prop('disabled', true);
                            $('#get_product_quantity').val('');
                            $('#get_product_disc_rp').prop('disabled', true);
                            $('#get_product_disc_rp').val('');
                            $('#get_product_disc_prc').prop('disabled', true);
                            $('#get_product_disc_prc').val('');
                        }else{
                            $('#addToCart').prop('disabled', false);
                            $('#get_product_quantity').prop('disabled', false);
                            $('#get_product_quantity').val('1');
                            $('#get_product_disc_rp').prop('disabled', false);
                            $('#get_product_disc_rp').val('');
                            $('#get_product_disc_prc').prop('disabled', false);
                            $('#get_product_disc_prc').val('');
                        }
                        $('#get_product_name').val(data.data.name);
                        $('#get_product_price').val(data.data.price);
                        $('#get_product_price3').val(data.data.price3);
                        $('#get_product_price6').val(data.data.price6);
                        $('#get_product_total').val(data.data.price);
                    },error:function(data){ 
                        $('#addToCart').prop('disabled', true);
                        $('#get_product_name').val('');
                        $('#get_product_price').val('');
                        $('#get_product_price3').val('');
                        $('#get_product_price6').val('');
                    }
                });
        })
        const addToCart = document.getElementById('addToCart');
        addToCart.addEventListener('click', function() {
            $productCode = $('#get_product_code');
            $productQuantity = $('#get_product_quantity');
            $productDiscRp = $('#get_product_disc_rp');
            $productDiscPrc = $('#get_product_disc_prc');
            $('#addToCart').prop('disabled', true);
            $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    dataType: 'json',
                    data: {'product_code':$productCode.val(),'quantity':$productQuantity.val(),'disc_rp':$productDiscRp.val(),'disc_prc':$productDiscPrc.val()},
                    url: '{{ route('admin.transaction.addToCart') }}',
                    success: function(data){
                        $('#get_product_code').val('');
                        $('#get_product_name').val('');
                        $('#get_product_price').val('');
                        $('#get_product_price3').val('');
                        $('#get_product_price6').val('');
                        $('#get_product_quantity').val('');
                        $('#get_product_disc_rp').val('');
                        $('#get_product_disc_prc').val('');
                        $('#get_product_total').val('');
                        $('.js-example-basic-single').val(0).trigger('change.select2');
                        fetchstudent();
                        getTotalBuy();
                    },
                    error: function(){
                    console.log('gagal');
                }
            })
        })
    
        const customer_container = document.querySelector('.table');
        const thumbs = document.querySelectorAll('tombol');
        customer_container.addEventListener('click', function(e) {
            if(e.target.classList.contains('delete-btn')){
                let id = e.target.dataset.id;
                e.target.disabled = true;
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'DELETE',
                    dataType: 'json',
                    data: {'id':id},
                    url: '{{ route('admin.transaction.deleteCart') }}',
                });
                fetchstudent();
                getTotalBuy();
            }
        })

        const productQuantity = document.getElementById('get_product_quantity');
        const productDiscRp = document.getElementById('get_product_disc_rp');
        const productDiscPrc = document.getElementById('get_product_disc_prc');
        
        [productQuantity, productDiscRp, productDiscPrc].map(element => element.addEventListener('input', function(){        
        let productPrice = document.getElementById('get_product_price');
        let productPrice3 = document.getElementById('get_product_price3');
        let productPrice6 = document.getElementById('get_product_price6');
        let productTotal = document.getElementById('get_product_total');
        if(productQuantity.value>=1 && productQuantity.value<=2) {
                            productPrice.value=productPrice.value;
                        }
                        else if(productQuantity.value>=3 && productQuantity.value<=5){
                            productPrice.value=productPrice3.value;
                        }else if(productQuantity.value>=6){
                            productPrice.value=productPrice6.value;
                        }
        let hasilDiscPrc = (productDiscPrc.value / 100) * (productPrice.value * productQuantity.value);
        let total = productPrice.value * productQuantity.value - productDiscRp.value - hasilDiscPrc;
        productTotal.value = total;

        if($(this).val() = 0){
            $('#addToCart').prop('disabled', true);
        }else{
            $('#addToCart').prop('disabled', false);
            }
        }))

        // productQuantity.addEventListener('change', function() {
        //     let productPrice = document.getElementById('get_product_price');
        //     let productTotal = document.getElementById('get_product_total');
        //     let hasilDiscPrc = (productDiscPrc.value / 100) * (productPrice.value * productQuantity.value);
        //     let total = productPrice.value * productQuantity.value - productDiscRp.value - hasilDiscPrc;
        // productTotal.value = total;
        //     if($(this).val() == 0){
        //         $('#addToCart').prop('disabled', true);
        //     }else{
        //         $('#addToCart').prop('disabled', false);
        //     }
        // })

        function getTotalBuy(){
            $.ajax({
                type: 'GET',
                url: '{{ route('admin.transaction.totalBuy') }}',
                dataType: 'json',
                success: function(data){
                    let totalBuy = document.getElementById('totalBuy');
                    totalBuy.innerHTML = "Total " + formatRupiah(data.data, 'Rp. ');
                },
                error: function(data){
                    console.log('gagal');
                }
            })    
        }
        function formatRupiah(angka, prefix){
			var number_string = angka.toString().replace(/[^,\d]/g, ''),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}
        let anonym = document.getElementById('anonym');
        anonym.addEventListener('click', function(e) {
        let containerCustomer = document.getElementById('customer_name');
        let lContainerCustomer = document.getElementById('l_customer_name');
            if(this.classList.contains('fa-eye')) {
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
                containerCustomer.style.display = 'none';
                lContainerCustomer.style.display = 'none';
            }else{
                this.classList.add('fa-eye');
                this.classList.remove('fa-eye-slash');
                containerCustomer.style.display = 'block';
                lContainerCustomer.style.display = 'block';
            }
        })
        let payment = document.getElementById('payment');
        payment.addEventListener('keyup', function() {
            let tPayment = document.getElementById('tPayment');
            let vReturn = document.getElementById('return');
            let totalBuy = document.getElementById('totalBuy');
            let split = totalBuy.innerHTML.split(' ');
            if(split[2] == 0){
                alert('Belum ada pesanan');
            }
            let result = parseInt(this.value) - split[2].replace('.','') ;
            if(result >= 0) {
                tPayment.disabled = false;
            }else{
                tPayment.disabled = true;
            }
            vReturn.value = result;
        })
    })     
  </script>
@endpush