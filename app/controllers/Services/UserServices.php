<?php 
namespace App\Controllers\Services;

use App;
use App\Models\User as User;
use App\Models\Gallery as Gallery;
use App\Helpers\Log as Log;
use App\Helpers\Helper as Helper;
// use App\Http\Request as Request;
use App\Http\Response as Response;
use App\Models\Repository\UserRepository as UserRepository;
use App\Models\Repository\GalleryRepository as GalleryRepository;

class UserServices {
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
        // $this->request = new Request();
        $this->response = new Response();
        $this->user = new UserRepository();
        $this->image = new GalleryRepository();
    }

    public function index()
    {
        $data = $this->user->index();

        if (!empty($data)) {
            $user = $this->response->sendWithCode(true, 200,'success', $data);
            
        } else {
            $user = $this->response->sendWithCode(false, 400,'no result found', $data);
        }
        return $this->response->responses($user);
    }

    public function login()
    {
        $email = $this->request->post('email');
        $password = $this->request->post('password');

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

                $user = $this->response->sendWithCode(true, 200,'Login successfully!', $data);

            } else {
                $user = $this->response->sendWithCode(false, 500,'Incorrect Email or Password, please try again.', null);
            }
            return $this->response->responses($user);
        }
    }

    public function createUser()
    {
        $input =  new User();

        $input->setFullName($this->request->post('full_name'));
        $input->setEmail($this->request->post('email'));
        $input->setPassword($this->request->post('password'));
        $input->setGender($this->request->post('gender'));
        $input->setAvatar($this->request->post('avatar'));
        $input->setCreatedAt(date('Y-m-d H:i:s'));
        $input->setUpdatedAt(date('Y-m-d H:i:s'));

        $data = $this->user->create($input);

        if ($data) {
            $user = $this->response->sendWithCode(true, 201,'Created successfully.', $data);
        } else {
            $user = $this->response->sendWithCode(false, 500,'Users could not be created.', null);
        }
        return $this->response->responses($user);
    }

    public function getUser($id)
    {
        $data = $this->user->getUser($id);

        if (!empty($data)) {
            $user = $this->response->sendWithCode(true, 200,'success', $data);
            
        } else {
            $user = $this->response->sendWithCode(false, 400,'no result found', null);
        }
        return $this->response->responses($user);
    }
    
    public function updateUser($id)
    {
        $input =  new User();
        $oldData = $this->user->get($id);

        if (empty($oldData)) {
            $user = $this->response->sendWithCode(false, 404,'not found', null);
        } else {
            $input->setFullName($this->request->post('full_name'));
            $input->setEmail($this->request->post('email'));
            $input->setGender($this->request->post('gender'));
            $input->setAvatar($this->request->post('avatar'));
            $input->setUpdatedAt(date('Y-m-d H:i:s'));
            $input->setId($id);

            $data = $this->user->update($input);

            if ($data) {
                $user = $this->response->sendWithCode(true, 200,'updated successfully.', $data);
            } else {
                $user = $this->response->sendWithCode(false, 500,'updated failed.', $oldData);
            }
        }

        return $this->response->responses($user);
    }

    public function deleteUser($id)
    {
        $oldData = $this->user->get($id);

        if (empty($oldData)) {
            $user = $this->response->sendWithCode(false, 404,'not found', null);
        } else {
            $this->user->delete($id);
            $user = $this->response->sendWithCode(true, 200,'delete successfully.',null);
        }
        return $this->response->responses($user);   
    }

    public function changeUserPassword($id)
    {   
        $input = new User();
        $oldData = $this->user->get($id);

        if (empty($oldData)) {  
            $user = $this->response->sendWithCode(false, 404,'not found', null);
        } else {
            $dataPassword = $oldData['password'];
            $currentPassword = $this->request->post('current_password');
            $changePassword = $this->request->post('change_password');

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
                        $user = $this->response->sendWithCode(true, 200,'password changed successfully.', $data);

                    } else {
                        $user = $this->response->sendWithCode(false, 500,'password can not changed.',null);
                    }
                } else {
                    $user = $this->response->sendWithCode(false, 500,'your current password does not matched.',null);
                }
            } else {
                $user = $this->response->sendWithCode(false, 500,'password can not changed.',null);
            }
        }

        return $this->response->responses($user);
    }

    public function upload()
    {
        $input = new Gallery();
        $targetDir = 'public/uploads/';
        $targetFile = Helper::cleanUrl($targetDir.basename($_FILES["fileToUpload"]["name"]));
        $fileName = $_FILES['fileToUpload']['name'];
        $filePath = $_FILES['fileToUpload']['tmp_name'];
        $fileSize = $_FILES['fileToUpload']['size'];
        $error = [];
        $imageUrl = Helper::cleanUrl(App::getConfig()['basePath'].$targetFile);

        if (empty($fileName)) {
            $error[] = 'please select an images';
        } else {
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $extension = ['jpg', 'png', 'gif', 'jpeg','gif'];

            if (in_array($fileExt, $extension)) {
                if (!file_exists($targetDir.$fileName)) {
                    if ($fileSize < 5000000) {
                        move_uploaded_file($filePath, $targetFile);
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
            $user = $this->response->sendWithCode(true, 200,'success', $data);
        } else {
            $user = $this->response->sendWithCode(false, 500, $error[0], null);
        }
        
        return $this->response->responses($user);   
    }
}