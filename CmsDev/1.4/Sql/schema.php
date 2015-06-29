<?php

/**
 * Description of schema
 *
 * @author Usuario
 */

namespace CmsDev\sql;

class schema {

    public static function getQuery($param = null) {
        /* @var $param type */
        if ($param) {
            $SKTDB = \CmsDev\sql\db_Skt::connect();
            $QUERY = "CREATE TABLE `lists` (`ID` int(11) NOT NULL, `ListName` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
                        TRUNCATE TABLE `lists`;
                        INSERT INTO `lists` (`ID`, `ListName`) VALUES (29, 'Demo'),(28, 'Inmuebles');
                        ALTER TABLE `lists` ADD PRIMARY KEY (`ID`);
                        ALTER TABLE `lists` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;";
            $insertLink = $SKTDB->query($QUERY);
        }
    }

}

?>
