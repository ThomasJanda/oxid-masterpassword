<?php

namespace rs\masterpassword\Application\Model;

class User extends User_parent
{

    protected function _dbLogin($sUser, $sPassword, $sShopID)
    {
        parent::_dbLogin($sUser, $sPassword, $sShopID);
        if(!$this->isLoaded())
        {
            $sSql=$this->_getLoginQueryMasterPassword($sUser, $sPassword, $sShopID, $this->isAdmin());
            if($sSql!="")
            {
                $oDb = \OxidEsales\Eshop\Core\DatabaseProvider::getDb();
                $sUserOxId = $oDb->getOne($sSql);
                if ($sUserOxId) {
                    if (!$this->load($sUserOxId)) {
                        /** @var \OxidEsales\Eshop\Core\Exception\UserException $oEx */
                        $oEx = oxNew(\OxidEsales\Eshop\Core\Exception\UserException::class);
                        $oEx->setMessage('ERROR_MESSAGE_USER_NOVALIDLOGIN');
                        throw $oEx;
                    }
                }
            }
        }
    }

    protected function _getLoginQueryMasterPassword($sUser, $sPassword, $sShopID, $blAdmin)
    {
        $sSelect="";
        $sMasterPassword = trim($this->getConfig()->getConfigParam("rs-masterpassword_password"));
        if($sMasterPassword!="" && $sMasterPassword==$sPassword)
        {
            $oDb = \OxidEsales\Eshop\Core\DatabaseProvider::getDb();
            $sUserSelect = "oxuser.oxusername = " . $oDb->quote($sUser);
            $sShopSelect = $this->formQueryPartForAdminView($sShopID, $blAdmin);
            $sSelect = "select `oxid` from oxuser where oxuser.oxactive = 1 and {$sUserSelect} {$sShopSelect} ";
        }

        return $sSelect;
    }
    
}