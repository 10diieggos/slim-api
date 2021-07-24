<?php
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Produto;

  $app->group('/api/v1', function () {
    
    $this->get('/produtos/lista', function (Request $request, Response $response) {
      $produtos = Produto::get();
      return $response->withJson($produtos);
    });

    $this->post('/produtos/adiciona', function (Request $request, Response $response) {
      $dados = $request->getParsedBody();
      $produto = Produto::create($dados);
      return $response->withJson($produto);
    });

    $this->get('/produtos/lista/{id}', function (Request $request, Response $response, $args) {
      $produtos = Produto::findOrFail($args['id']);
      return $response->withJson($produtos);
    });

    $this->put('/produtos/atualiza/{id}', function (Request $request, Response $response, $args) {
      
      $dados = $request->getParsedBody();
      $produtos = Produto::findOrFail($args['id']);
      $produtos->update($dados);
      return $response->withJson($produtos);
    });
      
    $this->delete('/produtos/remove/{id}', function (Request $request, Response $response, $args) {
      
      $produtos = Produto::findOrFail($args['id']);
      $produtos->delete();
      return $response->withJson($produtos);
      
    });


  });