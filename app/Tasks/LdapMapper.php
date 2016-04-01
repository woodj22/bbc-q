<?php
/**
 * Created by PhpStorm.
 * User: JoeWood
 * Date: 31/03/2016
 * Time: 14:02
 */

namespace App\Tasks;


class LdapMapper
{


    private $ldap_connection = null;
    private $baseDN = null;

    public function __construct($username, $password, $dc, $baseDN)
    {
        if (!$username || !$password || !$dc || !$baseDN) {
            return false;
        }

        if (!$this->ldap_connection) {
            $ldapConn = ldap_connect($dc);

            if (!$ldapConn) {
                return false;
            }

            ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);
            ldap_bind($ldapConn, $username, $password);

            $this->ldap_connection = $ldapConn;
            $this->baseDN = $baseDN;

            return true;
        }
    }

    public function isInGroup($group, $username)
    {
        $result = ldap_search(
            $this->ldap_connection,
            $this->baseDN,
            "(samaccountname=" . $username . ")",
            array('memberof')
        );

        $results = ldap_get_entries($this->ldap_connection, $result);

        if (count($results)) {
            $results = @$results[0]["memberof"];
            if (count($results)) {
                if (in_array($group, $results)) {
                    return true;
                }
            }
        }

        return false;
    }

}

/*
[2:00]
LDAP_USERNAME=NATIONAL\passwordreset
LDAP_PASSWORD=passwordreset
LDAP_DC=ldap.national.core.bbc.co.uk
LDAP_BASEDN=DC=national,DC=core,DC=bbc,DC=co,DC=uk
*/
