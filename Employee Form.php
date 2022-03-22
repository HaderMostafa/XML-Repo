<?php
session_start();
setcookie("count", 0, time() + 2 * 24 * 60 * 60, '/');

// link to xml file
$xmlObj = new DOMDocument("1.0", "UTF-8") or die("Error: Cannot create object"); ///**** */
$xmlObj->load("Employee.xml");

// root element
$root = $xmlObj->documentElement;
//$root = $xmlObj->getElementsByTagName("Employees")->item(0);
// $emp_name_val = $xmlObj->getElementsByTagName("id")->item(0)->nodeValue;

//************************************************NEXT***************************************************************** */
if (isset($_POST["next"])) {

    ++$_COOKIE["count"];
    $val = $_COOKIE["count"];

    $Emp_No = $xmlObj->getElementsByTagName("id")->length;

    if ($Emp_No == 0) {

        $emp_name_val = " ";
        $emp_phone_val = " ";
        $emp_address_val = " ";
        $emp_mail_val = " ";
        $val = $_COOKIE["count"] = 0;
        setcookie("count", $val, time() + 2 * 24 * 60 * 60, '/');

    } else {

        if ($_COOKIE["count"] <= $Emp_No) {

            setcookie("count", $val, time() + 2 * 24 * 60 * 60, '/');

            $i = $val - 1;
            $emp_name_val = $xmlObj->getElementsByTagName("Name")->item($i)->nodeValue;
            $emp_phone_val = $xmlObj->getElementsByTagName("Phone")->item($i)->nodeValue;
            $emp_address_val = $xmlObj->getElementsByTagName("Address")->item($i)->nodeValue;
            $emp_mail_val = $xmlObj->getElementsByTagName("Email")->item($i)->nodeValue;

        } else {

            $emp_name_val = " ";
            $emp_phone_val = " ";
            $emp_address_val = " ";
            $emp_mail_val = " ";
            $val = $Emp_No + 1;
            setcookie("count", $val, time() + 2 * 24 * 60 * 60, '/');

        }
    }
}

//************************************************PREV******************************************************************* */

if (isset($_POST["prev"])) {

    --$_COOKIE["count"];
    $val = $_COOKIE["count"];

    $Emp_No = $xmlObj->getElementsByTagName("id")->length;

    if ($Emp_No == 0) {

        $emp_name_val = " ";
        $emp_phone_val = " ";
        $emp_address_val = " ";
        $emp_mail_val = " ";
        $val = $_COOKIE["count"] = 0;
        setcookie("count", $val, time() + 2 * 24 * 60 * 60, '/');

    } else {

        if (($_COOKIE["count"]) > 0) {

            setcookie("count", $val, time() + 2 * 24 * 60 * 60, '/');

            $i = $val - 1;
            $emp_name_val = $xmlObj->getElementsByTagName("Name")->item($i)->nodeValue;
            $emp_phone_val = $xmlObj->getElementsByTagName("Phone")->item($i)->nodeValue;
            $emp_address_val = $xmlObj->getElementsByTagName("Address")->item($i)->nodeValue;
            $emp_mail_val = $xmlObj->getElementsByTagName("Email")->item($i)->nodeValue;

        } else {

            $emp_name_val = " ";
            $emp_phone_val = " ";
            $emp_address_val = " ";
            $emp_mail_val = " ";
            setcookie("count", 0, time() + 2 * 24 * 60 * 60, '/');

        }
    }
}

//************************************************INSERT****************************************************************** */

if (isset($_POST["insert"])) {

    // check that all fields are okay   /*********************** */

    // get data from input fields
    $emp_name = $_POST['name'];
    $emp_phone = $_POST['phone'];
    $emp_address = $_POST['address'];
    $emp_mail = $_POST['mail'];

    //echo $emp_name . $emp_phone . $emp_address . $emp_mail; //this line to test

    //to insert value of employee id
    $existed_Emp_No = $xmlObj->getElementsByTagName("id")->length; //array length
    if ($existed_Emp_No == 0) {
        $emp_id = 1;
    } else {
        $emp_id = $existed_Emp_No + 1;
    }

    //create Employee {
    $Emp = $xmlObj->createElement("Employee");
    $id = $xmlObj->createElement("id", $emp_id);
    $Name = $xmlObj->createElement("Name", $emp_name);
    $Phone = $xmlObj->createElement("Phone", $emp_phone);
    $Address = $xmlObj->createElement("Address", $emp_address);
    $Email = $xmlObj->createElement("Email", $emp_mail);

//append
    $root->appendChild($Emp);
    $Emp->appendChild($id);
    $Emp->appendChild($Name);
    $Emp->appendChild($Phone);
    $Emp->appendChild($Address);
    $Emp->appendChild($Email);

//save
    $xmlObj->save("Employee.xml");
}

//***********************************************UPDATE*************************************************************** */

if (isset($_POST["update"])) {

    $Emp_No = $xmlObj->getElementsByTagName("id")->length; //6
    $id;

    if ($_COOKIE["count"] > 0 && $_COOKIE["count"] <= $Emp_No) {

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&7&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&*/
        // for ($j = 0; $j < $Emp_No; $j++) {

        //     $matched_name = $xmlObj->getElementsByTagName("Name")->item($j)->nodeValue;
        //     $matched_phone = $xmlObj->getElementsByTagName("Phone")->item($j)->nodeValue;
        //     $matched_add = $xmlObj->getElementsByTagName("Address")->item($j)->nodeValue;
        //     $matched_mail = $xmlObj->getElementsByTagName("Email")->item($j)->nodeValue;

        //     if ($matched_name == $_POST['name']) {
        //         $id = $j;
        //     } else if ($matched_phone == $_POST['phone']) {
        //         $id = $j;
        //     } else if ($matched_add == $_POST['address']) {
        //         $id = $j;
        //     } else if ($matched_mail == $_POST['mail']) {
        //         $id = $j;
        //     }

        //     $xmlObj->getElementsByTagName("Name")[$id]->nodeValue = $_POST['name'];
        //     $xmlObj->getElementsByTagName("Phone")[$id]->nodeValue = $_POST['phone'];
        //     $xmlObj->getElementsByTagName("Address")[$id]->nodeValue = $_POST['address'];
        //     $xmlObj->getElementsByTagName("Email")[$id]->nodeValue = $_POST['mail'];
        // }

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&7&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&*/
        $empID = $_COOKIE["count"] - 1;

        $emp_name = $_POST['name'];
        $emp_phone = $_POST['phone'];
        $emp_address = $_POST['address'];
        $emp_mail = $_POST['mail'];

        $xmlObj->getElementsByTagName("Name")[$empID]->nodeValue = $emp_name;
        $xmlObj->getElementsByTagName("Phone")[$empID]->nodeValue = $emp_phone;
        $xmlObj->getElementsByTagName("Address")[$empID]->nodeValue = $emp_address;
        $xmlObj->getElementsByTagName("Email")[$empID]->nodeValue = $emp_mail;

        //save
        $xmlObj->save("Employee.xml");
    }
}

//*********************************************DELETE****************************************************************** */

if (isset($_POST["delete"])) {

    $Emp_No = $xmlObj->getElementsByTagName("id")->length;

    if ($_COOKIE["count"] > 0 && $_COOKIE["count"] <= $Emp_No) {

        foreach ($root->childNodes as $ElementEmp) {

            foreach ($ElementEmp->childNodes as $ElemChilds) {

                if ($ElemChilds->nodeName == "Name" && $ElemChilds->nodeValue == $_POST['name']) {

                    $parentElm = $ElemChilds->parentNode;
                    //print_r($parentElm);

                    $removedNode = $parentElm->nodeValue;
                    //print_r($removedNode);

                    $root->removeChild($ElementEmp);

                    //save
                    $xmlObj->save("Employee.xml");
                }
            }
        }

    }
}

//**************************************************SEARCH************************************************************* */

if (isset($_POST["search"])) {

    $Emp_No = $xmlObj->getElementsByTagName("id")->length;

    for ($j = 0; $j < $Emp_No; $j++) {

        $matched_name = $xmlObj->getElementsByTagName("Name")->item($j)->nodeValue;

        if ($matched_name == $_POST['name']) {

            $emp_name_val = $xmlObj->getElementsByTagName("Name")->item($j)->nodeValue;
            $emp_phone_val = $xmlObj->getElementsByTagName("Phone")->item($j)->nodeValue;
            $emp_address_val = $xmlObj->getElementsByTagName("Address")->item($j)->nodeValue;
            $emp_mail_val = $xmlObj->getElementsByTagName("Email")->item($j)->nodeValue;
        }
    }
}

//*************************************************************************************************************** */
?>
<!DOCTYPE html>
<html lang="en">

<title>Employee Form</title>

<head>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
        integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <style>
    html,
    body {
        display: flex;
        justify-content: center;
        font-family: Roboto, Arial, sans-serif;
        font-size: 15px;
    }

    form {
        border: 5px solid #f1f1f1;
        width: 70%
    }

    input {
        width: 100%;
        padding: 16px 8px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    button {
        background-color: #4286f4;
        color: white;
        padding: 14px 0;
        margin: 10px 0;
        border: none;
        cursor: grab;
        width: 20%;
    }

    h1 {
        text-align: center;
        font-size: 18;
    }

    button:hover {
        opacity: 0.8;
    }

    .formcontainer {
        text-align: center;
        margin: 24px 50px 12px;
    }

    .container {
        padding: 16px 0;
        text-align: left;
    }
    </style>
</head>

<body>
    <form method="post">
        <h1>Employee Form</h1>

        <div class=" formcontainer">
            <div class="container">
                <!-- Employee Form.php -->

                <label for="name"><strong>Name:</strong></label>
                <input type="text" placeholder="Enter Name" name="name" id="name"
                    value="<?php if (isset($_POST['prev']) || isset($_POST['next']) || isset($_POST['search'])) {echo $emp_name_val;}?>">

                <label for="phone"><strong>Phone Number:</strong></label>
                <input type="number" placeholder="Enter Phone Number" name="phone" id="phone"
                    value="<?php if (isset($_POST['prev']) || isset($_POST['next']) || isset($_POST['search'])) {echo $emp_phone_val;}?>">

                <label for="address"><strong>Address</strong></label>
                <input type="text" placeholder="Enter Address" name="address" id="address"
                    value="<?php if (isset($_POST['prev']) || isset($_POST['next']) || isset($_POST['search'])) {echo $emp_address_val;}?>">

                <label for="mail"><strong>E-mail</strong></label>
                <input type="email" placeholder="Enter E-mail" name="mail" id="mail"
                    value="<?php if (isset($_POST['prev']) || isset($_POST['next']) || isset($_POST['search'])) {echo $emp_mail_val;}?>">

            </div>

            <button type="submit" name="insert"><strong>Insert</strong></button>
            <button type="submit" name="update"><strong>Update</strong></button>
            <button type="submit" name="delete"><strong>Delete</strong></button>
            <button type="submit" name="search"><strong>Search</strong></button>
            <button type="submit" name="prev"><strong>Prev</strong></button>
            <button type="submit" name="next" <strong>Next</strong></button>
        </div>
    </form>
    <script>

    </script>
</body>

</html>