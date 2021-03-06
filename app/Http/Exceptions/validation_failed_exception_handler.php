<?php
use Dingo\Api\Exception\ResourceException;

App::error(function(ResourceException $e){
    return Response::make([
        'message' => $e->getMessage(),
        'errors' => $e->getErrors()
    ],422);
});