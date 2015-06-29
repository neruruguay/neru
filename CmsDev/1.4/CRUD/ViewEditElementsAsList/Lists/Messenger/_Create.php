<?php
if (\CmsDev\Security\loginIntent::action('validate') === true) {
        $Messenger = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Messenger\_classes;
        echo $Messenger->AddToList();
} else {
    echo 'login';
    
}
?>