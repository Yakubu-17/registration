<?php
ob_start();
session_start();

if (isset($_SESSION['user']) != "") {
    header("Location: index.php");
}
include_once 'dbconnect.php';

if (isset($_POST['signup'])) {

    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $oname = trim($_POST['oname']);  
    $dateOfBirth = trim($_POST['dateOfBirth']);                                     // get posted data and remove whitespace
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);
    $languages = trim($_POST['languages']);
    $hallOfResidence = trim($_POST['hallOfResidence']);
    $offCampusLocation = trim($_POST['offCampusLocation']);
    $roomNumber = trim($_POST['roomNumber']);
    $programOfstudy = trim($_POST['programOfStudy']);
    $studentID = trim($_POST['studentID']);
    $committeInterested = trim($_POST['committeInterested']);
    $whatsappContact = trim($_POST['whatsappContact']);
    $nationality = trim($_POST['nationality']);
    

    
   // $upass = trim($_POST['pass']);

    // hash password with SHA256;
  //  $password = hash('sha256', $upass);

    // check email exist or not
    $stmt = $conn->prepare("SELECT email FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $count = $result->num_rows;

    if ($count == 0) { // if email is not found add user


        $stmts = $conn->prepare("INSERT INTO users(fname,lname,oname,dateOfBirth,email,contact,languages,hallOfResidence,offCampusLocation,roomNumber,programOfStudy,studentID,committeInterested,whatsappContact,nationality) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmts->bind_param("sssssssssssssss", $fname, $lname, $oname, $dateOfBirth, $email, $contact, $languages, $hallOfResidence, $offCampusLocation, $roomNumber, $programOfStudy, $studentID, $committeInterested, $whatsappContact, $nationality );
        $res = $stmts->execute();//get result
        $stmts->close();

        $user_id = mysqli_insert_id($conn);
        if ($user_id > 0) {
            $_SESSION['user'] = $user_id; // set session and redirect to index page
            if (isset($_SESSION['user'])) {
                print_r($_SESSION);
                header("Location: index.php");
                exit;
            }

        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again";
        }

    } else {
        $errTyp = "warning";
        $errMSG = "Email is already used";
    }

}
?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Registration</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="assets/css/style.css" type="text/css"/>
</head>
<body>

<div class="container">

    <div id="login-form">
        <form method="post" autocomplete="off">

            <div class="col-md-12">

                <div class="form-group">
                    <h2 class="">GMSA Registration</h2>
                </div>

                <div class="form-group">
                    <hr/>
                </div>

                <?php
                if (isset($errMSG)) {

                    ?>
                    <div class="form-group">
                        <div class="alert alert-<?php echo ($errTyp == "success") ? "success" : $errTyp; ?>">
                            <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" name="fname" class="form-control" placeholder="First Name" required/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" name="lname" class="form-control" placeholder="Last Name" required/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" name="oname" class="form-control" placeholder="Other Names"/>
                    </div>
                </div>
                <div class="form-group">
                   <label for="date">Date of birth</label>
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        <input type="date" name="dateOfBirth" class="form-control" placeholder="Date of birth" required/>
                    </div>
                </div>    



                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                        <input type="email" name="email" class="form-control" placeholder="Enter Email" required/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></span>
                        <input type="text" name="contact" class="form-control" placeholder="Contact" required/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                        <input type="text" name="languages" class="form-control" placeholder="languages"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
                        <select type="text" name="hallOfResidence" class="form-control" placeholder="Hall of residence" required>
                          <option value="The University Hall">The University Hall</option>
                          <option value="Africa Hall">Africa Hall</option>
                          <option value="Unity Hall">Unity Hall</option>
                          <option value="Repulic Hall">Repulic Hall</option>
                          <option value="Independence Hall">Independence Hall</option>
                          <option value="Queen Elizaberth II Hall">Queen Elizaberth II Hall</option>


                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                        <input type="text" name="roomNumber" class="form-control" placeholder="Room Number"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                        <input type="text" name="offCampusLocation" class="form-control" placeholder="Off Campus Location"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                        <input type="text" name="programOfStudy" class="form-control" placeholder="Program of study" required/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                        <input type="text" name="studentID" class="form-control" placeholder="Student ID" required/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                        <select type="text" name="committeInterested" class="form-control" placeholder="Committe interested">
                          <option value="The University Hall">Educational Committe</option>
                          <option value="Africa Hall">Dawah Committe</option>
                          <option value="Unity Hall">Editorial Board Committe</option>
                          <option value="Repulic Hall">IT & Media Committe</option>
                          <option value="Independence Hall">Sport Committe</option>
                          <option value="Queen Elizaberth II Hall">Imamate Committe</option>
                          <option value="Africa Hall">Organizing Committe</option>
                          <option value="Africa Hall">Welfare Committe</option>


                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></span>
                        <input type="text" name="whatsappContact" class="form-control" placeholder="Whatsapp Contact" required/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                        <input type="text" name="nationality" class="form-control" placeholder="Nationality"/>
                    </div>
                </div>
               
<!--
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        <input type="password" name="pass" class="form-control" placeholder="Enter Password"
                               required/>
                    </div>
                </div>
                -->

                <div class="checkbox">
                    <label><input type="checkbox" id="TOS" value="This"><a href="#">I agree with
                            terms of service</a></label>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn    btn-block btn-primary" name="signup" id="reg">Register</button>
                </div>

                <div class="form-group">
                    <hr/>
                </div>

                <div class="form-group">
                    <a href="login.php" type="button" class="btn btn-block btn-success" name="btn-login">Login</a>
                </div>

            </div>

        </form>
    </div>

</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/tos.js"></script>

</body>
</html>
