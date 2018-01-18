<?php


namespace kitten\Component\pipeline;


use Closure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface MiddlewareInterface
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return null|Response
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next);
}