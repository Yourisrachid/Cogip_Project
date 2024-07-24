<?php

namespace App\Controllers;

use DateTime;
use Exception;
use DateTimeZone;
use PDOException;
use App\Models\Contact;
use App\Core\Controller;
use Faker\Factory as Faker;

class ContactSeederController extends Controller
{
    public function __invoke()
    {
        $contact = new Contact();
        $faker = Faker::create();
        $count = 50;

        for ($i = 0; $i < $count; $i++) {
            try {
                $contact->createContact([
                    "name" => $faker->firstName . ' ' . $faker->lastName,
                    "company_id" => rand(3, 52),
                    "email" => $faker->email,
                    "phone" => $faker->phoneNumber,
                    "created_at" => (new DateTime('now', new DateTimeZone('Europe/Brussels')))->format('Y-m-d H:i:s'),
                ]);
            } catch (Exception | PDOException $e) {
                throw new Exception($e->getMessage());
            }
        }
    }
}
