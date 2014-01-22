<div id="sidebar-wrapper">
    <br>
    <!-- Sidebar Profile links -->
    <div id="profile-links">Hello, <?php echo $_SESSION['LoginedAdmministratorName'];?><br>Your login time is <?php echo  date("d-m-y H:i:s");?></a><br />
        <a href="<?php echo GlobalPath;?>" title="Visit the WebSite">Visit The WebSite</a> | <a href="logoff.php" title="Logoff">Logo Off</a> </div>
    <ul id="main-nav">
        <!-- Accordion Menu -->
        <li> <a class="nav-top-item">System Management</a>
            <ul class="Nav-list">
                <li id="BasicInfo-clicked"><a title="Basic Info Management" >Basic Info Management</a></li>
        </li>
    </ul>

    <li> <a href="#" class="nav-top-item ">Mobile End Online</a>
        <ul class="Nav-list">
            <li id="MobileEndOnline-clicked"><a title="Check current mobile online">Current Online staffs</a></li><!--Added location-->
            <li id="AddedManagerAndBinded-clicked"><a title="Added a new manager and binded with root zone">Added a new manager</a></li><!--Added location-->

        </ul>
    </li>

    <li> <a href="#" class="nav-top-item ">
            <!-- Add the class "current" to current menu item -->
            Location Management </a>
        <ul class="Nav-list">
            <li id="addsLocation-clicked"><a title="Added new location including level one and level two">Adds and Manages Location</a></li><!--Added location-->
        </ul>
    </li>

    <li> <a href="#" class="nav-top-item ">
            <!-- Add the class "current" to current menu item -->
            Tags</a>
        <ul class="Nav-list">
            <li id="Tags-clicked"><a title="Manage And add tags">Tags Setting</a></li><!--Added&Manage Tags-->
        </ul>
    </li>


    <li> <a href="#" class="nav-top-item ">
            <!-- Add the class "current" to current menu item -->
            Manage Restaurants&Cuisines </a>
        <ul class="Nav-list">
            <li id="AddedRestaurants-clicked" ><a title="Registered New Restaurants's account">Added A New Restaurant</a></li><!--An able to add the new restaurants-->
            <li id="AddedCuisines-clicked"><a title="Added Cuisines">Add Cuisines</a></li><!--An able to add the new Cuisines for one of restaurants-->
            <li id="Restaurants-clicked"><a title="Displayed All Restaurants">Restaurants List</a></li><!--Restaurants list that shows all restaurants that located at database-->
            <li id="Cuisines-clicked"><a title="Displayed All Cuisine">Cuisines List</a></li><!--Restaurants list that shows all restaurants that located at database-->

        </ul>
    </li>



    <li> <a href="#" class="nav-top-item">User Management </a>
        <ul class="Nav-list">
            <li><a id="Admin-clicked"  title="Change the password of Administraotr or other things">Administrator Management</a></li>
            <li><a id="UserList-clicked" title="User List">User List</a></li><!--List all user by list-->
        </ul>
    </li>

    <li> <a href="#" class="nav-top-item">Mail </a>
        <ul class="Nav-list">
            <li><a id="MailSetting-clicked"  title="Change the password of Administraotr or other things">Mail Setting</a></li>
        </ul>
    </li>


    </ul>
    <!-- End #main-nav -->

</div>