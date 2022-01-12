<div id="sj-edit-modal">
    @component('shared.components.modal')
        @slot('content')
        <div class="flex flex-col gap-y-4 rounded-2xl bg-white w-2/4 mx-auto p-8">
            <button class="modal-close-button ml-auto focus:outline-none">
                <i class="fas fa-times text-primary"></i>
            </button>
            <h1 class="text-lg container-id-so font-bold">Nan</h1>

            <hr>

            <form action="" id="form-so-edit" autocomplete="off">
                <input type="hidden" val="" class="id_so"/>
                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password"> Load ID </label>
                        <input type="text"
                            name="load_id"
                            class="input-load-id border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            readonly
                            />
                    </div>
                </div>

                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password"> Penerima </label>
                        <input type="text"
                            name="penerima"
                            class="input-penerima border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            />
                    </div>
                </div>

                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password"> Customer Type </label>
                        <input type="text"
                            name="customer_type"
                            class="input-customer-type border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            />
                    </div>
                </div>

                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password"> Note </label>
                        <input type="text"
                            name="note"
                            class="input-note border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            />
                    </div>
                </div>

                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password"> Biaya Bongkar <div class="text-red-500">*Blujay - IDR. <span class="blujay-bongkar"></span></div></label>
                        <input type="number"
                            name="bongkar"
                            class="input-bongkar border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            value="0"
                            min=0/>
                    </div>
                </div>

                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password"> Biaya Overnight </label>
                        <input type="number"
                            name="overnight"
                            class="input-overnight border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            value="0"
                            min=0/>
                    </div>
                </div>

                <div class="w-full lg:w-12/12 px-4 mb-8">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password"> Biaya Multidrop </label>
                        <input type="number"
                            name="multidrop"
                            class="input-multidrop border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            value="0"
                            min=0/>
                    </div>
                </div>

                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3">
                        <button type="submit" class="input-item-add btn_blue">Save</button>
                    </div>
                </div>
            </form>
        </div>
        @endslot
    @endcomponent
</div>
