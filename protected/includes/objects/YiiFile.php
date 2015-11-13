<?php
/**
 * A File handling class
 *
 * @since  11.1
 */
class YiiFile {

    /**
     * Gets the extension of a file name
     *
     * @param   string  $file  The file name
     *
     * @return  string  The file extension
     *
     * @since   11.1
     */
    public static function getExt($file) {
        $dot = strrpos($file, '.') + 1;
        return substr($file, $dot);
    }

    /**
     * Strips the last extension off of a file name
     *
     * @param   string  $file  The file name
     *
     * @return  string  The file name without the extension
     *
     * @since   11.1
     */
    public static function stripExt($file) {
        return preg_replace('#\.[^.]*$#', '', $file);
    }

    /**
     * Makes file name safe to use
     *
     * @param   string  $file  The name of the file [not full path]
     *
     * @return  string  The sanitised string
     *
     * @since   11.1
     */
    public static function makeSafe($file) {
        // Remove any trailing dots, as those aren't ever valid file names.
        $file = rtrim($file, '.');

        $regex = array('#(\.){2,}#', '#[^A-Za-z0-9\.\_\- ]#', '#^\.#');

        return trim(preg_replace($regex, '', $file));
    }

    /**
     * Copies a file
     *
     * @param   string   $src          The path to the source file
     * @param   string   $dest         The path to the destination file
     * @param   string   $path         An optional base path to prefix to the file names
     * @param   boolean  $use_streams  True to use streams
     *
     * @return  boolean  True on success
     *
     * @since   11.1
     */
    public static function copy($src, $dest, $path = null) {

        if ($path) {
            $src = rtrim($path, "/") . '/' . $src;
            $dest = rtrim($path, "/") . '/' . $dest;
        }

        // Check src path
        if (!is_readable($src)) {
            return false;
        }

        if (!@ copy($src, $dest)) {
            return false;
        }

        $ret = true;

        return $ret;
    }

    /**
     * Delete a file or array of files
     *
     * @param   mixed  $file  The file name or an array of file names
     *
     * @return  boolean  True on success
     *
     * @since   11.1
     */
    public static function delete($file) {
        if (is_array($file)) {
            $files = $file;
        } else {
            $files[] = $file;
        }

        foreach ($files as $file) {
            $file = rtrim($file, "/");

            if (!is_file($file)) {
                continue;
            }

            // Try making the file writable first. If it's read-only, it can't be deleted
            // on Windows, even if the parent folder is writable
            @chmod($file, 0777);

            // In case of restricted permissions we zap it one way or the other
            // as long as the owner is either the webserver or the ftp
            if (@unlink($file)) {
                // Do nothing
            } else {
                $filename = basename($file);
                return false;
            }
        }
        return true;
    }

    /**
     * Moves a file
     *
     * @param   string   $src          The path to the source file
     * @param   string   $dest         The path to the destination file
     * @param   string   $path         An optional base path to prefix to the file names
     * @param   boolean  $use_streams  True to use streams
     *
     * @return  boolean  True on success
     *
     * @since   11.1
     */
    public static function move($src, $dest, $path = '') {

        if ($path) {
            $src = rtrim($path, "/") . '/' . $src;
            $dest = rtrim($path, "/") . '/' . $dest;
        }

        // Check src path
        if (!is_readable($src)) {
            return false;
        }
        if (!@ rename($src, $dest)) {
            return false;
        }

        return true;
    }

    /**
     * Read the contents of a file
     *
     * @param   string   $filename   The full file path
     * @param   boolean  $incpath    Use include path
     * @param   integer  $amount     Amount of file to read
     * @param   integer  $chunksize  Size of chunks to read
     * @param   integer  $offset     Offset of the file
     *
     * @return  mixed  Returns file contents or boolean False if failed
     *
     * @since   11.1
     * @deprecated  13.3 (Platform) & 4.0 (CMS) - Use the native file_get_contents() instead.
     */
    public static function read($filename, $incpath = false, $amount = 0, $chunksize = 8192, $offset = 0) {
        $data = null;

        if ($amount && $chunksize > $amount) {
            $chunksize = $amount;
        }

        if (false === $fh = fopen($filename, 'rb', $incpath)) {
            return false;
        }

        clearstatcache();

        if ($offset) {
            fseek($fh, $offset);
        }

        if ($fsize = @ filesize($filename)) {
            if ($amount && $fsize > $amount) {
                $data = fread($fh, $amount);
            } else {
                $data = fread($fh, $fsize);
            }
        } else {
            $data = '';

            /*
             * While it's:
             * 1: Not the end of the file AND
             * 2a: No Max Amount set OR
             * 2b: The length of the data is less than the max amount we want
             */
            while (!feof($fh) && (!$amount || strlen($data) < $amount)) {
                $data .= fread($fh, $chunksize);
            }
        }

        fclose($fh);

        return $data;
    }

    /**
     * Write contents to a file
     *
     * @param   string   $file         The full file path
     * @param   string   &$buffer      The buffer to write
     * @param   boolean  $use_streams  Use streams
     *
     * @return  boolean  True on success
     *
     * @since   11.1
     */
    public static function write($file, &$buffer) {
        @set_time_limit(ini_get('max_execution_time'));

        // If the destination directory doesn't exist we need to create it
        if (!file_exists(dirname($file))) {
            if (YiiFolder::create(dirname($file)) == false) {
                return false;
            }
        }

        $file = rtrim($file, "/");
        $ret = is_int(file_put_contents($file, $buffer)) ? true : false;
        return $ret;
    }

    /**
     * Moves an uploaded file to a destination folder
     *
     * @param   string   $src              The name of the php (temporary) uploaded file
     * @param   string   $dest             The path (including filename) to move the uploaded file to
     * @param   boolean  $use_streams      True to use streams
     * @param   boolean  $allow_unsafe     Allow the upload of unsafe files
     * @param   boolean  $safeFileOptions  Options to JFilterInput::isSafeFile
     *
     * @return  boolean  True on success
     *
     * @since   11.1
     */
    public static function upload($src, $dest) {
        // Ensure that the path is valid and clean 
        $dest = rtrim($dest, "/");

        // Create the destination directory if it does not exist
        $baseDir = dirname($dest);

        if (!file_exists($baseDir)) {
            YiiFolder::create($baseDir);
        }

        $ret = false;

        if (is_writeable($baseDir) && move_uploaded_file($src, $dest)) {
             $ret = true;
        } else {
            return false;
        }

        return $ret;
    }

    /**
     * Wrapper for the standard file_exists function
     *
     * @param   string  $file  File path
     *
     * @return  boolean  True if path is a file
     *
     * @since   11.1
     */
    public static function exists($file) {
        return is_file(rtrim($file,"/"));
    }

    /**
     * Returns the name, without any path.
     *
     * @param   string  $file  File path
     *
     * @return  string  filename
     *
     * @since   11.1
     * @deprecated  13.3 (Platform) & 4.0 (CMS) - Use basename() instead.
     */
    public static function getName($file) {
        // Convert back slashes to forward slashes
        $file = str_replace('\\', '/', $file);
        $slash = strrpos($file, '/');

        if ($slash !== false) {
            return substr($file, $slash + 1);
        } else {
            return $file;
        }
    }

}
