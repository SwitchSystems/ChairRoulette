<?php
namespace Application\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Sonata\Cache\Adapter\Cache\MemcachedCache;

class MemcacheService implements ServiceLocatorAwareInterface
{
	use \Zend\ServiceManager\ServiceLocatorAwareTrait;
	
	protected $memcache;
	
	public function setAdapter(MemcachedCache $memcache)
	{
		$this->memcache = $memcache;
	}
	
	public function get($key)
	{
		return $this->memcache->get([$key]);
	}
	
	public function set($key, $data)
	{
		return $this->memcache->set([$key],$data);
	}
	
	public function delete($key)
	{
		return $this->memcache->flush([$key]);
	}
	
}