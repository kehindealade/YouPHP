<nav class="navbar navbar-light bg-light fixed-top  navbar-expand-md"
id="mainNavBar">
    <ul class="items-container">
        <li>
            <ul class="left-side">
                <li>
                    <button class="btn btn-secondary nav-item float-left" id="buttonMenu"><span class="fa fa-bars"></span>
                    </button>
                    <script>
                            $(document).ready(function () {
                                $('#buttonMenu').on("click.sidebar", function (event) {
                                    event.stopPropagation();
                                    //$('#sidebar').fadeToggle();
                                    if ($('body').hasClass('youtube')) {
                                        $('body').removeClass('youtube')
                                        $("#sidebar").fadeOut();
                                    } else {
                                        $('body').addClass('youtube')
                                        $("#sidebar").fadeIn();
                                    }

                                    $('#myNavbar').removeClass("in");
                                    $('#mysearch').removeClass("in");
                                });

                                $(document).on("click.sidebar", function () {
                                    $("#sidebar").fadeOut();
                                });
                                $("#sidebar").on("click", function (event) {
                                    event.stopPropagation();
                                });
                                $("#buttonSearch").click(function (event) {
                                    $('#myNavbar').removeClass("in");
                                    $("#sidebar").fadeOut();
                                });
                                $("#buttonMyNavbar").click(function (event) {
                                    $('#mysearch').removeClass("in");
                                    $("#sidebar").fadeOut();
                                });
                                var wasMobile = true;
                                $(window).resize(function () {
                                    if ($(window).width() > 767) {
                                        // Window is bigger than 767 pixels wide - show search again, if autohide by mobile.
                                        if (wasMobile) {
                                            wasMobile = false;
                                            $('#mysearch').addClass("in");
                                            $('#myNavbar').addClass("in");
                                        }
                                    }
                                    if ($(window).width() < 767) {
                                        // Window is smaller 767 pixels wide - show search again, if autohide by mobile.
                                        if (wasMobile == false) {
                                            wasMobile = true;
                                            $('#myNavbar').removeClass("in");
                                            $('#mysearch').removeClass("in");
                                        }
                                    }
                                });
                            });
                        </script>
                </li>
                <li>
                    <!-- Youtube Logo UP --> <a class="navbar-brand" href="<?php echo empty($advancedCustom->logoMenuBarURL) ? $global['webSiteRootURL'] : $advancedCustom->logoMenuBarURL; ?>">

                            <img src="<?php echo $global['webSiteRootURL'], $config->getLogo(true); ?>" alt="<?php echo $config->getWebSiteTitle(); ?>" class="img-fluid ">

                        </a>
                </li>
            </ul>
        </li>
        <li class="nav-item" style="margin-right: 0px; ">
            <button type="button" id="buttonSearch" class="d-block d-sm-none navbar-toggler btn btn-secondary nav-item"
            data-toggle="collapse" data-target="#mysearch" style="padding: 6px 12px;"> <span class="fa fa-search"></span>
            </button>
            <!-- Top Search BAR -->
            <div class="input-group hidden-xsd-none d-sm-block" id="mysearch">
                <form class="form-inline form-inline input-group" role="search" id="searchForm"
                action="<?php echo $global['webSiteRootURL']; ?>">
                    <input class="form-control globalsearchfield" type="text" value="<?php

                        if (!empty($_GET['search'])) {

                            echo htmlentities($_GET['search']);

                        }

                        ?>" name="search" placeholder="<?php echo __("
                    search ");=" " ?=" ">">

                        <span class="input-group-append ">

                            <button class="btn btn-secondary btn-outline-secondary
                    border-left-0 border py-2 " type="submit ">

                                <i class="fas fa-search "></i>

                            </button>

                        </span>

                    </form>

                </div>

            </li>



            <li style="margin-right: 0px; padding-left: 0px; ">

                <div class="hidden-xsd-none d-sm-block col-lg-3 col-md-4
                    " id="myNavbar ">

                    <ul class="right-menus " style="padding-left: 0; ">

                        <?php

                        if (!empty($advancedCustom->menuBarHTMLCode->value)) {

                            echo $advancedCustom->menuBarHTMLCode->value;

                        }

                        ?>



                        <?php

                        echo YouPHPTubePlugin::getHTMLMenuRight();

                        ?>

                        <?php

                        if (User::canUpload() && empty($advancedCustom->doNotShowUploadButton)) {

                            ?>

                            <li>

                                <div class="btn-group ">

                                    <button type="button " class="btn
                    btn-secondary dropdown-toggle nav-item float-left " data-toggle="dropdown ">

                                        <i class="<?php echo isset($advancedCustom->uploadButtonDropdownIcon)
                    ? $advancedCustom->uploadButtonDropdownIcon : " fas=" " fa-video";=""
                    ?="">"></i>
                    <?php echo!empty($advancedCustom->uploadButtonDropdownText) ? $advancedCustom->uploadButtonDropdownText
                    : ""; ?> <span class="caret"></span>
                    </button>
                    <?php if ((isset($advancedCustomUser->onlyVerifiedEmailCanUpload) && $advancedCustomUser->onlyVerifiedEmailCanUpload
                    && User::isVerified()) || (isset($advancedCustomUser->onlyVerifiedEmailCanUpload)
                    && !$advancedCustomUser->onlyVerifiedEmailCanUpload) || !isset($advancedCustomUser->onlyVerifiedEmailCanUpload)
                    ) { ?>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                        <?php if (!empty($advancedCustom->encoderNetwork) && empty($advancedCustom->doNotShowEncoderNetwork))
                        { ?>
                        <li class="dropdown-item">
                            <form id="formEncoderN" method="post" action="<?php echo $advancedCustom->encoderNetwork; ?>"
                            target="encoder" autocomplete="off">
                                <input type="hidden" name="webSiteRootURL" value="<?php echo $global['webSiteRootURL']; ?>"
                                autocomplete="off">
                                <input type="hidden" name="user" value="<?php echo User::getUserName(); ?>"
                                autocomplete="off">
                                <input type="hidden" name="pass" value="<?php echo User::getUserPass(); ?>"
                                autocomplete="off">
                            </form> <a href="#" onclick="$('#formEncoderN').submit();

                                                                            return false;">

                                                        <span class="fa fa-cogs"></span> <?php echo empty($advancedCustom->encoderNetworkLabel) ? __("Encoder Network") : $advancedCustom->encoderNetworkLabel; ?>

                                                    </a>
                        </li>
                        <?php } if (empty($advancedCustom->doNotShowEncoderButton)) { if (!empty($config->getEncoderURL())) {
                        ?>
                        <li class="dropdown-item">
                            <form id="formEncoder" method="post" action="<?php echo $config->getEncoderURL(); ?>"
                            target="encoder" autocomplete="off">
                                <input type="hidden" name="webSiteRootURL" value="<?php echo $global['webSiteRootURL']; ?>"
                                autocomplete="off">
                                <input type="hidden" name="user" value="<?php echo User::getUserName(); ?>"
                                autocomplete="off">
                                <input type="hidden" name="pass" value="<?php echo User::getUserPass(); ?>"
                                autocomplete="off">
                            </form> <a href="#" onclick="$('#formEncoder').submit();

                                                                                    return false;">

                                                            <span class="fa fa-cog"></span> <?php echo empty($advancedCustom->encoderButtonLabel) ? __("Encode video and audio") : $advancedCustom->encoderButtonLabel; ?>

                                                        </a>
                        </li>
                        <?php } else { ?>
                        <li class="dropdown-item"> <a href="<?php echo $global['webSiteRootURL']; ?>siteConfigurations"><span class="fa fa-cogs"></span> <?php echo __("Configure an Encoder URL"); ?></a>
                        </li>
                        <?php } } if (empty($advancedCustom->doNotShowUploadMP4Button)) { ?>
                        <li class="dropdown-item"> <a href="<?php echo $global['webSiteRootURL']; ?>mvideos?upload=1">

                                                        <span class="fa fa-upload"></span> <?php echo empty($advancedCustom->uploadMP4ButtonLabel) ? __("Direct upload") : $advancedCustom->uploadMP4ButtonLabel; ?>

                                                    </a>
                        </li>
                        <?php } if (empty($advancedCustom->doNotShowImportMP4Button)) { ?>
                        <li class="dropdown-item"> <a href="<?php echo $global['webSiteRootURL']; ?>view/import.php">

                                                        <span class="fas fa-hdd"></span> <?php echo empty($advancedCustom->importMP4ButtonLabel) ? __("Direct Import Local Videos") : $advancedCustom->importMP4ButtonLabel; ?>

                                                    </a>
                        </li>
                        <?php } if (empty($advancedCustom->doNotShowEmbedButton)) { ?>
                        <li class="dropdown-item"> <a href="<?php echo $global['webSiteRootURL']; ?>mvideos?link=1">

                                                        <span class="fa fa-link"></span> <?php echo empty($advancedCustom->embedButtonLabel) ? __("Embed a video link") : $advancedCustom->embedButtonLabel; ?>

                                                    </a>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php } else { ?>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                        <li class="dropdown-item"> <a href="">

                                                    <span class="fa fa-exclamation"></span> <?php echo __("Only verified users can upload"); ?>

                                                </a>
                        </li>
                    </ul>
                    <?php } ?>
            </div>
        </li>
        <?php } ?>
        <li>
            <?php $flags=g etEnabledLangs(); $objFlag=n ew stdClass(); foreach ($flags
            as $key=>$value) { //$value = strtoupper($value); $objFlag->$value = $value;
            } if ($lang == 'en') { $lang = 'us'; } ?>
            <style>
                #navBarFlag .dropdown-menu {
                    min-width: 20px;
                }
            </style>
            <!-- Nav bar Flag -->
            <div id="navBarFlag" data-input-name="country" data-selected-country="<?php echo $lang; ?>"></div>
            <script>
                                $(function () {
                                    $("#navBarFlag").flagStrap({
                                        countries: <?php echo json_encode($objFlag); ?>,
                                        inputName: 'country',
                                        buttonType: "btn-default navbar-btn",
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
        <!-- // Login LOgout navbar -->
        <?php if (!empty($advancedCustomUser->signInOnRight)) {  
            if (User::isLogged()) { ?>
        <li> <a class="btn nav-item btn-secondary" href="<?php echo $global['webSiteRootURL']; ?>logoff">

                                        <?php

                                        if (!empty($_COOKIE['user']) && !empty($_COOKIE['pass'])) {

                                            ?>

                                            <i class="fas fa-lock text-muted" style="opacity: 0.2;"></i>    

                                            <?php

                                        } else {

                                            ?>

                                            <i class="fas fa-lock-open text-muted" style="opacity: 0.2;"></i>    

                                            <?php

                                        }

                                        ?>

                                        <i class="fas fa-sign-out-alt"></i> <span class="d-sm-none"><?php echo __("Sign Out"); ?></span>

                                    </a>
        </li>
        <?php } else { ?>
        <li> <a class="btn nav-item btn-secondary" href="<?php echo $global['webSiteRootURL']; ?>user">

                                        <i class="fas fa-sign-in-alt"></i> <?php echo __("Sign In"); ?>

                                    </a>
        </li>
        <?php } } ?>
    </ul>
    </div>
    <!-- Profile Photo -->
    <ul style="margin: 0; padding: 0;">
        <?php if (empty($advancedCustomUser->doNotShowRightProfile)) { ?>
        <li class="rightProfile">
            <div class="btn-group">
                <button type="button" class="btn btn-secondary  dropdown-toggle nav-item float-left"
                data-toggle="dropdown" id="rightProfileButton" style="">
                    <img src="<?php echo User::getPhoto(); ?>" style="width: 32px; height: 32px; max-width: 32px;"
                    class="img img-fluid rounded-circle">
                </button>
                <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                    <?php if (User::isLogged()) { ?>
                    <li class="dropdown-item">
                        <div class="float-left" style="margin-left: 10px;">
                            <img src="<?php echo User::getPhoto(); ?>" style="max-width: 50px;"
                            class="img img-fluid rounded-circle">
                        </div>
                        <div class="float-left">
                             <h2><?php echo User::getName(); ?></h2>
                            <div><small><?php echo User::getMail(); ?></small>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown-item">
                        <hr>
                    </li>
                    <li class="dropdown-item"> <a href="<?php echo $global['webSiteRootURL']; ?>logoff">

                                                    <?php

                                                    if (!empty($_COOKIE['user']) && !empty($_COOKIE['pass'])) {

                                                        ?>

                                                        <i class="fas fa-lock text-muted" style="opacity: 0.2;"></i>    

                                                        <?php

                                                    } else {

                                                        ?>

                                                        <i class="fas fa-lock-open text-muted" style="opacity: 0.2;"></i>    

                                                        <?php

                                                    }

                                                    ?>

                                                    <i class="fas fa-sign-out-alt"></i> <?php echo __("Sign out"); ?>

                                                </a>
                    </li>
                    <li class="dropdown-item"> <a href="<?php echo $global['webSiteRootURL']; ?>user"
                        style="border-radius: 4px 4px 0 0;">

                                                    <span class="fa fa-user-circle"></span>

                                                    <?php echo __("My Account"); ?>

                                                </a>
                    </li>
                    <li class="dropdown-item"> <a href="<?php echo User::getChannelLink(); ?>">

                                                    <span class="fab fa-youtube"></span>

                                                    <?php echo __($advancedCustomUser->MyChannelLabel); ?>

                                                </a>
                    </li>
                    <?php if (User::canUpload()) { ?>
                    <li class="dropdown-item"> <a href="<?php echo $global['webSiteRootURL']; ?>mvideos">

                                                        <span class="glyphicon glyphicon-film"></span>

                                                        <span class="glyphicon glyphicon-headphones"></span>

                                                        <?php echo __("My videos"); ?>

                                                    </a>
                    </li>
                    <?php } print YouPHPTubePlugin::navBarButtons(); if ((($config->getAuthCanViewChart() == 0) && (User::canUpload())) || (($config->getAuthCanViewChart()
                    == 1) && (User::canViewChart()))) { ?>
                    <li class="dropdown-item"> <a href="<?php echo $global['webSiteRootURL']; ?>charts">

                                                        <span class="fas fa-tachometer-alt"></span>

                                                        <?php echo __("Dashboard"); ?>

                                                    </a>
                    </li>
                    <?php } if (User::canUpload()) { ?>
                    <li class="dropdown-item"> <a href="<?php echo $global['webSiteRootURL']; ?>subscribes">

                                                        <span class="fa fa-check"></span>

                                                        <?php echo __("Subscriptions"); ?>

                                                    </a>
                    </li>
                    <?php if (Category::canCreateCategory()) { ?>
                    <li class="dropdown-item"> <a href="<?php echo $global['webSiteRootURL']; ?>categories">

                                                            <span class="glyphicon glyphicon-list"></span>

                                                            <?php echo __($advancedCustom->CategoryLabel); ?>

                                                        </a>
                    </li>
                    <?php } ?>
                    <li class="dropdown-item"> <a href="<?php echo $global['webSiteRootURL']; ?>comments">

                                                        <span class="fa fa-comment"></span>

                                                        <?php echo __("Comments"); ?>

                                                    </a>
                    </li>
                    <?php } ?>
                    <?php } else { ?>
                    <li class="dropdown-item"> <a href="<?php echo $global['webSiteRootURL']; ?>user">

                                                    <i class="fas fa-sign-in-alt"></i>

                                                    <?php echo __("Sign In"); ?>

                                                </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </li>
        <?php } ?>
    </ul>
    <div class="float-right">
        <button type="button" id="buttonMyNavbar" class=" navbar-toggler btn btn-secondary nav-item"
        data-toggle="collapse" data-target="#myNavbar" style="padding: 6px 12px;"> <span class="fa fa-bars"></span>
        </button>
    </div>
    </li>
    </ul>
    <div id="sidebar" class="list-group-item" style="<?php echo $sidebarStyle; ?>">
        <div id="sideBarContainer">
            <ul class="nav navbar navbar-expand-md">sidebar
                <?php if (empty($advancedCustom->doNotShowLeftHomeButton)) { ?>
                <li class="nav-item">
                    <div> <a href="<?php echo $global['webSiteRootURL']; ?>" class="btn btn-primary btn-block  ">

                                    <span class="fa fa-home"></span>

                                    <?php echo __("Home"); ?>

                                </a>
                    </div>
                </li>
                <?php } if (empty($advancedCustom->doNotShowLeftTrendingButton)) { ?>
                <li class="nav-item">
                    <div> <a href="<?php echo $global['webSiteRootURL']; ?>trending"
                        class="btn btn-primary btn-block ">

                                    <i class="fas fa-fire"></i>

                                    <?php echo __("Trending"); ?>

                                </a>
                    </div>
                </li>
                <?php } if (empty($advancedCustomUser->doNotShowLeftProfile)) { if (User::isLogged()) { ?>
                <li class="nav-item">
                    <hr>
                </li>
                <li class="nav-item">
                     <h2 class="text-danger"><?php echo __("My Menu"); ?></h2>
                    <div> <a href="<?php echo $global['webSiteRootURL']; ?>logoff"
                        class="btn btn-secondary btn-block">

                                        <?php

                                        if (!empty($_COOKIE['user']) && !empty($_COOKIE['pass'])) {

                                            ?>

                                            <i class="fas fa-lock text-muted" style="opacity: 0.2;"></i>    

                                            <?php

                                        } else {

                                            ?>

                                            <i class="fas fa-lock-open text-muted" style="opacity: 0.2;"></i>    

                                            <?php

                                        }

                                        ?>

                                        <i class="fas fa-sign-out-alt"></i> <?php echo __("Sign out"); ?>

                                    </a>
                    </div>
                </li>
                <li style="min-height: 60px;" class="nav-item">
                    <div class="float-left" style="margin-left: 10px;">
                        <img src="<?php echo User::getPhoto(); ?>" style="max-width: 55px;"
                        class="img img-thumbnail img-fluid rounded-circle">
                    </div>
                    <div style="margin-left: 80px;">
                         <h2><?php echo User::getName(); ?></h2>
                        <div><small><?php echo User::getMail(); ?></small>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <div> <a href="<?php echo $global['webSiteRootURL']; ?>user"
                        class="btn btn-primary btn-block" style="border-radius: 4px 4px 0 0;">

                                        <span class="fa fa-user-circle"></span>

                                        <?php echo __("My Account"); ?>

                                    </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div> <a href="<?php echo User::getChannelLink(); ?>" class="btn btn-danger btn-block"
                        style="border-radius: 0;">

                                        <span class="fab fa-youtube"></span>

                                        <?php echo __($advancedCustomUser->MyChannelLabel); ?>

                                    </a>
                    </div>
                </li>
                <?php if (User::canUpload()) { ?>
                <li class="nav-item">
                    <div> <a href="<?php echo $global['webSiteRootURL']; ?>mvideos"
                        class="btn btn-success btn-block" style="border-radius: 0;">

                                            <span class="glyphicon glyphicon-film"></span>

                                            <span class="glyphicon glyphicon-headphones"></span>

                                            <?php echo __("My videos"); ?>

                                        </a>
                    </div>
                </li>
                <?php } print YouPHPTubePlugin::navBarButtons(); if ((($config->getAuthCanViewChart() == 0) && (User::canUpload())) || (($config->getAuthCanViewChart()
                == 1) && (User::canViewChart()))) { ?>
                <li class="nav-item">
                    <div> <a href="<?php echo $global['webSiteRootURL']; ?>charts"
                        class="btn btn-info btn-block" style="border-radius: 0;">

                                            <span class="fas fa-tachometer-alt"></span>

                                            <?php echo __("Dashboard"); ?>

                                        </a>
                    </div>
                </li>
                <?php } if (User::canUpload()) { ?>
                <li class="nav-item">
                    <div> <a href="<?php echo $global['webSiteRootURL']; ?>subscribes"
                        class="btn btn-warning btn-block" style="border-radius: 0">

                                            <span class="fa fa-check"></span>

                                            <?php echo __("Subscriptions"); ?>

                                        </a>
                    </div>
                </li>
                <?php if (Category::canCreateCategory()) { ?>
                <li class="nav-item">
                    <div> <a href="<?php echo $global['webSiteRootURL']; ?>categories"
                        class="btn btn-info btn-block" style="border-radius: 0;">

                                                <span class="glyphicon glyphicon-list"></span>

                                                <?php echo __($advancedCustom->CategoryLabel); ?>

                                            </a>
                    </div>
                </li>
                <?php } ?>
                <li class="nav-item">
                    <div> <a href="<?php echo $global['webSiteRootURL']; ?>comments"
                        class="btn btn-secondary btn-block" style="border-radius: 0 0 4px 4px;">

                                            <span class="fa fa-comment"></span>

                                            <?php echo __("Comments"); ?>

                                        </a>
                    </div>
                </li>
                <?php } ?>
                <?php } else { ?>
                <li class="nav-item">
                    <hr>
                </li>
                <li class="nav-item">
                    <div> <a href="<?php echo $global['webSiteRootURL']; ?>user"
                        class="btn btn-success btn-block">

                                        <i class="fas fa-sign-in-alt"></i>

                                        <?php echo __("Sign In"); ?>

                                    </a>
                    </div>
                </li>
                <?php } } if (User::isAdmin()) { ?>
                <li class="nav-item">
                    <hr>
                </li>
                <li class="nav-item">
                     <h2 class="text-danger"><?php echo __("Admin Menu"); ?></h2>
                    <ul class="nav navbar navbar-expand-md" style="margin-bottom: 10px;">
                        <li class="nav-item"> <a href="<?php echo $global['webSiteRootURL']; ?>admin/"
                            class="nav-link">

                                        <i class="fas fa-star"></i>

                                        <?php echo __("Admin Panel"); ?>

                                    </a>
                        </li>
                        <li class="nav-item"> <a href="<?php echo $global['webSiteRootURL']; ?>users"
                            class="nav-link">

                                        <span class="glyphicon glyphicon-user"></span>

                                        <?php echo __("Users"); ?>

                                    </a>
                        </li>
                        <li class="nav-item"> <a href="<?php echo $global['webSiteRootURL']; ?>usersGroups"
                            class="nav-link">

                                        <span class="fa fa-users"></span>

                                        <?php echo __("Users Groups"); ?>

                                    </a>
                        </li>
                        <li class="nav-item"> <a href="<?php echo $global['webSiteRootURL']; ?>categories"
                            class="nav-link">

                                        <span class="glyphicon glyphicon-list"></span>

                                        <?php echo __($advancedCustom->CategoryLabel); ?>

                                    </a>
                        </li>
                        <li class="nav-item"> <a href="<?php echo $global['webSiteRootURL']; ?>update"
                            class="nav-link">

                                        <span class="glyphicon glyphicon-refresh"></span>

                                        <?php echo __("Update version"); ?>

                                        <?php

                                        if (!empty($updateFiles)) {

                                            ?><span class="badge badge-danger"><?php echo count($updateFiles); ?></span><?php

                                        }

                                        ?>

                                    </a>
                        </li>
                        <li class="nav-item"> <a href="<?php echo $global['webSiteRootURL']; ?>siteConfigurations"
                            class="nav-link">

                                        <span class="glyphicon glyphicon-cog"></span>

                                        <?php echo __("Site Configurations"); ?>

                                    </a>
                        </li>
                        <!-- <li>

                                    <a href="<?php echo $global['webSiteRootURL']; ?>locale">

                                        <span class="glyphicon glyphicon-flag"></span>

                                <?php echo __("Create more translations"); ?>

                                    </a>

                                </li>

                                -->
                        <li class="nav-item"> <a href="<?php echo $global['webSiteRootURL']; ?>plugins"
                            class="nav-link">

                                        <i class="fas fa-puzzle-piece"></i>

                                        <?php echo __("Plugins"); ?>

                                    </a>
                        </li>
                    </ul>
                </li>
                <?php } ?>
                <?php if (empty($advancedCustom->doNotShowLeftMenuAudioAndVideoButtons)) { ?>
                <li class="nav-item">
                    <hr>
                </li>
                <li class="nav-item <?php echo empty($_SESSION['type']) ?"
                active "=" " :=" " " ";=" " ?=" ">">

                            <a class="nav-link " href="<?php echo
                $global['webSiteRootURL']; ?>?type=all ">

                                <span class="glyphicon glyphicon-star "></span>

                                <?php echo __("Audios and Videos "); ?>

                            </a>

                        </li>

                        <li class="nav-item <?php echo (!empty($_SESSION['type'])
                && $_SESSION['type']== 'video' && empty($_GET['catName']))
                ? " active"="" :="" "";="" ?="">"> <a class="nav-link" href="<?php echo $global['webSiteRootURL']; ?>videoOnly">

                                <span class="glyphicon glyphicon-facetime-video"></span>

                                <?php echo __("Videos"); ?>

                            </a>
                </li>
                <li class="nav-item <?php echo (!empty($_SESSION['type']) && $_SESSION['type'] == 'audio' && empty($_GET['catName'])) ?"
                active "=" " :=" " " ";=" " ?=" ">">

                            <a class="nav-link " href="<?php echo
                $global['webSiteRootURL']; ?>audioOnly ">

                                <span class="glyphicon glyphicon-headphones "></span>

                                <?php echo __("Audios "); ?>

                            </a>

                        </li>

                        <?php

                    }

                    ?>



                    <?php

                    if (empty($advancedCustom->removeBrowserChannelLinkFromMenu)) {

                        ?>

                        <!-- Channels -->

                        <li class="nav-item ">

                            <hr>

                        </li>

                        <li class="nav-item ">

                            <h3 class="text-danger "><?php echo __("Channels "); ?></h3>

                        </li>

                        <li class="nav-item ">

                            <a href="<?php echo $global['webSiteRootURL'];
                ?>channels " class="nav-link ">

                                <i class="fa fa-search "></i>

                                <?php echo __("Browse Channels "); ?>

                            </a>

                        </li>



                        <?php

                    }

                    ?>

                    <li class="nav-item ">

                        <hr>

                    </li>

                    <!-- categories -->

                    <li class="nav-item ">

                        <h3 class="text-danger "><?php echo __($advancedCustom->CategoryLabel); ?></h3>

                    </li>

                    <?php

                    if (!function_exists('mkSub')) {



                        function mkSub($catId) {

                            global $global;

                            unset($_GET['parentsOnly']);

                            $subcats = Category::getChildCategories($catId);

                            if (!empty($subcats)) {

                                echo "<ul style='margin-bottom: 0px; list-style-type: none;'>"; foreach ($subcats as $subcat) { if (empty($subcat['total']))
                    { continue; } echo '
                    <li class="' . ($subcat['clean_name'] == @$_GET['catName'] ?  nav-item"
                    active "=" " :=" " " ")=" " .=" " '"="">' . '<a href="' . $global['webSiteRootURL'] . 'cat/' . $subcat['clean_name'] . '"
                        class="nav-link">'

                                    . '<span class="' . (empty($subcat['iconClass']) ? " fa="" fa-folder"="" :="" $subcat['iconclass'])="" .="" '"=""></span>  ' . $subcat['name'] . ' <span class="badge">' . $subcat['total'] . '</span></a>
                    </li>'; mkSub($subcat['id']); } echo "</ul>"; } }
            } if (empty($advancedCustom->doNotDisplayCategoryLeftMenu)) { $categories
            = Category::getAllCategories(); foreach ($categories as $value) { if($advancedCustom->ShowAllVideosOnCategory){
            $total = $value['fullTotal']; }else{ $total = $value['total'];
            } if (empty($total)) { continue; } echo '
            <li class="' . ($value['clean_name'] == @$_GET['catName'] ? "
            active "=" " :=" " " ")=" " .=" " '"="">' . '<a href="' . $global['webSiteRootURL'] . 'cat/' . $value['clean_name'] . '">'

                            . '<span class="' . (empty($value['iconClass']) ? " fa="" fa-folder"="" :="" $value['iconclass'])="" .="" '"=""></span>  ' . $value['name'] . ' <span class="badge">' . $total . '</span></a>';
                mkSub($value['id']); echo '</li>'; } } ?>
            <?php echo
            YouPHPTubePlugin::getHTMLMenuLeft(); ?>
            <!-- categories END -->
            <li>
                <hr>
            </li>
            <?php if (empty($advancedCustom->disableHelpLeftMenu)) { ?>
            <li> <a href="<?php echo $global['webSiteRootURL']; ?>help">

                                <span class="glyphicon glyphicon-question-sign"></span>

                                <?php echo __("Help"); ?>

                            </a>
            </li>
            <?php } if (empty($advancedCustom->disableAboutLeftMenu)) { ?>
            <li> <a href="<?php echo $global['webSiteRootURL']; ?>about">

                                <span class="glyphicon glyphicon-info-sign"></span>

                                <?php echo __("About"); ?>

                            </a>
            </li>
            <?php } if (empty($advancedCustom->disableContactLeftMenu)) { ?>
            <li> <a href="<?php echo $global['webSiteRootURL']; ?>contact">

                                <span class="glyphicon glyphicon-comment"></span>

                                <?php echo __("Contact"); ?>

                            </a>
            </li>
            <?php } ?>
        </div>
    </div>
    <!-- End of sidebar -->
</nav>