<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'Владелец']);
        $role->permissions()->create($this->getAllAccess());
        $role = Role::create(['name' => 'Администратор']);
        $role->permissions()->create($this->getAllAccess());
        $role = Role::create(['name' => 'Менеджер']);
        $role->permissions()->create(array_merge($this->getAllOrders(), $this->getAnalytics()));
        $role = Role::create(['name' => 'Акционер']);
        $role->permissions()->create(['analytics_graphics' => 1, 'analytics_pie' => 1]);
    }
    protected function getAllAccess()
    {
        $properties = (new Permission())->getFillable();
        $array  = [];
        foreach ($properties as $property)
        {
            if($property == 'orders_executor') { continue; }
            $array[$property] = 1;
        }
        return $array;
    }

    protected function getAllOrders()
    {
        $properties = (new Permission())->getFillable();
        $array  = [];
        foreach ($properties as $property)
        {
            if(explode('_', $property)[0] == 'orders') {
                $array[$property] = 1;
            }

        }
        return $array;
    }
    protected function getAnalytics()
    {
        $properties = (new Permission())->getFillable();
        $array  = [];
        foreach ($properties as $property)
        {
            if(explode('_', $property)[0] == 'analytics') {
                $array[$property] = 1;
            }

        }
        return $array;
    }
}
