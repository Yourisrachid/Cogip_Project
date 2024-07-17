<?php
namespace App\Models;

class Invoice
{
    public $id;
    public $ref;
    public $price;
    public $id_company;
    public $created_at;
    public $update_at;

    public function __construct(int $id, string $ref, float $price, int $id_company, string $created_at, string $update_at)
    {
        $this->id = $id;
        $this->ref = $ref;
        $this->price = $price;
        $this->id_company = $id_company;
        $this->created_at = $created_at;
        $this->update_at = $update_at;
    }

    public function formatPublishDate($format = 'Y-m-d\TH:i:s\Z', $dateType = 'created_at')
    {
        if ($this->$dateType) {
            $dateTime = new DateTime($this->$dateType);
            return $dateTime->format($format);
        }
        return null;
    }
}
