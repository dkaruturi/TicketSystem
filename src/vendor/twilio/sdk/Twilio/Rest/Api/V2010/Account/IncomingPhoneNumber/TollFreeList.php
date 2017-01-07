<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber;

use Twilio\ListResource;
use Twilio\Values;
use Twilio\Version;

class TollFreeList extends ListResource {
    /**
     * Construct the TollFreeList
     * 
     * @param Version $version Version that contains the resource
     * @param string $ownerAccountSid A 34 character string that uniquely
     *                                identifies this resource.
     * @return \Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber\TollFreeList 
     */
    public function __construct(Version $version, $ownerAccountSid) {
        parent::__construct($version);
        
        // Path Solution
        $this->solution = array(
            'ownerAccountSid' => $ownerAccountSid,
        );
        
        $this->uri = '/Accounts/' . $ownerAccountSid . '/IncomingPhoneNumbers/TollFree.json';
    }

    /**
     * Streams TollFreeInstance records from the API as a generator stream.
     * This operation lazily loads records as efficiently as possible until the
     * limit
     * is reached.
     * The results are returned as a generator, so this operation is memory
     * efficient.
     * 
     * @param array $options Optional Arguments
     * @param int $limit Upper limit for the number of records to return. stream()
     *                   guarantees to never return more than limit.  Default is no
     *                   limit
     * @param mixed $pageSize Number of records to fetch per request, when not set
     *                        will use
     *                        the default value of 50 records.  If no page_size is
     *                        defined
     *                        but a limit is defined, stream() will attempt to read
     *                        the limit
     *                        with the most efficient page size, i.e. min(limit,
     *                        1000)
     * @return \Twilio\Stream stream of results
     */
    public function stream(array $options = array(), $limit = null, $pageSize = null) {
        $limits = $this->version->readLimits($limit, $pageSize);
        
        $page = $this->page($options, $limits['pageSize']);
        
        return $this->version->stream($page, $limits['limit'], $limits['pageLimit']);
    }

    /**
     * Reads TollFreeInstance records from the API as a list.
     * Unlike stream(), this operation is eager and will load `limit` records into
     * memory before returning.
     * 
     * @param array $options Optional Arguments
     * @param int $limit Upper limit for the number of records to return. read()
     *                   guarantees to never return more than limit.  Default is no
     *                   limit
     * @param mixed $pageSize Number of records to fetch per request, when not set
     *                        will use
     *                        the default value of 50 records.  If no page_size is
     *                        defined
     *                        but a limit is defined, read() will attempt to read
     *                        the
     *                        limit with the most efficient page size, i.e.
     *                        min(limit, 1000)
     * @return TollFreeInstance[] Array of results
     */
    public function read(array $options = array(), $limit = null, $pageSize = Values::NONE) {
        return iterator_to_array($this->stream($options, $limit, $pageSize), false);
    }

    /**
     * Retrieve a single page of TollFreeInstance records from the API.
     * Request is executed immediately
     * 
     * @param array $options Optional Arguments
     * @param mixed $pageSize Number of records to return, defaults to 50
     * @param string $pageToken PageToken provided by the API
     * @param mixed $pageNumber Page Number, this value is simply for client state
     * @return \Twilio\Page Page of TollFreeInstance
     */
    public function page(array $options = array(), $pageSize = Values::NONE, $pageToken = Values::NONE, $pageNumber = Values::NONE) {
        $options = new Values($options);
        $params = Values::of(array(
            'Beta' => $options['beta'],
            'FriendlyName' => $options['friendlyName'],
            'PhoneNumber' => $options['phoneNumber'],
            'PageToken' => $pageToken,
            'Page' => $pageNumber,
            'PageSize' => $pageSize,
        ));
        
        $response = $this->version->page(
            'GET',
            $this->uri,
            $params
        );
        
        return new TollFreePage($this->version, $response, $this->solution);
    }

    /**
     * Create a new TollFreeInstance
     * 
     * @param string $phoneNumber The phone_number
     * @param array $options Optional Arguments
     * @return TollFreeInstance Newly created TollFreeInstance
     */
    public function create($phoneNumber, array $options = array()) {
        $options = new Values($options);
        
        $data = Values::of(array(
            'PhoneNumber' => $phoneNumber,
            'ApiVersion' => $options['apiVersion'],
            'FriendlyName' => $options['friendlyName'],
            'SmsApplicationSid' => $options['smsApplicationSid'],
            'SmsFallbackMethod' => $options['smsFallbackMethod'],
            'SmsFallbackUrl' => $options['smsFallbackUrl'],
            'SmsMethod' => $options['smsMethod'],
            'SmsUrl' => $options['smsUrl'],
            'StatusCallback' => $options['statusCallback'],
            'StatusCallbackMethod' => $options['statusCallbackMethod'],
            'VoiceApplicationSid' => $options['voiceApplicationSid'],
            'VoiceCallerIdLookup' => $options['voiceCallerIdLookup'],
            'VoiceFallbackMethod' => $options['voiceFallbackMethod'],
            'VoiceFallbackUrl' => $options['voiceFallbackUrl'],
            'VoiceMethod' => $options['voiceMethod'],
            'VoiceUrl' => $options['voiceUrl'],
        ));
        
        $payload = $this->version->create(
            'POST',
            $this->uri,
            array(),
            $data
        );
        
        return new TollFreeInstance(
            $this->version,
            $payload,
            $this->solution['ownerAccountSid']
        );
    }

    /**
     * Provide a friendly representation
     * 
     * @return string Machine friendly representation
     */
    public function __toString() {
        return '[Twilio.Api.V2010.TollFreeList]';
    }
}