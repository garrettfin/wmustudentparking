<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/parkingfavicon.png"/>
    <title>WMU Parking Availability</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        header {
            background-color: #6e4210;
            color: #e7b50e;
            padding: 10px 0;
            text-align: center;
        }
        h1 {
            margin: 20px;
        }
        #call-to-action {
            text-align: center;
            margin: auto;
            margin-bottom: 20px;
        }
        #input-form {
            text-align: center;
            background-color: goldenrod;
            color: white;
            font-weight: bold;
            border-radius: 10px;
            padding: 10px;
            margin: auto;
            margin-bottom: 30px;
            width: 75%;
        }
        #Lot {
            width: 200px;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #f1f1f1;
            color: black;
            text-align: center;
            cursor: pointer;
        }
        #Density {
            width: 180px;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #f1f1f1;
            color: black;
            text-align: center;
            cursor: pointer;
        }
        .button {
            background-color: white;
            color: black;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .button:hover {
            background-color: lightgray;
        }
        .container {
            max-width: 85%;
            margin: 0 auto;
            padding: 20px;
            margin-bottom: 5%;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        } 
        footer {
            text-align: center;
            font-size: 11px;
        }
        a {
            color: inherit; 
        } 
    </style>
</head>

<body>
    <header>
        <h1>WMU Student Parking Availability</h1>
    </header>
    <div class="container">

        <h2 id="call-to-action">Update the Availability of a Parking Lot</h2>
        
        <form id="input-form" action="parking-lot-density.php" method="POST">

            <label for="Lot">Select a Parking Lot:</label>
            <select name="Lot" id="Lot" required>
                <option disabled selected value> -- select an option -- </option>
                <option value="Lot 35 (Miller Parking Garage)">Lot 35 (Miller Parking Garage)</option>
                <option value="Lot 41 (Sangren Hall)">Lot 41 (Sangren Hall)</option>
                <option value="Lot 55 (Valley 2)">Lot 55 (Valley 2)</option>
                <option value="Lot 61 (Rood Hall)">Lot 61 (Rood Hall)</option>
                <option value="Lot 72W (Schneider Hall)">Lot 72W (Schneider Hall)</option>
            </select>
            <br><br>

            <label for="Density">Select the Parking Lot Availability:</label>
            <select name="Density" id="Density" required>
            <option disabled selected value> -- select an option -- </option>
                <option value="Many Spots Available">Many Spots Available</option>
                <option value="More Than Half Full">More Than Half Full</option>
                <option value="Limited Spots Available">Limited Spots Available</option>
                <option value="Completely Full">Completely Full</option>
            </select>
            <br><br>

            <input type="submit" class="button" name="submit" id="submit" value="Submit">
        </form>

        <p style = 'text-align: center;'>Check the current availability of different student parking lots:</p>
        
        <?php
            $connect = mysqli_connect("sql308.infinityfree.com", "if0_38936271", "2102010Ergf3839", "if0_38936271_parkingdata");

            $query = "SELECT lot_name, lot_density, time_updated FROM ParkingLots ORDER BY lot_name;";
            $result = mysqli_query($connect, $query);
            $date = date('Y-m-d H:i:s');
            
            while($record = mysqli_fetch_assoc($result)) {
            $timestamp1 = strtotime($date);
            $timestamp1 = strtotime("-3 hours");
            $timestamp2 = strtotime($record['time_updated']);
            $timedif = $timestamp1 - $timestamp2;
            $timedif = $timedif / 60;
                if ($timedif < 240) {
                    echo "<h3>".$record['lot_name'].'</h3>';
                    if ($record['lot_density'] == 'Completely Full')
                        echo "<p style = 'color: #FF0000; text-shadow: 0 0 1px black;'>Status: ".$record['lot_density'].'</p>';
                    else if ($record['lot_density'] == 'Many Spots Available')
                        echo "<p style = 'color: #90EE90; text-shadow: 0 0 1px black;'>Status: ".$record['lot_density'].'</p>';
                    else if ($record['lot_density'] == 'More Than Half Full')
                        echo "<p style = 'color: #FFCC00; text-shadow: 0 0 1px black;'>Status: ".$record['lot_density'].'</p>';
                    else if ($record['lot_density'] == 'Limited Spots Available')
                        echo "<p style = 'color: #FF8C00; text-shadow: 0 0 1px black;'>Status: ".$record['lot_density'].'</p>';
                    $timedif = round($timedif);
                    echo "<p style='font-size: 11px; padding-bottom: 15px;'>Last Updated: ".$timedif.' minutes ago</p>';
                } else {
                    echo "<h3>".$record['lot_name'].'</h3>';
                    echo "<p style = 'color: black; text-shadow: 0 0 1px black;'>Status: Unknown</p>";
                    echo "<p style='font-size: 11px; width: 200px; padding-bottom: 15px;'>The status of this parking lot has not been updated in the past 4 hours</p>";
                }
            }
            
        ?>

    </div>
    
    <footer>
        <p>Please email me with any questions, comments, or concerns: </p>
        <a href="mailto:garrett.finley98@gmail.com">garrett.finley98@gmail.com</a>
        <p>This site is not affiliated with Western Michigan Unviersity in any way <br> and is run through student submitted updates</p>
    </footer>
    
</body>
</html>
