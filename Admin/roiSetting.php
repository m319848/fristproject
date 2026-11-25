<!DOCTYPE html>
<html lang="en">
<?php include('include/head.php');
include("loginCheck.php");
include('include/header.php');
include('include/menu.php'); ?>
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2><a href="javascript:void(0);" onclick="window.history.back();"
                            class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Token
                        Rate Setting</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item"> Setting </a></li>
                        <li class="breadcrumb-item active"> Token Rate Setting</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Token Rate Setting</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover js-basic-example dataTable table-custom mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Coin Rate</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 0;
                                    $queryMisc = mysqli_query($con, "SELECT id,coinrate FROM meddolic_config_misc_setting");
                                    while ($valMisc = mysqli_fetch_array($queryMisc)) {
                                        $count++; ?>
                                        <tr>
                                            <td><?= $count ?></td>
                                            <td> <?= $valMisc['coinrate'] ?></td>

                                            <td><a data-id="<?= $valMisc['id']; ?>" data-toggle="modal"
                                                    data-target="#miscEdit" data-whatever="<?= $valMisc['id']; ?>" href="#"
                                                    data-backdrop="static" data-keyboard="false"
                                                    class="btn btn-success btn-sm">Edit</a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coin Rate Edit Modal -->
        <div class="modal fade" id="miscEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="coinDash"></div>
                </div>
            </div>
        </div>
        <?php include('include/footer.php'); ?>

        <script>
            $('#miscEdit').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var recipient = button.data('whatever') // Extract info from data-* attributes
                var modal = $(this);
                var miscId = recipient;
                // alert("helo");
                $.ajax({
                    type: "POST",
                    url: 'ajaxCalls/roiAjaxFetch',
                    data: { miscId: miscId },
                    cache: false,
                    success: function (data) {
                        console.log(data);
                        modal.find('.coinDash').html(data);
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            })
            var d = document.getElementById("Setting");
            d.className += " active";
            var d = document.getElementById("roiSetting");
            d.className += " active";
        </script>
        </body>

</html>