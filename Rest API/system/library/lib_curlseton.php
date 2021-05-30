<?php 

namespace system\library;

 /**
 * curlseton Class
 *
 * this class for doing curl or data transmision from
 * other source page or source url
 *
 * @package     system
 * @subpackage  library
 * @category    data transmision
 */

class curlseton
{
    /**
    * Static curl ini extention
    *
    * @var mixed
    */

    private $ch;

    /**
    * Responde the callebale file
    *
    * @var bool
    */

    private $response = false;

    // --------------------------------------------------------------------

    /**
     * @param string $url
     * @param array  $options
     */
    public function __construct($url, array $options = array())
    {
        $this->ch = curl_init($url);

        foreach ($options as $key => $val) {
            curl_setopt($this->ch, $key, $val);
        }

        

        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    }

    // --------------------------------------------------------------------

    /**
     * Get the response
     * @return string
     * @throws \RuntimeException On cURL error
     */
    public function getResponse()
    {
         if ($this->response) {
             return $this->response;
         }

        $response = curl_exec($this->ch);
        $error    = curl_error($this->ch);
        $errno    = curl_errno($this->ch);

        if (is_resource($this->ch)) {
            curl_close($this->ch);
        }

        if (0 !== $errno) {
            throw new \RuntimeException($error, $errno);
        }

        return $this->response = $response;
    }

    // --------------------------------------------------------------------

    /**
     * Let echo out the response
     * @return string
     */
    public function __toString()
    {
        return $this->getResponse();
    }
}
