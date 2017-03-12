<?php
namespace App\Model\Entity;

/**
 * @property int $id
 * @property \Cake\I18n\Time $from
 * @property \Cake\I18n\Time $to
 * @property string $name
 * @property string $description
 *
 * @property \App\Model\Entity\Attendee[] $attendees
 */
class Event extends Entity {
}
