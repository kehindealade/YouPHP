<?php
global $global, $config;
$isChannel = 1; // still workaround, for gallery-functions, please let it there.
if (!isset($global['systemRootPath'])) {
    require_once '../videos/configuration.php';
}
require_once $global['systemRootPath'] . 'objects/user.php';
require_once $global['systemRootPath'] . 'objects/category.php';
require_once $global['systemRootPath'] . 'objects/subscribe.php';
require_once $global['systemRootPath'] . 'objects/functions.php';

$img = "{$global['webSiteRootURL']}view/img/notfound.jpg";
$poster = "{$global['webSiteRootURL']}view/img/notfound.jpg";
$imgw = 1280;
$imgh = 720;

if (!empty($_GET['type'])) {
    if ($_GET['type'] == 'audio') {
        $_SESSION['type'] = 'audio';
    } else
    if ($_GET['type'] == 'video') {
        $_SESSION['type'] = 'video';
    } else {
        $_SESSION['type'] = "";
        unset($_SESSION['type']);
    }
} else {
    unset($_SESSION['type']);
}
session_write_close();
require_once $global['systemRootPath'] . 'objects/video.php';

$catLink = "";
if (!empty($_GET['catName'])) {
    $catLink = "cat/{$_GET['catName']}/";
}

// add this because if you change the video category the video was not loading anymore
$catName = @$_GET['catName'];

if (empty($_GET['clean_title']) && (isset($advancedCustom->forceCategory) && $advancedCustom->forceCategory === false)) {
    $_GET['catName'] = "";
}

if (empty($video)) {
    $video = Video::getVideo("", "viewable", false, false, true, true);
}

if (empty($video)) {
    $video = Video::getVideo("", "viewable", false, false, false, true);
}
if(empty($video)){
    $video = YouPHPTubePlugin::getVideo();
}
// add this because if you change the video category the video was not loading anymore
$_GET['catName'] = $catName;

$_GET['isMediaPlaySite'] = $video['id'];
$obj = new Video("", "", $video['id']);

/*
  if (empty($_SESSION['type'])) {
  $_SESSION['type'] = $video['type'];
  }
 * 
 */
// $resp = $obj->addView();

$get = array('channelName' => @$_GET['channelName'], 'catName' => @$_GET['catName']);

if (!empty($_GET['playlist_id'])) {
    $playlist_id = $_GET['playlist_id'];
    if (!empty($_GET['playlist_index'])) {
        $playlist_index = $_GET['playlist_index'];
    } else {
        $playlist_index = 0;
    }

    $videosArrayId = PlayList::getVideosIdFromPlaylist($_GET['playlist_id']);
    $videosPlayList = Video::getAllVideos("viewable");
    $videosPlayList = PlayList::sortVideos($videosPlayList, $videosArrayId);
    $video = Video::getVideo($videosPlayList[$playlist_index]['id']);
    if (!empty($videosPlayList[$playlist_index + 1])) {
        $autoPlayVideo = Video::getVideo($videosPlayList[$playlist_index + 1]['id']);
        $autoPlayVideo['url'] = $global['webSiteRootURL'] . "playlist/{$playlist_id}/" . ($playlist_index + 1);
    } else if (!empty($videosPlayList[0])) {
        $autoPlayVideo = Video::getVideo($videosPlayList[0]['id']);
        $autoPlayVideo['url'] = $global['webSiteRootURL'] . "playlist/{$playlist_id}/0";
    }

    unset($_GET['playlist_id']);
} else {
    if (!empty($video['next_videos_id'])) {
        $autoPlayVideo = Video::getVideo($video['next_videos_id']);
    } else {
        if ($video['category_order'] == 1) {
            unset($_POST['sort']);
            $category = Category::getAllCategories();
            $_POST['sort']['title'] = "ASC";

            // maybe there's a more slim method?
            $videos = Video::getAllVideos();
            $videoFound = false;
            $autoPlayVideo;
            foreach ($videos as $value) {
                if ($videoFound) {
                    $autoPlayVideo = $value;
                    break;
                }

                if ($value['id'] == $video['id']) {
                    // if the video is found, make another round to have the next video properly.
                    $videoFound = true;
                }
            }
        } else {
            $autoPlayVideo = Video::getRandom($video['id']);
        }
    }

    if (!empty($autoPlayVideo)) {

        $name2 = User::getNameIdentificationById($autoPlayVideo['users_id']);
        $autoPlayVideo['creator'] = '<div class="pull-left"><img src="' . User::getPhoto($autoPlayVideo['users_id']) . '" alt="" class="img img-responsive img-circle zoom" style="max-width: 40px;"/></div><div class="commentDetails" style="margin-left:45px;"><div class="commenterName"><strong>' . $name2 . '</strong> <small>' . humanTiming(strtotime($autoPlayVideo['videoCreation'])) . '</small></div></div>';
        $autoPlayVideo['tags'] = Video::getTags($autoPlayVideo['id']);
        //$autoPlayVideo['url'] = $global['webSiteRootURL'] . $catLink . "video/" . $autoPlayVideo['clean_title'];
        $autoPlayVideo['url'] = Video::getLink($autoPlayVideo['id'], $autoPlayVideo['clean_title'], false, $get);
    }
}

if (!empty($video)) {
    $name = User::getNameIdentificationById($video['users_id']);
    $name = "<a href='" . User::getChannelLink($video['users_id']) . "' class='btn btn-xs btn-default'>{$name}</a>";
    $subscribe = Subscribe::getButton($video['users_id']);
    $video['creator'] = '<div class="pull-left"><img src="' . User::getPhoto($video['users_id']) . '" alt="" class="img img-responsive img-circle zoom" style="max-width: 40px;"/></div><div class="commentDetails" style="margin-left:45px;"><div class="commenterName text-muted"><strong>' . $name . '</strong><br />' . $subscribe . '<br /><small>' . humanTiming(strtotime($video['videoCreation'])) . '</small></div></div>';
    $obj = new Video("", "", $video['id']);

    // dont need because have one embeded video on this page
    // $resp = $obj->addView();
}

if ($video['type'] == "video") {
    $poster = "{$global['webSiteRootURL']}videos/{$video['filename']}.jpg";
} else {
    $poster = "{$global['webSiteRootURL']}view/img/audio_wave.jpg";
}

if (!empty($video)) {
    $source = Video::getSourceFile($video['filename']);
    if (($video['type'] !== "audio") && ($video['type'] !== "linkAudio")) {
        $img = $source['url'];
        $data = getimgsize($source['path']);
        $imgw = $data[0];
        $imgh = $data[1];
    } else {
        $img = "{$global['webSiteRootURL']}view/img/audio_wave.jpg";
    }
    $images = Video::getImageFromFilename($video['filename']);
    $poster = $images->poster;
    if (!empty($images->posterPortrait)) {
        $img = $images->posterPortrait;
        $data = getimgsize($source['path']);
        $imgw = $data[0];
        $imgh = $data[1];
    }
} else {
    $poster = "{$global['webSiteRootURL']}view/img/notfound.jpg";
}

$objSecure = YouPHPTubePlugin::getObjectDataIfEnabled('SecureVideosDirectory');
$advancedCustom = YouPHPTubePlugin::getObjectDataIfEnabled("CustomizeAdvanced");

if (!empty($autoPlayVideo)) {
    $autoPlaySources = getSources($autoPlayVideo['filename'], true);
    $autoPlayURL = $autoPlayVideo['url'];
    $autoPlayPoster = "{$global['webSiteRootURL']}videos/{$autoPlayVideo['filename']}.jpg";
    $autoPlayThumbsSprit = "{$global['webSiteRootURL']}videos/{$autoPlayVideo['filename']}_thumbsSprit.jpg";
} else {
    $autoPlaySources = array();
    $autoPlayURL = '';
    $autoPlayPoster = '';
    $autoPlayThumbsSprit = "";
}

if (empty($_GET['videoName'])) {
    $_GET['videoName'] = $video['clean_title'];
}

$v = Video::getVideoFromCleanTitle($_GET['videoName']);

YouPHPTubePlugin::getModeYouTube($v['id']);

$videos = Video::getAllVideos("viewable"); 

?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">
    <head>
        <title><?php echo $video['title']; ?> - <?php echo $config->getWebSiteTitle(); ?></title>
        <link href="<?php echo $global['webSiteRootURL']; ?>view/js/video.js/video-js.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $global['webSiteRootURL']; ?>view/css/player.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $global['webSiteRootURL']; ?>view/css/social.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $global['webSiteRootURL']; ?>view/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <!-- The head include -->


         <?php include $global['systemRootPath'] . 'view/include/new_head.php'; ?>
        <?php //include $global['systemRootPath'] . 'view/include/head.php'; ?>


        <link rel="image_src" href="<?php echo $img; ?>" />
        <meta property="fb:app_id"             content="774958212660408" />
        <meta property="og:url"                content="<?php echo $global['webSiteRootURL'], $catLink, "video/", $video['clean_title']; ?>" />
        <meta property="og:type"               content="video.other" />
        <meta property="og:title"              content="<?php echo str_replace('"', '', $video['title']); ?> - <?php echo $config->getWebSiteTitle(); ?>" />
        <meta property="og:description"        content="<?php echo!empty($custom) ? $custom : str_replace('"', '', $video['title']); ?>" />
        <meta property="og:image"              content="<?php echo $img; ?>" />
        <meta property="og:image:width"        content="<?php echo $imgw; ?>" />
        <meta property="og:image:height"       content="<?php echo $imgh; ?>" />
        <meta property="video:duration" content="<?php echo Video::getItemDurationSeconds($video['duration']); ?>"  />
        <meta property="duration" content="<?php echo Video::getItemDurationSeconds($video['duration']); ?>"  />
    </head>

    <body class="<?php echo $global['bodyClass']; ?>">

        <?php //include $global['systemRootPath'] . 'view/include/navbar.php'; ?>
        <?php include $global['systemRootPath'] . 'view/include/new_navbar.php'; ?>
         <?php
        if (!empty($advancedCustomUser->showChannelBannerOnModeYoutube)) {
            ?>
            <!-- <div class="container" style="margin-bottom: 10px;">
                <img src="<?php //echo User::getBackground($video['users_id']); ?>" class="img img-responsive" />
            </div> -->
            <?php
        }
        ?>

      <div class="clearfix"></div>

     
  <div class="content-wrapper">
    <div class="container-fluid">
    
    
       
   
    
        <!-- <div class="container-fluid principalContainer" itemscope itemtype="http://schema.org/VideoObject"> -->
            <?php
            if (!empty($video)) {
                if (empty($video['type'])) {
                    $video['type'] = "video";
                }
                $img_portrait = ($video['rotation'] === "90" || $video['rotation'] === "270") ? "img-portrait" : "";
                if (!empty($advancedCustom->showAdsenseBannerOnTop)) {
                    ?>
                    <style>
                        .compress {
                            top: 100px !important;
                        }
                    </style>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <center style="margin:5px;">
                                <?php
                                echo $config->getAdsense();
                                ?>
                            </center>
                        </div>
                    </div>
                    <?php
                }
                $vType = $video['type'];
                if ($vType == "linkVideo") {
                    $vType = "video";
                } else if ($vType == "live") {
                    $vType = "../../plugin/Live/view/liveVideo";
                } else if ($vType == "linkAudio") {
                    $vType = "audio";
                }

                //The autoplay video
                //require "{$global['systemRootPath']}view/include/{$vType}.php";
                ?>


            
    <?php
                                        /*$imgGif = "";
                                        if (file_exists("{$global['systemRootPath']}videos/{$autoPlayVideo['filename']}.gif")) {
                                            $imgGif = "{$global['webSiteRootURL']}videos/{$autoPlayVideo['filename']}.gif";
                                        }
                                        if (($autoPlayVideo['type'] !== "audio") && ($autoPlayVideo['type'] !== "linkAudio")) {
                                            $img = "{$global['webSiteRootURL']}videos/{$autoPlayVideo['filename']}.jpg";
                                            $img_portrait = ($autoPlayVideo['rotation'] === "90" || $autoPlayVideo['rotation'] === "270") ? "img-portrait" : "";
                                        } else {
                                            $img = "{$global['webSiteRootURL']}view/img/audio_wave.jpg";
                                            $img_portrait = "";
                                        }*/
                                        ?>
                                       
                                        <div class="row">

                                       <?php  foreach ($videos as $key => $value) {
    if (!empty($video['id']) && $video['id'] == $value['id']) {
        continue; // skip video
    }
    $name = User::getNameIdentificationById($value['users_id']);
    $value['creator'] = '<div class="pull-left"><img src="' . User::getPhoto($value['users_id']) . '" alt="" class="img img-responsive img-circle zoom" style="max-width: 20px;"/></div><div class="commentDetails" style="margin-left:25px;"><div class="commenterName text-muted"><strong>' . $name . '</strong> <small>' . humanTiming(strtotime($value['videoCreation'])) . '</small></div></div>';
    ?>

    
    
            
                <?php
                $images = Video::getImageFromFilename($value['filename'], $value['type']);

                $imgGif = $images->thumbsGif;
                $img = $images->thumbsJpg;
                if (!empty($images->posterPortrait)) {
                    $imgGif = $images->gifPortrait;
                    $img = $images->posterPortrait;
                }
                if (($value['type'] !== "audio") && ($value['type'] !== "linkAudio")) {
                    $img_portrait = ($value['rotation'] === "90" || $value['rotation'] === "270") ? "img-portrait" : "";
                } else {
                    $img_portrait = "";
                }
                ?>

     
       <div class="col-12 col-xl-3 col-md-4 col-lg-4 col-sm-12" >
        <!-- style="width: 20rem; height: 20rem; -->
        <div class="card">

          <img src="<?php echo $images->thumbsJpg; ?>" class="card-img-top" height="160px">

          <meta itemprop="thumbnailUrl" content="<?php echo $img; ?>" />
                    <meta itemprop="uploadDate" content="<?php echo $value['created']; ?>" />
                    <center><time class="container duration float-right" itemprop="duration" datetime="<?php echo Video::getItemPropDuration($value['duration']); ?>"><?php echo Video::getCleanDuration($value['duration']); ?></time></center>
          
        </div>
       </div>
       
     <?php } ?>
     </div>

</div>



         <?php } else { ?>
                <div class="alert alert-warning">
                    <span class="alert alert-success" role="alert"></span> <strong><?php echo __("Warning"); ?>!</strong> <?php echo __("We have not found any videos or audios to show"); ?>.
                </div>
            <?php } ?>
            <script src="<?php echo $global['webSiteRootURL']; ?>bootstrap/js/app-script.js" type="text/javascript"></script>
             <script src="<?php echo $global['webSiteRootURL']; ?>bootstrap/simplebar/js/simplebar.js" type="text/javascript"></script>
        <script>
                        /*** Handle jQuery plugin naming conflict between jQuery UI and Bootstrap ***/
                        $.widget.bridge('uibutton', $.ui.button);
                        $.widget.bridge('uitooltip', $.ui.tooltip);
        </script>
        <?php
        $videoJSArray = array("view/js/video.js/video.js");
        if ($advancedCustom != false) {
            $disableYoutubeIntegration = $advancedCustom->disableYoutubePlayerIntegration;
        } else {
            $disableYoutubeIntegration = false;
        }

        if ((isset($_GET['isEmbedded'])) && ($disableYoutubeIntegration == false)) {
            if ($_GET['isEmbedded'] == "y") {
                $videoJSArray[] = "view/js/videojs-youtube/Youtube.js";
            } else if ($_GET['isEmbedded'] == "v") {
                $videoJSArray[] = "view/js/videojs-vimeo/videojs-vimeo.js";
            }
        }
        $jsURL = combineFiles($videoJSArray, "js");
        ?>
         </div>
     </div>
        <script src="<?php echo $jsURL; ?>" type="text/javascript"></script>
        <?php
        include $global['systemRootPath'] . 'view/include/footer.php';
        ?>
       

        <?php 
        $videoJSArray = array(
            "view/js/videojs-persistvolume/videojs.persistvolume.js",
            "view/js/BootstrapMenu.min.js");
        $jsURL = combineFiles($videoJSArray, "js");
        ?>
        <script src="<?php echo $jsURL; ?>" type="text/javascript"></script>
        <script>
                        var fading = false;
                        var autoPlaySources = <?php echo json_encode($autoPlaySources); ?>;
                        var autoPlayURL = '<?php echo $autoPlayURL; ?>';
                        var autoPlayPoster = '<?php echo $autoPlayPoster; ?>';
                        var autoPlayThumbsSprit = '<?php echo $autoPlayThumbsSprit; ?>';

                        $(document).ready(function () {
                        });
        </script>
    </body>
</html>
<?php include $global['systemRootPath'] . 'objects/include_end.php'; ?>
