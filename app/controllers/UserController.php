<?php

namespace App\Controllers;

use App;
use App\Core\Controller;
use App\Models\User as User;
use App\Models\Gallery as Gallery;
use App\Helpers\Log as Log;
use App\Models\Repository\UserRepository as UserRepository;
use App\Models\Repository\GalleryRepository as GalleryRepository;
use PHP_CodeSniffer\Generators\HTML;

class UserController extends Controller
{   
    /**
     * declare user variables
     * @param string
     * @return UserRepository
     */
    protected $user;

    /**
     * declare gallery variables
     * @param string
     * @return GalleryRepository
     */
    protected $image;

    public function __construct()
    {   
        $this->user = new UserRepository();
        $this->image = new GalleryRepository();
        header('Content-type: application/json');
    }

    // public function handlePage($page)
    // {
    //     echo $page;
    // }

    public function index()
    {
        $data = $this->user->index();

        if (!empty($data)) {
            http_response_code(200);
            header('Content-type: application/json');
            echo json_encode(
                [
                    "success" => true,
                    "message" => "success",
                    "code" => 200,
                    "data" => $data
            ]
            );
        } else {
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => "not found",
                    "code" => 404,
                    "data" => null
            ]
            );
        }
    }

    public function login()
    {

        $email = htmlentities($_POST['email']);
        $password = htmlentities($_POST['password']);

        $validator = $this->user->login($email);
        if (!empty($validator)) {
            if(password_verify($password, $validator['password'])) {
                $data =[
                    'full_name' => $validator['full_name'],
                    'email' => $validator['email'],
                    'gender' => $validator['gender'],
                    'avatar ' => $validator['avatar'],
                    'created_at' => $validator['created_at'],
                    'updated_at' => $validator['updated_at'],
                ];
                http_response_code(200);
                header('Content-type: application/json');
                echo json_encode(
                    [
                        "success" => true,
                        "message" => "Login successfully.",
                        "code" => 200,
                        "data" => $data
                ]
                );
            } else {
                http_response_code(500);
                echo json_encode(
                    [   "success" => false,
                        "message" => "Incorrect Email or Password, please try again.",
                        "code" => 500,
                        "data" => null
                ]
                );
            }
        }
    }

    public function createUser()
    {
        $input =  new User();

        $input->setFullName(htmlentities($_POST['full_name']));
        $input->setEmail(htmlentities($_POST['email']));
        $input->setPassword(htmlentities(($_POST['password'])));
        $input->setGender(htmlentities($_POST['gender']));
        $input->setAvatar(htmlentities($_POST['avatar']));
        $input->setCreatedAt(date('Y-m-d H:i:s'));
        $input->setUpdatedAt(date('Y-m-d H:i:s'));

        $data = $this->user->create($input);

        if ($data) {
            http_response_code(201);
            echo json_encode(
                [   "success" => true,
                    "message" => "Created successfully.",
                    "code" => 201,
                    "data" => $data
            ]
            );
        } else {
            http_response_code(500);
            return json_encode([
                "success" => false,
                "message" => "Users could not be created.",
                "code" => 500,
                "data" => $data
            ]);
        }
    }

    public function getUser($id)
    {
        $data = $this->user->getUser($id);

        if (empty($data)) {
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => "not found",
                    "code" => 404,
                    "data" => null
            ]
            );
        } else {
            http_response_code(200);
            echo json_encode(
                [   "success" => true,
                    "message" => "success",
                    "code" => 200,
                    "data" => $data
            ]
            );
        }
    }

    public function updateUser($id)
    {
        $input =  new User();
        $oldData = $this->user->get($id);

        if (empty($oldData)) {
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => "not found",
                    "code" => 404,
                    "data" => null
            ]
            );
        } else {
            $input->setFullName(htmlentities($_POST['full_name']));
            $input->setEmail(htmlentities($_POST['email']));
            $input->setGender(htmlentities($_POST['gender']));
            $input->setAvatar(htmlentities($_POST['avatar']));
            $input->setUpdatedAt(date('Y-m-d H:i:s'));
            $input->setId($id);

            $data = $this->user->update($input);

            if ($data) {
                http_response_code(200);
                echo json_encode(
                    [   "success" => true,
                        "message" => "updated successfully.",
                        "code" => 200,
                        "data" => $data
                ]
                );
            } else {
                http_response_code(500);
                echo json_encode(
                    [   "success" => false,
                        "message" => "users can not updated.",
                        "code" => 500,
                        "data" => null
                ]
                );
            }
        }
    }

    public function deleteUser($id)
    {
        $oldData = $this->user->get($id);

        if (empty($oldData)) {
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => "not found",
                    "code" => 404,
                    "data" => null
            ]
            );
        } else {
            $this->user->delete($id);
            http_response_code(200);
            echo json_encode(
                [   "success" => true,
                    "message" => "success",
                    "code" => 200,
                    "data" => null
            ]
            );
        }
    }

    public function changeUserPassword($id)
    {   
        $input = new User();
        $oldData = $this->user->get($id);

        if (empty($oldData)) {
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => "not found",
                    "code" => 404,
                    "data" => null
            ]);
        } else {
            $dataPassword = $oldData['password'];
            $currentPassword = htmlentities($_POST['current_password']);
            $changePassword = htmlentities($_POST['change_password']);
            if(isset($currentPassword)){
                if(password_verify($currentPassword,$dataPassword)){
                    $password = password_hash($changePassword, PASSWORD_DEFAULT);

                    $input->setId($id);
                    $input->setPassword($password);
                    $input->setUpdatedAt(date('Y-m-d H:i:s'));

                    $userData = $this->user->changePassword($input);
                    if ($userData) {
                        $data = [
                            'id' => $userData['id'],
                            'full_name' => $userData['full_name'],
                            'email' => $userData['email'],
                            'gender' => $userData['gender']
                        ];
                        http_response_code(200);
                        echo json_encode(
                            [   "success" => true,
                                "message" => "password changed successfully.",
                                "code" => 200,
                                "data" => $data
                            ]);
                    } else {
                            http_response_code(500);
                            echo json_encode(
                                [   "success" => false,
                                    "message" => "password can not changed.",
                                    "code" => 500,
                                    "data" => null
                            ]);
                    }
                }   else {
                    http_response_code(500);
                    echo json_encode(
                        [   "success" => false,
                            "message" => "your current password does not matched.",
                            "code" => 500,
                            "data" => null
                    ]);
                }
            } else {
                http_response_code(500);
                echo json_encode(
                    [   "success" => false,
                        "message" => "password can not changed.",
                        "code" => 500,
                        "data" => null
                ]);
            }
        }
    }


    public function upload()
    {
        $input = new Gallery();
        $targetDir = 'public/uploads';
        $targetFile = $targetDir.basename($_FILES["fileToUpload"]["name"]);
        // declare
        $fileName = $_FILES['fileToUpload']['name'];
        $filePath = $_FILES['fileToUpload']['tmp_name'];
        $fileSize = $_FILES['fileToUpload']['size'];
        $error = [];
        $imageUrl = App::getConfig()['basePath'].$targetFile;
        if (empty($fileName)) {
            $error[] = 'please select an images';
        } else {
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            //extension
            $extension = ['jpg', 'png', 'gif', 'jpeg','gif'];

            if (in_array($fileExt, $extension)) {
                if (!file_exists($targetDir.$fileName)) {
                    if ($fileSize < 5000000) {
                        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile);
                    } else {
                        $error[] = 'Sorry your file is too large';
                        Log::logError($error[0]);
                    }
                } else {
                    $error[] = 'Sorry, file already exists check upload folder';
                    Log::logError($error[0]);
                }
            } else {
                $error[] = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed';
                Log::logError($error[0]);
            }
        }

        if (empty($error)) {
            $data = [];
            $input->setName($fileName);
            $input->setPath($imageUrl);
            $images = $this->image->upload($input);
            if($images){
                $data = [
                    'name' => $fileName,
                    'path' => $imageUrl
                ];
            }
            
            http_response_code(200);
            echo json_encode(
                [   "success" => true,
                    "message" => 'success',
                    "code" => 200,
                    "data" => $data
            ]
            );
        } else {
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => $error[0],
                    "code" => 404,
                    "data" => null
            ]
            );
        }
    }
}
