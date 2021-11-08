<?php
if (!function_exists('csvReaderHelper')) {
    function csvReaderHelper($csvFilePublicLocation)
    {
        $csvFile = public_path($csvFilePublicLocation);

        $file_handle = fopen($csvFile, 'r'); // read csv file

        $header = null; //instantiate header variable

        while (($row = fgetcsv($file_handle, 1000)) !== false) { //loop through each row

            if ($header != null) {

                $line_of_text[] = array_combine($header, $row);
            } else {

                $header = $row;
            };
        }
        fclose($file_handle);

        return $line_of_text;
    }
}

if (!function_exists('createSku')) {
    function createSku($name)
    {
        return str_replace(' ', '-', strtolower($name)); //set sku
    }
}
