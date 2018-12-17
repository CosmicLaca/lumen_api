<?php
/**
 * Created by PhpStorm.
 * User: Laca
 * Date: 18/12/14
 * Time: 15:32
 */


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\ApiResponses;

class ApiController extends Controller
{

    private $APIAction;
    private $ContentType;
    private $DeviceBody;
    private $DeviceHeader;
    private $APIError = FALSE;
    private $ReturnData = NULL;
    private $RequestMethod = NULL;

    function __construct(Request $request)
    {
        $this->RequestMethod = Input::method();
        if ($this->RequestMethod == 'POST') {
            $this->ContentType = $request->getContentType();
            $this->DeviceHeader = $request->headers->all();
            $ClassMethods = get_class_methods($this);

            if (!empty($request->all())) {
                $this->DeviceBody = $request->all();
            } else {
                $this->APIError = self::sendResponse('Valid json data required on body.', 205, FALSE);
            }

            if ($this->ContentType != 'json') {
                $this->APIError = self::sendResponse('Content type must be application/json', 204, FALSE);
            }

            if (!in_array($request->header('X-Action'), $ClassMethods)) {
                $this->APIError = self::sendResponse('Invalid action, no controller class available', 206, FALSE);
            } else {
                $this->APIAction = $request->header('X-Action');
            }

            if (!empty($request->header('X-Action'))) {
                $this->APIAction = $request->header('X-Action');
            } else {
                $this->APIError = self::sendResponse('X-Action required on header.', 202, FALSE);
            }

        } else {
            $this->APIError = self::sendResponse('Invalid API call.', 203, FALSE);
        }
    }

    /**
     * Handle all POST rerquests
     * @return \Illuminate\Http\JsonResponse
     */
    public function post()
    {
        if ($this->APIError) {
            return response()->json($this->APIError);
        } else {
            $ActionName = $this->APIAction;
            return response()->json(self::$ActionName());
        }
    }

    /**
     * Test action only...
     * @return array
     */
    public function testaction()
    {
        $this->ReturnData = $this->DeviceBody;
        return self::sendResponse();
    }

    /*
     * Example JSON input:
     {
        "tablename": "products"
     }
     */
    /**
     * Get table content for test
     * @return array
     */
    public function tabletest()
    {
        $responseModel = new ApiResponses();
        $RequiredData = array("tablename");
        if (($responseModel->DataCheck($this->DeviceBody, $RequiredData)) == TRUE) {
            $this->ReturnData = $responseModel->getTableContent($this->DeviceBody['tablename']);
            return self::sendResponse();
        } else {
            return self::sendResponse('Invalid API call, required key(s) missing from body: ' . implode(';', $RequiredData), 207, FALSE);
        }
    }

    /*
     * Example JSON input:
     {
        "tablename": "products",
        "data":
        {
            "name":"új termék",
            "price": 14,
            "currency":"EU"
        }
     }
     */
    /**
     * Add new data to any table
     * @return array
     */
    public function addnewdata()
    {
        $responseModel = new ApiResponses();
        $RequiredData = array("tablename", "data");
        if (($responseModel->DataCheck($this->DeviceBody, $RequiredData)) == TRUE) {
            $this->ReturnData = $responseModel->addTableContent($this->DeviceBody);
            if ($this->ReturnData === TRUE) {
                return self::sendResponse();
            } else {
                return self::sendResponse($this->ReturnData, 210, FALSE);
            }
        } else {
            return self::sendResponse('Invalid API call, required key(s) missing from body: ' . implode(';', $RequiredData), 207, FALSE);
        }
    }

    /*
     * Example JSON input:
     {
	    "user_id": 1
     }
}    */
    /**
     * Get user cart content by valid user ID
     * @return array
     */
    public function getusercart()
    {
        $responseModel = new ApiResponses();
        $RequiredData = array("user_id");
        if (($responseModel->DataCheck($this->DeviceBody, $RequiredData)) == TRUE) {
            $this->ReturnData = $responseModel->getUserCart($this->DeviceBody);
            if (is_object($this->ReturnData)) {
                return self::sendResponse();
            } else {
                return self::sendResponse($this->ReturnData, 209, FALSE);
            }
        } else {
            return self::sendResponse('Invalid API call, required key(s) missing from body: ' . implode(';', $RequiredData), 207, FALSE);
        }
    }

    /*
     * Example JSON input:
     {
        "user_id": 1,
        "product_id": 1,
        "quantity": 5
     }
     */
    /**
     * Add product to user's cart
     * @return array
     */
    public function setusercart()
    {
        $responseModel = new ApiResponses();
        $RequiredData = array("user_id", "product_id", "quantity");
        if (($responseModel->DataCheck($this->DeviceBody, $RequiredData)) == TRUE) {
            $this->ReturnData = $responseModel->setUserCart($this->DeviceBody);
            if ($this->ReturnData === TRUE) {
                return self::sendResponse();
            } else {
                return self::sendResponse($this->ReturnData, 208, FALSE);
            }
        } else {
            return self::sendResponse('Invalid API call, required key(s) missing from body: ' . implode(';', $RequiredData), 207, FALSE);
        }
    }

    /**
     * Handle all responses
     * @param string $Reason
     * @param int $Status
     * @param bool $Success
     * @return array
     */
    public function sendResponse($Reason = 'Success', $Status = 200, $Success = TRUE)
    {
        return ['ReturnData' => $this->ReturnData,
                'Response' => [
                               'Message' => $Reason,
                               'Status' => $Status,
                               'Method' => $this->RequestMethod,
                               'Success' => $Success
                              ],
                'Sent' => [
                           'Body' => $this->DeviceBody,
                           'Header' => $this->DeviceHeader
                          ]
               ];
    }

    /**
     * Send error if using GET instead of POST
     * @return \Illuminate\Http\JsonResponse
     */
    public function get()
    {
        return response()->json(self::sendResponse('Post method allowed only.', 201, FALSE));
    }
}