<?php

namespace Mon\Oversight\Controller;

use Mon\Oversight\inc\DB;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class ContributorsController
{
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function showTable(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        $db = new DB();
        $db->connect();
        $query = 'SELECT plugin_name, contributor_login FROM contributors ORDER BY contributor_login ASC ';
        $contributors = $db->queryDB($query);
        $db->closeConnection();
        if (count($contributors) === 0) {
            echo 'No Plugins';
            die();
        }
        return $this->twig->render($response, 'table.twig', ['pageName' => 'Contributors', 'data' => $contributors]);
    }
}