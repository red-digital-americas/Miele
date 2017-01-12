<?php
/**
 * Description of RolesTableSeeder
 *
 * @author danielunag
 */
use Illuminate\Database\Seeder;
class RolesTableSeeder extends Seeder{
    
    public function run() {
        DB::table('mst_Roles')->insert([
            'id'         => 1,
            'name'          => env('ROLES_ADMIN_NAME'),
            'created_by'    => 1
        ]);
        
        DB::table('mst_Roles')->insert([
            'id'         => 2,
            'name'          => "userAdmin",
            'created_by'    => 1
        ]);
        
        DB::table('mst_Roles')->insert([
            'id'         => 1,
            'name'          => "userApp",
            'created_by'    => 1
        ]);
    }

}
