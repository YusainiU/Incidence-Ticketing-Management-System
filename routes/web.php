<?php
use App\Http\Controllers\uploadAssetExcelFileForImport;
use App\Http\Controllers\uploadProductExcelFileForImport;
use App\Livewire\ActivityCalendar;
use App\Livewire\AddCustomerContactToRole;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\CacheTable;
use App\Livewire\Admin\ConfigurationList;
use App\Livewire\Admin\FailedAttempts;
use App\Livewire\Admin\RolesAdmin;
use App\Livewire\Admin\RouteList;
use App\Livewire\Admin\SuccessfulLogins;
use App\Livewire\AssetList;
use App\Livewire\CreateNewRole;
use App\Livewire\CreateNewUser;
use App\Livewire\CreateSlaApplication;
use App\Livewire\Customer\CustomerCreateTicket;
use App\Livewire\Customer\CustomerTicketList;
use App\Livewire\Customer\CustomerTicketProfile;
use App\Livewire\Customer\CustomerViewProfile;
use App\Livewire\CustomerContact;
use App\Livewire\CustomerLogin;
use App\Livewire\EditCustomerDetails;
use App\Livewire\EditServiceLevelAgreement;
use App\Livewire\EditSlaApplication;
use App\Livewire\EditUserDetails;
use App\Livewire\LoginInternal;
use App\Livewire\ModalDeleteUser;
use App\Livewire\SlaApplicationTable;
use App\Livewire\TicketAuditLog;
use App\Livewire\TicketDeletedList;
use Illuminate\Support\Facades\Route;
use App\Livewire\CreateNewTicket;
use App\Livewire\CustomerProfile;
use App\Livewire\ProgressLogTimeline;
use App\Livewire\ProjectFileManager;
use App\Livewire\SupplierList;
use App\Livewire\TicketList;
use App\Livewire\TicketProfile;
use App\Livewire\UsersList;
use App\Livewire\UserProfile;
use App\Livewire\UserRoles;
use App\Livewire\AddRoutesToRoles;
use App\Livewire\TestEnvironment;
use App\Livewire\CustomerList;
use App\Livewire\ProductList;
use App\Livewire\AssetProfile;
use App\Livewire\ServiceLevelAgreementList;
use App\Livewire\MainDashboard;
use App\Livewire\AddUserToRole;
use App\Livewire\AssetTable;
use App\Livewire\CreateNewAsset;
use App\Livewire\CreateNewCustomer;
use App\Livewire\CreateNewProduct;
use App\Livewire\CreateNewServiceLevelAgreement;
use App\Livewire\CreateNewSupplier;
use App\Livewire\UploadPublicImage;
use App\Livewire\Customer\CustomerDashboard;
use App\Livewire\ResetUserPassword;

/*

    To enable user registration go to app->config->fortify
    then enabla registration in the 'features'

*/


Route::get('/', function () {
    return view('welcome');
});

Route::get('/licensing', function () {
    return view('livewire.licensing');
});

Route::get('/mobileWelcome', function () {
    return view('mobile-welcome.welcome');
});

Route::get('/login-internal/{error?}', LoginInternal::class)->name('internalLogin');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'internalUser',
])->group(function () {
    /*
        Add the route name to config file steps.routes for access permissions
    */
    Route::get('/dashboard', MainDashboard::class)->name('dashboard');
    Route::get('/dashboard/userList', UsersList::class)->name('userList');
    Route::get('/dashboard/userProfile/{user}', UserProfile::class)->name('userProfile');
    Route::get('/dashboard/userRoles', UserRoles::class)->name('userRoles');
    Route::get('/dashboard/playground', TestEnvironment::class)->name('playground');
    Route::get('/dashboard/customerList', CustomerList::class)->name('customerList');
    Route::get('/dashboard/customerProfile/{customer}', CustomerProfile::class)->name('customerProfile');
    Route::get('/dashboard/projectFileManager', ProjectFileManager::class)->name('projectFileManager');
    Route::get('/dashboard/productList/{product?}', ProductList::class)->name('productList');
    Route::get('/dashboard/supplierList/{supplier?}', SupplierList::class)->name('supplierList');
    Route::get('/dashboard/assetProfile/{asset}', AssetProfile::class)->name('assetProfile');
    Route::get('/dashboard/serviceLevelAgreementList/{sla?}', serviceLevelAgreementList::class)->name('serviceLevelAgreementList');
    Route::get('/dashboard/createNewTicket/{customer}', CreateNewTicket::class)->name('createNewTicket');
    Route::get('/dashboard/ticketProfile/{ticket}', TicketProfile::class)->name('ticketProfile');
    Route::get('/dashboard/progressLogTimeline/{ticket}', ProgressLogTimeline::class)->name('progressLogTimeline');
    Route::get('/dashboard/ticketList/{ticket?}', TicketList::class)->name('ticketList');
    Route::get('/dashboard/createNewRole', CreateNewRole::class)->name('createNewRole');
    Route::get('/dashboard/addUserToRole/{user}', AddUserToRole::class)->name('addUserToRole');
    Route::get('/dashboard/assetTable', AssetTable::class)->name('assetTable');
    Route::get('/dashboard/createNewAsset', CreateNewAsset::class)->name('createNewAsset');
    Route::get('/dashboard/createNewCustomer', CreateNewCustomer::class)->name('createNewCustomer');
    Route::get('/dashboard/createNewProduct', CreateNewProduct::class)->name('createNewProduct');
    Route::get('/dashboard/createNewServiceLevelAgreement', CreateNewServiceLevelAgreement::class)->name('createNewServiceLevelAgreement');
    Route::get('/dashboard/createNewSupplier', CreateNewSupplier::class)->name('createNewSupplier');
    Route::get('/dashboard/createNewUser', CreateNewUser::class)->name('createNewUser');
    Route::get('/dashboard/createSlaApplication', CreateSlaApplication::class)->name('createSlaApplication');
    Route::get('/dashboard/addCustomerContactToRole', AddCustomerContactToRole::class)->name('addCustomerContactToRole');
    Route::get('/dashboard/editCustomerDetails', EditCustomerDetails::class)->name('editCustomerDetails');
    Route::get('/dashboard/editServiceLevelAgreement/{sla}', EditServiceLevelAgreement::class)->name('editServiceLevelAgreement');
    Route::get('/dashboard/editSlaApplication/{slap}', EditSlaApplication::class)->name('editSlapApplication');
    Route::get('/dashboard/editUserDetails/{userdata}', EditUserDetails::class)->name('editUserDetails');
    Route::get('/dashboard/deleteUser/{userToDelete}', ModalDeleteUser::class)->name('deleteUser');
    Route::get('/dashboard/customerContact/{user}', CustomerContact::class)->name('customerContact');
    Route::get('/dashboard/uploadPublicImage/{imagePath?}', UploadPublicImage::class)->name('uploadPublicImage');
    Route::post('/dashboard/userProfile/{user}', [UserProfile::class, 'addUserRoles'])->name('addNewRoles');
    Route::post('/dashboard/addRouteToRole', [AddRoutesToRoles::class, 'addRouteToRole'])->name('addRouteToRole');
    Route::get('/dashboard/activityCalendar', ActivityCalendar::class)->name('activityCalendar');
    Route::get('/dashboard/ticketAuditLog/{ticket}', TicketAuditLog::class)->name('ticketAuditLog');
    Route::get('/dashboard/ticketDeletedList', TicketDeletedList::class)->name('ticketDeletedList');
    Route::get('/dashboard/slaApplicationTable/{customer}', SlaApplicationTable::class)->name('slaApplicationTable');
    Route::get('/dashboard/assetList', AssetList::class)->name('assetList');
    
    Route::post('/importProducts', [uploadProductExcelFileForImport::class, 'import'])->name('importProducts');
    Route::post('/importAssets/{customer}', [uploadAssetExcelFileForImport::class, 'import'])->name('importAssets');

    Route::get('/dashboard/resetUserPassword/{user}', ResetUserPassword::class)->name('resetUserPassword');
    Route::get('/dashboard/adminDashboard/{openContent?}', AdminDashboard::class)->name('adminDashboard');
    Route::get('/dashboard/failedAttempts', FailedAttempts::class)->name('failedAttempts');
    Route::get('/dashboard/successfulLogins', SuccessfulLogins::class)->name('successfulLogins');
    Route::get('/dashboard/cacheTable', CacheTable::class)->name('cacheTable');
    Route::get('/dashboard/routeList', RouteList::class)->name('routeList');
    Route::get('/dashboard/configurationList', ConfigurationList::class)->name('configurationList');
    Route::get('/dashboard/rolesAdmin', RolesAdmin::class)->name('rolesAdmin');

    
});


Route::get('/customer-login/{error?}', CustomerLogin::class)->name('customerLogin');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'customerUser',
])->group(function () {
    Route::get('/customerDashboard', CustomerDashboard::class)->name('customerDashboard');
    Route::get('/customerViewProfile', CustomerViewProfile::class)->name('customerViewProfile');
    Route::get('/customerTicketList', CustomerTicketList::class)->name('customerTicketList');
    Route::get('/customerTicketProfile/{ticket}', CustomerTicketProfile::class)->name('customerTicketProfile');
    Route::get('/customerCreateTicket', CustomerCreateTicket::class)->name('customerCreateTicket');
});
