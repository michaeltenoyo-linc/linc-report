<!-- Modal -->
<div class="modal fade" id="modal-customer-trucks" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <div class="row">
                    <div class="col text-center">
                        <h6 class="modal-title">Customer's Performance {{ ucfirst($division) }}</h6>
                        <h3><span id="modal-name">-Customer Name Here-</span></h3>
                        <span id="modal-reference">-Customer Reference-</span>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-5 overflow-auto" style="height: 600px;">
                        <span id="customer-unit-list">
                            -Unit List-
                        </span>
                    </div>
                    <div class="col">
                        <div class="row justify-content-center">
                            <b><span id="customer-unit-name">--Choose an unit--</span></b>
                        </div>
                        <div class="row justify-content-center">
                            <b><span id="cont-route-name">--Choose a route--</span></b>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-8 text-center border border-dark rounded mx-1 overflow-auto" style="height: 500px;">
                                <b>--Routes List--</b><br>
                                <span class="truck-route-list">
                                    -Route List-
                                </span>
                            </div>
                            <div class="col text-center border border-dark rounded mx-1 overflow-auto" style="height: 500px;">
                                <b>--Loads List--</b><br>
                                <span class="truck-load-list">
                                    -Load ID List-
                                </span>
                            </div>
                        </div>
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