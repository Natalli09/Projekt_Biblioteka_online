<?php
    session_start();
    if(isset($_POST['login']))
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        if($email == '')
        {
            echo "<script>alert('FILL EMAIL ');</script>";
        }
        if($password == '')
        {
            echo "<script>alert('FILL PASSWORD ');</script>";
        }
        else 
        {
            $conn = mysqli_connect('localhost','root','','bookstore');
            $log = "select * from sign_up where email='$email' && password='$password'";
            $data = mysqli_query($conn,$log);
            $check = mysqli_fetch_array($data);
            if(is_array($check)) 
            {
                $_SESSION['logid'] = $check['id_user'];
            } 
            else 
            {
                echo "<script>alert('Please Enter Correct Info !');</script>";
            }
        }
        if(isset($_SESSION['logid'])) 
        {
            header("Location:index_after.php");
        }
        
    }
?>
<!-- ================================================login=================================================== -->
<div class="container" id="bgfree" style="background:url('hdimg/homeback.png');">
    <h2 id="h2" class="">WIELE EBOOKÓW. NIEDROGIE I DOSTĘPNE</h2>
    <p id="p">Witamy w przyjaznej bibliotece sąsiedzkiej. Zapoznaj się z naszą kolekcją ponad 50 000 książek elektronicznych dostępnych w bezkonkurencyjnych cenach, gotowych do odkrycia.
    </p>
    <a type="submit" class="btn btn-lg" data-toggle="modal" data-target="#myModal" id="lgnbtn">login/signup</a>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="padding:35px 50px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-lock"></span> Login</h4>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <form role="form" method="POST">
                        <div class="form-group">
                            <label for="email"><span class="glyphicon glyphicon-user"></span> Username</label>
                            <input type="text" class="form-control" id="email"  placeholder="Enter Your Email Address" name="email" >
                        </div>
                        <div class="form-group">
                            <label for="password"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter Your password"  name="password"  >
                        </div>
                        <button type="submit" class="btn btn-success btn-block" name="login"><span
                                    class="glyphicon glyphicon-off"></span> Login</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span
                        class="glyphicon glyphicon-remove"></span> Cancel</button>
                        <p>Not a member? 
                            <a type="button" data-toggle="modal" data-target="#signup" id="aset" style="color: black;">sign up</a>
                        </p>
                        <p>
                            <a type="button" data-toggle="modal" data-target="#forget" id="aset" style="color: black;">Forget Password?</a>
                        </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ================================================sign-up=================================================== -->
<div class="modal fade" role="dialog" id="signup">`
    <div class="modal-dialog" style=" width: 680px; height: 520px; margin-top: 10px">
        <div class="modal-content">
            <div class="modal-header" style="padding:35px 50px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4><span class="glyphicon glyphicon-lock"></span> SIGN-UP</h4>
            </div>
            <div class="modal-body" style="padding:40px 50px;">
                <form class="form-horizontal" role="form" method="post">
                    <div class="form-group">
                        <label for="firstName" class="col-sm-3 control-label">First Name</label>
                        <div class="col-sm-9">
                            <input type="text" id="firstName" name="fname" placeholder="First Name" class="form-control" autofocus >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lastName" class="col-sm-3 control-label">Last Name</label>
                        <div class="col-sm-9">
                            <input type="text" id="lastName" placeholder="Last Name" class="form-control" name="lname" autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label">Address</label>
                        <div class="col-sm-9">
                            <input type="text" id="address" placeholder="Enter your Address" class="form-control" name="address">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email* </label>
                        <div class="col-sm-9">
                            <input type="email" id="email" placeholder="Email" class="form-control" name="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">Password*</label>
                        <div class="col-sm-9">
                            <input type="password" id="password" placeholder="Password" class="form-control" name="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-block" name="submit">Sign-up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ----------------------------------------------------------------------------------------------------------- -->

    <!-- ===============================signup database php code====================== -->
<?php
    if(isset($_POST['submit']))
    {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        if($fname == '')
        {
            echo "<script>alert('Fill frist name');</script>";
        }
        if($lname == '')
        {
            echo "<script>alert('Fill last name');</script>";
        }
        if($email == '')
        {
            echo "<script>alert('Fill Email');</script>";
        }
        if($password == '')
        {
            echo "<script>alert('Fill Password');</script>";
        }
        if($address == '')
        {
            echo "<script>alert('Fill  address');</script>";
        }
        else{
            $conn = mysqli_connect('localhost','root','','bookstore');
            $query = "INSERT INTO sign_up(fname,lname,address,email,password) VALUES('".$fname."','".$lname."','".$address."','".$email."','".$password."')";
            $data = mysqli_query($conn,$query);
            if($data)
            {
                echo "<script>alert('sign-up successfull');</script>";
            }
            else
            {
                echo "<script>alert('sign-up failed');</script>";
            }
        }
    }
?>
