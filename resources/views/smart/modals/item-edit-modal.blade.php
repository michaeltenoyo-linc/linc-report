<div id="item-edit-modal">
    @component('shared.components.modal')
        @slot('content')
        <div class="flex flex-col gap-y-4 rounded-2xl bg-white w-2/4 mx-auto p-8">
            <button class="modal-close-button ml-auto focus:outline-none">
                <i class="fas fa-times text-primary"></i>
            </button>
            <h1 class="text-lg">Material Code</h1>
            <h1 class="text-2xl container-code font-bold">Nan</h1>

            <hr>

            <form action="" id="form-item-edit" autocomplete="off">
                <input type="hidden" val="" class="material_code" name="material_code"/>
                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password"> Description </label>
                        <input type="text"
                            name="description"
                            class="input-description border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            />
                    </div>
                </div>

                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password"> Gross Weight </label>
                        <input type="number"
                            name="gross"
                            min=0
                            inputmode="decimal"
                            value="0.01"
                            step=".01"
                            class="input-gross border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            />
                    </div>
                </div>

                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password"> Net. Weight </label>
                        <input type="number"
                            name="net"
                            min=0
                            inputmode="decimal"
                            value="0.01"
                            step=".01"
                            class="input-net border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            />
                    </div>
                </div>

                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                            htmlFor="grid-password"> Category </label>
                        <input type="text"
                            name="category"
                            class="input-category border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                            />
                    </div>
                </div>

                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full mb-3 grid grid-cols-3 gap-4">
                        <div></div>
                        <div></div>
                        <button type="submit" class="input-item-add btn_blue">Save</button>
                    </div>
                </div>
            </form>
        </div>
        @endslot
    @endcomponent
</div>
