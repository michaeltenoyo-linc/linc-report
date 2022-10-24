<div id="loa-fixed-rental">
    @component('shared.components.modal')
        @slot('content')
        <div class="flex flex-col gap-y-4 rounded-2xl bg-white w-2/4 mx-auto p-8">
            <button class="modal-close-button ml-auto focus:outline-none">
                <i class="fas fa-times text-primary"></i>
            </button>
            <h3 class="text-lg font-bold">Add Fixed Rental</h3>
            <hr>
            <form action="" id="form-fixed-rental" autocomplete="off">
                <div class="w-full">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="name">Vehicle Type</label>
                        <input type="text"
                            name="type"
                            class="input-filename border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            value=""
                            required/>
                    </div>

                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="name">Customer Site</label>
                        <input type="text"
                            name="site"
                            class="input-filename border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            value=""
                            required/>
                    </div>

                    <div class="w-full grid grid-cols-2 gap-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name">Rental Charge</label>
                            <input type="number"
                                name="rate"
                                class="input-filename border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value=""
                                required/>
                        </div>
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name">UoM</label>
                            <input type="text"
                                name="uom"
                                class="input-filename border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                value="/Month"
                                required/>
                        </div>
                    </div>

                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="name">Terms & Condition</label>
                        <textarea rows="4" class="input-terms border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" placeholder="">Tidak ada</textarea>
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
