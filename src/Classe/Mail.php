<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
  // À modifier pour le fonctionnement en PROD
  // To be modified for PROD operation
  // Créer gratuitement un compte MailJet
  // https://app.mailjet.com/signup?lang=fr_FR
  private $api_key = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
  private $api_key_secret = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';

  public function send($to_email, $to_name, $subject, $content)
  {
    // À modifier pour le fonctionnement en PROD
    // To be modified for PROD operation
    // Email, Name et TemplateID
    $mj = new Client($this->api_key, $this->api_key_secret, true, ['version' => 'v3.1']);
    $body = [
      'Messages' => [
        [
          'From' => [
            'Email' => "contact@maboutiquedemo.alan.ouloube.fr",
            'Name' => "Ma Boutique Demo"
          ],
          'To' => [
            [
              'Email' => $to_email,
              'Name' => $to_name
            ]
          ],
          'TemplateID' => 3520028,
          'TemplateLanguage' => true,
          'Subject' => $subject,
          'Variables' => [
            'content' => $content,
          ]
        ]
      ]
    ];
    $response = $mj->post(Resources::$Email, ['body' => $body]);
    $response->success();
  }
}
