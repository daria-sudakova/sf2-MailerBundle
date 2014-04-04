<?php

namespace Umbrellaweb\Bundle\MailerBundle\Mailer;

use Symfony\Component\Templating\EngineInterface;
use Umbrellaweb\Bundle\MailerBundle\Mailer\Message;

/**
 * Mailer
 * Send any emails via current service
 * 
 * @author Umbrella-web <http://umbrella-web.com>
 */
class Mailer {

    /**
     * @var \Swift_Mailer
     */
    protected $_mailer;

    /**
     * @var Symfony\Component\Templating\EngineInterface 
     */
    protected $_templating;

    /**
     * @var array
     */
    protected $_defaultParams = array();

    /**
     * @param \Swift_Mailer $mailer
     * @param \Symfony\Component\Templating\EngineInterface $templating
     * @param array $params
     */
    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating, array $params) {
        $this->_mailer = $mailer;
        $this->_templating = $templating;

        $this->_defaultParams['charset'] = $params['charset'];
        $this->_defaultParams['content_type'] = $params['content_type'];
        $this->_defaultParams['sender_email'] = $params['sender_email'];
        $this->_defaultParams['sender_name'] = $params['sender_name'];
    }

    /**
     * Send message using Swift_Mailer send() method
     * 
     * @param string $tplFullPath
     * @param array $params Message params
     * @param string $customClass
     */
    public function send($tplFullPath, array $params = array(), $customClass = null) {

        $message = $this->_buildMessage($tplFullPath, $params, $customClass);

        return $this->_mailer->send($message);
    }

    /**
     * Build the message object of base Umbrellaweb Message class or object of custom developer Message Class
     * 
     * @param string $tplFullPath
     * @param array $params
     * @param string $customClass
     * @return \Umbrellaweb\Bundle\MailerBundle\Mailer\Message|custom developer class object extends Umbrellaweb Message class
     */
    protected function _buildMessage($tplFullPath, array $params = array(), $customClass = null) {

        // if custom developer message class defined - return instanse of this class 
        if ($customClass != NULL) {
            $message = new $customClass($tplFullPath, array_merge($this->_defaultParams, $params), $this->_templating);
            return $message;
        }

        // else return base Umbrellaweb Message class object
        return new Message($tplFullPath, array_merge($this->_defaultParams, $params), $this->_templating);
    }

}
