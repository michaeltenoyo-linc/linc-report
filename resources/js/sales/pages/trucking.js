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
      url: '/sales/truck/filter-nopol/'+division+'/'+ownership+'/'+group,
      type: 'GET',
      success: (data) => {
          console.log(data['nopol']);

          $('#form-trucking-performance .input-nopol').empty();
          $('#form-trucking-performance .input-nopol').append('<option value="all">==Semua==</option>');
          data['nopol'].forEach(d => {
            $('#form-trucking-performance .input-nopol').append('<option value="'+d['reference']+'">'+d['name']+'</option>');
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
      let sales = $('#form-trucking-performance .input-sales').val();

      window.location.href = '/sales/export/generate-report/'+division+'/'+sales+'/'+customer+'/false';
    })
  }

  onChangeCustomerFilter();
  onChangeNopolFilter();
  getCustomerList();
  generateReport();
  getNopolList();
}
