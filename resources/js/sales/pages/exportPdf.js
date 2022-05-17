import { toInteger } from 'lodash';
import { disableElement } from '../../utilities/helpers';
import Snackbar from 'node-snackbar';
import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';

export const ExportToPDF = async () => {
  const getCustomerList = async () => {
    let division = $('#form-export-sales .input-division').val();
    let sales = $('#form-export-sales .input-sales').val();
    
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      processData: false,
      contentType: false,
      dataType: 'JSON',
    });
    $.ajax({
      url: '/sales/export/filter-customer/'+division+'/'+sales,
      type: 'GET',
      success: (data) => {
          console.log(data['customer']);

          $('#form-export-sales .input-customer').empty();
          $('#form-export-sales .input-customer').append('<option value="all">==Semua==</option>');
          data['customer'].forEach(d => {
            $('#form-export-sales .input-customer').append('<option value="'+d['reference']+'">'+d['name']+'</option>');
          });
      }
    });
  }

  const onChangeCustomerFilter = () => {
    $('#form-export-sales .input-division').on('change', (e) => {
      e.preventDefault();
      getCustomerList();
    });

    $('#form-export-sales .input-sales').on('change', (e) => {
      e.preventDefault();
      getCustomerList();
    });
  }

  const generatePDF = () => {
    $('#form-export-sales .export-pdf-generate').on('click', (e) => {
      
      e.preventDefault();
      console.log("Generating...");

      let division = $('#form-export-sales .input-division').val();
      let sales = $('#form-export-sales .input-sales').val();
      let customer = $('#form-export-sales .input-customer').val();

      window.location.href = '/sales/export/generate-report/'+division+'/'+sales+'/'+customer+'/false';
    })
  }

  onChangeCustomerFilter();
  getCustomerList();
  generatePDF();
}
