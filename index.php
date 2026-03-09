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
// include('model/db_connection/connection.php');

class RoutingClass
{
    public $encryption, $pdoConnection, $login_user;
    private $key, $base_url; // Ensure this key is 32 bytes for AES-256

    public function __construct()
    {
        // Check if the request is from the correct domain
        $_SESSION['LOGIN_USERNAME'] = 'NO USER';
        $allowedDomain = 'aacar.sandslab.com';
        $currentDomain = $_SERVER['HTTP_HOST'];
        $this->login_user = $_SESSION['LOGIN_USERNAME'];
        $this->key = $_ENV['ENCRIPTION_KEY'];
        $this->base_url = $_ENV['BASE_URL'];
        if ($currentDomain !== $allowedDomain) {
            header("HTTP/1.0 404 Not Found!");
            echo "<p style='background-color: #7FB131; color: white;text-align: left;;font-size:20px;padding:20px; font-family: Arial, Helvetica, sans-serif;'>SIAN WORLD - 404 Not Found - By " . $_SERVER['SERVER_NAME'] . "</p>";
            exit();
        }

        // Initialize encryption class
        $this->encryption = new UrlEncryption($this->key);


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

            'getRentalOptions' => 'getRentalOptions',
            'getRentalOptions/' => 'getRentalOptions',

            'AddUser' => 'AddUser',
            'AddUser/' => 'AddUser',
			
			'PushToServer' => 'PushToServer',
            'PushToServer/' => 'PushToServer'



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
            echo "<p style='background-color: #7FB131; color: white;text-align: left;;font-size:20px;padding:20px; font-family: Arial, Helvetica, sans-serif;'>WhatsAppAPI Request - 404 Not Found - By " . $_SERVER['SERVER_NAME'] . "</p>";
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
    private function RegisterVehicles(...$params)
    {
        $this->includeWithParams("view/vehicles.php", $_GET);
    }
    private function AddUser(...$params)
    {
        $this->includeWithParams("view/users.php", $_GET);
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
	private function PushToServer(...$params)
    {
        $this->includeWithParams("webhook.php", $_GET);
    }




    private function includeWithParams($file, $params)
    {
        foreach ($params as $key => $value) {
            $key = $value;
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
