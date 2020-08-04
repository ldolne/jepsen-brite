<?php $title = 'Events by category'; ?>

<?php ob_start(); ?>

<main role="main" class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Events by category</h2>
            <div class="search">
                <a href="./index.php?action=allcategorycontroller"> <button class="btn btn-primary">All</button></a>
            </div>
            <br />
            <div class="search">
                <a href="./index.php?action=onecategorycontroller&amp;category_id=1"><button class="btn btn-primary">Concert</button></a>
                <a href="./index.php?action=subcategorycontroller&amp;subcategory_id=1"><button class="btn btn-success">Metal</button></a>
                <a href="./index.php?action=subcategorycontroller&amp;subcategory_id=11"><button class="btn btn-success">Classic</button></a>
                <a href="./index.php?action=subcategorycontroller&amp;subcategory_id=21"><button class="btn btn-success">EDM</button></a><br />

                <a href="./index.php?action=onecategorycontroller&amp;category_id=2"><button class="btn btn-primary">Exhibition</button></a>
                <a href="./index.php?action=subcategorycontroller&amp;subcategory_id=31"><button class="btn btn-success">Contemporary art</button></a>
                <a href="./index.php?action=subcategorycontroller&amp;subcategory_id=41"><button class="btn btn-success">Photography</button></a>
                <a href="./index.php?action=subcategorycontroller&amp;subcategory_id=51"><button class="btn btn-success">Historical</button></a><br />

                <a href="./index.php?action=onecategorycontroller&amp;category_id=3"><button class="btn btn-primary">Conference</button></a>
                <a href="./index.php?action=subcategorycontroller&amp;subcategory_id=61"><button class="btn btn-success">Political</button></a>
                <a href="./index.php?action=subcategorycontroller&amp;subcategory_id=71"><button class="btn btn-success">Environmental</button></a>
                <a href="./index.php?action=subcategorycontroller&amp;subcategory_id=81"><button class="btn btn-success">Educational</button></a><br />


                <a href="./index.php?action=onecategorycontroller&amp;category_id=4"><button class="btn btn-primary">Hackathon</button></a>
                <a href="./index.php?action=subcategorycontroller&amp;subcategory_id=91"><button class="btn btn-success">Musical</button></a>
                <a href="./index.php?action=subcategorycontroller&amp;subcategory_id=101"><button class="btn btn-success">Environmental</button></a>
                <a href="./index.php?action=subcategorycontroller&amp;subcategory_id=111"><button class="btn btn-success">Social</button></a><br />

                <a href="./index.php?action=onecategorycontroller&amp;category_id=5"><button class="btn btn-primary">Game Jam</button></a>
                <a href="./index.php?action=subcategorycontroller&amp;subcategory_id=121"><button class="btn btn-success">FPS</button></a>
                <a href="./index.php?action=subcategorycontroller&amp;subcategory_id=131"><button class="btn btn-success">RPG</button></a>
                <a href="./index.php?action=subcategorycontroller&amp;subcategory_id=141"><button class="btn btn-success">MOBA</button></a><br />



            </div>
            <br />
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            Name
                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            Hour
                        </th>
                        <th>
                            Place
                        </th>
                        <th>
                            Category
                        </th>
                        <th>See more...</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    while ($data = $search->fetch()) {
                    ?>
                        <tr>
                            <td>
                                <?php echo $data['title']; ?>
                            </td>
                            <td>
                                <?php echo $data['event_date_formatted']; ?>
                            </td>
                            <td>
                                <?php echo $data['event_hour_formatted']; ?>
                            </td>
                            <td>PLACE</td>
                            <td> <?php echo $data['category']; ?></td>
                            <td><a href="./index.php?action=showEvent&amp;id=<?= $data['id'] ?>">See this event</a></td>
                        </tr>
                    <?php }
                    $search->closeCursor(); ?>
                </tbody>
            </table>
        </div>

    </div><!-- /.row -->
</main><!-- /.container -->

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>