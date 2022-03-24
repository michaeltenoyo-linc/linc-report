<div id="loa-transport-modal-blujay">
    @component('shared.components.modal')
        @slot('content')
        <div class="flex flex-col gap-y-4 rounded-2xl bg-white w-2/4 mx-auto p-8">
            <button class="modal-close-button ml-auto focus:outline-none">
                <i class="fas fa-times text-primary"></i>
            </button>
            <h3 class="text-lg font-bold">Detail</h3>
            <hr>
            <div class="w-full lg:w-12/12 px-4 mb-4 grid grid-cols-2 gap-4 text-left">
                <div><b class="bg-blue-700 text-white p-1">Prov.</b> <span class="origin_province"></span></div>
                <div><b class="bg-blue-700 text-white p-1">Prov.</b> <span class="destination_province"></span></div>
                <div><b class="bg-green-700 text-white p-1">Kota</b> <span class="origin_regency"></span></div>
                <div><b class="bg-green-700 text-white p-1">Kota</b> <span class="destination_regency"></span></div>
                <div><b class="bg-orange-700 text-white p-1">Kec.</b> <span class="origin_district"></div>
                <div><b class="bg-orange-700 text-white p-1">Kec.</b> <span class="destination_district"></span></div>
                <div><b class="bg-red-700 text-white p-1">Kel.</b> <span class="origin_urban"></div>
                <div><b class="bg-red-700 text-white p-1">Kel.</b> <span class="destination_urban"></span></div>
            </div>
            <div class="w-full lg:w-12/12 px-4">
                <div class="relative w-full mb-3">
                    <table id="table-warehouse-detail" class="table-auto w-full">
                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                          <tr>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left">Nama Biaya</div>
                            </th>
                            <th class="p-2 whitespace-nowrap">
                                <div class="font-semibold text-left">Nominal</div>
                            </th>
                          </tr>
                        </thead>
                        <tbody class="content-transport-detail">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="w-full lg:w-12/12 px-4">
                <div class="relative w-full mb-3">
                    <a class="btn-goto-loa" href="">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-right">Buka LOA</button>
                    </a>
                </div>
            </div>       
        </div>
        @endslot
    @endcomponent
</div>
