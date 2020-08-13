<?php $title = 'Profile'; ?>

<?php ob_start(); ?>
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <div class="card-title mb-4">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex justify-content-start">
                            <div class="image-container p-3">
                                <img src="https://www.gravatar.com/avatar/<?= $result['avatar'] ?>" id="imgProfile" style="width: 200px; height: 200px" class="img-thumbnail rounded-circle" />
                            </div>
                            <div class="ml-auto">
                                <input type="button" class="btn btn-primary d-none" id="btnDiscard" value="Discard changes" />
                            </div>
                        </div>
                        <div>
                            <?php
                            $request = $this->userManager->getUser();
                            $request->execute(array($_SESSION['id']));
                            $result = $request->fetch();

                            $isUserAdmin = $result['isadmin'];
                            if ($isUserAdmin != "0") { ?>
                                <a href="./index.php?action=admindashboard" class="btn btn-primary">Admin dashboard</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="tab-content ml-1" id="myTabContent">

                            <div class="row">
                                <div class="col-sm-3 col-md-2 col-5">
                                    <label style="font-weight:bold;">Username</label>
                                </div>
                                <div class="col-md-8 col-6">
                                    <?= $result['username'] ?>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-sm-3 col-md-2 col-5">
                                    <label style="font-weight:bold;">Email</label>
                                </div>
                                <div class="col-md-8 col-6">
                                    <?= $result['email'] ?>
                                </div>
                            </div>
                            <hr />

                            <div class="row">

                                <div class="col-sm-3 col-md-2 col-5 ">
                                    <a href="./index.php?action=modifyprofile" class="btn btn-warning">Modify your profile</a>
                                </div>
                                <div class="col-sm-3 col-md-2 col-5">
                                    <a href="./index.php?action=deleteprofile" onclick="if(!confirm('Are you sure you want to delete this account?')) return false;" class="btn btn-danger">Delete your profile</a>
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