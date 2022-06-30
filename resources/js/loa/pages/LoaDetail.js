import Swal from 'sweetalert2';
import Snackbar from 'node-snackbar';

export const LoaDetail = () => {
    console.log("loading LoaDetail JS");

    async function refreshTimeline() {
        $('#timeline-list').empty();
        const group = $('#selected-timeline').val();
        const customer = $('#customer_reference').html();
        const type = $('#loa_type_short').val();

        const timelines = await $.get('/loa/data/getTimelineByGroup/'+type+'/'+customer+'/'+group);

        let ctr = 1;
        timelines['timeline'].forEach(row => {
            let rowDiv = '<div class="mb-12 flex justify-between items-center w-full">';
            rowDiv += '<div class="w-3/12 text-right">';
            rowDiv += '<b>'+row['effective']+'</b>'
            rowDiv += '</div>';
            rowDiv += '<div class="timeline-number z-20 flex items-center order-1 bg-gray-800 shadow-xl w-8 h-8 rounded-full">';
            rowDiv += '<h1 class="mx-auto font-semibold text-lg text-white">'+ctr+'</h1>';
            rowDiv += '</div>';
            rowDiv += '<div id="'+row['id']+'" name="'+row['name']+'" class="timeline cursor-pointer order-1 bg-gray-400 hover:bg-gray-300 rounded-lg shadow-xl w-8/12 px-6 py-4">';
            rowDiv += '<h3 class="mb-3 font-bold text-gray-800 text-xl">'+row['name']+'</h3>';
            rowDiv += '<p class="text-sm leading-snug tracking-wide text-gray-900 text-opacity-100">';
            rowDiv += '<b class="text-gray-800">Expired :</b> '+row['expired'];
            rowDiv += '</p>';
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
            
            const files = await $.get('/loa/data/getFileByGroup/'+groupId);
            

            //reset
            $('#file-container').empty();
            $('#file-group-name').html(groupName);
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

                let filename = row['filename'].split('-');

                let rowDiv = '<li id="'+row['id']+'" class="file-items cursor-pointer hover:bg-gray-200 px-6 py-2 border-b border-gray-200 w-full rounded-t-lg flex">'
                            +'<div class="w-full">'+filename[1]+'<span class="text-xs '+typeColor+' text-white rounded p-1 ml-3">'+row['extension'].toUpperCase()+'</span></div>'
                            +'</li>'
                
                            
                $('.btn-add-file').removeClass('hidden');
                $('#file-container').append(rowDiv);
            });
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

    init();
    onChangeGroup();
    onClickContext();
    onClickFile();
};
