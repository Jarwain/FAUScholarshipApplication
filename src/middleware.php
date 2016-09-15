<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

$delTrailingSlash = function ($request, $response, $next) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    if ($path != '/' && substr($path, -1) == '/') {
        // permanently redirect paths with a trailing slash
        // to their non-trailing counterpart
        $uri = $uri->withPath(substr($path, 0, -1));
        return $response->withRedirect((string)$uri, 301);
    }

    return $next($request, $response);
};

$addTrailingSlash = function ($request, $response, $next) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    $this->log->error("Path: ".$path);
    if (substr($path, -1) != '/') {
        // permanently redirect paths with a trailing slash
        // to their non-trailing counterpart
        $uri = $uri->withPath($path.'/');
        return $response->withRedirect((string)$uri, 301);
    }
    return $next($request, $response);
};

$dbTransaction = function($request, $response, $next) {
	if(!empty($this->db)){
		try{
			$this->db->beginTransaction();
			$response = $next($request, $response);
			$this->db->commit();
		} catch (\PDOException $ex){
			$this->db->rollBack();
			$this->log->error("DB Exception: ".$ex);
			$response->withJson(messageResponse(false,"Database Exception: ".$ex));
		}
	}
	else {
		$this->log->alert("wot");
		$response = $next($request, $response);	
	}
	return $response;
};

$generalExceptions = function($request, $response, $next) {
	try{
		$response = $next($request, $response);
	} catch (Exception $ex){
		$response->withJson(messageResponse(false,$ex->__toString()));
	}

	return $response;
};

$jsonCheck = function($request, $response, $next) {
	$mediaType = $request->getMediaType();
	if($mediaType != "application/json"){
		throw new genException("Invalid Content Type. Only 'application/json' allowed.");
	}
	return $next($request, $response);
};
//$app->add($addTrailingSlash);