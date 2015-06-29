<?php

/**
 * Description of User Plan
 *
 * @author Martín Daguerre
 */

namespace CmsDev\CRUD\ViewEditElementsAsList\Lists\User_plan;

class Plan {

    protected $ListTemplate = '
<div class="col-md-12 ItemPlan">
        <h5 class="title">[Business_Name]</h5>
</div>';
    protected $PlanFields = array(
        'bpid' => 'int',
        'UID' => 'int',
        'Limit_Plan' => 'int',
        'planID' => 'int',
        'Date_Finish' => 'text'
    );
    protected $DefaultParams = array(
        'IDUser' => '',
        'Limit' => 100
    );

    protected function Render($InstancsParams = array()) {
        $SelfParams = array(
            'TemplateItem' => $this->ListTemplate,
            'OrderBy' => 'user_plan.Date_Finish ASC'
        );
        $Settings = array_merge($this->DefaultParams, $SelfParams, $InstancsParams);
        $this->DefaultParams = $Settings;
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $Query = $SKTDB->get_results("SELECT UP.*, P.*, U.* FROM "
                . "user_plan as UP "
                . "JOIN plan as P "
                . "JOIN users as U "
                . "ON UP.planID = P.Plan_id "
                . "AND U.id = UP.UID");
        $TemplateItem = '
<div class="col-md-12 ItemPlan">
        <h5 class="title">[UID]</h5>
</div>';
        return $this->TemplateItem($Query, $Settings);
    }

    protected function TemplateItem($Query, $Settings) {
        $find = array(
            'bpid' => 'int',
            'UID' => 'int',
            'Limit_Plan' => 'int',
            'planID' => 'int',
            'Date_Finish' => 'text'
        );
        $Thisitem = '';
        if (!empty($Query)) {
            foreach ($Query as $item) {
                $replace = array(
                    $item->bpid,
                    $item->UID,
                    $item->Limit_Plan,
                    $item->planID,
                    $item->Date_Finish
                );
                $Thisitem .= str_replace($find, $replace, $Settings['TemplateItem']);
            }
        }
        return $Thisitem;
    }

    protected function CustomGetList($InstancsParams = array()) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $QueryWhere = '';
        $SelfParams = array(
            'TemplateItem' => $this->ListTemplate,
            'OrderBy' => 'user_plan.Date_Finish ASC'
        );
        $Settings = array_merge($this->DefaultParams, $SelfParams, $InstancsParams);
        $this->DefaultParams = $Settings;
        if ($Settings['Where'] != '') {
            $QueryWhere .= $Settings['Where'];
        }
        $CustomQuery = "SELECT userprofile.*, users.*, negocios_plan.*, user_plan.* FROM "
                . "user_plan "
                . "JOIN negocios_plan "
                . "JOIN userprofile "
                . "JOIN users "
                . "ON user_plan.UID = user.id "
                . "AND user.id = userprofile.IDX"
                . "AND negocios_plan.Plan_id = user_plan.UID "
                . "AND user_plan.UID = user.id "
                . "LIMIT " . $Settings['Limit'];
        echo $CustomQuery;
        $Query = $SKTDB->get_results($CustomQuery);
        $render = '<div><h3>resultados</h3>' . $this->TemplateItem($Query, $Settings) . '</div>';
        return $render;
    }

    protected function GetDataset($ID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $CustomQuery = "SELECT UP.*, P.*, U.* FROM "
                . "user_plan as UP "
                . "JOIN plan as P "
                . "JOIN users as U "
                . "ON UP.planID = P.Plan_id "
                . "AND U.id = UP.UID "
                . "WHERE U.id = " . GetSQLValueString($ID, 'int');
        $Query = $SKTDB->get_row($CustomQuery);
        return $Query;
    }

    protected function Add() {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $queryPlanFields = $queryPlanValues = '';
        foreach ($_POST as $Field => $Value) {
            if (array_key_exists($Field, $this->PlanFields)) {
                $queryPlanFields.= $Field . ',';
            }
        }
        foreach ($_POST as $Field => $Value) {
            if (array_key_exists($Field, $this->PlanFields)) {
                $queryPlanValues.= self::DecodeValue(\GetSQLValueString($Value, $this->PlanFields[$Field])) . ',';
            }
        }
        $queryPlanFieldsTrimed = trim($queryPlanFields, ',');
        $queryPlanValuesTrimed = trim($queryPlanValues, ',');
        $query = "INSERT INTO user_plan ($queryPlanFieldsTrimed) VALUES ($queryPlanValuesTrimed)";
        if ($queryPlanFieldsTrimed) {
            $insert = $SKTDB->query($query);
        }
        if ($insert) {
            echo 'okay';
        } else {
            echo "error";
        }
    }

    protected function AddGift($UID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $date = date('Y-m-d');
        $Date_FinishBuild = strtotime('+ 182 day', strtotime($date));
        $Date_Finish = date('Y-m-d', $Date_FinishBuild);
        $query = "INSERT INTO user_plan (UID,Limit_Plan,planID,Date_Finish) "
                . "VALUES (" . GetSQLValueString($insertUserID, "int") . ","
                . GetSQLValueString("180", "int") . ","
                . GetSQLValueString("99", "int") . ","
                . GetSQLValueString($Date_Finish, "date") . ")";
        $SKTDB->query($query);
    }

    protected function Update($ID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $queryPlanFields = '';
        foreach ($_POST as $Field => $Value) {
            if (in_array($Field, $this->PlanFields)) {
                $queryPlanFields.= $Field . ' = ' . self::DecodeValue(\GetSQLValueString($Value, $this->PlanFields[$Field])) . ',';
            }
        }
        $queryPlanFieldsTrimed = trim($queryPlanFields, ',');
        if ($queryPlanFieldsTrimed) {
            $update = $SKTDB->query("UPDATE user_plan Set 
            $queryPlanFieldsTrimed
            WHERE bpid = " . GetSQLValueString($ID, "int"));
        } else {
            $update = true;
        }
        if ($update) {
            echo 'Los datos fueron actualizados correctamente.';
        } else {
            echo "error";
        }
    }

    protected function CountDownLimit($ID) {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $update = $SKTDB->query("UPDATE user_plan Set 
            Limit_Plan = Limit_Plan-1
            WHERE UID = " . GetSQLValueString($ID, "int"));

        if (!$update) {
            echo "error";
        }
    }

    protected function Remove($ID = '') {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $DeleteQuery = $SKTDB->query("DELETE FROM user_plan WHERE bpid = '" . \GetSQLValueString(\str_replace('ID', '', $ID), "int") . "' LIMIT 1");
        if ($DeleteQuery) {
            echo 'ok';
        } else {
            echo \SKT_ADMIN_Message_Update_Error;
        }
    }

    protected static function EncodeValue($value) {
        return \utf8_encode($value);
    }

    protected static function DecodeValue($value) {
        return \utf8_decode($value);
    }

}

class _classes extends Plan {

    public function RenderList() {
        return self::Render();
    }

    public function Dataset($ID) {
        return self::GetDataset($ID);
    }

    public function AddNewUser($UID) {
        return self::AddGift($UID);
    }

    public function AddToList() {
        return self::Add();
    }

    public function RemoveFromList($ID) {
        return self::Remove($ID);
    }

    public function EditItemList($ID) {
        return self::Edit($ID);
    }

    public function UpdateData($ID) {
        return self::Update($ID);
    }

    public function CountDown($ID) {
        return self::CountDownLimit($ID);
    }

    public function GetList($InstancsParams) {
        return self::CustomGetList($InstancsParams);
    }

    public function GetFromUserID($DetailID) {
        return self::GetUserID($DetailID);
    }

}

?>