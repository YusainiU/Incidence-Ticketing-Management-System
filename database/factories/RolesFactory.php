<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Roles;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Roles>
 */
class RolesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Super Administrator',
            'description' => 'Super Administrator',
            'active' => 1,
            'allowed_routes' => 'dashboard,userList,userProfile,userRoles,customerList,customerProfile,projectFileManager,productList,supplierList,assetProfile,createNewTicket,ticketProfile,ticketList,addRoutesToRoles,createNewRole,addUserToRole,createNewAsset,createNewCustomer,createNewProduct,createNewServiceLevelAgreement,createNewSupplier,createNewUser,createSlaApplication,addCustomerContactToRole,editCustomerDetails,editServiceLevelAgreement,editSlaApplication,editUserDetails,deleteUser,customerContact,ticketAuditLog,ticketDeletedList,addNewRoles,slaApplicationTable,serviceLevelAgreementList,progressLogTimeline,adminDashboard,failedAttempts,successfulLogins,assetTable,cacheTable,routeList,configurationList,assetList,rolesAdmin',
            'allow_edit' => 'dashboard,userList,userProfile,userRoles,customerList,customerProfile,projectFileManager,productList,supplierList,assetProfile,createNewTicket,ticketProfile,ticketList,addRoutesToRoles,createNewRole,addUserToRole,createNewAsset,createNewCustomer,createNewProduct,createNewServiceLevelAgreement,createNewSupplier,createNewUser,createSlaApplication,addCustomerContactToRole,editCustomerDetails,editServiceLevelAgreement,editSlaApplication,editUserDetails,deleteUser,customerContact,ticketAuditLog,ticketDeletedList,addNewRoles,slaApplicationTable,serviceLevelAgreementList,progressLogTimeline,adminDashboard,failedAttempts,successfulLogins,assetTable,cacheTable,routeList,configurationList,assetList,rolesAdmin',
        ];
    }
}
