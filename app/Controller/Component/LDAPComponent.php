<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP LDAPComponent
 * @author cfpajm
 */
class LDAPComponent extends Component {

    private $ldap = null;
    private $ldapServer = 'ldap://akladc31.pfr.co.nz';
    public $suffix = '@pfr.co.nz';
    public $baseDN = 'dc=pfr,dc=co,dc=nz';
    
    private $ldapUser = 'CN=PFRappBinder,OU=PFR Services,DC=PFR,DC=CO,DC=NZ';
    private $ldapPassword = '';
 // lines 24-28 commented out to stop ldap login
    public function __construct() { //sets up the connection to the LDAP database
        //$this->ldap = ldap_connect($this->ldapServer) or die ("didnt connect");     
        //$this->ldapPassword = getenv('LDAP_PASS');
        //these next two lines are required for windows server 03
        //ldap_set_option($this->ldap, LDAP_OPT_REFERRALS, 0);
        //ldap_set_option($this->ldap, LDAP_OPT_PROTOCOL_VERSION, 3);        
    }
 
    public function auth($user,$pass)
    {
        if (empty($user) or empty($pass))
        {
            return false;
        }
        @$good = ldap_bind($this->ldap,$user.$this->suffix,$pass);
        if( $good === true ){
            return true;
        }else{
            return false;
        }
    }
 
    public function __destruct(){
        //ldap_unbind($this->ldap);
    }
 
    public function getInfo($user){
        $username = $user.$this->suffix;
        $attributes = array('givenName','sn','mail','samaccountname','memberof','physicaldeliveryofficename');
        $filter = "(userPrincipalName=$username)";
 
        ldap_bind($this->ldap,$this->ldapUser,$this->ldapPassword);
        $result = ldap_search($this->ldap, $this->baseDN, $filter,$attributes);
        $entries = ldap_get_entries($this->ldap, $result);        
        return $this->formatInfo($entries);
    }
 
    private function formatInfo($array){ //formats the info into an array
        $info = array();
        $info['first_name'] = $array[0]['givenname'][0];
        $info['last_name'] = $array[0]['sn'][0];
        $info['name'] = $info['first_name'] .' '. $info['last_name'];
        $info['email'] = $array[0]['mail'][0];
        $info['user'] = $array[0]['samaccountname'][0];
        $info['groups'] = $this->groups($array[0]['memberof']);
        $info['location'] = $array[0]['physicaldeliveryofficename'][0];
 
        return $info;
    }
 
    private function groups($array)
    {
        $groups = array();
        $tmp = array();
 
        foreach( $array as $entry )
        {
            $tmp = array_merge($tmp,explode(',',$entry));
        }
 
        foreach($tmp as $value) {
            if( substr($value,0,2) == 'CN' ){
                $groups[] = substr($value,3);
            }
        }
 
        return $groups;
    }
}
