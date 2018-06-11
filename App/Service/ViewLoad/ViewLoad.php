<?php

namespace App\Service\ViewLoad;

class ViewLoad {

    /*
     * Load view with parameter if exist
     * If $data exist used on view with $send[]
     *
     * @param $path string => URL of view
     * @param $data mixed
     */
    public function load_view($path, $data = null) {
        if ($data != null) {
            foreach ($data as $key => $value) {
                $send[$key] = $value;
            }
        }
        require_once ($path);
    }

}


?>