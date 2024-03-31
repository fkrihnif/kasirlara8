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
                <h5 class="card-title">Transaksi</h5>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <label for="get_product_code">Barcode Produk</label>
                        <input type="text" id="get_product_code" placeholder="scan barcode" class="form-control" autofocus autocomplete="off">
                    </div>
                    <div class="col-3" style="margin-top:10px;">
                        <input type="button" value="Cari (Enter)" id="addToCart" class="btn btn-primary text-white">
                    </div>
                    <div class="col-3">
                        {{-- <label for="get_product_quantity">Jumlah</label> --}}
                        <input type="number" hidden id="get_product_quantity" disabled placeholder="Jumlah" class="form-control" min="0">
                    </div>
                    <div class="col-3">
                        {{-- <label for="get_product_disc_rp">Discount Rp</label> --}}
                        <input type="number" hidden id="get_product_disc_rpp" disabled placeholder="Discount Rp" class="form-control" min="0">
                    </div>
                    <div class="col-3">
                        {{-- <label for="get_product_disc_prc">Discount %</label> --}}
                        <input type="number" hidden id="get_product_disc_prcc" disabled placeholder="Discount %" class="form-control" min="0">
                    </div>
                </div>
                <div class="row">
                    <div class="col"><small><i>F2 utk edit barang terakhir, F8 utk hapus barang terakhir, Shift+F8 Hapus Semua</i></small></div>
                </div>
                <div class="table-responsive mt-3">
                    <div class="overflow-auto" style="height:420px;
                    overflow-y: scroll;">
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
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-header justify-content-between d-flex d-inline">
                <h5 class="card-title" id="totalBuy"></h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.transaction-new.pay') }}" method="post">
                    @csrf
                    <label>
                        <input type="radio" name="method" id="method" value="offline" checked> Offline
                    </label> |
                    <label>
                        <input type="radio" name="method" id="method" value="online"> Online
                    </label>
                    <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Metode Pembayaran
                    </a>
                      <div class="collapse" id="collapseExample">
                        <label>
                            <input type="checkbox" name="payment_method" id="payment_method" value="Kartu"> Kartu
                        </label> |
                        <label>
                            <input type="checkbox" name="payment_method" id="payment_method" value="Transfer"> Transfer
                        </label> |
                        <label>
                            <input type="checkbox" name="payment_method" id="payment_method" value="QR Code"> QR Code
                        </label>
                        <div class="card card-body">
                            <div class="form-group">
                                <label for="customer_name" id="l_customer_name">Bank/Nama</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="account_number" id="account_number">Nomor Rek</label>
                                <input type="text" class="form-control" id="account_number" name="account_number" autocomplete="off">
                            </div>
                        </div>
                      </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="get_total_disc_rp">Discount Rp</label>
                                <input type="number" class="form-control" id="get_total_disc_rp" name="get_total_disc_rp">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="get_total_disc_prc">Discount %</label>
                                <input type="number" class="form-control" id="get_total_disc_prc" name="get_total_disc_prc">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="payment">Bayar (F9)</label>
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


<!-- Modal edit -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="productTransaction_id">

                <div class="form-group">
                    <label for="name_product" class="control-label">Nama Produk</label>
                    <input type="text" class="form-control" id="name-product-edit" disabled>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="get_product_disc_rp" class="control-label">Harga 1</label>
                            <input type="number" class="form-control" id="price-product-edit" disabled>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="get_product_disc_prc" class="control-label">Harga 3</label>
                            <input type="number" class="form-control" id="price3-product-edit" disabled>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="get_product_disc_prc" class="control-label">Harga 6</label>
                            <input type="number" class="form-control" id="price6-product-edit" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="quantity" class="control-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity-edit" autofocus>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-quantity-edit"></div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="get_product_disc_rp" class="control-label">Disc Rp</label>
                            <input type="number" class="form-control" id="get_product_disc_rp">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="get_product_disc_prc" class="control-label">Disc %</label>
                            <input type="number" class="form-control" id="get_product_disc_prc">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="button" class="btn btn-primary" id="update-quantity">UPDATE (F4)</button>
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
                url: '{{ route('admin.transaction-new.indexs') }}',
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
                    var hargaa = formatRupiah(harga);
                    var total = item.quantity * harga - item.disc_rp - ((item.disc_prc / 100) * (harga * item.quantity));
                    var totalRp = formatRupiah(total);
                    let content = `<tr>\
                        <td>${item.product.name}</td>\
                        <td>${item.quantity}</td>\
                        <td>${hargaa}</td>\
                        <td>${+item.disc_rp + ((item.disc_prc / 100) * (harga * item.quantity)) }</td>\
                        <td>${totalRp}</td>\
                        <td>  <a href="javascript:void(0)" value="${item.id}" data-id="${item.id}" class="btn btn-primary btn-sm edit-btn">EDIT</a>
                            <button type="button" value="${item.id}" data-id="${item.id}" class="btn btn-danger delete-btn btn-sm">Hapus</button>
                        </td>\
                    \</tr>`
                    $('tbody').append(content);
                    });
                }
            });
        }
        fetchstudent();
        getTotalBuy();

        let productCode = document.getElementById('get_product_code');
        let productCode2 = document.getElementById('get_product_code2');
        let productName = document.getElementById('get_product_name');
   
        const addToCart = document.getElementById('addToCart');
        const addToCart2 = document.getElementById('addToCart2');
        $(function() {
            $(document).keydown(function(e) {
                if (!$("#addToCart").is(":disabled")) {
                    switch(e.which) { 
                    case 13: // up key
                        tambahkan();
                    } 
                }
                if (!$("#tPayment").is(":disabled")) {
                    switch(e.which) { 
                    case 121: // up key
                        $('#tPayment').trigger('click');
                    } 
                }
                switch(e.which) { 
                case 120:
                    $("#payment").focus();
                }
                
                if (e.which == 113) {
                    //f2
                    editLastProduct();
                }
                if (e.which == 119) {
                    //f8
                    deleteLastProduct();
                }

                if (e.which == 115) {
                    //f4
                    $('#update-quantity').trigger('click');
                }

                if (e.which == 16) {
                    // shift
                    $("#get_product_code").focus();
                }
            });

            var map = {}; // You could also use an array
            onkeydown = onkeyup = function(e){
                e = e || event; // to deal with IE
                map[e.keyCode] = e.type == 'keydown';
                /* insert conditional here */
                //DELETE ALL PRODUCT IN CART
                if(map[16] && map[119]){ // SHIFT+F8
                    deleteAllCart();
                    map = {};
                }
            }
        });
        
        addToCart.addEventListener('click', function() {
            tambahkan();
        })
        function tambahkan() {
            $productCode = $('#get_product_code');            
            if ($productCode.val() != '') {
                $productCode = $('#get_product_code');
            } else {
                $productCode = $('#get_product_code2');
            }

            if ($productCode.val() != ''){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    dataType: 'json',
                    data: {'product_code':$productCode.val()},
                    url: '{{ route('admin.transaction-new.addToCart') }}',
                    success: function(data){
                        $('#get_product_code').val('');
                        $('.js-example-basic-single').val(0).trigger('change.select2');
                        document.getElementById("get_product_code").focus();
                        fetchstudent();
                        getTotalBuy();
                    },
                    error: function(){
                        alert($productCode.val() + ' Tidak Ada!');
                        $('#get_product_code').val('');
                        document.getElementById("get_product_code").focus();
                }
            })
            } else {
                alert('Tidak ada inputan!');
                $('#get_product_code').val('');
                document.getElementById("get_product_code").focus();
            }
        }

        //utk edit data di keranjang dgn id terakhir
        function editLastProduct() {
            let id = '1';
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'GET',
                    dataType: 'json',
                    data: {'id':id},
                    url: '{{ route('admin.transaction-new.showLastProduct') }}',
                    success:function(response){

                        //fill data to form
                        $('#productTransaction_id').val(response.data.id);
                        
                        $('#name-product-edit').val(response.data.product.name);
                        $('#price-product-edit').val(response.data.product.price);
                        $('#price3-product-edit').val(response.data.product.price3);
                        $('#price6-product-edit').val(response.data.product.price6);
                        $('#quantity-edit').val(response.data.quantity);
                        $('#get_product_disc_rp').val(response.data.disc_rp);
                        $('#get_product_disc_prc').val(response.data.disc_prc);
                        

                        //open modal
                        $('#modal-edit').modal('show');
                        $(document).ready(function(){
                            $("#modal-edit").on('shown.bs.modal', function(){
                                $(this).find('#quantity-edit').focus();
                                var autoselect = document.getElementById('quantity-edit');
	                            autoselect.select();
                            });
                        });

                        }
                });
        }

        //utk hapus data di keranjang dgn id terakhir
        function deleteLastProduct() {
            let id = '1';
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'DELETE',
                    dataType: 'json',
                    data: {'id':id},
                    url: '{{ route('admin.transaction-new.deleteLastProduct') }}',
                    success: function(data){
                        fetchstudent();
                        getTotalBuy();
                        fetchstudent();
                        getTotalBuy();
                        document.getElementById("get_product_code").focus();
                    },
                    error: function(){
                        alert('Gagal!');

                }
                });
        }

        //utk hapus semua barang di keranjang
        function deleteAllCart() {
            let id = '1';
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'DELETE',
                    dataType: 'json',
                    data: {'id':id},
                    url: '{{ route('admin.transaction-new.deleteAllCart') }}',
                    success: function(data){
                        fetchstudent();
                        getTotalBuy();
                        fetchstudent();
                        getTotalBuy();
                        document.getElementById("get_product_code").focus();
                    },
                    error: function(){
                        alert('Gagal!');

                }
                });
        }
    
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
                    url: '{{ route('admin.transaction-new.deleteCart') }}',
                });
                fetchstudent();
                getTotalBuy();
                fetchstudent();
                getTotalBuy();
                document.getElementById("get_product_code").focus();
            } else if (e.target.classList.contains('edit-btn')) {
                let id = e.target.dataset.id;
                e.target.disabled = true;
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'GET',
                    dataType: 'json',
                    data: {'id':id},
                    url: '{{ route('admin.transaction-new.show') }}',
                    success:function(response){

                        //fill data to form
                        $('#productTransaction_id').val(response.data.id);
                        $('#name-product-edit').val(response.data.product.name);
                        $('#price-product-edit').val(response.data.product.price);
                        $('#price3-product-edit').val(response.data.product.price3);
                        $('#price6-product-edit').val(response.data.product.price6);
                        $('#quantity-edit').val(response.data.quantity);
                        $('#get_product_disc_rp').val(response.data.disc_rp);
                        $('#get_product_disc_prc').val(response.data.disc_prc);

                        //open modal
                        $('#modal-edit').modal('show');
                        $(document).ready(function(){
                            $("#modal-edit").on('shown.bs.modal', function(){
                                $(this).find('#quantity-edit').focus();
                                var autoselect = document.getElementById('quantity-edit');
	                            autoselect.select();
                            });
                        });

                        }
                });
            }
        })


        //////
        //action update quantity
        const updateQuantity = document.getElementById('update-quantity');
        updateQuantity.addEventListener('click', function() {
            
            //define variable
            let productTransaction_id = $('#productTransaction_id').val();
            let quantity   = $('#quantity-edit').val();
            let productDiscRp   = $('#get_product_disc_rp').val();
            let productDiscPrc   = $('#get_product_disc_prc').val();
            let token   = $("meta[name='csrf-token']").attr("content");

            //ajax
            $.ajax({

                url: `/admin/transaction-new/update/${productTransaction_id}`,
                type: "PUT",
                cache: false,
                data: {
                    "quantity": quantity,
                    "disc_rp": productDiscRp,
                    "disc_prc": productDiscPrc,
                    "_token": token
                },
                success:function(response){

                    //data post
                    fetchstudent();
                    getTotalBuy();
                    $('#get_product_disc_rp').val('');
                    $('#get_product_disc_prc').val('');

                    //close modal
                    $('#modal-edit').modal('hide');
                    document.getElementById("get_product_code").focus();
                    

                }
            })
        });

        const productQuantity = document.getElementById('get_product_quantity');
        const productDiscRp = document.getElementById('get_product_disc_rp');
        const productDiscPrc = document.getElementById('get_product_disc_prc');
        
        [productQuantity, productDiscRp, productDiscPrc].map(element => element.addEventListener('input', function(){        
        let productPrice = document.getElementById('get_product_price');
        let productPrice3 = document.getElementById('get_product_price3');
        let productPrice6 = document.getElementById('get_product_price6');
        let productPriceDe = document.getElementById('get_product_priceDe');
        let productTotal = document.getElementById('get_product_total');

        if(productQuantity.value>=1 && productQuantity.value<=2) {
                            productPrice.value=productPriceDe.value;
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

        function getTotalBuy(){
            $.ajax({
                type: 'GET',
                url: '{{ route('admin.transaction-new.totalBuy') }}',
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

        // const productQuantity = document.getElementById('get_product_quantity');


        const totalDiscRp = document.getElementById('get_total_disc_rp');
        const totalDiscPrc = document.getElementById('get_total_disc_prc');
        [totalDiscRp, totalDiscPrc].map(element => element.addEventListener('input', function(){  
            $.ajax({
                type: 'GET',
                url: '{{ route('admin.transaction-new.totalBuy') }}',
                dataType: 'json',
                success: function(data){
                    let totalBuy = document.getElementById('totalBuy');
                    totalBuy.innerHTML = "Total " + formatDiskon(data.data, 'Rp. ');
                    hitung();
                },
                error: function(data){
                    console.log('gagal');
                }
            })  
        }))

        function formatDiskon(angka, prefix){
            
            var number = angka;
            let diskon = document.getElementById('get_total_disc_rp');
            let diskonPrc = document.getElementById('get_total_disc_prc');
            var totalDscPrc = (diskonPrc.value / 100) * (number);
            var totalDsc = number-diskon.value-totalDscPrc ;
            var format = totalDsc.toString().replace(/[^,\d]/g, ''),
            split   		= format.split(','),
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

        // let payment = document.getElementById('payment');
        // payment.addEventListener('keyup', function() {
        //     let tPayment = document.getElementById('tPayment');
        //     let vReturn = document.getElementById('return');
        //     let totalBuy = document.getElementById('totalBuy');
        //     let split = totalBuy.innerHTML.split(' ');
        //     if(split[2] == 0){
        //         alert('Belum ada pesanan');
        //     }
        //     let result = parseInt(this.value) - split[2].replace('.','') ;
        //     if(result >= 0) {
        //         tPayment.disabled = false;
        //     }else{
        //         tPayment.disabled = true;
        //     }
        //     vReturn.value = result;
        // })
        var payment = document.getElementById('payment');
        [payment].map(element => element.addEventListener('input', function(){  
            hitung();
        }))

        function hitung() {
            let tPayment = document.getElementById('tPayment');
            let vReturn = document.getElementById('return');
            let totalBuy = document.getElementById('totalBuy');
            let split = totalBuy.innerHTML.split(' ');
            if(split[2] == 0){
                alert('Belum ada pesanan');
            }
            let split1 = split[2].replace('.','');
            let split2 = split1.replace('.','');
            let result = parseInt(payment.value) - split2;
            if(result >= 0) {
                tPayment.disabled = false;
            }else{
                tPayment.disabled = true;
            }
            vReturn.value = result;
        }

        // let diskonRupiah = document.getElementById('get_total_disc_rp');
        // diskonRupiah.addEventListener('keyup', function() {
           
        //     let tPayment = document.getElementById('tPayment');
        //     let vReturn = document.getElementById('return');
        //     let totalBuy = document.getElementById('totalBuy');
        //     let split = totalBuy.innerHTML.split(' ');
        //     console.log(split[2].replace('.',''));
        //     if(split[2] == 0){
        //         alert('Belum ada pesanan');
        //     }
        //     let result = parseInt(payment.value) - split[2].replace('.','') ;
        //     if(result >= 0) {
        //         tPayment.disabled = false;
        //     }else{
        //         tPayment.disabled = true;
        //     }
        //     vReturn.value = result;
        // })
    })     
    
  </script>
@endpush