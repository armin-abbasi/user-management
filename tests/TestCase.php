<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->createApplication();

        // Checking database connection.
        try {
            DB::connection('mysql')->getPdo();
        } catch (\Exception $e) {
            echo "Could not connect to the database. Please check your configuration!\n";
            exit(1);
        }
    }
}
