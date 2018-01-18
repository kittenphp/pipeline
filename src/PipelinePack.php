<?php


namespace kitten\Component\pipeline;
use Symfony\Component\HttpFoundation\Request;

class PipelinePack
{
    /** @var  Pipeline */
    protected $pipeline;

    public function __construct()
    {
        $this->pipeline=new Pipeline();
    }

    public function add(MiddlewareInterface $middleware){
        $this->pipeline->add($middleware);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function handle(Request $request){
        return $this->pipeline->handle($request);
    }
}