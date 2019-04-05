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
   <div id="sidebar-wrapper" class="bg-theme bg-theme2" data-simplebar="" data-simplebar-auto-hide="true">
     <div class="brand-logo">
      <a href="<?php echo empty($advancedCustom->logoMenuBarURL) ? $global['webSiteRootURL'] : $advancedCustom->logoMenuBarURL; ?>">
       <img src="<?php echo $global['webSiteRootURL'], $config->getLogo(true); ?>" class="logo-icon" alt="<?php echo $config->getWebSiteTitle(); ?>">
       
     </a>
   </div>
   <div class="user-details">
    <div class="media align-items-center user-pointer collapsed" data-toggle="collapse" data-target="#user-dropdown">
      <div class="avatar"><img class="mr-3 side-user-img" src="<?php echo User::getPhoto(); ?>" alt="user avatar"></div>
       <div class="media-body">
        <!-- <i class="fas fa-arrow-right"></i> -->
        <?php if (User::isLogged()) {
                                ?>
                                
       <span class="side-user-name"><?php echo User::getName(); ?><i class="fas fa-angle-down float-right"></i></span> 
      </div>
       </div>
     <div id="user-dropdown" class="collapse">
      <ul class="user-setting-menu" >
            <li><a href="<?php echo $global['webSiteRootURL']; ?>user"" style="color: #000"><i class="fas fa-user-alt"></i>  My Profile</a></li>
             <li class="dropdown-divider"></li>
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
         <li class="dropdown-divider"></li>
    <?php }else{
        ?>
             <li><a href="<?php echo $global['webSiteRootURL']; ?>user" style="color: #000">
                <span><?php echo __("Sign In"); ?></span> <i class="fas fa-sign-out-alt"></i> Login</a>
            </li>
    <?php } ?>
      </ul>
     </div>
      </div>
   <ul class="sidebar-menu do-nicescroll">
            <?php
            if (User::canUpload()) {
            ?>
             <li class="dropdown-divider"></li>
        <li>
        <a href="<?php echo $global['webSiteRootURL']; ?>mvideos" class="waves-effect" style="color: #000">
         
          <span><?php echo __("My videos"); ?></span> <i class="fab fa-youtube float-right"></i>
        </a>
        </li>
    <?php } ?>

    <?php if ((($config->getAuthCanViewChart() == 0) && (User::canUpload())) || (($config->getAuthCanViewChart() == 1) && (User::canViewChart()))) {
    ?>
     <li class="dropdown-divider"></li>
    <li>
        <a href="<?php echo $global['webSiteRootURL']; ?>charts" class="waves-effect" style="color: #000">
         
          <span><?php echo __("Dashboard"); ?></span> <i class="fas fa-tachometer-alt pull-right"></i>
        </a>
    </li>
     <li class="dropdown-divider"></li>
<?php } ?>

<?php
if (User::canUpload()) {
?>
 <li class="dropdown-divider"></li>
<li>
    <a href="<?php echo $global['webSiteRootURL']; ?>subscribes" class="waves-effect" style="color: #000">
        <span><?php echo __("Subscriptions"); ?></span> <i class="fas fa-check pull-right"></i>
    </a>
</li>
 <li class="dropdown-divider"></li>
<?php } ?>

<?php
if (Category::canCreateCategory()) {
?>
<!-- <li>
    <a href="<?php //echo $global['webSiteRootURL']; ?>categories" class="waves-effect" style="color: #000">
        <span><?php //echo __($advancedCustom->CategoryLabel); ?></span> <i class="fas fa-folder pull-right"></i>
</li> -->
<?php } ?>
 <li class="dropdown-divider"></li>
<li>
                                                    <a class="waves-effect" style="color: #000" href="<?php echo $global['webSiteRootURL']; ?>comments">
                                                        <span><?php echo __("Comments"); ?></span>
                                                        <i class="fas fa-book float-right"></i>
                                                        
                                                    </a>
                                                </li>

                                               <?php  if (User::isAdmin()) {
                        ?>
                         <li class="dropdown-divider"></li>
                        <li>
                            <a href="<?php echo $global['webSiteRootURL']; ?>admin/" class="waves-effect" style="color: #000">
        <span><?php echo __("Admin Panel"); ?></span> <i class="fas fa-columns float-right"></i></a>
                        </li>
 <li class="dropdown-divider"></li>
                        <li>
                            <a href="<?php echo $global['webSiteRootURL']; ?>users" class="waves-effect" style="color: #000">
        <span><?php echo __("Users"); ?></span> <i class="fas fa-users pull-right"></i></a>
                        </li>
 <li class="dropdown-divider"></li>
                        <li>
                            <a href="<?php echo $global['webSiteRootURL']; ?>usersGroups" class="waves-effect" style="color: #000">
        <span><?php echo __("Users Groups"); ?></span> <i class="fas fa-users-cog pull-right"></i></a>
                        </li>

                        <!-- <li>
                            <a href="<?php //echo $global['webSiteRootURL']; ?>categories/" class="waves-effect" style="color: #000">
        <span><?php //echo __($advancedCustom->CategoryLabel); ?></span> <i class="fas fa-folder pull-right"></i></a>
                        </li>
 --> <li class="dropdown-divider"></li>
                        <li>
                            <a href="<?php echo $global['webSiteRootURL']; ?>update/" class="waves-effect" style="color: #000">
        <span><?php echo __("Update version"); ?>  <?php
                                        if (!empty($updateFiles)) {
                                            ?><span class="label label-danger"><?php echo count($updateFiles); ?></span><?php
                                        }
                                        ?></span> <i class="fas fa-arrow-alt-circle-down pull-right"></i></a>
                        </li>
 <li class="dropdown-divider"></li>
                        <li>
                            <a href="<?php echo $global['webSiteRootURL']; ?>siteConfigurations" class="waves-effect" style="color: #000">
        <span><?php echo __("Site Configurations"); ?></span> <i class="fas fa-wrench float-right"></i></a>
                        </li>
 <li class="dropdown-divider"></li>
                        <li>
                            <a href="<?php echo $global['webSiteRootURL']; ?>plugins" class="waves-effect" style="color: #000">
        <span><?php echo __("Plugins"); ?></span> <i class="fas fa-puzzle-piece pull-right"></i></a>
                        </li>
                    <?php } ?>
    </ul>
   
   </div>


   <!--Start topbar header-->
<header class="topbar-nav">
 <nav class="navbar navbar-expand fixed-top">
  <ul class="navbar-nav mr-auto align-items-center">
    <li class="nav-item">
      <a class="nav-link toggle-menu" href="javascript:void(0)">
       <i class="fas fa-bars"></i>
     </a>
    </li>
    <li class="nav-item">
      <form class="search-bar" action="<?php echo $global['webSiteRootURL']; ?>">
        <input type="text" class="form-control" value="<?php
                        if (!empty($_GET['search'])) {
                            echo htmlentities($_GET['search']);
                        }
                        ?>" name="search" placeholder="<?php echo __("Search"); ?>">
         <!-- <button type="submit" style="display: inline"><i class="icon-magnifier"></button> -->
      </form>
    </li>
  </ul>
     
  <ul class="navbar-nav align-items-center right-nav-link">
    <!-- <li class="nav-item dropdown-lg">
      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
      <i class="fa fa-envelope-open-o"></i><span class="badge badge-light badge-up">12</span></a>
      <div class="dropdown-menu dropdown-menu-right">
        <ul class="list-group list-group-flush">
         <li class="list-group-item d-flex justify-content-between align-items-center">
          You have 12 new messages
          <span class="badge badge-light">12</span>
          </li>
          <li class="list-group-item">
          <a href="javaScript:void();">
           <div class="media">
             <div class="avatar"><img class="align-self-start mr-3" src="assets/images/avatars/avatar-5.png" alt="user avatar"></div>
            <div class="media-body">
            <h6 class="mt-0 msg-title">Jhon Deo</h6>
            <p class="msg-info">Lorem ipsum dolor sit amet...</p>
            <small>Today, 4:10 PM</small>
            </div>
          </div>
          </a>
          </li>
          <li class="list-group-item">
          <a href="javaScript:void();">
           <div class="media">
             <div class="avatar"><img class="align-self-start mr-3" src="assets/images/avatars/avatar-6.png" alt="user avatar"></div>
            <div class="media-body">
            <h6 class="mt-0 msg-title">Sara Jen</h6>
            <p class="msg-info">Lorem ipsum dolor sit amet...</p>
            <small>Yesterday, 8:30 AM</small>
            </div>
          </div>
          </a>
          </li>
          <li class="list-group-item">
          <a href="javaScript:void();">
           <div class="media">
             <div class="avatar"><img class="align-self-start mr-3" src="assets/images/avatars/avatar-7.png" alt="user avatar"></div>
            <div class="media-body">
            <h6 class="mt-0 msg-title">Dannish Josh</h6>
            <p class="msg-info">Lorem ipsum dolor sit amet...</p>
             <small>5/11/2018, 2:50 PM</small>
            </div>
          </div>
          </a>
          </li>
          <li class="list-group-item">
          <a href="javaScript:void();">
           <div class="media">
             <div class="avatar"><img class="align-self-start mr-3" src="assets/images/avatars/avatar-8.png" alt="user avatar"></div>
            <div class="media-body">
            <h6 class="mt-0 msg-title">Katrina Mccoy</h6>
            <p class="msg-info">Lorem ipsum dolor sit amet.</p>
            <small>1/11/2018, 2:50 PM</small>
            </div>
          </div>
          </a>
          </li>
          <li class="list-group-item text-center"><a href="javaScript:void();">See All Messages</a></li>
        </ul>
        </div>
    </li> -->
    
    <li class="nav-item language">
      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();"><i class="fas fa-flag"></i></a>
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
        <!-- <li class="dropdown-divider"></li>
        <li class="dropdown-item"><i class="icon-envelope mr-2"></i> Inbox</li>
        <li class="dropdown-divider"></li>
        <li class="dropdown-item"><i class="icon-wallet mr-2"></i> Account</li>
        <li class="dropdown-divider"></li>
        <li class="dropdown-item"><i class="icon-settings mr-2"></i> Setting</li>
        <li class="dropdown-divider"></li>
        <li class="dropdown-item"><i class="icon-power mr-2"></i> Logout</li> -->
      </ul>
    </li>
<?php } ?>
  </ul>
</nav>
<div class="content-wrapper2 hidden-xs">
    <p style="color: #fff">Trending...</p>
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
            
            <?php } ?>
            </div>
</header>

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