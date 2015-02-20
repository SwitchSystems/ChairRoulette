<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	$viewParams = [];
    	
    	if ($this->getRequest()->isPost())
    	{
    		$post = $this->getRequest()->getPost();
    		if (!isset($post->name)) {
    			$this->flashMessenger()->addErrorMessage($this->translate('Unable to create room'));
    		} else {
    			$viewParams['roomName'] = $post->name;
    		}
    	}
    	
    	return new ViewModel($viewParams);
    }
	
    
    public function gameAction()
    {
        return new ViewModel();
    }

    public function lobbyAction()
    {
    	return new ViewModel();
    }
    
    public function apiAction()
    {
    	return $this->redirect()->toRoute('zf-apigility/welcome');
    }
}
