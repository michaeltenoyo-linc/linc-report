import { toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';

export const ItemsModal = () => {
    $('#form-so-new .open-item-modal').on('click', function(e){
        e.preventDefault();

        console.log("Open Modal");

        $('#sj-items-modal .modal').removeClass('hidden');
    });

    $('#form-so-add-item').on('submit', function(e){
        e.preventDefault();

        console.log("Add Item");
        var ctr = toInteger($('#form-so-new .ctr-item').val());

        //console.log(ctr);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
            dataType: 'JSON',
        });
        $.ajax({
            url: '/smart/data/get-items-fromname',
            type: 'POST',
            data: new FormData($(this)[0]),
            success: (data) => {
                let currItem = data['item'];

                var mcode = currItem['material_code'];
                var qty = $('#form-so-add-item .input-item-qty').val();
                var retur = $('#form-so-add-item .input-item-retur').val();

                //append item to table
                $('#yajra-datatable-so-items-list .so-items-list-body').append('<tr class="row-item-'+ctr+'">');
                $('#yajra-datatable-so-items-list .so-items-list-body').append('<td>'+currItem['material_code']+'</td>');
                $('#yajra-datatable-so-items-list .so-items-list-body').append('<td>'+currItem['description']+'</td>');
                $('#yajra-datatable-so-items-list .so-items-list-body').append('<td>'+qty+'</td>');
                $('#yajra-datatable-so-items-list .so-items-list-body').append('<td>'+retur+'</td>');
                $('#yajra-datatable-so-items-list .so-items-list-body').append('<td>'+currItem['gross_weight']+'</td>');

                let subtotal_weight = parseFloat(currItem['gross_weight']) * parseFloat(qty);
                subtotal_weight = subtotal_weight.toFixed(2);
                $('#yajra-datatable-so-items-list .so-items-list-body').append('<td>'+subtotal_weight+'</td>');
                $('#yajra-datatable-so-items-list .so-items-list-body').append('<td><button type="button" class="open-item-modal bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-right" value="'+ctr+'">Hapus</button></td>');
                $('#yajra-datatable-so-items-list .so-items-list-body').append('</tr>');

                //append item to form
                $('#form-so-new').append('<input value="'+mcode+'" type="hidden" name="item['+ctr+']" class="input-so-item-'+ctr+'">');
                $('#form-so-new').append('<input value="'+qty+'" type="hidden" name="qty['+ctr+']" class="input-so-qty-'+ctr+'">');
                $('#form-so-new').append('<input value="'+retur+'" type="hidden" name="retur['+ctr+']" class="input-so-retur-'+ctr+'">');
                ctr = ctr + 1;
                $('#form-so-new .ctr-item').val(ctr);

                //update total value
                var currTotal = parseFloat($('#form-so-new .input-total-weight').val());
                var currQty = parseFloat($('#form-so-new .input-total-qty').val());
                var kategori_truck = parseFloat($('#form-so-new .kategori-truck').val());
                currQty = parseFloat(currQty) + parseFloat(qty);
                console.log(currTotal);
                console.log(kategori_truck);
                currTotal = parseFloat(parseFloat(currTotal) + parseFloat(subtotal_weight));
                console.log(currTotal);
                var currUtility = parseFloat(currTotal / kategori_truck).toFixed(4);

                currUtility = parseFloat(currUtility).toFixed(4);
                currTotal = parseFloat(currTotal).toFixed(2);
                $('#form-so-new .input-total-weight').val(currTotal);
                $('#form-so-new .input-total-utility').val(currUtility*100);
                $('#form-so-new .input-total-qty').val(currQty);
                $('#form-so-new .teks-total-weight').html("Total : "+String(currTotal)+" Kg. | "+String(currQty));
                $('#form-so-new .teks-utility').html("Utilitas : "+String(currUtility*100)+"%");



                $('.modal').addClass('hidden');

                Snackbar.show({
                    text: "Berhasil menambahkan item",
                    actionText: 'Tutup',
                    duration: 3000,
                    pos: 'bottom-center',
                });
            },
            error: function(request, status, error){
                Snackbar.show({
                    text: (JSON.parse(request.responseText)).message,
                    actionText: 'Tutup',
                    duration: 3000,
                    pos: 'bottom-center',
                });
            }
        });
    });
}
