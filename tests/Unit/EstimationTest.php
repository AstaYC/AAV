<?php
namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\voiture;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;


class UserTest extends TestCase
{
  use RefreshDatabase;

  public function Estimation_test()
  {
      $response = $this->post('/api/auth/estimation', [
          'marque' => 'audi',
          'modele' => 'a5',
          'annee' => '2009',
      ]);

      $response->assertStatus(201);
      $this->assertCount(1, DB::select("select * from voitures where marque = 'audi' AND modele = 'a5' And annee = '2009'"));
  }
}
