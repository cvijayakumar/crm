<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common {

    public function __construct() {
        $this->ci = & get_instance();
    }

    public function file_upload($directory, $fieldname, $filename) {
        $config['upload_path'] = realpath($directory);
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        // $config['max_size'] = '100';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        //$config['overwrite'] = TRUE;


        $this->ci->load->library('upload', $config);

        if (!$this->ci->upload->do_upload($fieldname)) {
            $error = array('error' => $this->ci->upload->display_errors());
            return $error;
        } else {
            $data = array('upload_data' => $this->ci->upload->data());
            return $data;
        }
    }

    public function is_assoc_array_empty($array) {

        if (is_array($array) && count($array) > 0) {
            foreach ($array as $key => $value) {
                if (empty($value)) {
                    return FALSE;
                }
            }
        } else {
            if (empty($array))
                return FALSE;
        }

        return TRUE;
    }

    public function is_assoc_array_not_mandatory($array) {
        $result = FALSE;
        if (is_array($array) && count($array) > 0) {
            foreach ($array as $key => $value) {
                if (!empty($value)) {
                    $result = TRUE;
                }
            }
        }

        return $result;
    }

    private function getURL($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $tmp = curl_exec($ch);
        curl_close($ch);
        if ($tmp != false) {
            return $tmp;
        }
    }

    public function getCoordinates($address, $apiKey) {
        $address = str_replace(' ', '+', $address);
        $url = 'http://maps.google.com/maps/geo?q=' . $address . '&output=xml&key=' . $apiKey;
        $data = $this->getURL($url);
        if ($data) {
            $xml = new SimpleXMLElement($data);
            $requestCode = $xml->Response->Status->code;
            if ($requestCode == 200) {
                //all is ok
                $coords = $xml->Response->Placemark->Point->coordinates;
                $coords = explode(',', $coords);
                if (count($coords) > 1) {
                    if (count($coords) == 3) {
                        return array('lat' => $coords[1], 'long' => $coords[0], 'alt' => $coords[2]);
                    } else {
                        return array('lat' => $coords[1], 'long' => $coords[0], 'alt' => 0);
                    }
                }
            }
        }
        return array('lat' => 0, 'long' => 0, 'alt' => 0);
    }

    public function get_domain($url) {
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : '';
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            return $regs['domain'];
        }
        return false;
    }

    public function formatTree($tree, $parent) {
        $tree2 = array();
        foreach ($tree as $i => $item) {
            if ($item['parent_id'] == $parent) {
                $tree2[$item['id']] = $item;
                $tree2[$item['id']]['submenu'] = $this->formatTree($tree, $item['id']);
            }
        }
        return $tree2;
    }

}

/* End of file Common.php */
