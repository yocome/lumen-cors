<?php
/**
 * HomePage: https://github.com/yocome
 * Created by Yong.
 * Date: 2016/1/21
 * Time: 16:07
 */

namespace Yocome\Cors;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CorsMiddleware
{

    /**
     * @var CorsService
     */
    private $service;

    /**
     * @param CorsService $service
     */
    public function __construct(CorsService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param callable $next
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        //非跨域请求
        if(!$this->service->isCorsRequest($request)){

            return $next($request);
        }

        //处理OPTIONS
        if($this->service->isPreflightRequest($request)){

            return $this->service->handlePreflightRequest($request);
        }

        //不允许 Origin
        if(!$this->service->isRequestAllowed($request)){
            throw new HttpException(403, '', null, []);
        }

        //处理跨域请求
        return $this->service->handleRequest($request, $next($request));
    }

}