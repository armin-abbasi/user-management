<?php


namespace Tests\Unit;


use App\Libraries\Admin\Users;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use DatabaseTransactions;

    public $model = User::class;

    public $service;

    public $faker;

    private $databaseTable = 'users';

    /**
     * UsersTest constructor.
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->service = new Users();

        $this->faker = Factory::create();
    }

    /**
     * Create mock users for testing other methods.
     *
     * @return mixed
     */
    private function createUser()
    {
        $input = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->randomLetter,
        ];

        return $this->service->create($input);
    }

    /**
     *  Testing Users class create method.
     */
    public function testCreateUser()
    {
        $input = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->randomLetter,
        ];

        $result = $this->service->create($input);

        $this->assertInstanceOf($this->model, $result);

        $this->assertSame($input['name'], $result->name);

        $this->assertDatabaseHas($this->databaseTable, ['email' => $input['email']]);
    }

    /**
     *  Testing Users class getAll method.
     */
    public function testGetAll()
    {
        $this->createUser();

        $getResult = $this->service->getAll();

        $getResult = $getResult->toArray();

        $this->assertNotEmpty($getResult['data']);
    }

    /**
     *  Testing Users class delete method.
     */
    public function testDelete()
    {
        $mockUser = $this->createUser();

        $this->assertSame($this->service->delete($mockUser->id), 1);

        $this->assertDatabaseMissing($this->databaseTable, ['id' => $mockUser->id]);
    }
}