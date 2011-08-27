<?php

namespace PHPSP\Bundles\WebBundle\Services\Cache;

use Doctrine\Common\Cache\Cache;

class Service implements Cache
{
    /**
     * @var Doctrine\Common\Cache\Cache 
     */
    protected $cacheDriver;
    
    /**
     * Constructor
     * 
     * @param array $config 
     */
    public function __construct($config)
    {
        // Get Adpter instance
        $adapterClass = $config['adapterClass'];
        $adapter = new $adapterClass();

        // Define namespace for cache
        if (isset($config['prefix']) && ! empty($config['prefix'])) {
            $adapter->setNamespace($config['prefix']);
        }

        // Initialize
        if (method_exists($adapter, 'initialize')) {
            
            $adapter->initialize($config);
            
        } else if ($adapter instanceof \Doctrine\Common\Cache\MemcacheCache) {
            
            $this->initMemcache($config, $adapter);
            
        }

        $this->cacheDriver = $adapter;
    }
    
    /**
     * Initializes Memcache cache
     * 
     * @param array $config
     * @param Doctrine\Common\Cache\Cache $adapter 
     */
    private function initMemcache($config, $adapter)
    {
        // Prevent stupid PHP error of missing extension (if other driver is being used)
        $memcacheClassName = 'Memcache';
        $memcache = new $memcacheClassName();

        // Default server configuration
        $defaultServer = array(
            'host'          => 'localhost',
            'port'          => 11211,
            'persistent'    => true,
            'weight'        => 1,
            'timeout'       => 1,
            'retryInterval' => 15,
            'status'        => true
        );

        //Override
        if (isset($config['options']['servers'])) {
            
            foreach ($config['options']['servers'] as $server) {
                $server = array_replace_recursive($defaultServer, $server);

                $memcache->addServer(
                    $server['host'],
                    $server['port'],
                    $server['persistent'],
                    $server['weight'],
                    $server['timeout'],
                    $server['retryInterval'],
                    $server['status']
                );
            }
            
        }

        $adapter->setMemcache($memcache);
    }
    
    /**
     * Checks if key exists in cache
     * 
     * @param string $id
     * @return boolean 
     */
    public function contains($id)
    {
        return $this->cacheDriver->contains($id);
    }

    /**
     * Removes from cache
     * 
     * @param string $id
     * @return mixed 
     */
    public function delete($id)
    {
        return $this->cacheDriver->delete($id);
    }

    /**
     * Retrieves from cache
     * 
     * @param string $id
     * @return mixed 
     */
    public function fetch($id)
    {
        return $this->cacheDriver->fetch($id);
    }

    /**
     * Saves to cache
     * 
     * @param string $id
     * @param mixed $data
     * @param int $lifeTime
     * @return boolean 
     */
    public function save($id, $data, $lifeTime = 0)
    {
        return $this->cacheDriver->save($id, $data, $lifeTime);
    }

}