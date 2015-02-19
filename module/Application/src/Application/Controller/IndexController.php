<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	$mc = $this->getServiceLocator()->get('MemcacheService');
    	$mc->set('test','sdjoksfdjkfsd');
    	var_dump($mc->get('test'));
    	$mc->delete('test');
    	var_dump($mc->get('test'));
    	
     //   return $this->redirect()->toRoute('zf-apigility/welcome');
    }
}
