<div class="d-flex" id="wrapper">


    <div class="bg-light border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">Welcome <br><?php echo $_SESSION['name']; ?></div>
        <div class="list-group list-group-flush">
            <a href="admin.php" class="list-group-item list-group-item-action bg-light">Dashboard</a>
            <a href="groups.php" class="list-group-item list-group-item-action bg-light">Groups</a>
            <a href="expense_overview.php" class="list-group-item list-group-item-action bg-light">Expense Overview</a>
            <a href="friends.php" class="list-group-item list-group-item-action bg-light">Friends</a>
            <a href="profile.php" class="list-group-item list-group-item-action bg-light">Profile</a>
            <a href="includes/logout.php" class="list-group-item list-group-item-action bg-light">Logout</a>
        </div>
    </div>

    <div id="page-content-wrapper">

        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <button class="btn btn-primary" id="menu-toggle">ADMIN</button>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="homepage.php">Home Page<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="profile.php?source=edit_profile">Edit Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><?php echo $_SESSION['username']; ?></a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid">