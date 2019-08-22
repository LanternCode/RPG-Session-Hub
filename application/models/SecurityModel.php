<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class securityModel extends CI_Model{

        function __construct()
        {
            parent::__construct();
        }

        function userHasNoAccessToSession( $userId, $sessionId )
        {

            $sql = "SELECT id FROM participants WHERE userId = $userId AND session_id = $sessionId";
            $query = $this->db->query( $sql );

            if( isset( $query->row()->id ) && $query->row()->id )
                return 0;
            else return 1;

        }

        function userWasInvitedToSession( $userTagName, $sessionId )
        {
            $sql = "SELECT id
            FROM invites
            WHERE userTagName = '$userTagName'
            AND sessionId = $sessionId
            AND status = 0";

            $query = $this->db->query( $sql );

            if( isset( $query->row()->id ) && $query->row()->id ) return 1;
            else return 0;
        }

        function userNotInvitedNorParticipates( $userTagName, $sessionId )
        {
            $sql = "SELECT userTagName FROM invites WHERE sessionId = $sessionId AND status = 0 AND userTagName = '$userTagName'";
            $query = $this->db->query( $sql );

            if( isset( $query->row()->userTagName ) && $query->row()->userTagName ) return 0;
            else
            {
                $sql = "SELECT u.userTagName FROM users AS u JOIN participants AS p ON u.id = p.userId WHERE p.session_id = $sessionId AND u.userTagName = '$userTagName'";
                $query = $this->db->query( $sql );

                if( isset( $query->row()->userTagName ) && $query->row()->userTagName ) return 0;
                else return 1;
            }
        }

}
