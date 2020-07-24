<?php $title = 'profil'; ?>

<?php ob_start(); ?>
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <div class="card-title mb-4">
                    <div class="d-flex justify-content-start">
                        <div class="image-container">
                            <img src="http://placehold.it/200x200" id="imgProfile" style="width: 200px; height: 200px" class="img-thumbnail" />
                        </div>
                        <div class="ml-auto">
                            <input type="button" class="btn btn-primary d-none" id="btnDiscard" value="Discard Changes" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="tab-content ml-1" id="myTabContent">
                            <div class="tab-pane fade show active" id="basicInfo" role="tabpanel" aria-labelledby="basicInfo-tab">


                                <div class="row">
                                    <div class="col-sm-3 col-md-2 col-5">
                                        <label style="font-weight:bold;">Full Name</label>
                                    </div>
                                    <div class="col-md-8 col-6">
                                        Jane/John Doe
                                    </div>
                                </div>
                                <hr />

                                <div class="row">
                                    <div class="col-sm-3 col-md-2 col-5">
                                        <label style="font-weight:bold;">Birth Date</label>
                                    </div>
                                    <div class="col-md-8 col-6">
                                        March 22, 1994
                                    </div>
                                </div>
                                <hr />


                                <div class="row">
                                    <div class="col-sm-3 col-md-2 col-5">
                                        <label style="font-weight:bold;">Pseudo</label>
                                    </div>
                                    <div class="col-md-8 col-6">
                                        Bethber
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-sm-3 col-md-2 col-5">
                                        <label style="font-weight:bold;">Email</label>
                                    </div>
                                    <div class="col-md-8 col-6">
                                        ucakyppy-9596@yopmail.com
                                    </div>
                                </div>
                                <hr />

                                <div class="row">
                                    <button class="btn btn-primary">modify your profil</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>