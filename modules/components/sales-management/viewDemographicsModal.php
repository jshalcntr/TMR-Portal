<div class="modal fade" id="viewDemographicsModal" tabindex="-1" aria-labelledby="viewDemographicsModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" style="max-width: 90% !important; width:85% !important">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="viewDemographicsModalLabel">Demographics</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body custom-scrollable-body px-5">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="card shadow-sm card-gender" style="height: 400px;">
                                <div class="card-header py-2">
                                    <h6 class="m-0 font-weight-bold text-primary">Gender</h6>
                                </div>
                                <div class=" card-body">
                                    <canvas id="genderChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card shadow-sm card-source" style="height: 400px;">
                                <div class="card-header py-2">
                                    <h6 class="m-0 font-weight-bold text-primary">Source of Inquiry</h6>
                                </div>
                                <div class=" card-body">
                                    <canvas id="sourceInquiryChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card shadow-sm card-buyer" style="height: 400px;">
                                <div class="card-header py-2">
                                    <h6 class="m-0 font-weight-bold text-primary">Market Area</h6>
                                </div>
                                <div class=" card-body">
                                    <canvas id="marketAreaChart"></canvas>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="card shadow-sm card-buyer" style="height: 400px;">
                                <div class="card-header py-2">
                                    <h6 class="m-0 font-weight-bold text-primary">Buyer Type</h6>
                                </div>
                                <div class=" card-body">
                                    <canvas id="buyerTypeChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card shadow-sm card-age" style="height: 400px;">
                                <div class="card-header py-2">
                                    <h6 class="m-0 font-weight-bold text-primary">Age</h6>
                                </div>
                                <div class=" card-body">
                                    <canvas id="ageChart"></canvas>
                                </div>
                            </div>
                        </div>



                    </div>
                    <!-- <div class="col-md-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Donut Chart</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-pie pt-4">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <hr>
                                    Styling for the donut chart can be found in the
                                    <code>/js/demo/chart-pie-demo.js</code> file.
                                </div>
                            </div>
                        </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script src="../../assets/js/sales-management/getDemographicsInfo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>