<?php
session_start();

if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" || $_SESSION['usertype'] != 'p') {
        header("location: ../login.php");
        exit();
    } else {
        $useremail = $_SESSION["user"];
    }
} else {
    header("location: ../login.php");
    exit();
}

include("../connection.php");

$sqlmain = "select * from patient where pemail=?";
$stmt = $database->prepare($sqlmain);
$stmt->bind_param("s", $useremail);
$stmt->execute();
$result = $stmt->get_result();
$userfetch = $result->fetch_assoc();
$userid = $userfetch["pid"];
$username = $userfetch["pname"];

date_default_timezone_set('Asia/Kolkata');
$today = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="shortcut icon" href="../assets/images/nho-logo.jpg" type="image/x-icon">
   
        
    <title>Sessions</title>

    <style>
        label{
            padding-bottom: 0.5rem;
            padding-top: 1rem;
            font-family: 'Times New Roman', Times, serif;
            color: #161c2d;
        }
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .text-success{
            color:green;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="menu py-12">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container ">
                            <tr>
                                <td width="30%" style="padding-left:20px">
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($username, 0, 13) ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail, 0, 22) ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php"><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-home">
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">Home</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu "><div><p class="menu-text py-5">All Health Advocates</p></div></a>
                    </td>
                </tr>
                <!-- <tr class="menu-row">
                    <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                        <a href="schedule.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Scheduled Sessions</p></div></a>
                    </td>
                </tr> -->
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text py-5">My Bookings</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></div></a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body">
            
        <?php
                    $out_put ='<h4 class="text-center">fill all field</h4>';
                    if(isset($_POST["books"])){
                    
                        // $statement= "SELECT  * FROM doctor";
                        // $res = $database -> query($statement);
                        $booking_date=$_POST['booking_date'];
                        $inf=$_POST['inf'];
                        $com=$_POST['com'];
                        $schid=$_POST['session_id'];
                        $book_price=$_POST['book_price'];

                        if ($inf==""){
                           
                            // $sqlmain = "select * from patient where pemail=?";
                            // $stmt = $database->prepare($sqlmain);
                            // $stmt->execute();
                            $sql1="insert into appointment(pid,scheduleid, appodate,labtype,price) values('$userid', '$schid','$booking_date','$com','$book_price');";
                           
                            $database->query($sql1);
                            // $out_put ='<h4 class="text-center text-success">Data saved successfully</h4>';

                            ?>
                            <script>
                                window.location.href = "appointment.php";
                            </script>
                            <?php

                            // header("Location: index.php");
                            // exit();
                        
                        }elseif($com ==""){
                            
                            // $sql1="insert into appointment(pid,appodate,labtype,price) values('$userid','$booking_date','$inf','$book_price');";
                            $sql1="insert into appointment(pid,scheduleid, appodate,labtype,price) values('$userid', '$schid','$booking_date','$inf','$book_price');";
                           
                            $database->query($sql1);

                            ?>
                            <script>
                                window.location.href = "appointment.php";
                            </script>
                            <?php

                            // $out_put ='<h4 class="text-center text-success">Data saved successfully</h4>';

                            // header("Location: index.php");
                            // exit();
                       
                        }else{
                            echo "error in data entry";
                        }

                        
                    } 
                    
                ?>
            <div class="w-1/2 mx-auto  bg-slate-100 md:  mt-12">
            <h2 class="text-center  pt-8">Appointment Booking</h2>
            <?=$out_put?>
                <form action="" method="POST" class="p-4">
                    <div class="space-y-12">
                         <!-- <div class="sm:col-span-4">
                            <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                            <div class="mt-2">
                                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                <span class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">workcation.com/</span>
                                <input type="text" name="username" id="username" autocomplete="username" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="janesmith">
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <label for="" class="block">Appointment Date</label>
                    <input type="datetime-local" name="booking_date" id="" class="block text-sm flex-1 border-2 bg-white rounded py-1.5 pl-1 text-gray-900 w-1/2" required>

                    <label for="" class="block">Select Session</label>
                    <select name="session_id" id="" class="block flex-1 border-2 bg-white rounded py-1.5 pl-1 text-gray-900 w-full text-sm" required>
                        <!-- <option value="">Daniel Amartey</option>
                        <option value="">Frimpong Akwasi</option>-->
                        
                        <?php
                                $list11= "SELECT  * FROM schedule";
                                $res = $database -> query($list11);

                                if ($res -> num_rows  > 0){
                                    ?>
                                    <option value="">Click to  select ...</option>
                                    <?php
                                    while ($row = $res-> fetch_assoc()){
                                        $schid = $row["scheduleid"];
                                        $schdate = $row["scheduledate"];
                                        $schtime = $row["scheduletime"]; 
                                        echo '<option value='.$schid.'>'.$schdate." - ".$schtime.'<option/>';
                                    }
                                }else{
                                    echo "<option value=''>No Session Available</option>";
                                }
                                
                            ?>
                    </select>
                   
                    <label for="" class="block">Select Test Type</label>
                    <select name="" id="labs" class="block flex-1 border-2 bg-white rounded py-1.5 pl-1 text-gray-900 w-full text-sm" onChange="myBook();" required>
                        <option value="">click to select ..</option>
                        <option value="infect">Infectious Disease   Test</option>
                        <option value="compat">Compatibility Test</option>
                    </select>

                    <label for="" id="myInfectx" class="block">Select Specific test</label>
                    <select name="inf" id="myInfect" class="block flex-1 border-2 bg-white rounded py-1.5 pl-1 text-gray-900 w-full text-sm">
                    <option value="">click to select ..</option>
                        <option value="HIV">HIV</option>
                        <option value="HB">HB</option>
                        <option value="HC">HC</option>
                    </select>

                    <label for="" id="myCompatx" class="block">Select Specific test</label>
                    <select name="com" id="myCompat" class="block flex-1 border-2 bg-white rounded py-1.5 pl-1 text-gray-900 w-full text-sm">
                    <option value="">click to select ..</option>
                        <option value="Blood Group">Blood Group</option>
                        <option value="HB Hemoglobin Genotype">HB Hemoglobin Genotype</option>
                        <option value="HC">HC</option>
                    </select>

                    
                    <div class="pt-3">
                         <label for="" class="block">Price</label>
                        <input type="text" name="book_price" readonly id="price" class="block flex-1 border-2 bg-white rounded py-1.5 pl-1 text-gray-900 w-full text-sm">
                    </div>
                   
                    <!-- <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Doctor name or Email or Date (YYYY-MM-DD)" list="doctors">&nbsp;&nbsp; -->
                    <label for="" class="block">Select health Advocate</label>
                    <select name="" id="" class="block flex-1 border-2 bg-white rounded py-1.5 pl-1 text-gray-900 w-full text-sm" required>
                        <!-- <option value="">Daniel Amartey</option>
                        <option value="">Frimpong Akwasi</option>-->
                        
                        <?php
                                $list11= "SELECT  * FROM doctor";
                                $res = $database -> query($list11);

                                if ($res -> num_rows  > 0){
                                    ?>
                                    <option value="">Click to  select ...</option>
                                    <?php
                                    while ($row = $res-> fetch_assoc()){
                                        $d = $row["docname"];
                                        echo '<option value="'.$d.'">'.$d.'<option/>';
                                    }
                                }else{
                                    echo "<option value=''>No Health Advocate Available</option>";
                                }
                                
                            ?>
                    </select>    
                   
                   
                    <div class="my-4">
                        <button type="submit" name="books" class="bg-blue-600 px-4 py-2 rounded text-slate-100 text-sm">Confirm Bookings</button>
                    </div>
                    
                    

                    
                    
                </form>

               

            </div>
           <!-- <table border="0" width="100%" style="border-spacing: 0; margin:0; padding:0; margin-top:25px;">
                 <tr>
                    <td width="13%">
                        <a href="schedule.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px; padding-bottom:11px; margin-left:20px; width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <form action="schedule.php" method="post" class="header-search">
                            <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Doctor name or Email or Date (YYYY-MM-DD)" list="doctors">&nbsp;&nbsp;
                            <?php
                                // echo '<datalist id="doctors">';
                                // $list11 = $database->query("select DISTINCT * from doctor;");
                                // $list12 = $database->query("select DISTINCT * from schedule GROUP BY title;");
                                // for ($y = 0; $y < $list11->num_rows; $y++) {
                                //     $row00 = $list11->fetch_assoc();
                                //     $d = $row00["docname"];
                                //     echo "<option value='$d'><br/>";
                                // }
                                // for ($y = 0; $y < $list12->num_rows; $y++) {
                                //     $row00 = $list12->fetch_assoc();
                                //     $d = $row00["title"];
                                //     echo "<option value='$d'><br/>";
                                // }
                                // echo ' </datalist>';
                            ?>
                            <input type="submit" value="Search" class="login-btn btn-primary btn" style="padding-left:10px;">
                            <br>
                        </form>
                    </td>
                </tr>
                  Add your content here 
            </table>  -->
        </div>
    </div>
   
    <script>
         const inputInfect =document.getElementById("myInfect");
         const inputCompat =document.getElementById("myCompat");
         const myInfectTxt =document.getElementById("myInfectx");
         const myCompatTxt =document.getElementById("myCompatx");

         myInfectTxt.style.display = "none";
         inputInfect.style.display = "none";

         inputCompat.style.display = "none";
         myCompatTxt.style.display = "none";

        function myBook(){
             
             const labType = document.getElementById("labs").value;
            
             
             
             if(labType =="infect"){
                inputCompat.value = "";
                inputCompat.style.display = "none";
                myCompatTxt.style.display = "none";
                myInfectTxt.style.display = "block";
                inputInfect.style.display = "block";
                 document.getElementById('price').value="200";
             } else if(labType=="compat"){
                inputInfect.value = "";
                myInfectTxt.style.display = "none";
                inputInfect.style.display = "none";
                inputCompat.style.display = "block";
                myCompatTxt.style.display = "block";
                document.getElementById('price').value="100";
                
             }else{
                    alert(labType);
             }
            //  document.getElementById('price').value=200;
             
        }
        
    </script>
</body>
</html>
