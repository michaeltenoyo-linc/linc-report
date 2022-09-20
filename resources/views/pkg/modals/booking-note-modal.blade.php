<div id="booking-note-modal">
    @component('shared.components.modal')
        @slot('content')
        <div class="flex flex-col gap-y-4 rounded-2xl bg-white w-3/4 ml-auto p-8">
            <button class="modal-close-button ml-auto focus:outline-none">
                <i class="fas fa-times text-primary"></i>
            </button>

            <!-- Header -->
            <h3 class="text-lg font-bold">Note</h3>

            <hr>

            <!-- Body Full -->
            <div class="w-full p-5 container-table">
              <p class="container-note">

              </p>
            </div>

            <!-- Footer -->
            <form id="form-delete-note" class="w-full flex justify-end">
              <input type="hidden" class="input-load-id" name="load_id" value="">
              <input type="submit" value="Delete Note" class="cursor-pointer bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
            </form>
        </div>
        @endslot
    @endcomponent
</div>