<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\M3Result;
use App\Tool\UUID;
use Illuminate\Http\Request;

class UploadController extends Controller {

    /**
     * upload
     * @param Request $request
     * @param $type
     * @return string
     */
    public function uploadFile(Request $request, $type) {
        $width = $request->input('width', '');
        $height = $request->input('height', '');
        $m3_result = new M3Result();

        if ($_FILES["file"]["error"]) {
            $m3_result->status = 2;
            $m3_result->message = "Unknown error: " . $_FILES["file"]["error"];
            return $m3_result->toJson();
        }

        $file_size = $_FILES['file']['size'];
        if ($file_size > 1024 * 1024) {
            $m3_result->status = 2;
            $m3_result->message = "Max image size is 1M";
            return $m3_result->toJson();
        }
        $public_dir = sprintf('/upload/%s/%s/', $type, date('Ymd'));
        $upload_dir = public_path() . $public_dir;
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        //file type
        $arr_ext = explode('.', $_FILES['file']['name']);
        //last var
        $file_ext = count($arr_ext) > 1 && strlen(end($arr_ext)) ? end($arr_ext) : "unknow";
        //generate upload file name
        $upload_filename = UUID::create();

        $upload_file_path = $upload_dir . $upload_filename . '.' . $file_ext;
        if (strlen($width) > 0) {
            $public_uri = $upload_dir . $upload_filename . '.' . $file_ext;
            $m3_result->status = 0;
            $m3_result->message = "Upload success.";
            $m3_result->uri = $public_uri;
        } else {
            //from temp to long dir
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $upload_file_path)) {
                $public_uri = $public_dir . $upload_filename . '.' . $file_ext;
                $m3_result->status = 0;
                $m3_result->message = "upload success";
                $m3_result->uri = $public_uri;
            } else {
                $m3_result->status = 1;
                $m3_result->message = "Upload failded. Access denide.";
            }
        }
        return $m3_result->toJson();
    }

}
