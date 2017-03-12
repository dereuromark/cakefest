<?php
namespace App\Model\Entity;

/**
 * @property int $id
 * @property \Cake\I18n\Time $from
 * @property \Cake\I18n\Time $to
 * @property bool $display_email
 * @property string $comment
 * @property int $event_id
 * @property int $user_id
 * @property int $status
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Event $event
 * @property \App\Model\Entity\User $user
 */
class Attendee extends Entity {
}
