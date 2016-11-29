<?php
/**
 * Mandrill wrapper for PHPMailer
 * User: Alexander.Chajka
 * Date: 2/10/2015
 * Time: 07:58
 */

class MandrillEmailWrapper extends PHPMailer
{
    private $_md;
    private $_from;
    private $_to;
    private $_cc;
    private $_bcc;
    private $_data;
    private $_globals;

    public $Subject;
    public $ErrorInfo;

    public function __construct($api_key)
    {
        $this->_md = new Mandrill($api_key);
        $this->_globals = array('company' => 'Boogi');
    }

    public function setFrom($email, $name = '', $auto = true)
    {
        $this->_from = array(
            'email' => $email,
            'name'  => $name
        );
    }

    public function addAddress($email, $name = '')
    {
        $this->_to = array(
            'email' => $email,
            'name'  => $name
        );
    }

    public function setData($data)
    {
        $this->_data = $data;
    }

    public function addCC($email, $name = '')
    {
        $this->_cc = array(
            'email' => $email,
            'name'  => $name
        );
    }

    public function addBCC($email, $name = '')
    {
        $this->_bcc = array(
            'email' => $email,
            'name'  => $name
        );
    }

    public function msgHTML($message, $basedir = '', $advanced = false)
    {
        return parent::msgHTML($message, $basedir, $advanced);
    }

    public function getGlobalsArray()
    {
        $result = array();
        foreach ($this->_globals as $key => $value) {
            $result[] = array(
                'name'      => $key,
                'content'   => $value
            );
        }
        return $result;
    }

    public function getDataArray()
    {
        $result = array();
        foreach ($this->_data as $key => $value) {
            $result[] = array(
                'name'      => $key,
                'content'   => $value
            );
        }
        return $result;
    }

    public function getFullData()
    {
        $result = $this->_data;
        $result['from'] = $this->_from;
        $result['to'] = $this->_to;
        $result['cc'] = $this->_cc;
        $result['bcc'] = $this->_bcc;
        $result['globals'] = $this->_globals;
        return $result;
    }

    public function send()
    {
        $name = MCMDBridge::getTemplateNameById($this->_data['template_id']);
        if (!$name) {
            $this->ErrorInfo = 'Can\'t find name for template #' . $this->_data['template_id'];
            return false;
        }

        $options = array(
            'subject' => $this->Subject,
            'from_email' => $this->_from['email'],
            'from_name' => $this->_from['name'],
            'to' => array(
                array(
                    'email' => $this->_to['email'],
                    'name' => $this->_to['name'],
                    'type' => 'to'
                )
            ),
            'headers' => array('Reply-To' => $this->_from['email']),
            'track_opens' => true,
            'track_clicks' => true,
            'bcc_address' => $this->_bcc['email'],
            'merge_language' => 'mailchimp',
            'global_merge_vars' => $this->getGlobalsArray(),
            'merge_vars' => array(
                array(
                    'rcpt' => $this->_to['email'],
                    'vars' => $this->getDataArray()
                )
            ),
            'google_analytics_domains' => array(Yii::app()->params['gaDomain']),
            'metadata' => array('website' => Yii::app()->params['baseUrl']),
        );

        try {
            $result = $this->_md->messages->sendTemplate($name, $this->getDataArray(), $options);
            if (!in_array($result[0]['status'], array('rejected', 'invalid'))) {
                return 1;
            }

            // Check status and compile log entry
            if ($result[0]['status'] == 'rejected') {
                $this->ErrorInfo = "Send email to " . $this->_to['email'] . " rejected.\n Reason: " . $result[0]['reject_reason'];
            } else {
                $this->ErrorInfo = "Malformed email request.\n Data: " . \CJSON::encode($this->getDataArray()) . "\n Options: " . \CJSON::encode($options);
            }
        } catch(Exception $e) {
            $this->ErrorInfo = $e->getMessage();
        }
        return 0;
    }
}