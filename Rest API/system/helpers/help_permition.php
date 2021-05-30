<?php

if(!function_exists("get_file_perm_code")){

     /**
     * Get Permition code
     *
     * @param   mixed data
     * @return  string utf8
     */
    
    function get_file_perm_code($file){
    
        return substr(sprintf("%o", fileperms($file)), -4);
    
    }
}

if(!function_exists("get_file_perm_owner")){

    /**
     * Get Permition Owner
     *
     * @param   mixed data
     * @return  string utf8
     */

    function get_file_perm_owner($file){
        $stat = stat($file);
        if($stat){
            $group = posix_getgrgid($stat[5]);
            $user = posix_getpwuid($stat[4]);
            return compact("user", "group");
        }
        else
            return false;
    }
}

if(!function_exists("get_file_perm_asci_code")){

    /**
     * Get Permition ASCI Code
     *
     * @param   mixed data
     * @return  string utf8
     */

    function get_file_perm_asci_code($perms, $file){
        $rwx = array(
            "---",
            "--x",
            "-w-",
            "-wx",
            "r--",
            "r-x",
            "rw-",
            "rw"
        );
        $type = is_dir($file) ? "d" : "-";
        $owner = $perms[1];
        $group = $perms[2];
        $public = $perms[3];
        return $type.$rwx[$owner].$rwx[$group].$rwx[$public];
    }
}