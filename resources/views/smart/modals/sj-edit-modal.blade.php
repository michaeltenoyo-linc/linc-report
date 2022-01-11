<div id="sj-edit-modal">
    @component('shared.components.modal')
        @slot('content')
        <div class="flex flex-col gap-y-4 rounded-2xl bg-white w-2/4 mx-auto p-8">
            <button class="modal-close-button ml-auto focus:outline-none">
                <i class="fas fa-times text-primary"></i>
            </button>
            <h3 class="text-lg">BELUM BISA</h3>
            
            <form action="" id="form-so-add-item" autocomplete="off">
                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password"> BELUM BISA </label>
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
