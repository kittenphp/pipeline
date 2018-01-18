### introduce

<p>The "kittenphp/pipeline" is a Lightweight library,It can convert Symfony's http request to response.</p>
<p>Usually handle middleware in the MVC framework.</p>

* install:<br>
composer require kittenphp/pipeline

* example:

```php
<?php
require __DIR__.'/vendor/autoload.php';

use kitten\Component\pipeline\MiddlewareInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use kitten\Component\pipeline\PipelinePack;

class M1 implements MiddlewareInterface{
    public function handle(Request $request, Closure $next)
    {
        // Some processing work...
        return $next($request);
    }
}
class M2 implements MiddlewareInterface{
    public function handle(Request $request, Closure $next)
    {
        return new Response('hello world! (kitten\Component\pipeline)');
    }
}

$pack=new PipelinePack();
$pack->add(new M1());
$pack->add(new M2());
$response=$pack->handle(Request::createFromGlobals());
$response->send();
```