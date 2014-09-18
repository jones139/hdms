<?php
class OdmDoc extends AppModel {
    var $name='OdmDoc';
    var $useDbConfig='odm';
    var $useTable = 'odm_data';
    var $primaryKey = 'id';

    ////////////////////////////////////////////////////
    // SET THIS TO MATCH YOUR SYSTEM INSTALLATION!!!!
    ////////////////////////////////////////////////////
    var $odmFolder = '/home/graham/odm/';



    /**
     * cat2doctype - array to convert from odm category to hdms doc_type ids.
     */
    var $cat2docType = array(
        '1' => null,
        '2' => null,
        '3' => null, 
        '4' => null,
        '5' => 1,   # MSM
        '6' => 2,   # POL
        '7' => 3,   # PROC
        '8' => 4,   # FORM
        '9' => 5    # REC
    );

    /**
     * docNo2subType - return the subtype of a document derived from its doc
     * number.
     */
    public function docNo2subType($docNo) {
        if (strpos($docNo,'GOV') !== false) {
            return 1;
        } elseif (strpos($docNo,'MSM') !== false) {
            return 1;  # Treat all MSM docs as Governance ones.
        } elseif (strpos($docNo,'FIN') !== false) {
            return 2;
        } elseif (strpos($docNo,'HR') !== false) {
            return 3;
        } elseif (strpos($docNo,'HS') !== false) {
            return 4;
        } elseif (strpos($docNo,'FAC') !== false) {
            return 5;
        } elseif (strpos($docNo,'EDU') !== false) {
            return 6;
        } else {
            return null;
        }     
    }




}

?>