<?php

namespace App\Controllers;

use DateTime;
use Exception;
use DateTimeZone;
use PDOException;
use App\Models\Invoice;
use App\Core\Controller;
use Faker\Factory as Faker;

class InvoiceSeederController extends Controller
{
    public function __invoke()
    {
        $invoice = new Invoice();
        $faker = Faker::create();
        $count = 50;

        for ($i = 0; $i < $count; $i++) {
            try {

                $invoice->createInvoice([
                    "ref" => $faker->ean8,
                    "price" => rand(1, 500),
                    "id_company" => rand(3, 52),
                    "created_at" => (new DateTime('now', new DateTimeZone('Europe/Brussels')))->format('Y-m-d H:i:s'),
                    "updated_at" => (new DateTime('now', new DateTimeZone('Europe/Brussels')))->format('Y-m-d H:i:s'),
                ]);
            } catch (Exception | PDOException $e) {
                throw new Exception($e->getMessage());
            }
        }
    }
}