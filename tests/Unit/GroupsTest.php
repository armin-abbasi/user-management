<?php


namespace Tests\Unit;


use App\Exceptions\GroupIsNotEmptyException;
use App\Exceptions\UserAlreadyAttachedException;
use App\Libraries\Admin\Facades\GroupService;
use App\Libraries\Admin\Facades\UserService;
use App\Models\Group;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class GroupsTest extends TestCase
{
    use DatabaseTransactions;

    public $model = Group::class;

    public $faker;

    private $databaseTable = 'groups';

    private $databasePivotTable = 'group_user';

    /**
     * GroupsTest constructor.
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->faker = Factory::create();
    }

    /**
     * Create mock groups for testing other methods.
     *
     * @return mixed
     */
    private function createGroup()
    {
        $input = [
            'name' => $this->faker->company,
            'description' => $this->faker->realText(50),
        ];

        return GroupService::create($input);
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

        return UserService::create($input);
    }

    /**
     *  Testing Groups class create method.
     */
    public function testCreateGroup()
    {
        $input = [
            'name' => $this->faker->company,
            'description' => $this->faker->realText(50),
        ];

        $createResult = GroupService::create($input);

        $this->assertInstanceOf($this->model, $createResult);

        $this->assertSame($input['name'], $createResult->name);

        $this->assertDatabaseHas($this->databaseTable, ['name' => $input['name']]);
    }

    /**
     *  Testing Groups class getAll method.
     */
    public function testGetAll()
    {
        $this->createGroup();

        $getResult = GroupService::getAll();

        $getResult = $getResult->toArray();

        $this->assertNotEmpty($getResult['data']);
    }

    /**
     *  Testing Groups class delete method.
     *
     * @throws \Exception
     */
    public function testDelete()
    {
        $mockGroup = $this->createGroup();

        try {
            $this->assertSame(GroupService::delete($mockGroup->id), true);
            $this->assertDatabaseMissing($this->databaseTable, ['id' => $mockGroup->id]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *  Testing Groups class delete method functionality.
     */
    public function testDeleteOnlyEmptyGroups()
    {
        $mockGroup = $this->createGroup();
        $mockUser = $this->createUser();

        try {
            // First attach a user to group.
            GroupService::attach($mockGroup->id, $mockUser->id);
            $this->assertDatabaseHas($this->databasePivotTable,
                [
                    'user_id' => $mockUser->id,
                    'group_id' => $mockGroup->id
                ]
            );
            // Now trying to delete the group.
            GroupService::delete($mockGroup->id);
        } catch (\Exception $e) {
            $this->assertInstanceOf(GroupIsNotEmptyException::class, $e);
        }
    }

    /**
     *  Testing Groups class attach method with successful result.
     *
     * @throws \Exception
     */
    public function testSuccessfulAttach()
    {
        $mockGroup = $this->createGroup();
        $mockUser = $this->createUser();

        try {
            GroupService::attach($mockGroup->id, $mockUser->id);
            $this->assertDatabaseHas($this->databasePivotTable, ['group_id' => $mockGroup->id, 'user_id' => $mockUser->id]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     *  Testing Groups class attach method with failure result due to duplicate entry error.
     */
    public function testFailToAttachTwice()
    {
        $mockGroup = $this->createGroup();
        $mockUser = $this->createUser();

        try {
            GroupService::attach($mockGroup->id, $mockUser->id);
            GroupService::attach($mockGroup->id, $mockUser->id);
        } catch (\Exception $e) {
            $this->assertInstanceOf(UserAlreadyAttachedException::class, $e);
        }
    }

    /**
     *  Testing Groups class detach method.
     *
     * @throws \Exception
     */
    public function testSuccessfulDetach()
    {
        $mockGroup = $this->createGroup();
        $mockUser = $this->createUser();

        try {
            // Attaching mock data.
            GroupService::attach($mockGroup->id, $mockUser->id);
            $this->assertDatabaseHas($this->databasePivotTable, ['group_id' => $mockGroup->id, 'user_id' => $mockUser->id]);
            // Detaching mock data.
            GroupService::detach($mockGroup->id, $mockUser->id);
            $this->assertDatabaseMissing($this->databasePivotTable, ['group_id' => $mockGroup->id, 'user_id' => $mockUser->id]);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}