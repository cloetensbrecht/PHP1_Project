<!-- TODO  < ?php include_once '../inc/nav.inc.php'; ?> -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="index.php">Travel Inspiration</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <!-- <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="upload.php">New Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php?id=<?php echo $id; ?>">My profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="updateProfile.php?id=<?php echo $id; ?>">Edit my profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="updatePassword.php?id=<?php echo $id; ?>">Edit password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
                <!-- FEATURE 6 - SEARCH -->
                <form class="form-inline my-2 my-lg-0" action="" method="GET" name='search'>
                    <input class="form-control mr-sm-2" name="searchInput" type="search" placeholder="Search"
                        aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>