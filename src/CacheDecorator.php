<?php namespace Clean\Repository;

class CacheDecorator extends AbstractRepository
{
    /**
     * @var CacheAdapterInterface
     */
    protected $adapter;

    /**
     * @var AbstractRepository
     */
    protected $repository;

    /**
     * @param $adapter adapter
     * @param AbstractRepository $repository
     * @return void
     */
    public function __construct(CacheAdapterInterface $cache, AbstractRepository $repository)
    {
        $this->adapter = $cache;
        $this->repository = $repository;
    }

    /**
     * Sets ttl value for cache
     *
     * @param $ttl int Cache time in seconds
     * @return self
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;
        return $this;
    }

    /**
     * Returns cached data
     *
     * @return mixed
     */
    public function assemble()
    {
        return $this->adapter->cache(
            $this->getHash(),
            function () {
                return $this->repository->assemble();
            },
            $this->ttl
        );
    }

    public function getHash()
    {
        return $this->repository->getHash();
    }
}
