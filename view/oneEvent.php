<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title>Jepsen Brite Team 5</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/blog/">


    <!-- Bootstrap core CSS -->
    <link href="./public/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="./public/css/base.css">
    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="./public/css/blog.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <?php require('./view/header.php') ?>

        <?php require('./view/nav-bar.php') ?>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <button class="btn btn-primary">Participate</button>
                                <button class="btn btn-primary">Maybe</button>
                                <button class="btn btn-primary">Don't partipate</button>
                            </div>
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
                                                    <label style="font-weight:bold;">Name</label>
                                                </div>
                                                <div class="col-md-8 col-6">
                                                    Fiesta's on the beach
                                                </div>
                                            </div>
                                            <hr />

                                            <div class="row">
                                                <div class="col-sm-3 col-md-2 col-5">
                                                    <label style="font-weight:bold;">Date</label>
                                                </div>
                                                <div class="col-md-8 col-6">
                                                    22/07/2020
                                                </div>
                                            </div>
                                            <hr />


                                            <div class="row">
                                                <div class="col-sm-3 col-md-2 col-5">
                                                    <label style="font-weight:bold;">Hour</label>
                                                </div>
                                                <div class="col-md-8 col-6">
                                                    20:00
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-sm-3 col-md-2 col-5">
                                                    <label style="font-weight:bold;">Place</label>
                                                </div>
                                                <div class="col-md-8 col-6">
                                                    Liege
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-sm-3 col-md-2 col-5">
                                                    <label style="font-weight:bold;">Category</label>
                                                </div>
                                                <div class="col-md-8 col-6">
                                                    Something
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-sm-3 col-md-2 col-5">
                                                    <label style="font-weight:bold;">Description</label>
                                                </div>
                                                <div class="col-md-8 col-6">
                                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                                                    Tempora praesentium numquam sunt consequuntur aliquam mollitia
                                                    recusandae fugiat libero alias nam? Voluptas quo aliquid dicta
                                                    cumque exercitationem temporibus fugiat molestiae autem!
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-sm-3 col-md-2 col-5">
                                                    <label style="font-weight:bold;">Author's event</label>
                                                </div>
                                                <div class="col-md-8 col-6">
                                                    mehdoche1988
                                                </div>
                                            </div>
                                            <hr />

                                            <div class="row">
                                                <button class="btn btn-primary">Modify event</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 col-md-2 col-5">
                                    <label style="font-weight:bold;"> Author's comentary</label>
                                </div>
                                <div class="col-md-8 col-6">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                    Eaque facere recusandae cumque. Consequuntur sed sint earum
                                    numquam illo explicabo quod illum tempora
                                    laborum aut ullam ipsam, magni nulla aspernatur quia.
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 col-md-2 col-5">
                                    <label style="font-weight:bold;"> Author's comentary</label>
                                </div>
                                <div class="col-md-8 col-6">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                    Eaque facere recusandae cumque. Consequuntur sed sint earum
                                    numquam illo explicabo quod illum tempora
                                    laborum aut ullam ipsam, magni nulla aspernatur quia.
                                </div>
                            </div>

                        </div>
                        <form role="form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3 col-md-2 col-5 ">
                                        <label style="font-weight:bold;"> Add comentary</label>
                                    </div>
                                    <textarea class="col-md-8 col-6">

                                    </textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <?php require('./view/footer.php') ?>