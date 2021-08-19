<?php

class Page
{

    private $_title = "Please change title.";

    function __construct(string $title)
    {
        $this->_title = $title;
    }

    function header()
    { ?>

        <!doctype html>
        <html lang="en">

        <head>
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

            <style>
                h1 {
                    margin-bottom: 25px;
                }
                p {
                    padding: 0px;
                    margin: 0px;
                    font-size: 12px;
                    vertical-align: middle;
                }
                .stats {
                    margin-bottom: 15px;
                    padding-top: 5px;
                }
                .label {
                    float: left;
                    width: 15%;
                }
                .progress {
                    width: 50%;
                }
                th,td {
                    vertical-align: middle !important; 
                    text-align: center;
                }
                form {
                    margin-top: 10px;
                }
                form.stats{
                    margin: 20px 0;
                }
                .error {
                    float: right;
                    color: red;
                    font-weight: bold;
                }
            </style>

            <title><?php echo $this->_title; ?></title>
        </head>

        <body>
            <div class="container">
                <h1><?php echo $this->_title; ?></h1>

            <?php }

        function footer()
        { ?>

            </div>
            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        </body>

        </html>

    <?php }

        function displaySeatingPlan(array $seatingPlan)
        {    ?>
            <table class="table">
            <thead class="thead-light">
            <?php
            //Show the number of cols
            for ($r = 1; $r <= $seatingPlan['rowWidth']; $r++) {
                echo '<th scope="col">' . $r . '</th>';
            } ?>
            </thead>

            <?php
            $islePos = $seatingPlan['islePosition'];
            //Go through the seating plan by each row
            for ($r = 0; $r < sizeof($seatingPlan) - 3; $r++) {
                echo "<tr>";
                //go through each seat
                for ($s = 0; $s < sizeof($seatingPlan[$r]); $s++) {
                    //If the current plan is an isle then print tha
                    if ($s == $islePos - 1) {
                        echo '<td width="36" height"44">[' . 'Isle' . ']</td>';
                    } else {
                        //If the seat is taken display a the image icon, if not display the price
                        if ($seatingPlan[$r][$s]->getOccupied()) {
                            echo '<td width="36" height="44" class="table-info"><img src="img/personicon.png" style="{background-color: white}"></td>';
                        } else {
                            echo '<td width="36" height="44"><a href="' . $_SERVER['PHP_SELF'] . '?data=PHP&row=' . $r . '&seat='. $s .'">' . 
                            $seatingPlan[$r][$s]->getPrice() . '</a></td>';
                        }
                    }
                }
                echo "</tr>";
            }
            echo "</table>";
        }

        function displayStatistics($stats)
        { ?>
        <div class="stats">
            <div class="label">
                <p>Total Seats</p>
            </div>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width:<?php echo  
                round($stats["seatsBooked"] / $stats["totalSeats"] * 100) . 
                "%;" ?>" 
                aria-valuenow="<?php echo $stats["seatsBooked"]; ?>" aria-valuemin="0" 
                aria-valuemax="<?php echo $stats["totalSeats"]; ?>">
                <?php echo $stats["seatsBooked"]; ?></div>
            </div>
        </div>
        <div class="stats">
            <div class="label">
                <p>Window Seats</p>
            </div>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style=width:<?php echo 
                round($stats["windowSeatsBooked"] / $stats["totalWindowSeats"] * 100) . 
                "%;" ?>" 
                aria-valuenow="<?php echo $stats["windowSeatsBooked"]; ?>" aria-valuemin="0" 
                aria-valuemax="<?php echo $stats["totalWindowSeats"]; ?>">
                <?php echo $stats["windowSeatsBooked"]; ?></div>
            </div>
        </div>
        <div class="stats">
            <div class="label">
                <p>Isle Seats</p>
            </div>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style=width:<?php echo 
                round($stats["isleSeatsBooked"] / $stats["totalIsleSeats"] * 100) . 
                "%;" ?>" 
                aria-valuenow="<?php echo $stats["isleSeatsBooked"]; ?>" aria-valuemin="0" 
                aria-valuemax="<?php echo $stats["totalIsleSeats"]; ?>">
                <?php echo $stats["isleSeatsBooked"]; ?></div>
            </div>
        </div>
        <div class="stats">
            <div class="label">
                <p>Seats with Leg Room</p>
            </div>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style=width:<?php echo 
                round($stats["legRoomSeatsBooked"] / $stats["totalLegRoomSeats"] * 100) . 
                "%;" ?>" 
                aria-valuenow="<?php echo $stats["legRoomSeatsBooked"]; ?>" aria-valuemin="0" 
                aria-valuemax="<?php echo $stats["totalLegRoomSeats"]; ?>">
                <?php echo $stats["legRoomSeatsBooked"]; ?></div>
            </div>
        </div>
        <form class="stats" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <input class="btn btn-primary" type="submit" name="clear" value="Clear Manifest">
        </form>
        <?php }


        function displayManifestform()
        { ?>
            <h3>Generate Manifest</h3>
            <p style="font-size: 15px; margin: 20px 0;">Please create the manifest below by setting the various options and clicking "Generate Manifest"</p>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="rows">Number of Rows</label>
                    <div class="col-sm-4">
                        <input class="form-control" type="text" name="rows" value="">
                    </div>
                    <span class="error">* <?php echo Validation::$_rowsError;?></span>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="width">Row Width (including isle)</label>
                    <div class="col-sm-4">
                        <input class="form-control" type="text" name="width" value="">
                    </div>
                    <span class="error">* <?php echo Validation::$_widthError;?></span>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="islePos">Isle Position</label>
                    <div class="col-sm-4">
                        <input class="form-control" type="text" name="islePos" value="">
                    </div>
                </div>
                <input class="btn btn-primary" type="submit" name="submit" value="Generate Manifest">
            </form>

    <?php }
    }

    ?>