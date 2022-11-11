<div id="loa-error-warning">
    @component('shared.components.modal')
        @slot('content')
        <div class="flex flex-col gap-y-4 rounded-2xl bg-white w-2/4 mx-auto p-8">
            <button class="modal-close-button ml-auto focus:outline-none">
                <i class="fas fa-times text-primary"></i>
            </button>

            <div class="w-full">
                <h1 class="font-bold text-xl ">Unsaved Data</h1>
            </div>
            
            <div class="w-full mb-5">
                <div class="flex p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800">
                    <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Danger</span>
                    <div>
                      <span class="font-medium">Ensure that these requirements are met:</span>
                        <ul class="mt-1.5 ml-4 text-red-700 list-disc list-inside">
                          <li>No duplicate routes with the same vehicle type</li>
                          <li>Check again if the new data already exists</li>
                      </ul>
                    </div>
                </div>
            </div>

            <ul class="w-full overflow-y-auto h-64 container-error">
                
            </ul>
        </div>
        @endslot
    @endcomponent
</div>
