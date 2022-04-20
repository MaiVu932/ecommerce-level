<?php

    include 'BaseRepository.php';
    class AccuseRepository extends BaseRepository
    {    
        public function UpLoadFile($data)
        {
            $UploadErr = [];
            if(!isset($_FILES['file'])){
                $UploadErr['exitFile'] = 'Không tệp nào được chọn';
            }
            $file_name = $_FILES['file']['name'];
            $temp_name = $_FILES['file']['tmp_name'];
            $file_size = $_FILES['file']['size'];
            $type = explode('/', $_FILES['file']['type']);
            $extension = end($type);
            $allowed = ['png', 'jpg', 'jpeg'];

            if(!in_array($extension, $allowed)){
                $UploadErr = 'File phải có đuôi định dạng PNG, JPG, JPEG';
            }
            if($file_size <= 500000){

                $UploadErr = 'Dung lượng file quá lớn !';

            }
            $path = '../../public/images/ac/' . $data . '.' . $extension;
            $is_upload = move_uploaded_file($temp_name, $path );

            if(!$is_upload){
                $UploadErr['stageFile'] = 'Thêm tệp thất bại!';
            }
            return ['extension' => $extension];
        }
        public function accuse(array $data)
        {
            $isCreatorName = trim($data['creatorN']);
            $isAccusedName = trim($data['accusedN']);
            $isNote = trim($data['message']);
            $image = $isCreatorName . '.' . $this->UpLoadFile($isCreatorName)['extension'];
            
            if($isNote) {
                $accuse = [
                    'creator_name' => $isCreatorName,
                    'accused_name' => $isAccusedName,
                    'note' => $isNote,
                    'fileN' => $image,
                    ];

                $this->insert('accuse', $accuse);
                echo '<script>alert("Đăng tải đơn khếu nại thành công, vui lòng chờ duyệt !")</script>';
                return $accuse;
            }
        }
    }
?>