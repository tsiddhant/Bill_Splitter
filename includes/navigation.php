<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Bill Splitter</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="homepage.php">Home</a></li>
                <li><a href="admin.php">ADMIN</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="register.php"><span ><i class="fa fa-user-plus"></i></span> Register</a></li>
                <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul>
        </div>
    </div>
</nav>


<style>
    .navbar-inverse {
      background: #2c3e50;
      color: rgba(255, 255, 255, 1);
    }
    .navbar-inverse .navbar-brand, .navbar-inverse a{
    color: rgba(255, 255, 255, 1);
    z-index: 2;
    display: block;
    cursor: pointer;
}


    
    .navbar-inverse .navbar-nav>li>a {
      color: rgba(255, 255, 255, 1);
    } 



</style>
