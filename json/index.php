<?php require_once '../CMS/GobalConnection.php'?>
<?php
if($_SERVER['REQUEST_METHOD']==='GET'){
/***************************************************define variables*************************************************/
//GetImageType: The default parameter is All.If you want to get different return values, you can use paramters.
//For example:?GetAllResAndCuis='yes' (Get all images and its info without condition)

    /**
     * Get all cuisine from database without fetching limitation
     */
    if($_GET['GetAllCuis']==='yes'){
      echo $JsonReturnOrDealclass -> RestaurantAndcuisine(); //this will reutrn json that contains cuisines' info including cuisine ID, name .... and its ResName, id
    }

    /**
     * According to root location to get restuarants and cuisines
     */
    if(isset($_GET['GetResAndCuByRootL'])){
      echo $JsonReturnOrDealclass -> ReturnResAndCusineAccordingToLocation($_GET['GetResAndCuByRootL'],intval($_GET['startCount']),intval($_GET['count']),$_GET['AvailabilityTags'],$_GET['CuisineTags'],$_GET['TypeTags'],$_GET['PriceTags']);// this will return json that contains Resturant and its cuisines
    }

    /**
     * According to paramters to get customer's favourite
     */
    if(isset($_GET['ListMyFavourite'])){
      echo $JsonReturnOrDealclass -> ReturnMyFavourite($_GET['UserID'],$_GET['FavouriteStatus']);
    }
    /**
     * According to Restaurant to get its cuisines (the Restaurant fetching is accoring to its ID, and the Restaurant should belong to root location)
     */
    if(isset($_GET['GetResAndItsCuisine'])){
      echo $JsonReturnOrDealclass -> ReturnCurrentRestaurantCuisine($_GET['GetResID'],$_GET['FilterCuisineID'],intval($_GET['startCount']),intval($_GET['count']));
    }
    /**
     * Fecthing comment of cuisine according to cuisine ID and User ID
     */
    if(isset($_GET['GetCuisineComment'])){
      echo $JsonReturnOrDealclass -> ReturnCommentOfCuisine($_GET['CurrentLoginedUserID'], $_GET['GetCurrentCuID'], intval($_GET['commentStartCount']), intval($_GET['LimitedCommentCount']));
    }













}








?>