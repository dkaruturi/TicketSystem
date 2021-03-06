<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Tests\Integration\Preview\Wireless;

use Twilio\Exceptions\DeserializeException;
use Twilio\Exceptions\TwilioException;
use Twilio\Http\Response;
use Twilio\Tests\HolodeckTestCase;
use Twilio\Tests\Request;

class CommandTest extends HolodeckTestCase {
    public function testFetchRequest() {
        $this->holodeck->mock(new Response(500, ''));
        
        try {
            $this->twilio->preview->wireless->commands("DCaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")->fetch();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}
        
        $this->assertTrue($this->holodeck->hasRequest(new Request(
            'get',
            'https://preview.twilio.com/wireless/Commands/DCaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
        )));
    }

    public function testReadRequest() {
        $this->holodeck->mock(new Response(500, ''));
        
        try {
            $this->twilio->preview->wireless->commands->read();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}
        
        $this->assertTrue($this->holodeck->hasRequest(new Request(
            'get',
            'https://preview.twilio.com/wireless/Commands'
        )));
    }

    public function testCreateRequest() {
        $this->holodeck->mock(new Response(500, ''));
        
        try {
            $this->twilio->preview->wireless->commands->create("device", "command");
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}
        
        $values = array(
            'Device' => "device",
            'Command' => "command",
        );
        
        $this->assertTrue($this->holodeck->hasRequest(new Request(
            'post',
            'https://preview.twilio.com/wireless/Commands',
            null,
            $values
        )));
    }
}