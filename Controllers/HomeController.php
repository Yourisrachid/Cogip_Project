<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    /*
    * return view
    */
    public function index()
    {
        return $this->view('welcome',["name" => "Cogip"]);
    }
    public function invoices()
    {
        return $this->view('invoice');
    }
    public function contact()
    {
        return $this->view('contact');
    }
    public function companies()
    {
        return $this->view('companies');
    }
    public function showCompanies()
    {
        return $this->view('show-companies');
    }
    public function dashboard()
    {
        return $this->view('dashboard');
    }
    public function newInvoices()
    {
        return $this->view('new-invoices');
    }
    public function newCompanies()
    {
        return $this->view('new-companies');
    }
    public function newContact()
    {
        return $this->view('new-contact');
    }
    public function logout()
    {
        return $this->view('logout');
    }
    public function login()
    {
        return $this->view('login');
    }
}