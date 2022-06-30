<div id="loa-add-file">
    @component('shared.components.modal')
        @slot('content')
        <div class="flex flex-col gap-y-4 rounded-2xl bg-white w-2/4 mx-auto p-8">
            <button class="modal-close-button ml-auto focus:outline-none">
                <i class="fas fa-times text-primary"></i>
            </button>
            <h3 class="text-lg font-bold">Add Contract File</h3>
            <div class="w-full border-4 border-green-900 border-dashed py-2">
                <p>
                    <span class="customer-reference"></span>
                    <br><span class="customer-name underline"></span>
                    <br><i class="fa fa-folder"></i> <b class="selected-timeline"></b>
                    <br><i class='fas fa-file-contract'></i> <b class="selected-loa"></b>
                </p>
            </div>
            <hr>
            <form action="" id="form-loa-file" autocomplete="off">
                <input type="hidden" name="id_loa" class="selected-id-loa" value="">
                <div class="w-full">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="name">Filename</label>
                        <input type="text"
                            name="filename"
                            class="input-filename border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            value=""
                            required/>
                    </div>
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="name">Upload</label>
                        <input type="file"
                            name="file"
                            class="input-file border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            value=""
                            required/>
                    </div>
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="name">Extension</label>
                        <select
                            name="extension"
                            class="input-extension border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            required>
                            <option value=".pdf">PDF (.pdf)</option>
                            <option value=".docx">Office Word (.docm, .docx, .dot, .dotx)</option>
                            <option value=".xlsx">Spreadsheet (.xlxs, .xlsm, .xlsb, .xltx, .xls)</option>
                            <option value=".jpg">Image (.jpeg, .jpg, .png)</option>
                        </select>
                    </div>

                    
                    <div class="relative w-full mb-3">
                        <a class="btn-save-file-loa" href="">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-right">Simpan</button>
                        </a>
                    </div>
                </div>
            </form>     
        </div>
        @endslot
    @endcomponent
</div>
