<?php
/*
  $ServerFolder 	= 'C:/xampp/htdocs/subSite/_FileSystems/Imagenes/';
  $PublicURL 		= '/subSite/_FileSystems/Imagenes/';
  $subSite		= '/'; // Sub folder in site http://www.website.com/[subSite]
 */
$ServerFolder = SKTPATH_FileSystems . DS . 'Banners' . DS.'Home'. DS;
$PublicURL = SKTURL_FileSystems . '/Banners/home/';
$DirFolder = new CmsDev\AdminFilesystem\FolderRecoveryFiles(); // Create new instance
$DirFolder->Folder($ServerFolder, $PublicURL, SKTServerURL);
$DirFolder->TrumbnailImage(1200, 480, 85); // $Width, $Height, $Quality
$DirFolder->Trumbnail(false);
$DirFolder->View_image(1); // 0 or 1
$DirFolder->View_video(0); // 0 or 1
$DirFolder->View_Download(0); // 0 or 1
$DirFolder->extArray(array("jpg"));
$DirFolder->item_model_image('<div class="bg-holder">
    <img src="[PublicURL]" alt="" title="" />
    <div class="bg-mask"></div>
    <div class="vert-center text-white text-center slider-caption">
                            <h2 class="text-uc">[Title]</h2>
                            <p class="text-bigger">[Description]</p>
                            <p class="text-hero">[CustomData]</p>
                            <a href="[hiperlink]" class="btn btn-lg btn-ghost btn-white">Conoce m&aacute;s +</a>
                        </div>
                        <div class="bg-front vert-center text-white text-center">
    </div>
</div>');
$DirFolder->item_model_video('');
$DirFolder->item_model_Download('');
if ($DirFolder->exist() == true && $DirFolder->FilesInFolder() != 0) {
    ?>
    <div class="top-area">
        <div class="owl-carousel owl-slider" id="owl-carousel-slider" data-inner-pagination="true" data-white-pagination="true" data-nav="true">
            <?php
            echo $DirFolder->ListFolder();
            ?>
        </div>
    </div>
<?php } ?>