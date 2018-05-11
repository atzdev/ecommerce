<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Illuminate\Http\Response;

trait ExceptionTrait
{
	public function apiException($request, $e)
	{
			if($this->isModel($e)) {
                return $this->modelResponse($e);
            }   

            if($this->isHttp($e)) {
                return $this->httpResponse($e);
            }   

            return parent::render($request, $e);
	}

	protected function isModel($e)
	{
		return $e instanceof ModelNotFoundException;
	}

	protected function isHttp($e)
	{
		return $e instanceof NotFoundHttpException;
	}

	protected function modelResponse($e)
	{
		return response()->json([
                    'errors' => 'Model not found'
                ], Response::HTTP_NOT_FOUND);
	}

	protected function httpResponse($e)
	{
		return response()->json([
                    'errors' => 'Incorect route'
                ], Response::HTTP_NOT_FOUND);
	}
}