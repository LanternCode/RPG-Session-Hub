<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class securityModel extends CI_Model{

        function __construct(){
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

        function userWasInvitedToSession( $userEmail, $sessionId )
        {
            $sql = "SELECT id
            FROM invites
            WHERE email = '$userEmail'
            AND sessionId = $sessionId
            AND status = 0";

            $query = $this->db->query( $sql );

            if( isset( $query->row()->id ) && $query->row()->id ) return 1;
            else return 0;
        }

        function userNotInvitedNorParticipates( $email, $sessionId )
        {
            $sql = "SELECT email FROM invites WHERE sessionId = $sessionId AND status = 0 AND email = '$email'";
            $query = $this->db->query( $sql );

            if( isset( $query->row()->email ) && $query->row()->email ) return 0;
            else
            {
                $sql = "SELECT u.email FROM users AS u JOIN participants AS p ON u.id = p.userId WHERE p.session_id = $sessionId AND u.email = '$email'";
                $query = $this->db->query( $sql );

                if( isset( $query->row()->email ) && $query->row()->email ) return 0;
                else return 1;
            }
        }

}
