<?php


namespace kitten\Component\pipeline;

use Closure;
use Symfony\Component\HttpFoundation\Request;

class Pipeline
{
    /** @var MiddlewareInterface[] */
    private $middlewareArray=[];

    public function add(MiddlewareInterface $middleware)
    {
        $this->middlewareArray[]=$middleware;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function handle(Request $request){
        return $this->build($request,function (Request $object){});
    }

    /**
     * @param  Request  $request
     * @param  Closure $endClosure
     * @return mixed
     */
    protected function build(Request $request, Closure $endClosure)
    {
        $endFunction = $this->createCoreFunction($endClosure);
        $middlewareArray = array_reverse($this->middlewareArray);
        $completeOnion = array_reduce($middlewareArray, function($result, MiddlewareInterface $middleware){
            return $this->createLayer($result, $middleware);
        }, $endFunction);
        return $completeOnion($request);
    }

    /**
     * Return $next closure function
     * @param Closure $core
     * @return Closure
     */
    private function createCoreFunction(Closure $core)
    {
        return function(Request $request) use($core) {
            return $core($request);
        };
    }

    /**
     * @param Closure $result
     * @param MiddlewareInterface $middleware
     * @return Closure
     */
    private function createLayer(Closure $result, MiddlewareInterface $middleware)
    {
        return function(Request $request) use($result, $middleware){
            return $middleware->handle($request, $result);
        };
    }
}