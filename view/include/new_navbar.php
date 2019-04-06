<?php
global $includeDefaultNavBar, $global, $config, $advancedCustom, $advancedCustomUser;
if (!isset($global['systemRootPath'])) {
    require_once '../videos/configuration.php';
}
require_once $global['systemRootPath'] . 'objects/user.php';
require_once $global['systemRootPath'] . 'objects/category.php';
$_GET['parentsOnly'] = "1";
if (empty($_SESSION['language'])) {
    $lang = 'us';
} else {
    $lang = $_SESSION['language'];
}
$thisScriptFile = pathinfo($_SERVER["SCRIPT_FILENAME"]);
if (empty($sidebarStyle)) {
    $sidebarStyle = "display: none;";
}
$includeDefaultNavBar = true;
YouPHPTubePlugin::navBar();
if (!$includeDefaultNavBar) {
    return false;
}
?>

<?php
if (((empty($advancedCustomUser->userMustBeLoggedIn) && empty($advancedCustom->disableNavbar)) || $thisScriptFile["basename"] === "signUp.php") || User::isLogged()) {
    $updateFiles = getUpdatesFilesArray();
    ?>

    <!-- Start of nav logged in users -->
    <!-- Start wrapper-->
 <div id="wrapper">
 
  <!--Start sidebar-wrapper-->
   <div id="sidebar-wrapper" class="bg-theme bg-theme2" data-simplebar="init" data-simplebar-auto-hide="true">
     <div class="brand-logo">
      <a href="<?php echo empty($advancedCustom->logoMenuBarURL) ? $global['webSiteRootURL'] : $advancedCustom->logoMenuBarURL; ?>">
       <img src="<?php echo $global['webSiteRootURL'], $config->getLogo(true); ?>" class="logo-icon" alt="<?php echo $config->getWebSiteTitle(); ?>">
       
     </a>
   </div>
   <div class="user-details">
    <div class="media align-items-center text-center">
      <div class="avatar text-center" style="margin-right: auto; margin-left: auto;"><img class="mr-3 side-user-img" src="<?php echo User::getPhoto(); ?>" alt="user avatar" ></div>

       
       </div>
       <div data-toggle="collapse" data-target="#user-dropdown" class="user-pointer collapsed">
       <div class="media-body">
        <!-- <i class="fas fa-arrow-right"></i> -->
        <?php if (User::isLogged()) {
                                ?>
                                
      
     
        <center><span class="side-user-name text-capitalize" color="#000"><?php echo User::getName(); ?><i class="fas fa-angle-down float-right"></i></span> </center>
 </div>
</div>
     <div id="user-dropdown" class="collapse">
      <ul class="user-setting-menu" >
            <li><a href="<?php echo $global['webSiteRootURL']; ?>user"" style="color: #000"><i class="fas fa-user-alt"></i>  My Profile</a></li>
             
      <li><a href="<?php echo $global['webSiteRootURL']; ?>logoff" style="color: #000">
            <?php
                                                    if (!empty($_COOKIE['user']) && !empty($_COOKIE['pass'])) { 
                                                        ?>
                                          
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <i class="fas fa-lock-open text-muted" style="opacity: 0.2;"></i>    
                                                        <?php
                                                    }
                                                    ?>
        <i class="fas fa-sign-out-alt"></i> Logout</a></li>
         
    <?php }else{
        ?>
             <li><a href="<?php echo $global['webSiteRootURL']; ?>user" style="color: #000">
                <span><?php echo __("Sign In"); ?></span> <i class="fas fa-sign-out-alt"></i></a>
            </li>
    <?php } ?>
      </ul>

     </div>
     <li class="dropdown-divider"></li> 
      </div>

   <ul class="sidebar-menu do-nicescrol">
            <?php
            if (User::canUpload()) {
            ?>
             
        <li>
        <a href="<?php echo $global['webSiteRootURL']; ?>mvideos" class="waves-effect" style="color: #000">
         
          <span><?php echo __("My videos"); ?></span> 
        </a>
        </li>
    <?php } ?>

    <?php if ((($config->getAuthCanViewChart() == 0) && (User::canUpload())) || (($config->getAuthCanViewChart() == 1) && (User::canViewChart()))) {
    ?>
     
    <li>
        <a href="<?php echo $global['webSiteRootURL']; ?>charts" class="waves-effect" style="color: #000">
         
          <span><?php echo __("Dashboard"); ?></span> 
        </a>
    </li>
     
<?php } ?>

<?php
if (User::canUpload()) {
?>
 
<li>
    <a href="<?php echo $global['webSiteRootURL']; ?>subscribes" class="waves-effect" style="color: #000">
        <span><?php echo __("Subscriptions"); ?></span> 
    </a>
</li>
 
<?php } ?>



                                               <?php  if (User::isAdmin()) {
                        ?>

                        <li>
                                                    <a class="waves-effect" style="color: #000" href="<?php echo $global['webSiteRootURL']; ?>comments">
                                                        <span><?php echo __("Comments"); ?></span>
                                                        
                                                        
                                                    </a>
                                                </li>
                         
                        <li>
                            <a href="<?php echo $global['webSiteRootURL']; ?>admin/" class="waves-effect" style="color: #000">
        <span><?php echo __("Admin Panel"); ?></span> </a>
                        </li>
 
                        <li>
                            <a href="<?php echo $global['webSiteRootURL']; ?>users" class="waves-effect" style="color: #000">
        <span><?php echo __("Users"); ?></span> </a>
                        </li>
 
                        <li>
                            <a href="<?php echo $global['webSiteRootURL']; ?>usersGroups" class="waves-effect" style="color: #000">
        <span><?php echo __("Users Groups"); ?></span> </a>
                        </li>

                        <!-- <li>
                            <a href="<?php //echo $global['webSiteRootURL']; ?>categories/" class="waves-effect" style="color: #000">
        <span><?php //echo __($advancedCustom->CategoryLabel); ?></span> <i class="fas fa-folder pull-right"></i></a>
                        </li>
 --> 
                        <li>
                            <a href="<?php echo $global['webSiteRootURL']; ?>update/" class="waves-effect" style="color: #000">
        <span><?php echo __("Update version"); ?>  <?php
                                        if (!empty($updateFiles)) {
                                            ?><span class=""><?php echo count($updateFiles); ?></span><?php
                                        }
                                        ?></span> </a>
                        </li>
 
                        <li>
                            <a href="<?php echo $global['webSiteRootURL']; ?>siteConfigurations" class="waves-effect" style="color: #000">
        <span><?php echo __("Site Configurations"); ?></span></a>
                        </li>
 
                        <li>
                            <a href="<?php echo $global['webSiteRootURL']; ?>plugins" class="waves-effect" style="color: #000">
        <span><?php echo __("Plugins"); ?></span> </a>
                        </li>
                    <?php } ?>
    </ul>
   
   </div>


   <!--Start topbar header-->
<header class="topbar-nav">
  <canvas id="canvas"></canvas>
 <nav class="navbar navbar-expand fixed-top">
  <ul class="navbar-nav mr-auto align-items-center">
    <li class="nav-item">
      <a class="nav-link toggle-menu" href="javascript:void(0)">
        <script>
          function changeIt(){
        document.querySelector(".ico").classList.toggle("toggle-display");
          }
        </script>
       <i class="fas fa-arrow-circle-left ico" style="color: #fff; font-size: 30px" onclick="changeIt()"></i></i>
     </a>
    </li>
    <li class="nav-item">
      <form class="search-bar" action="<?php echo $global['webSiteRootURL']; ?>" name="MyForm">
        <a href="<?php echo $global['webSiteRootURL']; ?>upload"><i class="fas fa-video " style="color: #fff"></i></a>
        
         
        <input type="text" class="form-control" style="color:#fff !important; padding-left: 55px !important;" value="<?php
                        if (!empty($_GET['search'])) {
                            echo htmlentities($_GET['search']);
                        }
                        ?>" name="search" placeholder="<?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . __("Search"); ?>">
                        
     <!--  <button class="btn" style="background-color: #0378e0;" type="submit"> -->
        <a href="javascript:document.MyForm.submit();"><i class="fas fa-search" style="color: #fff;
        position: absolute;
        right: 90%;
        "></i></a>
      <!-- </button> -->
   
 
         
      </form>
    </li>
  </ul>
     
  <ul class="navbar-nav align-items-center right-nav-link">
    
    
    <li class="nav-item language">
      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();"><i class="fas fa-flag" style="color: #fff"></i></a>
      <ul class="dropdown-menu dropdown-menu-right">
          <li>
                            <?php
                            $flags = getEnabledLangs();
                            $objFlag = new stdClass();
                            foreach ($flags as $key => $value) {
                                //$value = strtoupper($value);
                                $objFlag->$value = $value;
                            }
                            if ($lang == 'en') {
                                $lang = 'us';
                            }
                            ?>
                           
                            <style>
                                #navBarFlag .dropdown-menu {
                                    min-width: 20px;
                                }
                            </style>
                            <div id="navBarFlag" data-input-name="country" data-selected-country="<?php echo $lang; ?>"></i></div>
                            <script>
                                $(function () {
                                    $("#navBarFlag").flagStrap({
                                        countries: <?php echo json_encode($objFlag); ?>,
                                        inputName: 'country',
                                        buttonType: "btn-primary navbar-btn",
                                        onSelect: function (value, element) {
                                            if (!value && element[1]) {
                                                value = $(element[1]).val();
                                            }
                                            window.location.href = "<?php echo $global['webSiteRootURL']; ?>?lang=" + value;
                                        },
                                        placeholder: {
                                            value: "",
                                            text: ""
                                        }
                                    });
                                });
                            </script>
                        </li>
        </ul>
    </li>
     <?php if (User::isLogged()) {
                                ?>
    <li class="nav-item">
      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
        <span class="user-profile"><img src="<?php echo User::getPhoto(); ?>" class="img-circle" alt="user avatar"></span>
      </a>
      <ul class="dropdown-menu dropdown-menu-right">
       <li class="dropdown-item user-details">
        <a href="javaScript:void();">
           <div class="media">
             <div class="avatar"><img class="align-self-start mr-3" src="<?php echo User::getPhoto(); ?>" alt="user avatar"></div>
            <div class="media-body">
            <a href="<?php echo $global['webSiteRootURL']; ?>user"><h6 class="mt-2 user-title"><?php echo User::getName(); ?></h6></a>
            <p class="user-subtitle"><?php echo User::getMail(); ?></p>
            </div>
           </div>
          </a>
        </li>
        <!-- 
        <li class="dropdown-item"><i class="icon-envelope mr-2"></i> Inbox</li>
        
        <li class="dropdown-item"><i class="icon-wallet mr-2"></i> Account</li>
        
        <li class="dropdown-item"><i class="icon-settings mr-2"></i> Setting</li>
        
        <li class="dropdown-item"><i class="icon-power mr-2"></i> Logout</li> -->
      </ul>
    </li>
<?php } ?>
  </ul>
</nav>


<div class="content-wrapper2 hidden-xs">
   
   <div class="row">
        <div class="col-lg-9">  
        
        <div style="padding-bottom: 5px" class="float-left">
        <span style="color: #fff">Featured</span> &nbsp;<span style="color: #fff">Trending</span>  &nbsp; <span style="color: #fff">Hot</span> 
</div>
    </div>
         <div class="col-lg-3"> 
    <div style="padding-bottom: 5px" class="float-right">
        <span style="color: #fff">Sort by</span> 

    </div>
</div>
    </div>
<?php  foreach ($videos as $key => $value) {
    if (!empty($video['id']) && $video['id'] == $value['id']) {
        continue; // skip video
    }
                $images = Video::getImageFromFilename($value['filename'], $value['type']);

                $imgGif = $images->thumbsGif;
                $img = $images->thumbsJpg;
                if (!empty($images->posterPortrait)) {
                    $imgGif = $images->gifPortrait;
                    $img = $images->posterPortrait;
                }
                ?>

        <img src="<?php echo $images->thumbsJpg ?>" alt="user avatar" class="customer-img rounded-circle" >
        <img src="<?php echo $images->thumbsJpg ?>" alt="user avatar" class="customer-img rounded-circle" >
        
            
            <?php } ?>
           
          </div>
</header>

<?php if (!User::isLogged()) {
        echo "</div>";
    }
        ?>

         

<!--End topbar header-->

   <!--End sidebar-wrapper-->


    <?php
    if (!empty($advancedCustom->underMenuBarHTMLCode->value)) {
        echo $advancedCustom->underMenuBarHTMLCode->value;
    }

} else if ($thisScriptFile["basename"] !== 'user.php' && empty($advancedCustom->disableNavbar)) {
    header("Location: {$global['webSiteRootURL']}user");
}
?>