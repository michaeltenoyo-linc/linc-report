<!-- Modal -->
<div class="modal fade" id="modal-truck-activity" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <div class="row">
                    <div class="col text-center">
                        <h6 class="modal-title">Truck's Activity</h6>
                        <h3><span id="modal-nopol">-Nopol Here-</span></h3>
                        <span id="modal-unit-type">-Unit Type-</span>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <!-- Content Here -->
                <div class="row">
                    <div class="col-8">
                        <!-- Calendar -->
                        <div class="row mb-4">
                            <div class="col text-center" style="font-size:16pt;">
                                <b>{{ $period }}</b>
                            </div>
                        </div>
                        <div class="row calendar-list px-4">
                            <!-- Calendar Day List Here -->
                        </div>
                    </div>
                    <div class="col">
                        <!-- Activity Detail -->
                        <div class="row text-center">
                            <div class="col calendar-activity-message font-weight-bold text-danger">
                                --Activity Here--
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-right calendar-activity-dd font-weight-bold" style="font-size: 34pt;">
                                DD
                            </div>
                            <div class="col text-left">
                                <div class="row">
                                    <div class="col calendar-activity-mm font-weight-bold">
                                        MM
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col calendar-activity-yyyy font-weight-bold">
                                        YYYY
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col calendar-activity-day font-weight-bold">
                                        DAYNAME
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row px-4">
                            <div class="col">
                                <hr>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col calendar-activity-detail">
                                --Activity Detail Here--
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