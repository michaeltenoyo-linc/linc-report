<!-- Modal -->
<div class="modal fade" id="modal-customer-loads" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <div class="row">
                    <div class="col text-center">
                        <h6 class="modal-title">Customer's Loads {{ ucfirst($division) }}</h6>
                        <h3><span id="cloads-modal-name">-Customer Name Here-</span></h3>
                        <span id="cloads-modal-reference">-Customer Reference-</span>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col overflow-auto" style="height: 600px;">
                        <span id="customer-load-list">
                            -Unit List-
                        </span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
</script>