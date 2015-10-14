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
	
	var $dataDir = ROOT.DS.'data';     // Folder where all the actual document files are stored.
	var $backupDir = APP . DS . 'Backups';   // Folder for the backup zip archives to be stored.
	var $tmpRestoreDir = APP . DS . 'tmp'. DS . 'data_restore';   // temporary folder for restoring backups.
	var $tmpBackupDir = APP . DS . 'tmp'. DS . 'data_old';   // temporary folder for storing data directory
	                                                             // before doing restore (just in case!) 

	/**
	 * index method - present backup and restore options - including
	 * list of backup archives on the server, plus option to upload
	 * another archive.
	 */
	function index() {
		$msgs[] = 'Listing backup files in backup directory '.$this->backupDir;
		$fileList = scandir($this->backupDir);
		foreach ($fileList as $file) {
			if ($file!='.' && $file!='..') {
    			$fileParts = explode(".",$file);
    			if(isset($fileParts[count($fileParts)-1]) && $fileParts[count($fileParts)-1]=='zip'){
					$files[] = $file;
				}
			}
		}
		$this -> set('msgs', $msgs);
		$this -> set('files', $files);
	}
	
	function download($fname) {
    	$this->response->file($this->backupDir.DS.$fname);
    return $this->response;
	}

	/**
	 *	Restore from a backup archive file named $archive_fname.
	 */
	function Restore($archive_fname) {
			if ($this -> Auth -> user('role_id') != 1) {
				$this -> Session -> setFlash(__('Only an Administrator can import data!!!'));
				return $this -> redirect($this -> referer());
			}
			
        App::import('Model', 'AppModel');          
        $model = new AppModel(false, false);

			$zipfile = $this->backupDir . DS . $archive_fname;
			
			if (!is_writable($this->tmpRestoreDir)) {
				trigger_error('The path "' . $this->tmpRestoreDir . '" isn\'t writable!', E_USER_ERROR);
			} else {
				$msgs[] = "Temporary output directory ".$this->tmpRestoreDir." writeable - OK!";
			}


			$msgs[]='Restoring file: '.$archive_fname;
    		$fileParts = explode(".",$archive_fname);
    		if(isset($fileParts[count($fileParts)-1]) && $fileParts[count($fileParts)-1]=='zip'){
    			$msgs[]='Unzipping File';
    			if (class_exists('ZipArchive')) {
    				$zip = new ZipArchive;
    				if($zip->open($zipfile) === TRUE){
    					$zip->extractTo($this->tmpRestoreDir);
    					$unzipped_file = $this->tmpRestoreDir.DS.$zip->getNameIndex(0);
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
    		if (($sql_content = file_get_contents($filename = $unzipped_file)) !== false){
    			$msgs[] = 'Restoring Database';
    			$sql = explode("\n\n", $sql_content);
    			foreach ($sql as $key => $s) {
    				if(trim($s)){
    					$result = $model->query($s);
    				}
    			}
    			#unlink($unzipped_file);
    		} else {
    			$msgs[] = "Couldn't load contents of file {$unzipped_file}, aborting...";
    			#unlink($unzipped_file);
         	#$this->_stop();
    		}
		

		/* Copy the Files */
		/* Erase the contents of the temporary backup directory */	
		if (!is_writable($this->tmpBackupDir)) {
				trigger_error('The path "' . $this->tmpBackupDir . '" isn\'t writable!', E_USER_ERROR);
			} else {
				$msgs[] = "Temporary backup directory ".$this->tmpBackupDir." writeable - OK!";
		}
		$files = scandir($this->tmpBackupDir);
		$msgs[] = 'Deleting files from temporary backup directory '.$this->tmpBackupDir;
		foreach ($files as $file) {
			if ($file!='.' && $file!='..') {
				$msgs[] = '   - Deleting '.$this->tmpBackupDir.DS.$file;
				rrmdir($this->tmpBackupDir.DS.$file);
			}
		}
			
		/* move the contents of the on-line data directory to the temporary backup directory */
		$files = scandir($this->dataDir);
		$msgs[] = 'Copying on-line files to temporary backup directory '.$this->tmpBackupDir;
		foreach ($files as $file) {
			if ($file!='.' && $file!='..') {
				$msgs[] = '  - Backing up - '.$file.'...';
				rename($this->dataDir.DS.$file,$this->tmpBackupDir.DS.$file);
			}
		}
		
		/* now copy the restored files on-line */
		$files = scandir($this->tmpRestoreDir);
		$msgs[] = 'Copying files from backup on-line, to '.$this->dataDir;
		foreach ($files as $file) {
			if ($file!='.' && $file!='..') {
				$msgs[] = '  - Restored - '.$file.' - copying it on-line';
				rename($this->tmpRestoreDir.DS.$file,$this->dataDir.DS.$file);
			}
		}
		


		/* Check Integrity between files and database */

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

		$path = APP . DS . 'Backups' . DS;
		$Folder = new Folder($path, true);

		if (!is_writable($path)) {
			trigger_error('The path "' . $path . '" isn\'t writable!', E_USER_ERROR);
		}

		$msgs[] = "Backing up...\n";

		/* Dump the Database to a file */
		$dbDumpFile = ROOT . DS . 'data' . DS . 'dbDump' . '.sql';
		$archiveFile = $path . date('Ymd\_His') . '.zip';
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
			Zip(ROOT.DS.'data',$archiveFile,false);

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