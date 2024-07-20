<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    public function searchCeps($ceps)
    {
       
      $paramsArray = explode('/', $ceps);

      $results = [];

      foreach ($paramsArray as $cep) {
          if (preg_match('/^\d{8}$/', $cep)) {
              $response = Http::get("https://viacep.com.br/ws/$cep/json/");

              if ($response->successful()) {
                  $results[] = $response->json();
              } else {
                  $results[] = ['cep' => $cep, 'error' => 'Erro ao obter os dados da API'];
              }
          } else {
              $results[] = ['cep' => $cep, 'error' => 'CEP inválido'];
          }
      }

      return response()->json($results);

    }

}