import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';

export const refreshTimeline = async () => {
    $('#timeline-list').empty();
    const group = $('#selected-timeline').val();
    const customer = $('#customer_reference').html();
    const type = $('#loa_type_short').val();

    const timelines = await $.get('/loa/data/getTimelineByGroup/'+type+'/'+customer+'/'+group);

    let ctr = 1;
    timelines['timeline'].forEach(row => {
        let activeColor = "bg-green-500 hover:bg-green-700";
        let activeIcon = "<i class='fas fa-check'></i>";

        if(row['is_archived'] == 1){
            activeColor = "bg-gray-500 hover:bg-gray-700";
            activeIcon = "<i class='fas fa-archive'></i>";
        }

        let rowDiv = '<div class="mb-12 flex justify-between items-center w-full">';
        rowDiv += '<div class="w-3/12 text-right">';
        rowDiv += '<b>'+row['effective']+'</b>'
        rowDiv += '</div>';
        rowDiv += '<div class="timeline-number z-20 flex items-center order-1 bg-gray-800 shadow-xl w-8 h-8 rounded-full">';
        rowDiv += '<h1 class="mx-auto font-semibold text-lg text-white">'+ctr+'</h1>';
        rowDiv += '</div>';
        rowDiv += '<div id="'+row['id']+'" name="'+row['name']+'" class="timeline flex cursor-pointer order-1 bg-gray-400 hover:bg-gray-300 rounded-lg shadow-xl w-8/12 px-6 py-4">';
        rowDiv += '<div class="w-8/12">'
        rowDiv += '<h3 class="mb-3 font-bold text-gray-800 text-xl">'+row['name']+'</h3>';
        rowDiv += '<p class="text-sm leading-snug tracking-wide text-gray-900 text-opacity-100">';
        rowDiv += '<b class="text-gray-800">Expired :</b> '+row['expired'];
        rowDiv += '</p>';
        rowDiv += '</div>';
        rowDiv += '<div class="w-4/12 grid grid-cols-3 gap-4">';
        rowDiv += '<div>'+'<button id="'+row['id']+'" class="btn-edit-loa py-3 w-full rounded-full bg-yellow-500 hover:bg-yellow-700 text-white"><i class="far fa-edit"></i></button>'+'</div>';
        rowDiv += '<div>'+'<button id="'+row['id']+'" class="btn-archive-loa py-3 w-full rounded-full '+activeColor+' text-white">'+activeIcon+'</button>'+'</div>';
        rowDiv += '<div>'+'<button id="'+row['id']+'" class="btn-delete-loa py-3 w-full rounded-full bg-red-500 hover:bg-red-700 text-white"><i class="far fa-trash-alt"></i></button>'+'</div>';
        rowDiv += '</div>';
        rowDiv += '</div>';
        rowDiv += '</div>';

        $('#timeline-list').append(rowDiv);
        ctr++;
    });

    //Reset Tab Class
    $.each($('.tab-active'), function(index, e) { 
        $(e).removeClass('tab-active');
        $(e).addClass('tab-inactive');
    });

    $.each($('.tab-inactive'), function(index, e) { 
        if($(e).html() == group){
            $(e).removeClass('tab-inactive');
            $(e).addClass('tab-active');
        }
    });
}

export const refreshFileList = async () => {
    let loaId = $('#selected-loa-id').val();
    const files = await $.get('/loa/data/getFileByGroup/'+loaId);
    

    //reset
    $('#file-container').empty();
    $('#file-period').html();
    //Set files div
    files.forEach(row => {
        let typeColor = "";
        switch (row['extension']) {
            case '.pdf':
                typeColor = 'bg-red-700';
                break;
            case '.xlsx':
                typeColor = 'bg-lime-700';
                break;
            case '.docx':
                typeColor = 'bg-blue-700';
                break;
            case '.jpg':
                typeColor = 'bg-yellow-700';
                break;
        }

        let filename = row['filename'].split('$');

        let rowDiv = '<li id="'+row['id']+'" class="file-items flex cursor-pointer hover:bg-gray-200 px-6 py-2 border-b border-gray-200 w-full rounded-t-lg flex">'
                    +'<div class="w-full">'+filename[2]+'<span class="text-xs '+typeColor+' text-white rounded p-1 ml-3">'+row['extension'].toUpperCase()+'</span></div>'
                    +'</li>'
        
                    
        $('.btn-add-file').removeClass('hidden');
        $('#file-container').append(rowDiv);
    });
}

export const LoaDetail = () => {
    console.log("loading LoaDetail JS");

    const init = async () => {
        const customer = $('#customer_reference').html();
        const type = $('#loa_type_short').val();

        //Group Tab
        $('#tab-container').empty();
        $('#file-container').empty();
        $('.btn-add-file').addClass('hidden');
        const CustomerGroups = await $.get('/loa/data/getGroupByCustomer/'+type+'/'+customer);
        
        let firstGroup = true;
        CustomerGroups['groups'].forEach(row => {
            let status = "tab-inactive";
            if(firstGroup){
                status = "tab-active";
                firstGroup = false;
                $('#selected-timeline').val(row);
            }

            let rowDiv = "<li class='mr-2 tab-content'>"
            +"<a class='"+status+"'>"+row
            +"</a></li>";

            $('#tab-container').append(rowDiv);
        });

        //Timeline
        refreshTimeline();
    }

    const onChangeGroup = () => {
        $(document).on('click', '.tab-inactive', function(e){
            e.preventDefault();
            const group = $(this).html();
            
            //Refresh Timeline
            $('#selected-timeline').val(group);
            refreshTimeline();
            //Reset Files
            $('#file-container').empty();
            $('#file-group-name').html("<< Choose a Context >>");
        });
    }

    const onClickContext = () => {
        $(document).on('click', '.timeline', async function(e){
            e.preventDefault();
            const groupId = $(this).attr('id');
            $('#selected-loa-id').val(groupId);
            const groupName = $(this).attr('name');
            $('#file-group-name').html(groupName);

            refreshFileList();
        });
    }

    const onClickFile = async () => {
        $(document).on('click', '.file-items', async function(e){
            let id = $(this).attr('id');
            
            const fileData = await $.get('/loa/data/getFileById/'+id);
            
            $('.viewer-container').addClass('hidden');

            if(fileData['extension'] == '.pdf'){
                $('#pdf').removeClass('hidden');
                PDFObject.embed("/show-pdf/"+fileData['filename']+'/'+fileData['content_path']['type'], "#pdf-viewer");
            }else if(fileData['extension'] == ".jpg"){
                $('#image').removeClass('hidden');
                $('#img-viewer').attr('src',"/show-png/"+fileData['filename']+'/'+fileData['content_path']['type']);
            }else if(fileData['extension'] == ".xlsx"){
                $('#excel').removeClass('hidden');
                $('#excel').empty();

                const excel_content = await $.get("/show-excel-pages/"+fileData['filename']+'/'+fileData['content_path']['type']);
                let ctrExcel = 1;
                excel_content['name'].forEach(row => {
                    console.log(row);
                    var left = (screen.width/2)-(800/2);
                    let divRow = '<a id="open-excel" onclick="window.open('+"'"+"/show-excel/"+fileData['filename']+'/'+fileData['content_path']['type']+"/"+(ctrExcel-1)+"'"+','+"'"+"popup"+"'"+','+"'"+"width=800,height=800,top=20,left="+left+""+"'"+')"><button class="mx-2 bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded"><span class="text-xs">Sheet '+ctrExcel+'</span><br>'+row+'</button></a>';
                    $('#excel').append(divRow);
                    ctrExcel++;
                });
            }
            
        })
    }

    const onClickDeleteLoa = async () => {
        $(document).on('click', '.btn-delete-loa', async function(e){
            let id = $(this).attr('id');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "Semua data beserta file akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, hapus!'
              }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        processData: false,
                        contentType: false,
                        dataType: 'JSON',
                    });
                    $.ajax({
                        url: '/loa/data/deleteById/'+id,
                        type: 'GET',
                        enctype: 'multipart/form-data',
                        success: (data) => {
                            Swal.fire({
                                title: 'Terhapus!',
                                text: 'Data LOA berhasil dihapus.',
                                icon: 'success'
                            }).then(function(){
                                location.reload();
                            });
                        },
                        error : function(request, status, error){
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: (JSON.parse(request.responseText)).message,
                            })
                        },
                    });
                }
            });
        })
    }

    init();
    onChangeGroup();
    onClickContext();
    onClickFile();
    onClickDeleteLoa();
};
