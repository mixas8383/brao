<?php
/**
 * @package    LongCMS.Site
 * @copyright    Copyright (C) 2009 - 2012 LongCMS Team (http://unix.ge/longcms). All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

// Set flag that this is a parent file.
define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);
ini_set('max_execution_time', 0);
ini_set('memory_limit', -1);


require_once dirname(__FILE__) . '/defines.php';


if (!defined('_JDEFINES')) {
    define('JPATH_BASE', dirname(__FILE__));
    require_once JPATH_BASE.'/includes/defines.php';
}


require_once JPATH_BASE.'/includes/framework.php';

// Mark afterLoad in the profiler.
JDEBUG ? $_PROFILER->mark('afterLoad') : null;

// Instantiate the application.
$app = JFactory::getApplication('site');

// Initialise the application.
$app->initialise();
$user = JFactory::getUser();
$session = JFactory::getSession();
$db= JFactory::getDbo();
jimport('project.deals.deals');
jimport('project.deal');
$deals = PDeals::getActiveAution();

 if(isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT'] == 'Debug')
 {
     echo '<pre>'.__FILE__.' -->>| <b> Line </b>'.__LINE__.'</pre><pre>';
     print_r($deals);
     die;
     
 }

if(!empty($deals))
{
    foreach ($deals as $one)
    {
        
        
        
        $one->doAutoDeal();
        
         if(isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT'] == 'Debug')
         {
             echo '<pre>'.__FILE__.' -->>| <b> Line </b>'.__LINE__.'</pre><pre>';
             print_r($one);
             die;
             
         }
         
         
         
         
         
         
    }
}

 
 