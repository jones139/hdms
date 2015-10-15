<?php
/***************************************************************************
 *   This file is part of HDMS.
 *
 *   Copyright 2015, Graham Jones (grahamjones@physics.org)
 *   BackupRestoreController is based on https://github.com/Maldicore/Backups.
 *
 *   HDMS is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   HDMS is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with HDMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 ****************************************************************************/

App::uses('AppController', 'Controller');
App::uses('CakeSchema', 'Model');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * BackupRestoreController - Controller to handle backing up and restoring
 * the HDMS database and data.
 *
 */

class BackupRestoreController extends AppController {
	var $name = 'BackupRestore';
	var $uses = array('Doc', 'Revision');
	
	/**
	 * default action - just redirects to listBackups
	 */	
	function index() {
        return $this->redirect(array('action' => 'listBackups'));
	}

	/**
	 * list method - present backup and restore options - including
	 * list of backup archives on the server, plus option to upload
	 * another archive.
	 */
	function listBackups() {
		if ($this -> Auth -> user('role_id') != 1) {
				$this -> Session -> setFlash(__('Only an Administrator can manage backups!!!'));
				return $this -> redirect($this -> referer());
		}

		# Check backup directory exists.
		if (!is_dir(BACKUP_DIR)) {
			trigger_error('The path "' . BACKUP_DIR . '" does not exist - please create it.', E_USER_ERROR);
		} else {
			$msgs[] = "Backup directory ".BACKUP_DIR." exists - OK!";
		}

		# Check we can write to backup directory.
		if (!is_writable(BACKUP_DIR)) {
			trigger_error('The path "' . BACKUP_DIR . '" isn\'t writable!', E_USER_ERROR);
		} else {
			$msgs[] = "Backup directory ".BACKUP_DIR." writeable - OK!";
		}
		
		$files = array();
		$msgs[] = 'Listing backup files in backup directory '.BACKUP_DIR;
		$fileList = scandir(BACKUP_DIR);
		foreach ($fileList as $file) {
			if ($file!='.' && $file!='..') {
    			$fileParts = explode(".",$file);
    			if(isset($fileParts[count($fileParts)-1]) && $fileParts[count($fileParts)-1]=='zip'){
					$files[] = [$file,filesize(BACKUP_DIR.DS.$file)];
				}
			}
		}

		if (count($files)==0)	{
			$msgs[]="No backup files found";
		}	
		
		$this -> set('msgs', $msgs);
		$this -> set('files', $files);
	}
	
	/**
	 * Download a backup file with filename $fname to the users computer.
	 */
	function download($fname) {
		if ($this -> Auth -> user('role_id') != 1) {
			$this -> Session -> setFlash(__('Only an Administrator can manage backups!!!'));
			return $this -> redirect($this -> referer());
		}

    	$this->response->file(BACKUP_DIR.DS.$fname);
    return $this->response;
	}

	function deleteBackupFile() {
		if ($this -> Auth -> user('role_id') != 1) {
			$this -> Session -> setFlash(__('Only an Administrator can manage backups!!!'));
			return $this -> redirect($this -> referer());
		}
	
		if ($this->request->is(array('post','put'))) {
			$fname = $this->request->data['fname'];
		 	if (is_file(BACKUP_DIR.DS.$fname)) {
		 		unlink(BACKUP_DIR.DS.$fname);
				$this -> Session -> setFlash(__('File Deleted'));
		 	} else {
				$this -> Session -> setFlash(__('File '.$fname.' does not exist in backup directory'));
		 	}
		 } else {
				$this -> Session -> setFlash(__('Do Not call deleteBackupFile directly - use form on listBackups.'));
		 }
	    return $this->redirect(array('action' => 'listBackups'));
	}



   /**
    * Handle uploading of backupfiles to the server, using the form in the list.ctp view.
    */
	function uploadBackupFile() {
		if ($this -> Auth -> user('role_id') != 1) {
				$this -> Session -> setFlash(__('Only an Administrator can manage backups!!!'));
				return $this -> redirect($this -> referer());
		}
		  # If we have submitted a form, process the data, otherwise we
        # display the form.
        if ($this->request->is(array('post','put'))) {
        	echo var_dump ($this->request->data);
        	echo var_dump ($this->request->form);
        	  $result = move_uploaded_file($this->request->form['uploadedFile']['tmp_name'],
        	  			BACKUP_DIR.DS.$this->request->form['uploadedFile']['name']);

            if ($result) 
                {
                    $this->Session->setFlash(
                        __('File Uploaded.'));
                } else {
                $this->Session->setFlash(
                    __('File Upload Failed.'.var_dump($this->request->data)));
            }
        } else {
         	$this->Session->setFlash(
                        __('Do not call uploadBackupFile directly - use BackupRestore instead'));
        }
        return $this->redirect(array('action' => 'listBackups'));
	}		


	function RestoreBackup() {
			if ($this -> Auth -> user('role_id') != 1) {
				$this -> Session -> setFlash(__('Only an Administrator can restore backups!!!'));
				return $this -> redirect($this -> referer());
			}
        if ($this->request->is(array('post','put'))) {
				$fname = $this->request->data['fname'];
				if (is_file(BACKUP_DIR.DS.$fname)) {
					$this->Restore($fname);
				} else {
         		$this->Session->setFlash(
                        __('Restore Failed - Filename '.$fname.' is not a valid file'));
        			return $this->redirect(array('action' => 'listBackups'));
				}
        } else {
         	$this->Session->setFlash(
                        __('Do not call RestoreBackup directly - use BackupRestore instead'));
        }
        /* array msgs[] for the view is set in Restore() */
	}


	/**
	 *	Restore from a backup archive file named $archive_fname.
	 */
	private	function Restore($archive_fname) {
			if ($this -> Auth -> user('role_id') != 1) {
				$this -> Session -> setFlash(__('Only an Administrator can import data!!!'));
				return $this -> redirect($this -> referer());
			}
						
			# Check the folder we use to restore the backup exists.
			if (!is_dir(TMP_RESTORE_DIR)) {
				trigger_error('The directory "' . TMP_RESTORE_DIR . '" does not exist - please create it!', E_USER_ERROR);
			} else {
				$msgs[] = "Temporary output directory ".TMP_RESTORE_DIR." exists - ok!";
			}
			# ...and is writeable.
			if (!is_writable(TMP_RESTORE_DIR)) {
				trigger_error('The path "' . TMP_RESTORE_DIR . '" isn\'t writable!', E_USER_ERROR);
			} else {
				$msgs[] = "Temporary output directory ".TMP_RESTORE_DIR." writeable - OK!";
			}

			# Check our temporary backup directory exists, and is writeable.
			if (!is_dir(TMP_BACKUP_DIR)) {
					trigger_error('The directory "' . TMP_BACKUP_DIR . '" does not exist - please create it!', E_USER_ERROR);
				} else {
					$msgs[] = "Temporary backup directory ".TMP_BACKUP_DIR." exists - ok!";
			}
			if (!is_writable(TMP_BACKUP_DIR)) {
					trigger_error('The path "' . TMP_BACKUP_DIR . '" isn\'t writable!', E_USER_ERROR);
				} else {
					$msgs[] = "Temporary backup directory ".TMP_BACKUP_DIR." writeable - OK!";
			}

			# Check if main data directory exists, and is writeable.
			if (!is_dir(DATA_DIR)) {
				trigger_error('The directory "' . DATA_DIR . '" does not exist - please create it!', E_USER_ERROR);
			} else {
				$msgs[] = "Main data directory ".DATA_DIR." exists - ok!";
			}
			if (!is_writable(DATA_DIR)) {
				trigger_error('The directory "' . DATA_DIR . '" isn\'t writable!', E_USER_ERROR);
			} else {
				$msgs[] = "Main data directory ".DATA_DIR." writeable - OK!";
			}


	      App::import('Model', 'AppModel');          
         $model = new AppModel(false, false);

			$zipfile = BACKUP_DIR . DS . $archive_fname;
			$msgs[]='Restoring file: '.$archive_fname;
    		$fileParts = explode(".",$archive_fname);
    		if(isset($fileParts[count($fileParts)-1]) && $fileParts[count($fileParts)-1]=='zip'){
    			$msgs[]='Unzipping File';
    			if (class_exists('ZipArchive')) {
    				$zip = new ZipArchive;
    				if($zip->open($zipfile) === TRUE){
    					$zip->extractTo(TMP_RESTORE_DIR);
    					#$unzipped_file = TMP_RESTORE_DIR.DS.$zip->getNameIndex(0);
    					$zip->close();
    					$msgs[] = 'Successfully Unzipped';
    				} else {
    					$msgs[] = 'Unzip Failed';
    					#$this->_stop();
    				}
    			} else {
    				$msgs[] = 'ZipArchive not found, cannot Unzip File!';
    				#$this->_stop();
    			}
    		} else {
    			$msgs[] = "***ERROR - filename does not end in .zip***";
    		}
    		if (($sql_content = file_get_contents($filename = TMP_RESTORE_DIR.DS.DB_DUMP_FNAME)) !== false){
    			$msgs[] = 'Restoring Database';
    			$sql = explode("\n\n", $sql_content);
    			foreach ($sql as $key => $s) {
    				if(trim($s)){
    					$result = $model->query($s);
    				}
    			}
    			#unlink($unzipped_file);
    		} else {
				trigger_error('Could not open database Dump file "' . TMP_RESTORE_DIR.DS.DB_DUMP_FNAME. '"', E_USER_ERROR);
    			$msgs[] = "Couldn't load contents of file {DB_DUMP_FNAME}, aborting...";
    			#unlink($unzipped_file);
         	#$this->_stop();
    		}
		

		/* Copy the Files */
		/* Erase the contents of the temporary backup directory */	
		$files = scandir(TMP_BACKUP_DIR);
		$msgs[] = 'Deleting files from temporary backup directory '.TMP_BACKUP_DIR;
		foreach ($files as $file) {
			if ($file!='.' && $file!='..') {
				$msgs[] = '   - Deleting '.TMP_BACKUP_DIR.DS.$file;
				rrmdir(TMP_BACKUP_DIR.DS.$file);
			}
		}
			
		/* move the contents of the on-line data directory to the temporary backup directory */
		$files = scandir(DATA_DIR);
		$msgs[] = 'Copying on-line files to temporary backup directory '.TMP_BACKUP_DIR;
		foreach ($files as $file) {
			if ($file!='.' && $file!='..') {
				$msgs[] = '  - Backing up - '.$file.'...';
				rename(DATA_DIR.DS.$file,TMP_BACKUP_DIR.DS.$file);
			}
		}
		
		/* now copy the restored files on-line */
		$files = scandir(TMP_RESTORE_DIR);
		$msgs[] = 'Copying files from backup on-line, to '.DATA_DIR;
		foreach ($files as $file) {
			if ($file!='.' && $file!='..') {
				$msgs[] = '  - Restored - '.$file.' - copying it on-line';
				rename(TMP_RESTORE_DIR.DS.$file,DATA_DIR.DS.$file);
			}
		}
		


		/* Check Integrity between files and database */
		# FIXME - integrity not checked yet!!!

		$this -> set('msgs', $msgs);

	}

	/**
	 *	Backup the database and files to an archive file.
	 */
	function Backup() {
		if ($this -> Auth -> user('role_id') != 1) {
			$this -> Session -> setFlash(__('Only an Administrator can import data!!!'));
			return $this -> redirect($this -> referer());
		}

		/* Set backup directory and check it is writeable */
		$dataSourceName = 'default';

		#$Folder = new Folder($path, true);

		# Check if main data directory exists, and is writeable.
		if (!is_dir(DATA_DIR)) {
			trigger_error('The directory "' . DATA_DIR . '" does not exist - please create it!', E_USER_ERROR);
		} else {
			$msgs[] = "Main data directory ".DATA_DIR." exists - ok!";
		}
		if (!is_writable(DATA_DIR)) {
			trigger_error('The directory "' . DATA_DIR . '" isn\'t writable!', E_USER_ERROR);
		} else {
			$msgs[] = "Main data directory ".DATA_DIR." writeable - OK!";
		}

		# Check our backup directory exists, and is writeable.
		if (!is_dir(BACKUP_DIR)) {
				trigger_error('The directory "' . BACKUP_DIR . '" does not exist - please create it!', E_USER_ERROR);
			} else {
				$msgs[] = "Backup directory ".BACKUP_DIR." exists - ok!";
		}
		if (!is_writable(BACKUP_DIR)) {
				trigger_error('The path "' . BACKUP_DIR . '" isn\'t writable!', E_USER_ERROR);
			} else {
				$msgs[] = "Backup directory ".BACKUP_DIR." writeable - OK!";
		}


		$msgs[] = "Backing up...\n";

		/* Dump the Database to a file */
		$dbDumpFile = DATA_DIR . DS . DB_DUMP_FNAME;
		$archiveFile = BACKUP_DIR. DS . date('Ymd\_His') . '.zip';
		$File = new File($dbDumpFile);
		$db = ConnectionManager::getDataSource($dataSourceName);
		$config = $db -> config;
		$this -> connection = "default";

		foreach ($db->listSources() as $table) {

			$table = str_replace($config['prefix'], '', $table);
			// $table = str_replace($config['prefix'], '', 'dinings');
			$ModelName = Inflector::classify($table);
			$Model = ClassRegistry::init($ModelName);
			$DataSource = $Model -> getDataSource();
			$this -> Schema = new CakeSchema( array('connection' => $this -> connection));

			$cakeSchema = $db -> describe($table);
			// $CakeSchema = new CakeSchema();
			$this -> Schema -> tables = array($table => $cakeSchema);

			$File -> write("\n/* Drop statement for {$table} */\n");
			$File -> write("SET foreign_key_checks = 0;");
			// $File->write($DataSource->dropSchema($this->Schema, $table) . "\n");
			$File -> write($DataSource -> dropSchema($this -> Schema, $table));
			$File -> write("SET foreign_key_checks = 1;\n");
			$File -> write("\n/* Backuping table schema {$table} */\n");
			$File -> write($DataSource -> createSchema($this -> Schema, $table) . "\n");
			$File -> write("\n/* Backuping table data {$table} */\n");

			unset($valueInsert, $fieldInsert);
			$rows = $Model -> find('all', array('recursive' => -1));
			$quantity = 0;

			if (sizeOf($rows) > 0) {
				$fields = array_keys($rows[0][$ModelName]);
				$values = array_values($rows);
				$count = count($fields);
				for ($i = 0; $i < $count; $i++) {
					$fieldInsert[] = $DataSource -> name($fields[$i]);
				}
				$fieldsInsertComma = implode(', ', $fieldInsert);
				foreach ($rows as $k => $row) {
					unset($valueInsert);
					for ($i = 0; $i < $count; $i++) {
						$valueInsert[] = $DataSource -> value(utf8_encode($row[$ModelName][$fields[$i]]), $Model -> getColumnType($fields[$i]), false);
					}
					$query = array('table' => $DataSource -> fullTableName($table), 'fields' => $fieldsInsertComma, 'values' => implode(', ', $valueInsert));
					$File -> write($DataSource -> renderStatement('create', $query) . ";\n");
					$quantity++;
				}
			}

			$msgs[] = 'Model "' . $ModelName . '" (' . $quantity . ')';
		}
		$File -> close();
		$msgs[] = "\nFile \"" . $dbDumpFile . "\" saved (" . filesize($dbDumpFile) . " bytes)\n";
		$msgs[] = "Database Backup Successful.\n";


		/* Create backup archive */
			Zip(DATA_DIR,$archiveFile,false);

			$msgs[] = "Zip \"" . $archiveFile . "\" Saved (" . filesize($archiveFile) . " bytes)\n";
			$msgs[] = "Zipping Done!";

			# Delete the database dump file now it is included in the zip archvie.
			if (file_exists($archiveFile)) {
				$msgs[] = 'Confirmed '.$archiveFile.' created ok';
			} else {
				$msgs[] = "****ERROR - ZipArchive facility not present on system - Backup NOT CREATED******";
			}


		/* Present Download option for archive */

		$this -> set('msgs', $msgs);
	}

}

	/**
	 * From http://stackoverflow.com/questions/1334613/how-to-recursively-zip-a-directory-in-php
	 */
	function Zip($source, $destination, $include_dir = false) {

		if (!extension_loaded('zip') || !file_exists($source)) {
			return false;
		}

		if (file_exists($destination)) {
			unlink($destination);
		}

		$zip = new ZipArchive();
		if (!$zip -> open($destination, ZIPARCHIVE::CREATE)) {
			return false;
		}
		$source = str_replace('\\', '/', realpath($source));

		if (is_dir($source) === true) {

			$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

			if ($include_dir) {

				$arr = explode("/", $source);
				$maindir = $arr[count($arr) - 1];

				$source = "";
				for ($i = 0; $i < count($arr) - 1; $i++) {
					$source .= '/' . $arr[$i];
				}

				$source = substr($source, 1);

				$zip -> addEmptyDir($maindir);

			}

			foreach ($files as $file) {
				$file = str_replace('\\', '/', $file);

				// Ignore "." and ".." folders
				if (in_array(substr($file, strrpos($file, '/') + 1), array('.', '..')))
					continue;

				$file = realpath($file);

				if (is_dir($file) === true) {
					$zip -> addEmptyDir(str_replace($source . '/', '', $file . '/'));
				} else if (is_file($file) === true) {
					$zip -> addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
				}
			}
		} else if (is_file($source) === true) {
			$zip -> addFromString(basename($source), file_get_contents($source));
		}

		return $zip -> close();
	}

	/**
	 * Remove the entire contents of a directory.
	 * from http://stackoverflow.com/questions/11613840/remove-all-files-folders-and-their-subfolders-with-php
	 */
	 function rrmdir($dir) {
	  if (is_dir($dir)) {
	    $objects = scandir($dir);
	    foreach ($objects as $object) {
	      if ($object != "." && $object != "..") {
	        if (filetype($dir."/".$object) == "dir") 
	           rrmdir($dir."/".$object); 
	        else unlink   ($dir."/".$object);
	      }
	    }
	    reset($objects);
	    rmdir($dir);
	  }
	 }

?>