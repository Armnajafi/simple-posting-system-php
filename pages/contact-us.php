<?php
    include "../db.php";
    include "../classes/Location.class.php";
    include "../classes/Contact.class.php";

    $location = new Location();
    $contact = new Contact();
    $location->dbh = $dbh;
    $contact->dbh = $dbh;

    if(isset($_POST["phone_number"] , $_POST["message"] , $_POST["province"] , $_POST["city"])){
        $phone_number = $_POST["phone_number"];
        $message = $_POST["message"];
        $province = $_POST["province"];
        $city = $_POST["city"];
        if(!empty(trim($phone_number)) && !empty(trim($message)) && $province != 0 && $city != 0){
            if($contact->checkPhoneNumber($phone_number)){
                if(strlen($message) > 10){
                    $contact->addMessage($phone_number , $message , $province , $city);
                    echo "Your message sent";
                } else {
                    echo "Message text is very short";
                }
            } else {
                echo "Phone Number format is invalid";
            }
        } else {
            echo "please fill out the form";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact us</title>
</head>

<body>
    <h1>Contact Us</h1>
    <form action="" method="post">
        <input type="number" name="phone_number" placeholder="Enter Your phone number"><br>
        <textarea name="message" placeholder="Enter your message"></textarea><br>
        <select id="province" name="province">
            <option value="0" selected>Select Province</option>
            <?php
            foreach ($location->getProvinces() as $row) {
            ?>
                <option value="<?php echo $row["id"] ?>"><?php echo $row["name"] ?></option>
            <?php
            }
            ?>
        </select>

        <select id="city" name="city" disabled>
            <option value="0">Select City</option>
        </select>
        <br>
        <button type="submit">Send Message</button>
    </form>

    <script>
        let cities = [];

        <?php
        foreach ($location->getCities() as $row) {
        ?>
            cities.push({
                id: <?php echo $row["id"] ?>,
                name: "<?php echo $row["name"] ?>",
                pro_id: <?php echo $row["province_id"] ?>
            })
        <?php
        }
        ?>
        document.getElementById("province").addEventListener("change", function() {
            let selected_province = document.getElementById("province").value
            let city_select = document.getElementById("city")
            if (selected_province == 0) {
                city_select.disabled = true;
                return city_select.innerHTML = `<option value="0">Select city</option>`
            }
            let new_cities = cities.filter((item) => item.pro_id == selected_province)
            city_select.innerHTML = "";
            city_select.disabled = false;
            new_cities.map((city) => {
                document.getElementById("city").innerHTML += `<option value="${city.id}">${city.name}</option>`
            })
        })
    </script>
</body>

</html>