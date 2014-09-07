<?php
class SettingsController extends AppController {

  /**
   * Index method is actually an edit page - only works with record
   * id=1 becuse there should only ever be one settings record in the
   * database.
   */
  public function index() {
        if ($this->Auth->user('role_id')!=1) {
	$this->Session->setFlash("Only An Administrator can Edit Settings");
      return $this->referer();
    }
      

    $id = 1;
    $setting = $this->Setting->findById($id);
    if (!$setting) {
      throw new NotFoundException('Invalid Settings ID');
    }

    if ($this->request->is(array('post','put'))) {
      $this->Setting->id = $id;
      if ($this->Setting->save($this->request->data)) {
	$this->Session->setFlash("Settings Saved ok");
	return($this->referer());
      } else {
	$this->Session->setFlash("ERROR SAVING SETTINGS");
	return($this->referer());
      }
			       
    }

    if (!$this->request->data) {
      $this->request->data = $setting;
    }

    #$this->Setting->id = $data['Setting']['id'];
    #$this->Setting->save($data);
    #$this->set('data',$data);

   
  }
  
}
