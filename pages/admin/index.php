<?php
session_start();

include "../../db.php";
include "../../classes/Auth.class.php";
include "../../classes/Contact.class.php";
include "../../classes/Location.class.php";

$login = new Auth();
$contact = new Contact();
$location = new Location();
$login->dbh = $dbh;
$contact->dbh = $dbh;
$location->dbh = $dbh;

if (!$login->checkLoginAdmin()) return  header("location: ../login.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <title>Document</title>
</head>

<body>
    <a href="../user/logout.php">Logout</a>
    <hr>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <td>Phone Number</td>
                <td>Message</td>
                <td>Province</td>
                <td>City</td>
                <td>Remove</td>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($contact->allMessages() as $row) {
            ?>
                <tr>
                    <td><?php echo $row["phone"] ?></td>

                    <td>
                        <div class="messageContainer">
                            <span class="message"> <?php echo $row["message"] ?></span>
                            <button class="showMoreButton">More</button>
                        </div>
                    </td>
                    <td><?php echo $location->getProvinceById($row["province"])["name"] ?></td>
                    <td><?php  echo $location->getCityById($row["city"])["name"] ?></td>
                    <td><a href="delete-message.php?id=<?php echo $row["id"] ?>">Remove</a></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        new DataTable('#example');

        var messageElements = document.querySelectorAll(".message");
        var showMoreButtons = document.querySelectorAll(".showMoreButton");

        var maxLength = 30;
        var isCollapsed = true;

        var originalMessages = [];
        var limitedMessages = [];

        messageElements.forEach(function(messageElement, index) {
            originalMessages.push(messageElement.innerText);
            limitedMessages.push(messageElement.innerText.substring(0, maxLength));

            messageElement.innerText = limitedMessages[index];
        });

        showMoreButtons.forEach(function(showMoreButton, index) {
            showMoreButton.addEventListener("click", function() {
                if (isCollapsed) {
                    messageElements[index].innerText = originalMessages[index];
                    showMoreButton.innerText = "Less";
                } else {
                    messageElements[index].innerText = limitedMessages[index];
                    showMoreButton.innerText = "More";
                }
                isCollapsed = !isCollapsed;
            });
        });
    </script>
</body>

</html>