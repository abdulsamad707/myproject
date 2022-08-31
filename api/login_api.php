<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
header('Content-Type:appliction/json');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include ("function.php");
include ("validkey.php");
include ('./vendor/autoload.php');
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
ob_start();

if (!isset($status))
{
    $message = "";
    $actionStatus = "";
    $actionStatusText = "";
    $actionStatusTextSymbol = "";
    $userdata = file_get_contents("php://input");
    $userdata = json_decode($userdata, true);
    extract($userdata);
    if ($email == "")
    {
        $message = "Please Provide Email";
        $actionStatus = 0;
        $actionStatusText = "error";
        $actionStatusTextSymbol = "Oops! SomeThing Wrong";
        $response_array['message'] = $message;
        /*$response_array['JWT_TOKN']=$token;*/
        $response_array['action_status'] = $actionStatus;
        $response_array['actionStatusText'] = $actionStatusText;
        $response_array['actionStatusTextSymbol'] = $actionStatusTextSymbol;
        echo json_encode($response_array);
        return false;
    }
    if ($password == "")
    {
        $message = "Please Provide Password";
        $actionStatus = 0;
        $actionStatusTextSymbol = "Oops! SomeThing Wrong";
        $response_array['message'] = $message;
        /*$response_array['JWT_TOKN']=$token;*/
        $response_array['action_status'] = $actionStatus;
        $actionStatusText = "error";
        $response_array['actionStatusText'] = $actionStatusText;
        $response_array['actionStatusTextSymbol'] = $actionStatusTextSymbol;
        echo json_encode($response_array);
        return false;
    }
    $checkData = ['email' => "'$email'"];

    $userdat = $data->getData('users', ['id', 'password', 'username', 'mobile', 'status', 'verified', 'mobile_verify'], null, $checkData, null, null, " OR ");

    $totalRecord = $userdat["totalRecord"];
    if ($totalRecord > 0)
    {
        $iss = "localhost";

        $id = $userdat['data'][0]['id'];
        $customerusername = $userdat['data'][0]['username'];
        $customermobile = $userdat['data'][0]['mobile'];
        $customerdbpass = $userdat['data'][0]['password'];
        $customerstatus = $userdat['data'][0]['status'];
        $customerverified = $userdat['data'][0]['verified'];
        $customerverifiedmobile = $userdat['data'][0]['mobile_verify'];
       /*Check Password */
        if (password_verify($password, $customerdbpass))
        {
             /*Check status */
            if ($customerstatus == 1)
            {

                if ($customerverified == 1)
                {
                    $key = 'example_key';
                    $payload = ['iss' => 'localhost', 'aud' => 'localhost', 'iat' => time() , 'nbf' => time() - 30, 'exp' => time() + 60 * 60 * 60, 'data' => array(
                        'id' => $id,
                        'email' => $email,
                        'customerusername' => $customerusername,
                        'mobile' => $customermobile
                    ) ];

                    $key = "owt125";

                    $_SESSION["USER_ID"]=$id;
                    $token=
                    setCookie('token', $token, time() + 60 * 60 * 13);
                    $ip_add = get_client_ip();
                    $usershasitemsql = "Select qty,id FROM carts WHERE ip_add='$ip_add' OR  customerID ='$id'";
                    $usershasitemsqldata = $data->sql($usershasitemsql, "read");
                    $totalRecordCart = $usershasitemsqldata['totalRecord'];

                    if ($totalRecordCart > 0)
                    {
                        $sql_update = "UPDATE carts SET customerID ='$id' WHERE ip_add='$ip_add' ";
                        $data->sql($sql_update, 'update');
                    }

                    $message = "User Login Successfully";
                    $actionStatusTextSymbol = "Congratulatons";
                    $actionStatusText = "success";
                    $actionStatus = 1;
                    $jwtToken = $token;
                    $token;
                }
                else
                {
                    $message = "Account is Not Verified";
                    $actionStatus = 0;
                    $jwtToken = "";
                    $actionStatusTextSymbol = "Oops! SomeThing Wrong";
                    $actionStatusText = "error";

                }
            }
            else
            {
                $jwtToken = "";
                $message = "User Is Blocked By Admin";
                $actionStatusTextSymbol = "Oops ";
                $actionStatus = 0;
                $actionStatusText = "success";
            }
        }
        else
        {
            $message = "Wrong Password";
            $actionStatus = 0;
            $actionStatusTextSymbol = "Oop! Something Went Wrong ";
            $jwtToken = "";
            $id = 0;
            $actionStatusText = "error";
        }

    }
    else
    {
        $message = "Email Is Not Register";
        $actionStatus = 0;
        $jwtToken = "";
        $id = 0;
        $actionStatusText = "error";
        $actionStatusTextSymbol = "Oops! SomeThing Went Wrong ";
    }
    $response_array['message'] = $message;
    $response_array['actionStatusText'] = $actionStatusText;
    $response_array['JWT_TOKN'] = $jwtToken;
    $response_array['action_status'] = $actionStatus;
    $response_array['actionStatusTextSymbol'] = $actionStatusTextSymbol;
    echo json_encode($response_array);

}

?>