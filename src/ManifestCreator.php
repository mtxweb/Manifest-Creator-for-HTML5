<?php
/*
Manifest Creator for HTML5
    Copyright (C) 2012        Tiziano Basile

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class ManifestCreator {
    protected $files = array();
    /**
     * All the magic happens here, in the constructor method
     * 
     * For first, checks if a path is passed; if not, sets the path parameter to the file's path;
     * then parses the given path and populates the files array
     * finally downloads the manifest file.
     * 
     * @param string $filename The generated manifest filename
     * @param string $path The path where to parse files to generate .manifest file
     * @param array  $network An array of strings containing the remote resources urls
     * 
     * @return file The Manifest file
     */
    public function __construct($filename = 'file', $path = null, $network = null) {
        if(is_null($path))
        {
            $path = dirname(__FILE__);
        }
        $this->parseDir($path);
        $this->purgeFileNames($this->getFiles(), $path);
        $this->saveManifest($filename, $network);

    }
    /**
     * Returns an array containing file's relative path
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }
    /**
     * Set the values for the File Class' attribute
     * 
     * If both parameters are null, the method sets the attribute to a void array
     * 
     * @param type $file The relative path to save
     * @param type $index The array index (useful in case of override)
     * 
     * @return void
     */
    public function setFiles($file = null, $index = null)
    {
        if(is_null($file) && is_null($index))
        {
            $this->files = array();
        }
        else{
            if(isset($index))
            {
                $this->files[$index] = $file;
            }
            else
            {
                $this->files[] = $file;
            }
        }
    }
    /**
     * Parses a directory and populates the Files attribute
     * @param type $path the absolute path where to parse files
     * 
     * @return void
     */
    private function parseDir($path)
    {
        $dir = opendir($path);
        while(($file = readdir($dir) )!== false)
        {
            if(($file == '.') || ($file == '..') || ($file == basename($_SERVER['PHP_SELF']))) continue;
            $fullPath = $path . '/' . $file;
            if(is_dir($fullPath))
            {
                $this->parseDir($fullPath);
            }
            else
            {
                $this->setFiles($fullPath);
            }
        }
    }
    /**
     * Delete the unnecessary characters from each file path in order to have only relative paths
     * 
     * @param array $files The array of files to purge
     * @param type $path the path given when the object is created
     * 
     * @return void
     */
    private function purgeFileNames($files, $path)
    {
        foreach($files as $index => $file)
        {
            //$domain = dirname(__FILE__);
            if(is_null($path))
            {
               $domain = dirname(__FILE__) . '/'; 
            }
            else
            {
                $domain = $path . '/';
            }
            $file = str_replace($domain, '', $file);
            $this->setFiles($file, $index);
        }
    }
    /**
     * Prepare the manifest file for the download
     * @param string $filename
     * @param array $network
     * 
     * @return file
     */
    private function saveManifest($filename, $network)
    {
        $output =  "CACHE MANIFEST \n\n";
        $files = $this->getFiles();
        foreach($files as $file)
        {
            $output .= "$file \n";
        }
        if(isset($network))
        {
            $output .= "\nNETWORK: \n";
            foreach($network as $net)
            {
                $output .= "$net \n";
            }
        }
        header('Content-type: text/plain');
        header("Content-disposition: attachment; filename={$filename}.manifest");
        echo $output;
    }
}
$manifest = new ManifestCreator();
?>
