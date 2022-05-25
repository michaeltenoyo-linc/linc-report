import { toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';
import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';

export const trucking = async () => {
  const getNopolList = async () => {
    let division = $('#form-trucking-performance .input-division').val();
    let ownership = $('#form-trucking-performance .input-ownership').val();
    let group = $('#form-trucking-performance .input-group').val();

    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      processData: false,
      contentType: false,
      dataType: 'JSON',
    });
    $.ajax({
      url: '/sales/truck/filter-nopol/'+division+'/'+ownership,
      type: 'GET',
      success: (data) => {
          console.log(data['nopol']);

          $('#form-trucking-performance .input-nopol').empty();
          $('#form-trucking-performance .input-nopol').append('<option value="all">==Semua==</option>');
          data['nopol'].forEach(d => {
            $('#form-trucking-performance .input-nopol').append('<option value="'+d+'">'+d+'</option>');
          });
      }
    });
  }

  const onChangeNopolFilter = () => {
    $('#form-trucking-performance .input-division').on('change', (e) => {
      e.preventDefault();
      getNopolList();
    });

    $('#form-trucking-performance .input-ownership').on('change', (e) => {
      e.preventDefault();
      getNopolList();
    });

    $('#form-trucking-performance .input-group').on('change', (e) => {
      e.preventDefault();
      getNopolList();
    });
  }

  const generateReport = () => {
    $('#form-trucking-performance .export-pdf-generate').on('click', (e) => {
      
      e.preventDefault();
      console.log("Generating...");

      let division = $('#form-trucking-performance .input-division').val();
      let ownership = $('#form-trucking-performance .input-ownership').val();
      let nopol = $('#form-trucking-performance .input-nopol').val();

      let tree = $('#form-trucking-performance .input-tree').val();

      if(tree == "nopol_to_customer"){
        window.location.href = '/sales/truck/performance-generate/'+ownership+'/'+division+'/'+nopol;
      }else{
        window.location.href = '/sales/truck/performance-customer/'+ownership+'/'+division+'/'+nopol;
      }
    })
  }

  onChangeNopolFilter();
  generateReport();
  getNopolList();
}
