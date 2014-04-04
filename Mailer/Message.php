<?php

namespace Umbrellaweb\Bundle\MailerBundle\Mailer;

/**
 * Base Message class
 * 
 * @author Umbrella-web <http://umbrella-web.com>
 */
class Message extends \Swift_Message {

    /**
     * @var Symfony\Component\Templating\EngineInterface 
     */
    protected $_templating;

    /**
     * @var array 
     */
    protected $_parameters = array();

    /**
     * @param string $tplFullPath
     * @param array $parameters
     * @param \Symfony\Component\Templating\EngineInterface $templating
     */
    function __construct($tplFullPath, array $parameters, \Symfony\Component\Templating\EngineInterface $templating) {
        parent::__construct();

        $this->_templating = $templating;
        $this->_parameters = $parameters;

        $this->_validateParameters();

        
        // fill email message 
        
        $this->setTo($parameters['recipient_email']);

        $this->setFrom($parameters['sender_email']);

        $this->setCharset($parameters['charset']);

        $this->setContentType($parameters['content_type']);

        $this->setSubject($parameters['subject']);

        $this->setTemplateBody($tplFullPath);
    }

    /**
     * @see Swift_Mime_Message interface 
     */
    public function generateId() {}

    /**
     * Create email body using Templating
     * 
     * @param string $tplFullPath
     */
    public function setTemplateBody($tplFullPath) {
        $this->setBody($this->_templating->render($tplFullPath, $this->_parameters));
    }

    /**
     * {@inheritdoc}
     * 
     * Override Swift_Mime_Message setTo() method to set before developer parameters if it needed
     */
    public function setTo($addresses, $name = null) {
        if (key_exists('recipient_name', $this->_parameters) && $this->_parameters['recipient_name'] != NULL) {
            $name = $this->_parameters['recipient_name'];
        }

        parent::setTo($addresses, $name);
    }

    /**
     * {@inheritdoc}
     * 
     * Override Swift_Mime_Message setFrom() method to set before developer parameters if it needed
     */
    public function setFrom($addresses, $name = null) {
        if (key_exists('sender_name', $this->_parameters) && $this->_parameters['sender_name'] != NULL) {
            $name = $this->_parameters['sender_name'];
        }

        parent::setFrom($addresses, $name);
    }

    /**
     * Validate parameters is required for configure email
     * 
     * @throws \Exception
     */
    protected function _validateParameters() {
        if (!key_exists('recipient_email', $this->_parameters) || $this->_parameters['recipient_email'] == NULL) {
            throw new \Exception('Please set \'recipient_email\' parameter');
        }

        if (!key_exists('sender_email', $this->_parameters) || $this->_parameters['sender_email'] == NULL) {
            throw new \Exception('Please set \'sender_email\' parameter');
        }

        if (!key_exists('subject', $this->_parameters) || $this->_parameters['subject'] == NULL) {
            throw new \Exception('Please set \'subject\' parameter');
        }
    }

}
