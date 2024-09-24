<?php
	session_start();
?>
<style>
* {
    box-sizing: border-box;
}

body {
    /* background: url("assets/img/doc2.png") left top no-repeat !important; */
    /* background-size: cover; */
    /* position: relative; */
    width: 100%;
    height: 100vh;
    /* background: linear-gradient(to bottom, #33ccff 40%, #ffcc66 86%); */
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    font-family: 'Montserrat', sans-serif;
    height: 100vh;
    margin: -20px 0 50px;
}

h1 {
    font-weight: bold;
    margin: 0;
}

h2 {
    text-align: center;
}

p {
    font-size: 14px;
    font-weight: 100;
    line-height: 20px;
    letter-spacing: 0.5px;
    margin: 20px 0 30px;
}

span {
    font-size: 12px;
}

a {
    color: #333;
    font-size: 14px;
    text-decoration: none;
    margin: 15px 0;
}

button {
    border-radius: 20px;
    border: 1px solid #FF4B2B;
    background-color: #FF4B2B;
    color: #FFFFFF;
    font-size: 12px;
    font-weight: bold;
    padding: 12px 45px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: transform 80ms ease-in;
}

button:active {
    transform: scale(0.95);
}

button:focus {
    outline: none;
}

button.ghost {
    background-color: transparent;
    border-color: #FFFFFF;
}

form {
    background-color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 50px;
    height: 100%;
    text-align: center;
}

input {
    background-color: #eee;
    border: none;
    padding: 12px 15px;
    margin: 8px 0;
    width: 100%;
}

.container {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
    position: relative;
    overflow: hidden;
    width: 768px;
    max-width: 50%;
    min-height: 480px;
}

.form-container {
    position: absolute;
    top: 0;
    height: 100%;
    transition: all 0.6s ease-in-out;
}

.sign-in-container {
    left: 0;
    width: 100%;
    z-index: 2;
}

.container.right-panel-active .sign-in-container {
    transform: translateX(100%);
}

.sign-up-container {
    left: 0;
    width: 50%;
    opacity: 0;
    z-index: 1;
}

.container.right-panel-active .sign-up-container {
    transform: translateX(100%);
    opacity: 1;
    z-index: 5;
    animation: show 0.6s;
}

@keyframes show {

    0%,
    49.99% {
        opacity: 0;
        z-index: 1;
    }

    50%,
    100% {
        opacity: 1;
        z-index: 5;
    }
}

.social-container {
    margin: 20px 0;
}

.social-container a {
    border: 1px solid #DDDDDD;
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    margin: 0 5px;
    height: 40px;
    width: 40px;
}

.doc-frm {
    margin-left: 40%;
}

.doc-frm h2 {
    margin-right: 50%;
}
</style>
<div class="doc-frm">
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form method="POST" actions="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" autocomplete="on">
                <h1>Login in</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <!-- <span>or use your account</span> -->
                <input type="email" name="email" placeholder="Email" />
                <input type="password" name="password" placeholder="Password" />
                <button name="submit" id="signUp">Log In</button>

            </form>
        </div>

    </div>
</div>
<?php

$conn=mysqli_connect('localhost','root','','warehouse_final');
	if (isset($_POST['submit'])) {
		$email= $_POST["email"];
		$password= $_POST["password"];
		$query = "SELECT * FROM users WHERE email= '$email' AND password='$password'";
		$run = mysqli_query($conn,$query);
		if (mysqli_num_rows($run)>0) {
			$data = mysqli_fetch_assoc($run);
			$_SESSION['authrole'] = $data['role'];
			$_SESSION['authemail'] = $email;
			$_SESSION['authid'] = $data['id'];
			$_SESSION['name']= $data['name'];
			if ($data['role']=='admin') {
			header('location: admin/header.php');
			}elseif($data['role']=='user') {
				header('location: user/header.php');
			}
		}else{
			?>
<script>
alert("Incorrect Password");
</script>
<?php
			header('location:login.php');  //redirecting to login page
		}

	}


?>