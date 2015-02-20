<?php
namespace Application\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Sonata\Cache\Adapter\Cache\MemcachedCache;
use Sonata\Cache\CacheElement;

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
		return $this->memcache->get([$key])->getData();
	}
	
	public function set($key, $data, $ttl = CacheElement::HOUR)
	{
		return $this->memcache->set([$key],$data,$ttl)->getData();
	}
	
	public function delete($key)
	{
		return $this->memcache->flush([$key]);
	}
	
}