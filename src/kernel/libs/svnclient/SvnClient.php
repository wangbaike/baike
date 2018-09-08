<?php

/**
 * This Tpl designed by wbk
 *
 * contact me by email with wangbaike168@qq.com if you have any question, good luck with you !
 *
 * @filename           SvnClient.php
 * @package		Netbeans
 * @author		Administrator
 * @link		http://www.baikeshuo.cn
 * @datetime          2018-8-4 22:35:25
 */

namespace baike\framework\libs\svnclient;

/**
 * Description of SvnClient
 */
class SvnClient
{

    /**
     * svn 程序的执行路径，使用之前需要提前设置该参数
     */
    private $svnPath = 'svn';

    /**
     * svn 用户名，使用之前需要提前设置该参数
     */
    private $svnUser = '';

    /**
     * svn 用户密码，使用之前需要提前设置该参数
     */
    private $svnPassword = '';

    function __construct($svnUser, $svnPassword, $svnPath = '')
    {
        $this->svnUser = $svnUser;
        $this->svnPassword = $svnPassword;
        if ($svnPath) {
            $this->svnPath = $svnPath;
        }
        if ($this->svnUser == '' || $this->svnPassword == '') {
            throw new SvnException('SVN_USER or SVN_PASSWORD is empty !');
        }
    }

    /**
     * List directory entries in the repository
     *
     * @param string a specific project repository path
     * @return bool true, if validated successfully, otherwise false
     */
    public function ls($repository)
    {
        $command = $this->svnPath . " ls " . $repository;
        $output = $this->runCmd($command);
        $output = implode("<br>", $output);
        if (strpos($output, 'non-existent in that revision')) {
            throw new SvnException('non-existent in that revision');
        }

        return "<br>" . $command . "<br>" . $output;
    }

    /**
     * Duplicate something in working copy or repository, remembering history
     *
     * @param $src
     * @param $dst
     * @param $comment string specify log message
     * @return bool true, if copy successfully, otherwise return the error message
     *
     * @todo comment need addslashes for svn commit
     */
    public function copy($src, $dst, $comment)
    {
        $command = $this->svnPath . " cp $src $dst -m '$comment'";
        $output = $this->runCmd($command);
        $output = implode("<br>", $output);

        if (strpos($output, 'Committed revision')) {
            return true;
        }

        return "<br>" . $command . "<br>" . $output;
    }

    /**
     * Remove files and directories from version control
     *
     * @param $url
     * @return bool true, if delete successfully, otherwise return the error message
     *
     * @todo comment need addslashes for svn commit
     */
    public function delete($url, $comment)
    {
        $command = $this->svnPath . " del $url -m '$comment'";
        $output = $this->runCmd($command);
        $output = implode('<br>', $output);
        if (strpos($output, 'Committed revision')) {
            return true;
        }

        return "<br>" . $command . "<br>" . $output;
    }

    /**
     * Move and/or rename something in working copy or repository
     *
     * @param $src string trunk path
     * @param $dst string new branch path
     * @param $comment string specify log message
     * @return bool true, if move successfully, otherwise return the error message
     *
     * @todo comment need addslashes for svn commit
     */
    public function move($src, $dst, $comment)
    {
        $command = $this->svnPath . " mv $src $dst -m '$comment'";
        $output = $this->runCmd($command);
        $output = implode('<br>', $output);

        if (strpos($output, 'Committed revision')) {
            return true;
        }

        return "<br>" . $command . "<br>" . $output;
    }

    /**
     * Create a new directory under version control
     *
     * @param $url string
     * @param $comment string the svn message
     * @return bool true, if create successfully, otherwise return the error message
     *
     * @todo comment need addslashes for svn commit
     */
    public function mkdir($url, $comment)
    {
        $command = $this->svnPath . " mkdir $url -m '$comment'";
        $output = $this->runCmd($command);
        $output = implode('<br>', $output);

        if (strpos($output, 'Committed revision')) {
            return true;
        }

        return "<br>" . $command . "<br>" . $output;
    }

    public function diff($pathA, $pathB)
    {
        $output = $this->runCmd($this->svnPath . " diff $pathA $pathB");
        return implode('<br>', $output);
    }

    public function checkout($url, $dir)
    {
        $command = "cd $dir && " . $this->svnPath . " co $url";
        $output = $this->runCmd($command);
        $output = implode('<br>', $output);
        if (strstr($output, 'Checked out revision')) {
            return true;
        }

        return "<br>" . $command . "<br>" . $output;
    }

    public function update($path)
    {
        $command = "cd $path && " . $this->svnPath . " up";
        $output = $this->runCmd($command);
        $output = implode('<br>', $output);

        preg_match_all("/[0-9]+/", $output, $ret);
        if (!$ret[0][0]) {
            return "<br>" . $command . "<br>" . $output;
        }

        return $ret[0][0];
    }

    public function merge($revision, $url, $dir)
    {
        $command = "cd $dir && " . $this->svnPath . " merge -r1:$revision $url";
        $output = implode('<br>', $this->runCmd($command));
        if (strstr($output, 'Text conflicts')) {
            return 'Command: ' . $command . '<br>' . $output;
        }

        return true;
    }

    public function commit($dir, $comment)
    {
        $command = "cd $dir && " . $this->svnPath . " commit -m'$comment'";
        $output = implode('<br>', $this->runCmd($command));

        if (strpos($output, 'Committed revision') || empty($output)) {
            return true;
        }

        return $output;
    }

    public function getStatus($dir)
    {
        $command = "cd $dir && " . $this->svnPath . " st";
        return $this->runCmd($command);
    }

    public function hasConflict($dir)
    {
        $output = $this->getStatus($dir);
        foreach ($output as $line) {
            if ('C' == substr(trim($line), 0, 1) || ('!' == substr(trim($line), 0, 1))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Show the log messages for a set of path with XML
     *
     * @param path string
     * @return log message string
     */
    public function getLog($path)
    {
        $command = $this->svnPath . " log $path --xml";
        $output = $this->runCmd($command);
        return implode('', $output);
    }

    public function getPathRevision($path)
    {
        $command = $this->svnPath . " info $path --xml";
        $output = $this->runCmd($command);
        $string = implode('', $output);
        $xml = new SimpleXMLElement($string);
        foreach ($xml->entry[0]->attributes() as $key => $value) {
            if ('revision' == $key) {
                return $value;
            }
        }
    }

    public function getHeadRevision($path)
    {
        $command = "cd $path && " . $this->svnPath . " up";
        $output = $this->runCmd($command);
        $output = implode('<br>', $output);

        preg_match_all("/[0-9]+/", $output, $ret);
        if (!$ret[0][0]) {
            return "<br>" . $command . "<br>" . $output;
        }

        return $ret[0][0];
    }

    /**
     * Run a cmd and return result
     *
     * @param string command line
     * @param boolen true need add the svn authentication
     * @return array the contents of the output that svn execute
     */
    private function runCmd($command)
    {
        $authCommand = ' --username ' . $this->svnUser . ' --password ' . $this->svnPassword . ' --no-auth-cache --non-interactive '; //--config-dir '.SVN_CONFIG_DIR.'.subversion';
        if (!function_exists('exec')) {
            throw new SvnException('function exec can not use !');
        }
        exec($command . $authCommand . " 2>&1", $output);
        var_dump($output);
        return $output;
    }

}
