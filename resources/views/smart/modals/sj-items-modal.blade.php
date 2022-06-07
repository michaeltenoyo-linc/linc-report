<div id="sj-items-modal">
    @component('shared.components.modal')
        @slot('content')
        <div class="flex flex-col gap-y-4 rounded-2xl bg-white w-2/4 mx-auto p-8">
            <button class="modal-close-button ml-auto focus:outline-none">
                <i class="fas fa-times text-primary"></i>
            </button>
            <h3 class="text-lg">Tambah Item</h3>
            
            <form action="" id="form-so-add-item" autocomplete="off">
                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password"> Material Code </label>
                        <input type="text"
                            name="material_code"
                            class="input-item-code border-0 px-3 py-3 mb-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            value="" list="items"/>
                        <datalist id="items">
                            @foreach ($items as $i)
                                <option value="{{ $i->material_code }}">{{ $i->description }}</option>
                            @endforeach
                        </datalist>

                        <div class="w-full" class="">
                            <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded check-material-code">Check Code</button>
                        </div>
                    </div>
                </div>

                <div class="w-full border border-rose-500 border-dashed p-2 mb-3">
                    <div class="w-full px-4 mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password"> Material Name <b class="text-red-700">*If data no exist, check item database</b></label>
                        <input type="text"
                            name="material_name"
                            class="input-item-name border-0 px-3 py-3 mb-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            value="" readonly/>
                    </div>
    
                    <div class="w-full grid grid-cols-2 gap-4 px-4 mb-3">
                        <div>
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password">Gross Weight</label>
                            <input type="text"
                                name="material_weight"
                                class="input-item-gross border-0 px-3 py-3 mb-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value="" readonly/>
                        </div>
    
                        <div>
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password">Net Weight</label>
                            <input type="text"
                                name="material_weight"
                                class="input-item-net border-0 px-3 py-3 mb-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value="" readonly/>
                        </div>
                    </div>
                    
    
                    <div class="w-full grid grid-cols-2 gap-4 mb-3">
                        <div class="w-full" class="">
                            <a href="" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded refresh-item-database">Refresh Item</a>
                        </div>
                        <div class="w-full" class="">
                            <a href="{{ url('/smart/nav-items-list') }}" target="_blank" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded goto-item-database">Item Database</a>
                        </div>
                    </div>
                </div>
    
                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password"> Qty. </label>
                        <input type="number"
                            name="qty"
                            class="input-item-qty border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            value="0"
                            min=0/>
                    </div>
                </div>

                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password"> Retur </label>
                        <input type="number"
                            name="retur"
                            class="input-item-retur border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            value="0"
                            min=0/>
                    </div>
                </div>
    
                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3">
                        <button type="submit" class="input-item-add btn_blue">Tambah</button>
                    </div>
                </div>     
            </form>           
        </div>
        @endslot
    @endcomponent
</div>
