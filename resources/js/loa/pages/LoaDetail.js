import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';
import { split } from 'lodash';

export const refreshTimeline = async () => {
    $('#timeline-list').empty();
    $('.viewer-container').addClass('hidden');
    //Reset Files
    $('#file-container').empty();
    $('#file-group-name').html("<< Choose a Context >>");
    const group = $('#selected-timeline').val();
    const customer = $('#customer_reference').html();
    const type = $('#loa_type_short').val();
    const showArchive = $('#loa-archive-checkbox').prop('checked');

    let timelines;

    if(group == 'Favorite'){
        timelines = await $.get('/loa/data/getPinnedGroup/'+type+'/'+customer);
    }else{
        timelines = await $.get('/loa/data/getTimelineByGroup/'+type+'/'+customer+'/'+group);
    }

    let ctr = 1;
    timelines['timeline'].forEach(row => {
        let activeColor = "bg-green-500 hover:bg-green-700";
        let activeIcon = "<i class='fas fa-check'></i>";

        let iconFavorite = '<i class="far fa-star"></i>';

        if(row['is_archived'] == 1){
            activeColor = "bg-gray-500 hover:bg-gray-700";
            activeIcon = "<i class='fas fa-archive'></i>";
        }

        if(row['is_pinned'] == 1){
            iconFavorite = '<i class="fas fa-star"></i>';
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
        rowDiv += '<div class="w-4/12 ml-5 grid grid-cols-2 gap-4">';
        rowDiv += '<div>'+'<button id="'+row['id']+'" class="btn-archive-loa py-3 w-full rounded-full '+activeColor+' text-white">'+activeIcon+'</button>'+'</div>';
        rowDiv += '<div>'+'<button id="'+row['id']+'" class="btn-pin-loa py-3 w-full rounded-full bg-orange-600 hover:bg-orange-700 text-white">'+iconFavorite+'</button>'+'</div>';
        rowDiv += '<div>'+'<button id="'+row['id']+'" class="btn-edit-loa py-3 w-full rounded-full bg-yellow-500 hover:bg-yellow-700 text-white"><i class="far fa-edit"></i></button>'+'</div>';
        rowDiv += '<div>'+'<button id="'+row['id']+'" class="btn-delete-loa py-3 w-full rounded-full bg-red-500 hover:bg-red-700 text-white"><i class="far fa-trash-alt"></i></button>'+'</div>';
        rowDiv += '</div>';
        rowDiv += '</div>';
        rowDiv += '</div>';

        if(showArchive){
            $('#timeline-list').append(rowDiv);
            ctr++;
        }else{
            if(row['is_archived'] == 0){
                $('#timeline-list').append(rowDiv);
                ctr++;
            }
        }
        
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
    $('.viewer-container').addClass('hidden');
    $('#file-container').empty();
    $('#file-period').html();
    //Set files div
    files.forEach(row => {
        let typeColor = "";
        switch (row['extension']) {
            case '.pdf':
                typeColor = 'bg-red-700 type-pdf';
                break;
            case '.xlsx':
                typeColor = 'bg-lime-700 type-xlsx';
                break;
            case '.docx':
                typeColor = 'bg-blue-700 type-docx';
                break;
            case '.jpg':
                typeColor = 'bg-orange-700 type-jpg';
                break;
            case '.msg':
                typeColor = 'bg-yellow-500 type-msg';
                break;
        }

        let filename = row['filename'].split('$');

        let rowDiv = '<li id="'+row['id']+'" class="file-items flex cursor-pointer hover:bg-gray-200 px-6 py-2 border-b border-gray-200 w-full rounded-t-lg flex">'
                    +'<div class="w-full">'+'<button id="'+row['id']+'" type="button" class="p-1 btn-delete-file bg-red-400 text-white hover:bg-red-500 rounded-full"><i class="far fa-trash-alt" style="font-size:15px"></i></button> '+filename[2]+'<span class="text-xs '+typeColor+' text-white rounded p-1 ml-3">'+row['extension'].toUpperCase()+'</span></div>'
                    +'</li>'
        
             
        $('.btn-delete-all-file').removeClass('hidden');
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
        $('.btn-delete-all-file').addClass('hidden');
        const CustomerGroups = await $.get('/loa/data/getGroupByCustomer/'+type+'/'+customer);
        console.log(CustomerGroups);

        let firstGroup = true;
        CustomerGroups['groups'].forEach(row => {
            let status = "tab-inactive";
            if(firstGroup){
                status = "tab-active";
                firstGroup = false;
                $('#selected-timeline').val(row);
            }

            let pinIcon = "";
            if(row == "Favorite"){
                pinIcon = "<i class='fas fa-map-pin font-2xl mr-2'></i>";
            }

            let rowDiv = "<li class='mr-2 tab-content'>"
            +pinIcon+" <a class='"+status+"'>"+row
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
            }else if(fileData['extension'] == ".msg"){
                $('#msg').removeClass('hidden');
                $('#msg').empty();
                const filenameFormat = split(fileData['filename'],'$')[2];
                var left = (screen.width/2)-(800/2);
                let divRow = '<a id="open-excel" onclick="window.open('+"'"+"/show-msg/"+fileData['filename']+'/'+fileData['content_path']['type']+"'"+','+"'"+"popup"+"'"+','+"'"+"width=800,height=800,top=20,left="+left+""+"'"+')"><button class="mx-2 bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded"><span class="text-xs">'+filenameFormat+'</span></button></a>';
                $('#msg').append(divRow);
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

    const onDeleteFile = async () => {
        $(document).on('click','.btn-delete-file', async function(e){
            let id = $(this).attr('id');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "File akan dihapus permanen!",
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
                        url: '/loa/data/deleteFileById/'+id,
                        type: 'GET',
                        enctype: 'multipart/form-data',
                        success: (data) => {
                            Swal.fire({
                                title: 'Terhapus!',
                                text: 'File berhasil dihapus.',
                                icon: 'success'
                            }).then(function(){
                                $('.viewer-container').addClass('hidden');
                                refreshFileList();
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
        });
    }

    const onClickLoaActivation = async () =>{
        $(document).on('click', '.btn-archive-loa', async function(e){
            let id = $(this).attr('id');
            let fetch = await $.get('/loa/data/read/byId/'+id);
            let loa = fetch['loa'];

            if(loa['is_archived'] == 0){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "LOA akan dinonaktifkan menjadi arsip.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya, Arsip!'
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
                            url: '/loa/data/activationById/'+id,
                            type: 'GET',
                            success: (data) => {
                                Swal.fire({
                                    title: 'Terarsip!',
                                    text: 'File berhasil diarsip.',
                                    icon: 'success'
                                }).then(function(){
                                    refreshTimeline();
                                    //Reset Files
                                    $('#file-container').empty();
                                    $('#file-group-name').html("<< Choose a Context >>");
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
            }else if(loa['is_archived'] == 1){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "LOA akan diaktifkan dari arsip.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya, Aktifkan!'
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
                            url: '/loa/data/activationById/'+id,
                            type: 'GET',
                            success: (data) => {
                                Swal.fire({
                                    title: 'Terarsip!',
                                    text: 'File berhasil diaktifkan.',
                                    icon: 'success'
                                }).then(function(){
                                    refreshTimeline();
                                    //Reset Files
                                    $('#file-container').empty();
                                    $('#file-group-name').html("<< Choose a Context >>");
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
            }
        });
    }

    const onClickPin = async () => {
        $(document).on('click','.btn-pin-loa', async function(e){
            e.preventDefault();
            const id = $(this).attr('id');
            let fetch = await $.get('/loa/data/read/byId/'+id);
            let loa = fetch['loa'];

            if(loa['is_pinned'] == 0){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "LOA akan diklasifikasikan sebagai LOA favorit.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya, Pin!'
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
                            url: '/loa/data/pinById/'+id,
                            type: 'GET',
                            success: (data) => {
                                Swal.fire({
                                    title: 'Pinned!',
                                    text: 'File berhasil dipin.',
                                    icon: 'success'
                                }).then(function(){
                                    init();
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
            }else if(loa['is_pinned'] == 1){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "LOA akan dikeluarkan dari LOA favorit.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya, Unpin!'
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
                            url: '/loa/data/pinById/'+id,
                            type: 'GET',
                            success: (data) => {
                                Swal.fire({
                                    title: 'Unpinned!',
                                    text: 'File berhasil diunpin.',
                                    icon: 'success'
                                }).then(function(){
                                    init();
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
            }
        });
    }
    
    const onClickShowArchive = async () => {
        $(document).on('click','#loa-archive-checkbox', async function(e){
            refreshTimeline();
        })
    }

    init();
    onChangeGroup();
    onClickContext();
    onClickFile();
    onClickDeleteLoa();
    onDeleteFile();
    onClickLoaActivation();
    onClickPin();
    onClickShowArchive();
};
