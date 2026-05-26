<?php session_start();
define('ROOT_PATH', __DIR__);
//$rootPath = realpath(__DIR__ );
require_once ROOT_PATH . '/envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH . '/envfiles');
$dotenv->load();

if (isset($_ENV['APP_TIMEZONE'])) {
    date_default_timezone_set($_ENV['APP_TIMEZONE']);
}

include('model/common/en_de_class.php');
include('model/db_connection/pdo_db_connection.php');
include('model/common/pdoCommonFunctions.php');
include('model/common/FormSQLHelper.php');
include('jwt/jwt_en_de.php');
// include('model/db_connection/connection.php');

class RoutingClass
{
    public $encryption, $pdoConnection, $login_user;
    private $key, $base_url, $server_name; // Ensure this key is 32 bytes for AES-256

    public function __construct()
    {
        $this->server_name = $_ENV['MAINSERVER'];
        $this->key = $_ENV['ENCRIPTION_KEY'];
        $this->base_url = $_ENV['BASE_URL'];
        
        $currentDomain = $_SERVER['HTTP_HOST'];
        $allowedDomain = $this->server_name;
        
        // Allow localhost and 127.0.0.1 automatically in development mode
        $isLocal = ($currentDomain === 'localhost' || $currentDomain === '127.0.0.1' || str_starts_with($currentDomain, 'localhost:') || str_starts_with($currentDomain, '127.0.0.1:'));
        $isDev = (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'development');

        if (!$isLocal && !$isDev && $currentDomain !== $allowedDomain) {
            header("HTTP/1.0 404 Not Found!");
            echo "<p style='background-color: #7FB131; color: white;text-align: left;font-size:20px;padding:20px; font-family: Arial, Helvetica, sans-serif;'>AA CAR RENTAL- 404 Not Found - By " . $_SERVER['SERVER_NAME'] .'-- Allowed : '. $this->server_name. "</p>";
            exit();
        }

        // Initialize encryption class
        $this->encryption = new EncryptionHelper($this->key);
        
        // Retrieve the requested URL
        $this->url = isset($_GET['url']) ? $_GET['url'] : '/';
        // Define the routes
        $this->routes = array(
            '' => 'Login',
            '/' => 'Login',
            'Login' => 'Login',
            'Login/' => 'Login',
            'LoginController' => 'LoginController',
            'LoginController/' => 'LoginController',
            'Logout' => 'Logout',
            'Logout/' => 'Logout',
            'Home' => 'Home',
            'Home/' => 'Home',
            'GetEventLog' => 'GetEventLog',
            'GetEventLog/' => 'GetEventLog',
            'GetEventLogDetails' => 'GetEventLogDetails',
            'GetEventLogDetails/' => 'GetEventLogDetails',
            'DeleteEventLogDetails' => 'DeleteEventLogDetails',
            'DeleteEventLogDetails/' => 'DeleteEventLogDetails',
            'UploadUserDocuments' => 'UploadUserDocuments',
            'UploadUserDocuments/' => 'UploadUserDocuments',
            'UploadUserDriverDocuments' => 'UploadUserDriverDocuments',
            'UploadUserDriverDocuments/' => 'UploadUserDriverDocuments',
            'UploadRentCarImages' => 'UploadRentCarImages',
            'UploadRentCarImages/' => 'UploadRentCarImages',

            'UploadDocumentsCompressed' => 'UploadDocumentsCompressed',
            'UploadDocumentsCompressed/' => 'UploadDocumentsCompressed',

            'DeleteUploadDocuments' => 'DeleteUploadDocuments',
            'DeleteUploadDocuments/' => 'DeleteUploadDocuments',
            'SaveFinalBooking' => 'SaveFinalBooking',
            'SaveFinalBooking/' => 'SaveFinalBooking',

            'SaveCustomerDetails' => 'SaveCustomerDetails',
            'SaveCustomerDetails/' => 'SaveCustomerDetails',

            'SearchCustomerDetails' => 'SearchCustomerDetails',
            'SearchCustomerDetails/' => 'SearchCustomerDetails',

            'GetCustomerDetails' => 'GetCustomerDetails',
            'GetCustomerDetails/' => 'GetCustomerDetails',

            'RegisterVehicles' => 'RegisterVehicles',
            'RegisterVehicles/' => 'RegisterVehicles',

            'AddVehicles' => 'AddVehicles',
            'AddVehicles/' => 'AddVehicles',

            'ListOfVehicles' => 'ListOfVehicles',
            'ListOfVehicles/' => 'ListOfVehicles',

            'UploadVehicleImages' => 'UploadVehicleImages',
            'UploadVehicleImages/' => 'UploadVehicleImages',

            'DeleteUploadVehicleImages' => 'DeleteUploadVehicleImages',
            'DeleteUploadVehicleImages/' => 'DeleteUploadVehicleImages',

            'FetchAllAvlVehicle' => 'FetchAllAvlVehicle',
            'FetchAllAvlVehicle/' => 'FetchAllAvlVehicle',

            'LoadVehicleByUserSellection' => 'LoadVehicleByUserSellection',
            'LoadVehicleByUserSellection/' => 'LoadVehicleByUserSellection',

            'Quotation' => 'Quotation',
            'Quotation/' => 'Quotation',

            'GetTerms' => 'GetTerms',
            'GetTerms/' => 'GetTerms',

            'GetItemList' => 'GetItemList',
            'GetItemList/' => 'GetItemList',

            'GetAllTermsAndConditions' => 'GetAllTermsAndConditions',
            'GetAllTermsAndConditions/' => 'GetAllTermsAndConditions',

            'DeleteTerms' => 'DeleteTerms',
            'DeleteTerms/' => 'DeleteTerms',

            'getVehicleDetails' => 'getVehicleDetails',
            'getVehicleDetails/' => 'getVehicleDetails',
            
            'GetVehicleStatus' => 'GetVehicleStatus',
            'GetVehicleStatus/' => 'GetVehicleStatus',
            
            'VehicleStatusController' => 'VehicleStatusController',
            'VehicleStatusController/' => 'VehicleStatusController',

            'getRentalOptions' => 'getRentalOptions',
            'getRentalOptions/' => 'getRentalOptions',

            'AddUser' => 'AddUser',
            'AddUser/' => 'AddUser',

            'InsertUser' => 'InsertUser',
            'InsertUser/' => 'InsertUser',

            'LoadRoles' => 'LoadRoles',
            'LoadRoles/' => 'LoadRoles',

            'LoadCompanies' => 'LoadCompanies',
            'LoadCompanies/' => 'LoadCompanies',

            'CheckUsername' => 'CheckUsername',
            'CheckUsername/' => 'CheckUsername',

            'UploadUserImages' => 'UploadUserImages',
            'UploadUserImages/' => 'CheckUploadUserImagesUsername',

            'ListOfUsers' => 'ListOfUsers',
            'ListOfUsers/' => 'ListOfUsers',

            'UpdateUserStatus' => 'UpdateUserStatus',
            'UpdateUserStatus/' => 'UpdateUserStatus',

            'UpdateUserInformation' => 'UpdateUserInformation',
            'UpdateUserInformation/' => 'UpdateUserInformation',

            'ResetUserPassword' => 'ResetUserPassword',
            'ResetUserPassword/' => 'ResetUserPassword',
            
            'QuotationController' => 'QuotationController',
            'QuotationController/' => 'QuotationController',
            
            'GetQtnIntroduction' => 'GetQtnIntroduction',
            'GetQtnIntroduction/' => 'GetQtnIntroduction',
            
            'OtherEventController' => 'OtherEventController',
            'OtherEventController/' => 'OtherEventController',
            
            'TestPage' => 'TestPage',
            'TestPage/' => 'TestPage',

            'LoadCategoryController' => 'LoadCategoryController',
            'LoadCategoryController/' => 'LoadCategoryController',
            
            'LoadModelSelect' => 'LoadModelSelect',
            'LoadModelSelect/' => 'LoadModelSelect',
            
            'VehicleStatusJsonController' => 'VehicleStatusJsonController',
            'VehicleStatusJsonController/' => 'VehicleStatusJsonController',
            
            'UploadVehicleDocs' => 'UploadVehicleDocs',
            'UploadVehicleDocs/' => 'UploadVehicleDocs',
            
            'AutoLoadQuotationNo' => 'AutoLoadQuotationNo',
            'AutoLoadQuotationNo/' => 'AutoLoadQuotationNo',
            
             'GetQuotationDetails' => 'GetQuotationDetails',
            'GetQuotationDetails/' => 'GetQuotationDetails',
            
            'VehicleReservation' => 'VehicleReservation',
            'VehicleReservation/' => 'VehicleReservation',
            
             'LoadVehicleModelReservation' => 'LoadVehicleModelReservation',
            'LoadVehicleModelReservation/' => 'LoadVehicleModelReservation',
            
             'LoadVehicleModelReservationAvail' => 'LoadVehicleModelReservationAvail',
            'LoadVehicleModelReservationAvail/' => 'LoadVehicleModelReservationAvail',
            
             'VehicleMasterConfiguration' => 'VehicleMasterConfiguration',
            'VehicleMasterConfiguration/' => 'VehicleMasterConfiguration',
            
            
            'MasterConfigurationController' => 'MasterConfigurationController',
            'MasterConfigurationController/' => 'MasterConfigurationController',
            
            'LoadCategorySelect' => 'LoadCategorySelect',
            'LoadCategorySelect/' => 'LoadCategorySelect',
            
            'LoadBrandSelect' => 'LoadBrandSelect',
            'LoadBrandSelect/' => 'LoadBrandSelect',
            
            'LoadPriceModelTable' => 'LoadPriceModelTable',
            'LoadPriceModelTable/' => 'LoadPriceModelTable',
            
            'VehicleContract' => 'VehicleContract',
            'VehicleContract/' => 'VehicleContract',
            
            'VehicleContractGeneration' => 'VehicleContractGeneration',
            'VehicleContractGeneration/' => 'VehicleContractGeneration',
            
             'RegisterDrivers' => 'RegisterDrivers',
            'RegisterDrivers/' => 'RegisterDrivers',
            
            'DriverController' => 'DriverController',
            'DriverController/' => 'DriverController',
            
            'LoadDriverSelect' => 'LoadDriverSelect',
            'LoadDriverSelect/' => 'LoadDriverSelect',
            
            'CustomerLedger' => 'CustomerLedger',
            'CustomerLedger/' => 'CustomerLedger',
            
            'CustomerLedgerController' => 'CustomerLedgerController',
            'FundFlow' => 'FundFlow',
            'FundFlow/' => 'FundFlow',
            'FundFlowController' => 'FundFlowController',
            'FundFlowController/' => 'FundFlowController',
            'VehicleInsights' => 'VehicleInsights',
            'VehicleInsights/' => 'VehicleInsights',
            'ExpectedReturns' => 'ExpectedReturns',
            'ExpectedReturns/' => 'ExpectedReturns',
            'CustomerBalances' => 'CustomerBalances',
            'CustomerBalances/' => 'CustomerBalances',
            'CustomerLedgerController/' => 'CustomerLedgerController',
       

        );

        // Parse the URL
        $urlSegments = parse_url($this->url, PHP_URL_PATH);
        $urlSegments = explode('/', trim($urlSegments, '/'));

        // Reconstruct the first segment to match the defined routes
        $firstSegment = implode('/', array_slice($urlSegments, 0, 2));

        // Route based on the first segment
        if (isset($this->routes[$firstSegment])) {
            $method = $this->routes[$firstSegment];
            $this->$method($urlSegments);
        } else if (isset($this->routes[$urlSegments[0]])) {
            $method = $this->routes[$urlSegments[0]];
            array_shift($urlSegments); // Remove the route part from the params
            $this->$method($urlSegments);
        } else {

            header("HTTP/1.0 404 Not Found...!");
            echo "<p style='background-color: #7FB131; color: white;text-align: left;;font-size:20px;padding:20px; font-family: Arial, Helvetica, sans-serif;'>AA Car Request - 404 Not Found - By " . $_SERVER['SERVER_NAME'] . "</p>";
        }
    }
 
   
    private function Login(...$params)
    {
        $this->includeWithParams("view/login_page.php", $_GET);
    }
    private function LoginController(...$params)
    {
        $this->includeWithParams("controller/login/LoginController.php", $_GET);
    }
    private function Home(...$params)
    {
        $this->includeWithParams("view/index.php", $_GET);
        // $this->includeWithParams("controller/login/LoginController.php", $_GET);
        Logger::ActivityLog('PageAccesed', "controller/login/LoginController.php", ['user' => $this->login_user]);
    }
    private function GetEventLog(...$params)
    {
        $this->includeWithParams("view/get_event_log.php", $_GET);
    }
    private function GetEventLogDetails(...$params)
    {
        $this->includeWithParams("controller/logs/get_log_details.php", $_GET);
    }
    private function DeleteEventLogDetails(...$params)
    {
        $this->includeWithParams("controller/logs/delete_logs.php", $_GET);
    }
    private function UploadUserDocuments(...$params)
    {
        $this->includeWithParams("controller/clients/upload_client_document.php", $_GET);
    }
    private function UploadUserDriverDocuments(...$params)
    {
        $this->includeWithParams("controller/clients/upload_driver_documents.php", $_GET);
    }
    private function UploadRentCarImages(...$params)
    {
        $this->includeWithParams("controller/clients/upload_rent_car_images.php", $_GET);
    }
    private function UploadDocumentsCompressed(...$params)
    {
        $this->includeWithParams("controller/clients/upload_for_all_document_compressed.php", $_GET);
    }
    private function DeleteUploadDocuments(...$params)
    {
        $this->includeWithParams("controller/clients/delete_uploaded_document.php", $_GET);
    }
    private function SaveFinalBooking(...$params)
    {
        $this->includeWithParams("controller/booking/BookingController.php", $_GET);
    }
    private function SaveCustomerDetails(...$params)
    {
        $this->includeWithParams("controller/customer/CustomerController.php", $_GET);
    }
    private function SearchCustomerDetails(...$params)
    {
        $this->includeWithParams("controller/customer/SearchCustomer.php", $_GET);
    }
    private function GetCustomerDetails(...$params)
    {
        $this->includeWithParams("controller/customer/GetCustomerDetails.php", $_GET);
    }
    private function VehicleStatusController(...$params)
    {
        $this->includeWithParams("controller/VehicleStatus/VehicleStatusController.php", $_GET);
    }
    
    private function GetVehicleStatus(...$params)
    {
        $this->includeWithParams("view/vehicle_status.php", $_GET);
    }
    private function RegisterVehicles(...$params)
    {
        $this->includeWithParams("view/vehicles.php", $_GET);
    }
    private function AddUser(...$params)
    {
        $this->includeWithParams("view/users.php", $_GET);
    }
    private function InsertUser(...$params)
    {
        $this->includeWithParams("controller/users/UsersController.php", $_GET);
    }
    private function LoadRoles(...$params)
    {
        $this->includeWithParams("controller/users/UsersController.php", $_GET);
    }
    private function LoadCompanies(...$params)
    {
        $this->includeWithParams("controller/users/UsersController.php", $_GET);
    }
    private function CheckUsername(...$params)
    {
        $this->includeWithParams("controller/users/UsersController.php", $_GET);
    }
    private function UploadUserImages(...$params)
    {
        $this->includeWithParams("controller/users/UploadUserImage.php", $_GET);
    }
    private function ListOfUsers(...$params)
    {
        $this->includeWithParams("controller/users/UsersController.php", $_GET);
    }
    private function UpdateUserStatus(...$params)
    {
        $this->includeWithParams("controller/users/UsersController.php", $_GET);
    }
    private function UpdateUserInformation(...$params)
    {
        $this->includeWithParams("controller/users/UsersController.php", $_GET);
    }
    private function ResetUserPassword(...$params)
    {
        $this->includeWithParams("controller/users/UsersController.php", $_GET);
    }
    private function AddVehicles(...$params)
    {
        $this->includeWithParams("controller/vehicles/VehiclesController.php", $_GET);
    }
    private function ListOfVehicles(...$params)
    {
        $this->includeWithParams("view/vehicles_list.php", $_GET);
    }
    private function UploadVehicleImages(...$params)
    {
        $this->includeWithParams("controller/vehicles/UploadImages.php", $_GET);
    }
    private function DeleteUploadVehicleImages(...$params)
    {
        $this->includeWithParams("controller/vehicles/DeleteImages.php", $_GET);
    }
    private function FetchAllAvlVehicle(...$params)
    {
        $this->includeWithParams("controller/vehicles/VehiclesController.php", $_GET);
    }
    private function LoadVehicleByUserSellection(...$params)
    {
        $this->includeWithParams("controller/vehicles/VehiclesController.php", $_GET);
    }
    private function Quotation(...$params)
    {
        $this->includeWithParams("view/quotation.php", $_GET);
    }
    private function SaveTerms(...$params)
    {
        $this->includeWithParams("controller/quotation/save_terms.php", $_GET);
    }
     private function QuotationController(...$params)
    {
        $this->includeWithParams("controller/quotation/quotation_controller.php", $_GET);
    }
     private function GetQtnIntroduction(...$params)
    {
        $this->includeWithParams("controller/quotation/get_introduction.php", $_GET);
    }
    
    private function GetTerms(...$params)
    {
        $this->includeWithParams("controller/quotation/get_terms.php", $_GET);
    }
    private function GetItemList(...$params)
    {
        $this->includeWithParams("controller/quotation/get_items_list.php", $_GET);
    }
    private function GetAllTermsAndConditions(...$params)
    {
        $this->includeWithParams("controller/quotation/fetch_terms.php", $_GET);
    }
    private function DeleteTerms(...$params)
    {
        $this->includeWithParams("controller/quotation/delete_terms.php", $_GET);
    }
    private function getVehicleDetails(...$params)
    {
        $this->includeWithParams("controller/quotation/get_vehicle_details.php", $_GET);
    }
    private function getRentalOptions(...$params)
    {
        $this->includeWithParams("controller/quotation/get_rental_options.php", $_GET);
    }
    private function logOut(...$params)
    {
        $this->includeWithParams("view/logout.php", $_GET);
    }
    
    private function OtherEventController(...$params)
    {
        $this->includeWithParams("controller/login/OtherEventController.php", $_GET);
    }
    private function TestPage(...$params)
    {
        $this->includeWithParams("view/login_test.php", $_GET);
    }

    private function LoadCategoryController(...$params)
    {
        $this->includeWithParams("controller/VehicleStatus/load_category.php", $_GET);
    }
    
    private function LoadModelSelect(...$params)
    {
        $this->includeWithParams("controller/vehicles/LoadVehicleModelSelect.php", $_GET);
    }

    private function VehicleStatusJsonController(...$params)
    {
        $this->includeWithParams("controller/VehicleStatus/VehicleStatusJsonController.php", $_GET);
    } 
    
    private function UploadVehicleDocs(...$params)
    {
        $this->includeWithParams("controller/VehicleStatus/UploadVehicleDocs.php", $_GET);
    }
    
    private function AutoLoadQuotationNo(...$params)
    {
        $this->includeWithParams("controller/VehicleStatus/getQuotationNumber.php", $_GET);
    }
    
    private function GetQuotationDetails(...$params)
    {
        $this->includeWithParams("controller/VehicleStatus/getQuotationDetails.php", $_GET);
    }
    private function VehicleReservation(...$params)
    {
        $this->includeWithParams("view/vehicle_reservation_quotation.php", $_GET);
    }
     private function LoadVehicleModelReservation(...$params)
    {
        $this->includeWithParams("controller/VehicleStatus/getVehicleModels.php", $_GET);
    }
     private function LoadVehicleModelReservationAvail(...$params)
    {
        $this->includeWithParams("controller/VehicleStatus/getVehicelModelsAvail.php", $_GET);
    }
    private function VehicleMasterConfiguration(...$params)
    {
        $this->includeWithParams("view/vehicle_master_configuration.php", $_GET);
    }
     private function MasterConfigurationController(...$params)
    {
        $this->includeWithParams("controller/MasterConfiguration/MasetrConfigurationController.php", $_GET);
    }
     private function LoadCategorySelect(...$params)
    {
        $this->includeWithParams("controller/MasterConfiguration/LoadVehicleCategorySelect.php", $_GET);
    }
     private function LoadBrandSelect(...$params)
    {
        $this->includeWithParams("controller/MasterConfiguration/LoadVehicleBrandSelect.php", $_GET);
    }
     private function LoadPriceModelTable(...$params)
    {
        $this->includeWithParams("controller/MasterConfiguration/LoadPriceModelTable.php", $_GET);
    }
     private function VehicleContract(...$params)
    {
        $this->includeWithParams("view/VehicleContractGeneration.php", $_GET);
    }
     private function VehicleContractGeneration(...$params)
    {
        $this->includeWithParams("controller/VehicleContractGeneration/vehicleContractController.php", $_GET);
    }
     private function RegisterDrivers(...$params)
    {
        $this->includeWithParams("view/driver_register.php", $_GET);
    }
      private function DriverController(...$params)
    {
        $this->includeWithParams("controller/drivers/DriverController.php", $_GET);
    }
      private function LoadDriverSelect(...$params)
    {
        $this->includeWithParams("controller/VehicleContractGeneration/loadDriverSelect.php", $_GET);
    }
    private function CustomerLedger(...$params)
    {
        $this->includeWithParams("view/customer_ledger.php", $_GET);
    }
    private function CustomerLedgerController(...$params)
    {
        $this->includeWithParams("controller/ledger/CustomerLedgerController.php", $_GET);
    }
    private function FundFlow(...$params)
    {
        $this->includeWithParams("view/fund_flow.php", $_GET);
    }
    private function FundFlowController(...$params)
    {
        $this->includeWithParams("controller/reports/FundFlowController.php", $_GET);
    }
    public function VehicleInsights() {
        require 'controller/reports/VehicleInsightController.php';
    }

    public function ExpectedReturns() {
        require 'controller/reports/ExpectedReturnController.php';
    }

    public function CustomerBalances() {
        require 'controller/reports/CustomerBalanceController.php';
    }
    private function includeWithParams($file, $params)
    {
        if (is_array($params)) {
            extract($params);
        }
        include($file);
    }
    public function generateUrl($route, $params = [])
    {

        $url = "/$route?";
        $query = [];
        foreach ($params as $key => $value) {
            $encryptedValue = $this->encryption->encrypt($value);
            $query[] = "$key=" . urlencode($encryptedValue);
        }
        $url .= implode('&', $query);
        return $url;
    }
}

$obj = new RoutingClass();
