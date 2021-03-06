<?php
/**
 * classStepTest.php
 *  
 * ProcessMaker Open Source Edition
 * Copyright (C) 2004 - 2008 Colosa Inc.23
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * For more information, contact Colosa Inc, 2566 Le Jeune Rd., 
 * Coral Gables, FL, 33134, USA, or email info@colosa.com.
 * 
 */
  $unitFilename = $_SERVER['PWD'] . '/test/bootstrap/unit.php' ;
  require_once( $unitFilename );

  require_once( PATH_THIRDPARTY . '/lime/lime.php');
  require_once( PATH_THIRDPARTY.'lime/yaml.class.php');
  require_once (  PATH_CORE . "config/databases.php");  
  require_once ( "propel/Propel.php" );
  Propel::init(  PATH_CORE . "config/databases.php");

  G::LoadThirdParty('smarty/libs','Smarty.class');
  G::LoadSystem ( 'error');
  G::LoadSystem ( 'xmlform');
  G::LoadSystem ( 'xmlDocument');
  G::LoadSystem ( 'form');
  G::LoadSystem ( 'dbconnection');
  G::LoadSystem ( 'dbsession');
  G::LoadSystem ( 'dbrecordset');
  G::LoadSystem ( 'dbtable');
  //G::LoadClass ( 'user');
  G::LoadSystem ( 'testTools');
  require_once(PATH_CORE.'/classes/model/Step.php');

  require_once (  PATH_CORE . "config/databases.php");  

  $dbc = new DBConnection(); 
  $ses = new DBSession( $dbc);
 
  $obj = new Step ($dbc); 
  $t   = new lime_test( 9, new lime_output_color() );
 
  $t->diag('class Step' );
  $t->isa_ok( $obj  , 'Step',  'class Step created');

  //method load
  $t->can_ok( $obj,      'load',   'load() is callable' );
  //method save
  $t->can_ok( $obj,      'update',   'update() is callable' );
  //method delete
  $t->can_ok( $obj,      'delete',   'delete() is callable' );
  //method create
  $t->can_ok( $obj,      'create',   'create() is callable' );

  
  class StepTest extends UnitTest
  {
  	function CreateStep($data,$fields)
  	{
  	  try
  	  {
  	    $Step=new Step();
  	    $result=$Step->create($fields);
  	    $this->domain->addDomainValue('CREATED',$Step->getStepUid());
  	    return $result;
  	  }
  	  catch(Exception $e)
  	  {
  	  	$result=array('Exception!! '=> $e->getMessage());
  	  	if(isset($e->aValidationFailures))
  	  		$result['ValidationFailures'] = $e->aValidationFailures;
  	    return $result;
  	  }
  	}
  	function UpdateStep($data,$fields)
  	{
  	  try
  	  {
  	    $Step=new Step();
  	    $result=$Step->update($fields);
  	    return $result;
  	  }
  	  catch(Exception $e)
  	  {
  	    return array('Exception!! '=> $e->getMessage());
  	  }
  	}
  	function LoadStep($data,$fields)
  	{
  	  try
  	  {
  	    $Step=new Step();
  	    $result=$Step->load($fields['STEP_UID']);
  	    return $result;
  	  }
  	  catch(Exception $e)
  	  {
  	    return array('Exception!! '=> $e->getMessage());
  	  }
  	}
  	function RemoveStep($data,$fields)
  	{
  	  try
  	  {
  	    $Step=new Step();
  	    $result=$Step->remove($fields['STEP_UID']);
  	    return $result;
  	  }
  	  catch(Exception $e)
  	  {
  	    return array('Exception!! '=> $e->getMessage());
  	  }
  	}
  }
  $test=new StepTest('step.yml',$t);
  $test->domain->addDomain('CREATED');
  $test->load('CreateTestSteps');
  $test->runAll();
  $test->load('StepUnitTest');
  $test->runAll();
