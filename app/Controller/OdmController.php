<?php
/***************************************************************************
 *   This file is part of HDMS.
 *
 *   Copyright 2014, Graham Jones (grahamjones@physics.org)
 *
 *   HDMS is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   Foobar is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with HDMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 ****************************************************************************/

App::uses('AppController', 'Controller');
/**
 * OdmController - Controller to handle importing data from OpenDocMan (ODM).
 *
 */

class OdmController extends AppController {
    var $name='Odm';
    var $uses = array('OdmDoc','Doc','Revision');

    /**
     * index method - list all of the documents in the ODM instance.
     */
    function index() {
        $odmDocs = $this->OdmDoc->find('all');
        $this->set('odmDocs',$odmDocs);
    }


    /**
     * import method - import all of the ODM documents into hdms.
     * Note that the OdmDoc model also defines the location of the odm files.
     */
    function import() {
	#$this->loadModel('doc');
        if ($this->Auth->user('role_id')!=1) {
            $this->Session->setFlash(__('Only an Administrator can import data!!!'));
            return $this->redirect($this->referer());          
        }

        $odmDocs = $this->OdmDoc->find('all');

        # Loop through each document in turn.
        foreach ($odmDocs as $odm) {
            #$odm = $odmDocs['0'];
            $odmD = $odm['OdmDoc'];

            $odmNativeFname = $this->OdmDoc->odmFolder.$odmD['id'].'.dat';
            $odmPDFFname = $this->OdmDoc->odmFolder.$odmD['id'].'.pdf';
            
            #####################################
            # Create the document
            $docData = array(
                'facility_id' => 1,  # HAT by default
                'doc_type_id' => $this->OdmDoc->cat2docType[$odmD['category']],
                'doc_subtype_id' => $this->OdmDoc->docNo2subType($odmD['odm_udftbl_DocNo']),
                'docNo' => $odmD['odm_udftbl_DocNo'],
                'title' => $odmD['description']
            );
            # Create Document record
            $this->Doc->create();
            if (!$this->Doc->save($docData)) {
                $this->Session->setFlash(
                    __('The document record could not be saved...'));
                return $this->redirect(array('action'=>'index'));
            }
            $docId = $this->Doc->getInsertID();

            # Look at the issue number to decide if the document is issued
            # or not.
            $issueParts = explode("Issue ",$odmD['odm_udftbl_Issue']);
            if (isset($issueParts[1])) {
                $major_revision = $issueParts[1];
                $status = '2';  # Issued
            } else {
                $major_revision = '1';
                $status = '0'; # Draft
            }

            ##########################################
            # Create the Revision
            $revData = array(
                'doc_id' => $docId,
                'major_revision' => $major_revision,
                'minor_revision' => '1',
                'user_id' => null,
                'is_checked_out' => false,
                'filename' => $odmD['realname'],
                'doc_status_id' => $status,  
                'doc_status_date' => $odmD['created'],
                'has_native' => file_exists($odmNativeFname),
                'has_pdf' => file_exists($odmPDFFname),
            );
            # Create Revision record
            $this->Revision->create();
            if (!$this->Revision->save($revData)) {
                $this->Session->setFlash(
                    __('The revision record could not be saved...'));
                return $this->redirect(array('action'=>'index'));
            }
            $revId = $this->Revision->getInsertID();

            #########################################
            # Copy the files into the HDMS directory.
            # - Native File
            if ($revData['has_native']) {
                $this->Revision->save_file(
                    $odmNativeFname,
                    $revId,
                    'native');
            }

            # - PDF File
            if ($revData['has_pdf']) {
                $this->Revision->save_file(
                    $odmPDFFname,
                    $revId,
                    'pdf');
            }
            

            #echo var_dump($docData)."<br/>";
            #echo var_dump($revData)."<br/>";
        }
        $this->set('odmDocs',$odmDocs);
    }

}
?>