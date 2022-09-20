<div id="add-note-modal">
    @component('shared.components.modal')
        @slot('content')
        <div class="flex flex-col gap-y-4 rounded-2xl bg-white w-3/4 ml-auto p-8">
            <button class="modal-close-button ml-auto focus:outline-none">
                <i class="fas fa-times text-primary"></i>
            </button>

            <form id="form-delete-note">
              <!-- Body Full -->
              <div class="w-full p-5 container-table">
                <textarea rows="5" type="text" name="remark" class="input-remark w-full">
                </textarea>
              </div>

              <!-- Footer -->
              <input type="hidden" class="input-load-id" name="load_id" value="">
              <input type="submit" value="Save Note" class="cursor-pointer bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            </form>
        </div>
        @endslot
    @endcomponent
</div>