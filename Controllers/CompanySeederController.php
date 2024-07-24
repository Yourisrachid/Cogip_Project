<?php

namespace App\Controllers;

use DateTime;
use Exception;
use DateTimeZone;
use PDOException;
use App\Models\Company;
use App\Core\Controller;
use Faker\Factory as Faker;

class CompanySeederController extends Controller
{
    public function __invoke()
    {
        $company = new Company();
        $faker = Faker::create();
        $count = 50;

        for ($i = 0; $i < $count; $i++) {
            try {
                $countryCode = $faker->countryCode;
                $tva = $countryCode . $faker->randomNumber(9, true);

                $company->createCompany([
                    "name" => $faker->company,
                    "type_id" => rand(1, 2),
                    "country" => $faker->country,
                    "tva" => $tva,
                    "created_at" => (new DateTime('now', new DateTimeZone('Europe/Brussels')))->format('Y-m-d H:i:s'),
                ]);
            } catch (Exception | PDOException $e) {
                throw new Exception($e->getMessage());
            }
        }
    }
}
