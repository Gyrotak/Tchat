<?php $title = "Authentification"; ?>
<?php ob_start(); ?>

<body class="text-center">
        <form class="form-signin" method="post">
          <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
          <label for="inputEmail" class="sr-only">Email address</label>
          <input type="email" id="inputEmail" name="email" class="form-control" style="width: 12%;margin: auto;" placeholder="Email address" required="" autofocus=""><br>
          <label for="inputPassword" class="sr-only">Password</label>
          <input type="password" id="inputPassword" name="password" class="form-control" style="width: 12%;margin: auto;" placeholder="Password" required=""><br>
          <button class="btn btn-lg btn-primary btn-block" style="width: 10%;text-align: center;margin: auto;" type="submit">Sign in</button>
<?php
    if (isset($error["email_error"]))
        print($error["email_error"] . " <br/>");
    if (isset($error["password_error"]))
        print($error["password_error"] . " <br/>");
?>
    
        </form>
</body>
    
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?> 