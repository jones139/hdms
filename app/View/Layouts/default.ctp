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
/**
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
	HDMS - 
	<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		#echo $this->Html->css('cake.generic');
		echo $this->Html->css('hat.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
<?php echo $this->Html->image('ca_logo.png', array(
      'alt' => 'Catcote Academy Logo',
      'url' => 'http://catcoteacademy.co.uk')); ?>
	<h1>
<?php echo $this->Html->link('Hartlepool Aspire Trust: Document Management System', '/'); 
?>
        </h1>

	<br/>
      <?php
      ######################################################################
      # Show Users menu bar at the top
      ######################################################################
        if ($authUserData['id']) { # Logged in users
           if ($authUserData['role_id']==1) {  # Administrators only
	      echo "Admin Menu: ";
	      echo $this->Html->link('Add/Edit Users',
	      	   	             array('controller'=>'users',
				           'action'=>'index'));
	      echo "; ";
	      echo $this->Html->link('Add/Edit Documents',
	      	   	             array('controller'=>'docs',
				           'action'=>'index'));
	      echo " - ";
           }

	   echo "Logged in as ";
	   echo $this->Html->link($authUserData['title'],array('controller'=>'users',
							'action'=>'edit',$authUserData['id']));
	   echo " (".$authUserData['Role']['title'].') ';
	   $nNotifications = count($authUserExtraData);
	   echo $this->Html->link('('.$nNotifications.' notifications)',
             	array('controller'=>'notifications','action'=>'index',
	           'user_id'=>$authUserData['id']));
           echo ' ';
	   echo $this->Html->link('logout',
             	array('controller'=>'users','action'=>'logout',
	           )); 
	} else {  
	  # If not logged in, include link to login page.
	  echo $this->Html->link('login',
             	array('controller'=>'users','action'=>'login',
	           ));
	}     
	?>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Session->flash('auth'); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
				);
			?>
			<p>
				Copyright &copy; 2014 <a href="mailto:graham.jones@catcotegb.co.uk?Subject=HDMS">Graham Jones</a></p>
<p>HDMS is open source software.    Please submit any suggestions for improvement to the 
			 <a href="https://github.com/jones139/hdms"> HDMS GitHub repository</a>.
			</p>
		</div>
	</div>
<!--	<?php echo $this->element('sql_dump'); ?> -->
</body>
</html>
