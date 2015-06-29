<?php

$NavMenu = new \CmsDev\Navegation\make();
$Sections_Menu = array();
$Sections_Menu['Class'] = 'menu';
$Sections_Menu['DisplayMenu'] = '1'; // 0=HiddenSections , 1=Top, 2= Footer, 3=Secundary ...
$Sections_Menu['sktRecycleBinHidden'] = 'sktRecycleBinHidden'; // Dont Change is a Admin control!!!
$Sections_Menu['Wrap_Before'] = '<ul>';
$Sections_Menu['Wrap_After'] = '</ul>';
$Sections_Menu['set_Item_Template_Before'] = '<li class="[sktRecycleBinHidden] [CSS_Selected]">
    <a class="[CSS_WithArrow]" href="[URL]" target="_self"><span>[Name]</span></a>';
$Sections_Menu['set_Item_Template_After'] = '</li>';
$Sections_Menu['set_CSS_Selected'] = 'active';
$Sections_Menu['init_level'] = 1;
$UIDnav = \rand(555, 999);

echo '<ul class="nav nav-pills flexnav" data-breakpoint="800" id="flexnav">';
echo $NavMenu->nav($Sections_Menu, 1);
//if (\CmsDev\Security\loginIntent::action('validate', 'UserBoxActions') === true) {
//    $UserBoxActions = new \CmsDev\Security\UserBoxActions();
//    echo "<li>" . $UserBoxActions->Render() . "</li>";
//}
echo '</ul>';
?>