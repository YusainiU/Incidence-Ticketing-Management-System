<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Roles;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Customer;
use App\Models\UserToRoles;
use Illuminate\Database\Seeder;
use LivewireFilemanager\Filemanager\Models\Folder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(3)->create();
        Customer::factory(3)->create();
        Product::factory(3)->create();
        Roles::factory(1)->create();
        Supplier::factory(3)->create();
        UserToRoles::factory(1)->create();

        //Create the first root folder
        $root = 'File System';
        $fsys = [
            'name' => $root,
            'slug' => Str::slug($root),            
        ];
        Folder::create($fsys);

        //Create the second folder
        $internalFolder = 'Internal Folder';
        $iFolder = [
            'name' => $internalFolder,
            'slug' => Str::slug($internalFolder),
        ];
        Folder::create($iFolder);

        //Update First User as Admin Use
        $admin = [
            'email' => 'admin@admin.com',            
        ];
        $u = User::find(1);
        $u->update($admin);

        //Create Administration (Not super Admin) and Default roles           
        Roles::create(
            [
                'name' => 'Administrator',
                'description' => 'Administrator',
                'active' => 1,
                'allowed_routes' => 'dashboard,userList,userProfile,customerList,customerProfile,projectFileManager,productList,supplierList,assetProfile,createNewTicket,ticketProfile,ticketList,addRoutesToRoles,createNewRole,addUserToRole,createNewAsset,createNewCustomer,createNewProduct,createNewServiceLevelAgreement,createNewSupplier,createNewUser,createSlaApplication,addCustomerContactToRole,editCustomerDetails,editServiceLevelAgreement,editSlaApplication,editUserDetails,deleteUser,customerContact,ticketAuditLog,ticketDeletedList,addNewRoles,slaApplicationTable,serviceLevelAgreementList,progressLogTimeline,adminDashboard,failedAttempts,successfulLogins,assetTable,cacheTable,routeList,configurationList,assetList,rolesAdmin',
                'allow_edit' => 'dashboard,userList,userProfile,customerList,customerProfile,projectFileManager,productList,supplierList,assetProfile,createNewTicket,ticketProfile,ticketList,addRoutesToRoles,createNewRole,addUserToRole,createNewAsset,createNewCustomer,createNewProduct,createNewServiceLevelAgreement,createNewSupplier,createNewUser,createSlaApplication,addCustomerContactToRole,editCustomerDetails,editServiceLevelAgreement,editSlaApplication,editUserDetails,deleteUser,customerContact,ticketAuditLog,ticketDeletedList,addNewRoles,slaApplicationTable,serviceLevelAgreementList,progressLogTimeline,adminDashboard,failedAttempts,successfulLogins,assetTable,cacheTable,routeList,configurationList,assetList,rolesAdmin',
            ]
        );
        Roles::create(
            [
                'name' => 'Default',
                'description' => 'Default Role',
                'active' => 1,
                'allowed_routes' => 'dashboard,userList,userProfile,userRoles,customerList,customerProfile,productList,supplierList,assetProfile,serviceLevelAgreementList,slaApplicationTable,createNewTicket,ticketProfile,progressLogTimeline,ticketList,addNewRoles,addRoutesToRoles,createNewRole,addUserToRole,adminDashboard,assetTable,createNewAsset,createNewCustomer,createNewProduct,createNewServiceLevelAgreement,createNewSupplier,createNewUser,createSlaApplication,addCustomerContactToRole,editCustomerDetails,editServiceLevelAgreement,editSlaApplication,editUserDetails,deleteUser,customerContact,ticketAuditLog,ticketDeletedList,failedAttempts,successfulLogins,cacheTable,routeList,configurationList,assetList,rolesAdmin',
                'allow_edit' => null,
            ],            
        );        

    }
}
