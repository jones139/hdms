	<?php
		echo $this->Html->css('homepage');
		echo $this->fetch('css');
		echo $this->Html->script('jquery');


		echo $this->Form->create(null,array(
		     'action'=>'index',
		     'type'=>'get'
		));

		$facArr = array('HAT','CA','CF');
		echo $this->Form->input("Facility",
		     array(
		     'label'=>'Select Business Unit(s) (Facilities)',
		     'multiple'=>'true',
		     'options'=>$facilities, # provide by controller
		     'selected'=>$facArr,
		     'div'=>false,
		     'id'=>'facSel',
		     'class'=>'col')
		    );
		echo $this->Form->end();
        ?>

<table>
<tr>
	<td class='col'><h3>MSM</h3></td>
	<td  class="msm" id="Msm" colspan = 6>
	     <h2>Management System Manual</h2>
	     <h3>Vision: To be an outstanding provider of education services to all learners</h3>
	     <h3>Mission: Provide an environment where students are offered every opportunity to maximise their
potential, <br/> grow in confidence and above all, be happy "Working together, achieving success"</h3>
	   </td>
</tr>
<tr>
	<td class='col'><h3>Strategic Objectives</h3></td>
	<td class="gov col" id="Gov"> <h3>GOV - Governance</h3>Effective Governance and Oversight</td>
	<td class="edu col" id="Edu"> <h3>EDU - Education</h3>Education / Curriculum</td>
	<td class="hr col" id="HR"><h3>HR - Human Resources</h3>Engaged and Well Qualified Workforce</td>
	<td class="hs col" id="HS"><h3>HS - Health and Safety</h3>Zero Harm to staff, students, visitors and the environment</td>
	<td class="fac col" id="Fac"><h3>FAC - Facilities</h3>Provide high quality teaching and learning facilities</td>
	<td class="fin col" id="Fin"><h3>FIN - Finance</h3>Financial Stability</td>
</tr>
<tr>
	<td class='col'><h3>Policies</h3></td>
	<td class="gov col" id="GovPol">Policies on all aspects of Corporate Governance</td>
	<td class="edu col" id="EduPol">Policies on Education Standards and Curriculum</td>
	<td class="hr col" id="HRPol">Policies on Human Resources to achieve the "Engaged and Well Qualified Workforce" Objective.</td>
	<td class="hs col" id="HSPol">Health and Safety Policies</td>
	<td class="fac col" id="FacPol">Facilities Management Policies</td>
	<td class="fin col" id="FinPol">Financial Management Policies.</td>
</tr>

<tr>
	<td class='col'><h3>Procedures</h3></td>
	<td class="gov col" id="GovProc">
	Governance Procedures	</td>
	<td class="edu col" id="EduProc">
	Education/Curriculum Procedures	</td>
	<td class="hr col" id="HRProc">
	Human Resources Procedures	</td>
	<td class="hs col" id="HSProc">
	Health and Safety Procedures	</td>
	<td class="fac col" id="FacProc">
	Facilities Management Procedures	</td>
	<td class="fin col" id="FinProc">
	Finance Procedures	</td>
</tr>

<tr>
	<td class='col'><h3>Forms</h3></td>
	<td class="gov col" id="GovForm">
	Governance Forms	</td>
	<td class="edu col" id="EduForm">
	Education/Curriculum Forms	</td>
	<td class="hr col" id="HRForm">
	Human Resources Forms	</td>
	<td class="hs col" id="HSForm">
	Health and Safety Forms	</td>
	<td class="fac col" id="FacForm">
	Facilities Management Forms	</td>
	<td class="fin col" id="FinForm">
	Finance Forms	</td>
</tr>
</table>



<script>
$('document').ready(function() {
$('td').click(function(e) {
   url = <?php echo '"'.Router::Url(array('controller'=>'docs','action'=>'index',false)).'";'; ?>
   targetId = $(e.target).attr('id');
   //alert("targetId="+targetId+" e.target="+e.target);
   if (targetId.indexOf('Msm')>=0)
      docType = '1';
   else if (targetId.indexOf('Pol')>=0)
      docType = '2';
   else if (targetId.indexOf('Proc')>=0)
      docType = '3';
   else if (targetId.indexOf('Form')>=0)
      docType = '4';
   else if (targetId.indexOf('Rec')>=0)
      docType = '5';
   else
      docType = ''; //alert("Unknown Doc Type "+targetId);

   if (targetId.indexOf('Gov')>=0)
      docSubType = '1';
   else if (targetId.indexOf('Fin')>=0)
      docSubType = '2';
   else if (targetId.indexOf('HR')>=0)
      docSubType = '3';
   else if (targetId.indexOf('HS')>=0)
      docSubType = '4';
   else if (targetId.indexOf('Fac')>=0)
      docSubType = '5';
   else if (targetId.indexOf('Edu')>=0)
      docSubType = '6';
   else if (targetId.indexOf('Msm')>=0)
      docSubType = '';
   else
      alert("Unknown Doc SubType "+targetId);


   facSel = $('#facSel').val();
   if (facSel.length>0) {
      facQueryStr = "&Facility="
      for (i=0;i<facSel.length;i++) {
          switch (facSel[i]) {
	     case "HAT": facId=1; break;
	     case "CA": facId=2; break;
	     case "CF": facId=3; break;
	     default: alert("Unrecognised Facility"+facSel[i]);
          }
      	  facQueryStr = facQueryStr+"&Facility[]="+facId;
      }
   } else
	facQueryStr = "";

   queryStr = "?";
   if (docType!='') queryStr = queryStr + "DocType="+docType
   if (docSubType!='') queryStr = queryStr + "&DocSubType="+docSubType
   if (facQueryStr!='') queryStr = queryStr + facQueryStr;
   url = url+queryStr;
   //alert("URL="+url);
   window.location.href=url;
});
});
</script>