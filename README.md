## UmbrellawebMailerBundle

Provides conveniently configure email parts. If you are looking for a light bundle to create emails with ``html`` body this is what you need.

## Requirements

* PHP 5.3+

* [Symfony Standard Edition](https://github.com/symfony/symfony-standard)

## Installation

## Configuration 

Available optional configuration settings which you can use in your ``app/config/config.yml``

    umbrellaweb_mailer:
        charset: 'your-custom-charset' # 'utf-8' by default
        content_type: 'your-custom-content-type' # 'text/html' by default
        sender_email: 'noreply@email.com' # '' by default
        sender_name: 'noreply name' # '' by default

*``sender_email`` and  ``sender_name`` will be useful if email sender is often repeated by your project*

## Usage 

### Basic Usage

1. You need to create template with needed html structure and styles. For example, template's full name is ``ProjectBundle:path:template.html.twg``

2. In controller you can use the following example of code:
 
        $this->get('umbrellaweb.mailer')->send('ProjectBundle:path:template.html.twg', array(
                                                  'subject' => 'Your Subject',
                                                  'recipient_email' => 'to@email.com',
                                                  'recipient_name' => 'To Name', // optional parameter
                                                  // also you can define some template variables here
                                                  // or redefine some umbrellaweb_mailer config params here
                                                  )
                                               );

### Additional Usage

Besides, if you need specify some extra logic for ``Message`` class you can create custom developer class, extend it from ``Umbrellaweb\Bundle\MailerBundle\Mailer\Message`` 
and override methods which you want.

Example of this actions:

    <?php
    namespace ProjectBundle\Mailer\Message;

    use Umbrellaweb\Bundle\MailerBundle\Mailer\Message as UmbrellawebMessage;

    class UserEmailSomeNotification extends UmbrellawebMessage 
    {
        // set your methods here
    }

In this case you need to pass this class path when you using ``umbrellaweb.mailer`` send() method with 3rd parameter. Сode would look like this:

    $this->get('umbrellaweb.mailer')->send('ProjectBundle:path:template.html.twg', array(
                                              'subject' => 'Your Subject',
                                              'recipient_email' => 'to@email.com',
                                              'recipient_name' => 'To Name', // optional parameter
                                               // also you can define some template variables here
                                               // or redefine some umbrellaweb_mailer config params here
                                               ),
                                            'ProjectBundle\Mailer\Message\UserEmailSomeNotification'
                                            );
