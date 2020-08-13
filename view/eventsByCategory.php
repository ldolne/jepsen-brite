<?php $title = 'Events by category'; ?>

<?php ob_start(); ?>

<main role="main" class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Events by category</h2>
            <div class="search">
                <nav>
                    <ul>
                        <li><a href="./index.php?action=showAllCategories"><button class="btn btn-primary">All</button></a></li>

                        <li style="list-style-type: none;"><a href="./index.php?action=showOneCategory&amp;category_id=1"><button class="btn btn-primary">Concert</button></a>
                            <ul style="list-style-type: none;">
                                <li style="list-style-type: none;"><a href="./index.php?action=showOneSubcategory&amp;subcategory_id=1"><button class="btn btn-info">Metal</button></a></li>
                                <li><a href="./index.php?action=showOneSubcategory&amp;subcategory_id=11"><button class="btn btn-info">Classic</button></a></li>
                                <li><a href="./index.php?action=showOneSubcategory&amp;subcategory_id=21"><button class="btn btn-info">EDM</button></a></li>
                            </ul>
                        </li>

                        <li style="list-style-type: none;"><a href="./index.php?action=showOneCategory&amp;category_id=2"><button class="btn btn-primary">Exhibition</button></a>
                            <ul  style="list-style-type: none;"> 
                                <li><a href="./index.php?action=showOneSubcategory&amp;subcategory_id=31"><button class="btn btn-info">Contemporary art</button></a></li>
                                <li><a href="./index.php?action=showOneSubcategory&amp;subcategory_id=41"><button class="btn btn-info">Photography</button></a></li>
                                <li><a href="./index.php?action=showOneSubcategory&amp;subcategory_id=51"><button class="btn btn-info">Historical</button></a></li>
                            </ul>
                        </li>

                        <li style="list-style-type: none;"><a href="./index.php?action=showOneCategory&amp;category_id=3"><button class="btn btn-primary">Conference</button></a>
                            <ul  style="list-style-type: none;">
                                <li><a href="./index.php?action=showOneSubcategory&amp;subcategory_id=61"><button class="btn btn-info">Political</button></a></li>
                                <li><a href="./index.php?action=showOneSubcategory&amp;subcategory_id=71"><button class="btn btn-info">Environmental</button></a></li>
                                <li><a href="./index.php?action=showOneSubcategory&amp;subcategory_id=81"><button class="btn btn-info">Educational</button></a></li>
                            </ul>
                        </li>

                        <li style="list-style-type: none;"><a href="./index.php?action=showOneCategory&amp;category_id=4"><button class="btn btn-primary">Hackathon</button></a>
                            <ul  style="list-style-type: none;"> 
                                <li><a href="./index.php?action=showOneSubcategory&amp;subcategory_id=91"><button class="btn btn-info">Musical</button></a></li>
                                <li><a href="./index.php?action=showOneSubcategory&amp;subcategory_id=101"><button class="btn btn-info">Environmental</button></a></li>
                                <li><a href="./index.php?action=showOneSubcategory&amp;subcategory_id=111"><button class="btn btn-info">Social</button></a></li>
                            </ul>
                        </li>

                        <li style="list-style-type: none;"><a href="./index.php?action=showOneCategory&amp;category_id=5"><button class="btn btn-primary">Game Jam</button></a>
                            <ul>
                                <li><a href="./index.php?action=showOneSubcategory&amp;subcategory_id=121"><button class="btn btn-info">FPS</button></a></li>
                                <li><a href="./index.php?action=showOneSubcategory&amp;subcategory_id=131"><button class="btn btn-info">RPG</button></a></li>
                                <li><a href="./index.php?action=showOneSubcategory&amp;subcategory_id=141"><button class="btn btn-info">MOBA</button></a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <br />

            </div>
            <br />
            <table class="table EspaceTable">
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
                            <td style="color: white;">
                                <?php echo $data['title']; ?>
                            </td>
                            <td>
                                <?php echo $data['event_date_formatted']; ?>
                            </td>
                            <td>
                                <?php echo $data['event_hour_formatted']; ?>
                            </td>
                            <td>
                                <?php echo $data['category']; ?>
                            </td>
                            <td><a href="./index.php?action=showEvent&amp;id=<?= $data['id'] ?>"><button class="btn btn-light"><div style="color: #ff0060;">See this event</div></button></a></td>
                        </tr>
                    <?php }
                    $search->closeCursor();
                    ?>
                </tbody>
            </table>
        </div>

    </div><!-- /.row -->
</main><!-- /.container -->

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>