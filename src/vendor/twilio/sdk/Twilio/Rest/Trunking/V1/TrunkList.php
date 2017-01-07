<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Trunking\V1;

use Twilio\ListResource;
use Twilio\Values;
use Twilio\Version;

class TrunkList extends ListResource {
    /**
     * Construct the TrunkList
     * 
     * @param Version $version Version that contains the resource
     * @return \Twilio\Rest\Trunking\V1\TrunkList 
     */
    public function __construct(Version $version) {
        parent::__construct($version);
        
        // Path Solution
        $this->solution = array();
        
        $this->uri = '/Trunks';
    }

    /**
     * Create a new TrunkInstance
     * 
     * @param array $options Optional Arguments
     * @return TrunkInstance Newly created TrunkInstance
     */
    public function create(array $options = array()) {
        $options = new Values($options);
        
        $data = Values::of(array(
            'FriendlyName' => $options['friendlyName'],
            'DomainName' => $options['domainName'],
            'DisasterRecoveryUrl' => $options['disasterRecoveryUrl'],
            'DisasterRecoveryMethod' => $options['disasterRecoveryMethod'],
            'Recording' => $options['recording'],
            'Secure' => $options['secure'],
        ));
        
        $payload = $this->version->create(
            'POST',
            $this->uri,
            array(),
            $data
        );
        
        return new TrunkInstance(
            $this->version,
            $payload
        );
    }

    /**
     * Streams TrunkInstance records from the API as a generator stream.
     * This operation lazily loads records as efficiently as possible until the
     * limit
     * is reached.
     * The results are returned as a generator, so this operation is memory
     * efficient.
     * 
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
    public function stream($limit = null, $pageSize = null) {
        $limits = $this->version->readLimits($limit, $pageSize);
        
        $page = $this->page($limits['pageSize']);
        
        return $this->version->stream($page, $limits['limit'], $limits['pageLimit']);
    }

    /**
     * Reads TrunkInstance records from the API as a list.
     * Unlike stream(), this operation is eager and will load `limit` records into
     * memory before returning.
     * 
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
     * @return TrunkInstance[] Array of results
     */
    public function read($limit = null, $pageSize = Values::NONE) {
        return iterator_to_array($this->stream($limit, $pageSize), false);
    }

    /**
     * Retrieve a single page of TrunkInstance records from the API.
     * Request is executed immediately
     * 
     * @param mixed $pageSize Number of records to return, defaults to 50
     * @param string $pageToken PageToken provided by the API
     * @param mixed $pageNumber Page Number, this value is simply for client state
     * @return \Twilio\Page Page of TrunkInstance
     */
    public function page($pageSize = Values::NONE, $pageToken = Values::NONE, $pageNumber = Values::NONE) {
        $params = Values::of(array(
            'PageToken' => $pageToken,
            'Page' => $pageNumber,
            'PageSize' => $pageSize,
        ));
        
        $response = $this->version->page(
            'GET',
            $this->uri,
            $params
        );
        
        return new TrunkPage($this->version, $response, $this->solution);
    }

    /**
     * Constructs a TrunkContext
     * 
     * @param string $sid The sid
     * @return \Twilio\Rest\Trunking\V1\TrunkContext 
     */
    public function getContext($sid) {
        return new TrunkContext(
            $this->version,
            $sid
        );
    }

    /**
     * Provide a friendly representation
     * 
     * @return string Machine friendly representation
     */
    public function __toString() {
        return '[Twilio.Trunking.V1.TrunkList]';
    }
}